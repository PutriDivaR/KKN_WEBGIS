<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaFasilitas extends Model
{
    protected $table = 'media_fasilitas';
    protected $primaryKey = 'id_medfas';
    public $timestamps = false;

    /**
     * Folder fisik penyimpanan file, RELATIF terhadap public/.
     * Kolom `file` di database hanya berisi nama file (mis. "xxxx-uuid.jpg"),
     * BUKAN path lengkap — konstanta ini yang melengkapinya jadi path/URL utuh.
     * Harus sama persis dengan yang dipakai di
     * AdminFasilitasController::storePhoto() (public_path(self::PUBLIC_FOLDER)).
     */
    public const PUBLIC_FOLDER = 'assets/fasilitas';

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
     * URL publik untuk ditampilkan di <img>/<video> (mis. public/assets/fasilitas/xxxx.jpg
     * -> https://domain.test/assets/fasilitas/xxxx.jpg).
     */
    public function getUrlAttribute(): string
    {
        if (! $this->file) {
            return '';
        }

        if (str_starts_with($this->file, 'http://') || str_starts_with($this->file, 'https://')) {
            return $this->file;
        }

        return asset(self::PUBLIC_FOLDER . '/' . ltrim($this->file, '/'));
    }

    /**
     * Path fisik file di disk server — dipakai saat menghapus file lewat
     * File::delete() di AdminFasilitasController::deletePhotoFile().
     */
    public function getAbsolutePathAttribute(): string
    {
        return public_path(self::PUBLIC_FOLDER . '/' . ltrim($this->file, '/'));
    }
}