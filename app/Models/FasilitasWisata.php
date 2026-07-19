<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FasilitasWisata extends Model
{
    protected $table = 'fasilitas_wisata';
    protected $primaryKey = 'id_fasilitas';
    public $timestamps = false;

    /**
     * Pilihan kategori fasilitas — dipakai di dropdown form admin
     * (admin.fasilitas._form) dan sebagai referensi filter di peta publik.
     */
    public const KATEGORI_OPTIONS = ['Pendidikan', 'Pusat Informasi', 'Umum'];

    protected $fillable = [
        'id_jorong',
        'id_kampung',
        'nama',
        'kategori',
        'deskripsi',
        'latitude',
        'longitude',
    ];

    public function media()
    {
        return $this->hasMany(MediaFasilitas::class, 'id_fasilitas', 'id_fasilitas');
    }

    public function jorong()
    {
        return $this->belongsTo(Jorong::class, 'id_jorong', 'id_jorong');
    }

    /**
     * URL foto sampul (satu-satunya foto per fasilitas — dibatasi 1 foto
     * lewat AdminFasilitasController::storePhoto()). Dipakai di kartu
     * daftar fasilitas admin lewat `$item->cover_photo`. Null kalau
     * fasilitas ini belum punya foto sama sekali.
     */
    public function getCoverPhotoAttribute(): ?string
    {
        $foto = $this->media->firstWhere('jenis_media', 'foto');

        return $foto?->url;
    }
}