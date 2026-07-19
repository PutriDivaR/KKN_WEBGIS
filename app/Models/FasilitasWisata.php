<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FasilitasWisata extends Model
{
    protected $table = 'fasilitas_wisata';
    protected $primaryKey = 'id_fasilitas';
    public $timestamps = false;

    protected $fillable = [
        'id_jorong',
        'id_kampung',
        'nama',
        'kategori',
        'deskripsi',
        'latitude',
        'longitude',
    ];

    /**
     * Semua media (foto & video) milik fasilitas ini.
     */
    public function media()
    {
        return $this->hasMany(MediaFasilitas::class, 'id_fasilitas', 'id_fasilitas');
    }

    /**
     * Jorong tempat fasilitas ini berada (opsional, bisa null).
     */
    public function jorong()
    {
        return $this->belongsTo(Jorong::class, 'id_jorong', 'id_jorong');
    }
}