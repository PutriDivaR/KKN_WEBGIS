<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FasilitasWisata extends Model
{
    protected $table = 'fasilitas_wisata';

    protected $primaryKey = 'id_fasilitas';

    public $timestamps = false;

    protected $fillable = [
        'id_kampung',
        'id_jorong',
        'nama',
        'kategori',
        'deskripsi',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'latitude'  => 'float',
        'longitude' => 'float',
    ];

    /**
     * Daftar kategori yang tersedia (sesuai ENUM kolom kategori).
     */
    public const KATEGORI_OPTIONS = ['Pendidikan', 'Pusat Informasi', 'Umum'];

    public function jorong(): BelongsTo
    {
        return $this->belongsTo(Jorong::class, 'id_jorong', 'id_jorong');
    }

    public function media(): HasMany
    {
        return $this->hasMany(MediaFasilitas::class, 'id_fasilitas', 'id_fasilitas');
    }

    /**
     * Thumbnail pertama untuk ditampilkan di daftar fasilitas.
     */
    public function getCoverPhotoAttribute(): ?string
    {
        $first = $this->media->firstWhere('jenis_media', 'foto');

        return $first?->url;
    }
}
