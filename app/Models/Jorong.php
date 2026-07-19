<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jorong extends Model
{
    protected $table = 'jorong';
    protected $primaryKey = 'id_jorong';
    public $timestamps = false;

    protected $fillable = ['nama_jorong'];

    public function fasilitas(): HasMany
    {
        return $this->hasMany(FasilitasWisata::class, 'id_jorong', 'id_jorong');
    }
}

