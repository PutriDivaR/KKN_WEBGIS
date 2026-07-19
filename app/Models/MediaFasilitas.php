<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaFasilitas extends Model
{
    protected $table = 'media_fasilitas';
    protected $primaryKey = 'id_medfas';
    public $timestamps = false;

    protected $fillable = [
        'id_fasilitas',
        'nama_file',
        'file',
        'jenis_media', // 'foto' | 'video'
    ];

    public function fasilitas()
    {
        return $this->belongsTo(FasilitasWisata::class, 'id_fasilitas', 'id_fasilitas');
    }

    /**
     * URL publik ke file media ini.
     *
     * Asumsi: kolom `file` berisi path relatif hasil upload lewat
     * Storage::disk('public') (mis. "fasilitas/nama-file.jpg"), dan
     * symlink storage sudah dibuat lewat `php artisan storage:link`.
     *
     * Kalau ternyata kolom `file` sudah berisi URL penuh (http/https)
     * atau kamu simpan file-nya manual langsung di folder public/,
     * accessor ini tetap aman menyesuaikan.
     */
    public function getUrlAttribute(): string
    {
        $file = $this->file;

        if (! $file) {
            return '';
        }

        if (str_starts_with($file, 'http://') || str_starts_with($file, 'https://')) {
            return $file;
        }

        // Sudah berupa path public/ langsung (mis. "assets/fasilitas/...")
        if (str_starts_with($file, 'assets/') || str_starts_with($file, 'storage/')) {
            return asset(ltrim($file, '/'));
        }

        // Default: anggap file disimpan via disk 'public' (storage/app/public/...)
        return asset('storage/' . ltrim($file, '/'));
    }
}