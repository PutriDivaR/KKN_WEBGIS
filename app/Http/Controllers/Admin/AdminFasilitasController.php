<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FasilitasRequest;
use App\Models\FasilitasWisata;
use App\Models\Jorong;
use App\Models\MediaFasilitas;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminFasilitasController extends Controller
{
    /**
     * ID kampung adat default. Saat ini hanya ada satu kampung adat
     * (Perkampungan Adat Sijunjung) sehingga tidak perlu dipilih di form.
     */
    private const DEFAULT_ID_KAMPUNG = 1;

    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search'));

        $fasilitas = FasilitasWisata::with(['jorong', 'media'])
            ->when($search !== '', fn ($q) => $q->where('nama', 'like', "%{$search}%"))
            ->orderBy('nama')
            ->paginate(9)
            ->withQueryString();

        return view('admin.fasilitas.index', [
            'fasilitas' => $fasilitas,
            'search'    => $search,
        ]);
    }

    public function create(): View
    {
        return view('admin.fasilitas.create', [
            'fasilitas'  => new FasilitasWisata(),
            'jorongList' => Jorong::orderBy('nama_jorong')->get(),
        ]);
    }

    public function store(FasilitasRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $fasilitas = FasilitasWisata::create([
            'id_kampung' => self::DEFAULT_ID_KAMPUNG,
            'id_jorong'  => $data['id_jorong'] ?? null,
            'nama'       => $data['nama'],
            'kategori'   => $data['kategori'] ?? null,
            'deskripsi'  => $data['deskripsi'] ?? null,
            'latitude'   => $data['latitude'] ?? null,
            'longitude'  => $data['longitude'] ?? null,
        ]);

        $this->storePhoto($fasilitas, $request->file('foto'));

        return redirect()
            ->route('admin.fasilitas.index')
            ->with('success', "Fasilitas \"{$fasilitas->nama}\" berhasil ditambahkan.");
    }

    public function edit(string $id): View
    {
        $fasilitas = FasilitasWisata::with('media')->findOrFail($id);

        return view('admin.fasilitas.edit', [
            'fasilitas'  => $fasilitas,
            'jorongList' => Jorong::orderBy('nama_jorong')->get(),
        ]);
    }

    public function update(FasilitasRequest $request, string $id): RedirectResponse
    {
        $fasilitas = FasilitasWisata::findOrFail($id);
        $data = $request->validated();

        $fasilitas->update([
            'id_jorong'  => $data['id_jorong'] ?? null,
            'nama'       => $data['nama'],
            'kategori'   => $data['kategori'] ?? null,
            'deskripsi'  => $data['deskripsi'] ?? null,
            'latitude'   => $data['latitude'] ?? null,
            'longitude'  => $data['longitude'] ?? null,
        ]);

        $this->storePhoto($fasilitas, $request->file('foto'));

        return redirect()
            ->route('admin.fasilitas.index')
            ->with('success', "Fasilitas \"{$fasilitas->nama}\" berhasil diperbarui.");
    }

    public function destroy(string $id): RedirectResponse
    {
        $fasilitas = FasilitasWisata::with('media')->findOrFail($id);

        foreach ($fasilitas->media as $media) {
            $this->deletePhotoFile($media);
            $media->delete();
        }

        $fasilitas->delete();

        return redirect()
            ->route('admin.fasilitas.index')
            ->with('success', "Fasilitas \"{$fasilitas->nama}\" berhasil dihapus.");
    }

    /**
     * Hapus satu foto dari galeri (dipanggil dari halaman edit).
     */
    public function destroyMedia(string $mediaId): RedirectResponse
    {
        $media = MediaFasilitas::findOrFail($mediaId);
        $this->deletePhotoFile($media);
        $idFasilitas = $media->id_fasilitas;
        $media->delete();

        return redirect()
            ->route('admin.fasilitas.edit', $idFasilitas)
            ->with('success', 'Foto berhasil dihapus.');
    }

    /**
     * Simpan foto fasilitas — DIBATASI 1 FOTO PER FASILITAS.
     * Kalau sudah ada foto dan upload baru dikirim, foto lama (baik file
     * fisik di public/assets/fasilitas maupun row di database) otomatis
     * dihapus dulu sebelum yang baru disimpan.
     */
    private function storePhoto(FasilitasWisata $fasilitas, ?\Illuminate\Http\UploadedFile $file): void
    {
        if (! $file) {
            return;
        }

        $existing = $fasilitas->media()->where('jenis_media', 'foto')->first();
        if ($existing) {
            $this->deletePhotoFile($existing);
            $existing->delete();
        }

        $targetDir = public_path(MediaFasilitas::PUBLIC_FOLDER);

        if (! File::isDirectory($targetDir)) {
            File::makeDirectory($targetDir, 0755, true);
        }

        // Nama file dibuat unik (UUID) supaya tidak bentrok antar-fasilitas,
        // nama asli tetap disimpan di kolom nama_file untuk ditampilkan/diunduh.
        $filename = Str::uuid()->toString() . '.' . strtolower($file->getClientOriginalExtension());

        $file->move($targetDir, $filename);

        MediaFasilitas::create([
            'id_fasilitas' => $fasilitas->id_fasilitas,
            'nama_file'    => $file->getClientOriginalName(),
            'file'         => $filename,
            'jenis_media'  => 'foto',
        ]);
    }

    private function deletePhotoFile(MediaFasilitas $media): void
    {
        $path = $media->absolute_path;

        if (File::exists($path)) {
            File::delete($path);
        }
    }
}
