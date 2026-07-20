<?php

namespace App\Console\Commands;

use App\Models\MediaFasilitas;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

/**
 * php artisan fasilitas:migrate-photos [--dry-run]
 *
 * Merapikan file foto fasilitas lama supaya sesuai konvensi baru:
 *  - Semua file fisik ada di public/assets/fasilitas/{nama_file_unik}
 *  - Kolom media_fasilitas.file di database HANYA berisi nama file
 *    (tanpa folder/path), karena itu yang dipakai oleh
 *    MediaFasilitas::getUrlAttribute() -> asset('assets/fasilitas/'.$file)
 *
 * Command ini akan mencoba menemukan file fisik di beberapa lokasi lama
 * yang mungkin dipakai sebelumnya (storage disk Laravel, symlink public/storage,
 * dll), lalu menyalinnya ke public/assets/fasilitas dan menormalkan kolom
 * `file` di database. Baris yang file fisiknya benar-benar tidak ditemukan
 * di lokasi manapun akan dilaporkan di akhir supaya bisa di-upload ulang
 * manual lewat halaman Edit Fasilitas.
 */
class MigrateFasilitasPhotos extends Command
{
    protected $signature = 'fasilitas:migrate-photos {--dry-run : Tampilkan rencana tanpa mengubah apapun}';

    protected $description = 'Pindahkan/rapikan file foto fasilitas lama ke public/assets/fasilitas dan normalkan kolom file di database';

    public function handle(): int
    {
        $dryRun = (bool) $this->option('dry-run');
        $targetDir = public_path(MediaFasilitas::PUBLIC_FOLDER);

        if (! File::isDirectory($targetDir)) {
            $this->info("Membuat folder: {$targetDir}");
            if (! $dryRun) {
                File::makeDirectory($targetDir, 0755, true);
            }
        }

        $rows = MediaFasilitas::all();

        if ($rows->isEmpty()) {
            $this->info('Tidak ada data di tabel media_fasilitas.');
            return self::SUCCESS;
        }

        $ok = 0;
        $migrated = 0;
        $missing = [];

        foreach ($rows as $media) {
            $currentValue = (string) $media->file;
            $basename = basename($currentValue);

            // Sudah benar: file fisik ada persis di public/assets/fasilitas
            // dengan nama sesuai kolom `file` (tanpa folder).
            $alreadyOk = $currentValue === $basename
                && File::exists($targetDir . DIRECTORY_SEPARATOR . $currentValue);

            if ($alreadyOk) {
                $ok++;
                continue;
            }

            $source = $this->findLegacyFile($currentValue, $basename);

            if ($source === null) {
                $missing[] = $media;
                continue;
            }

            $finalName = $this->uniqueTargetName($targetDir, $basename);
            $destination = $targetDir . DIRECTORY_SEPARATOR . $finalName;

            $this->line("Copy: {$source} -> {$destination}");

            if (! $dryRun) {
                File::copy($source, $destination);
                $media->file = $finalName;
                $media->save();
            }

            $migrated++;
        }

        $this->newLine();
        $this->info("Sudah sesuai sebelumnya : {$ok}");
        $this->info('Berhasil dipindahkan    : ' . $migrated . ($dryRun ? ' (dry-run, belum disimpan)' : ''));

        if (! empty($missing)) {
            $this->newLine();
            $this->warn('File fisik TIDAK ditemukan untuk ' . count($missing) . ' data berikut — perlu diunggah ulang manual lewat halaman Edit Fasilitas:');
            $this->table(
                ['id_medfas', 'id_fasilitas', 'nama_file', 'file (di database)'],
                collect($missing)->map(fn ($m) => [$m->id_medfas, $m->id_fasilitas, $m->nama_file, $m->file])
            );
        }

        return self::SUCCESS;
    }

    /**
     * Coba temukan file fisik di beberapa kemungkinan lokasi lama.
     */
    private function findLegacyFile(string $currentValue, string $basename): ?string
    {
        $candidates = [
            // storage/app/public/{file}  (mis. "fasilitas/xxxx.jpg" dari versi lama)
            storage_path('app/public/' . $currentValue),
            // storage/app/public/fasilitas/{basename}
            storage_path('app/public/fasilitas/' . $basename),
            // public/storage/{file}  (lewat symlink storage:link, kalau sempat dibuat)
            public_path('storage/' . $currentValue),
            public_path('storage/fasilitas/' . $basename),
            // kemungkinan folder upload lama lainnya
            public_path('uploads/' . $basename),
            public_path('uploads/fasilitas/' . $basename),
            public_path('assets/fasilitas/' . $basename),
        ];

        foreach ($candidates as $path) {
            if (File::exists($path) && File::isFile($path)) {
                return $path;
            }
        }

        return null;
    }

    /**
     * Hindari menimpa file lain yang kebetulan sama nama-nya.
     */
    private function uniqueTargetName(string $targetDir, string $basename): string
    {
        if (! File::exists($targetDir . DIRECTORY_SEPARATOR . $basename)) {
            return $basename;
        }

        $ext = pathinfo($basename, PATHINFO_EXTENSION);
        $name = pathinfo($basename, PATHINFO_FILENAME);
        $i = 1;

        do {
            $candidate = "{$name}-{$i}." . ($ext !== '' ? $ext : 'jpg');
            $i++;
        } while (File::exists($targetDir . DIRECTORY_SEPARATOR . $candidate));

        return $candidate;
    }
}
