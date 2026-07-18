<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RumahKategori extends Model
{
    protected $table = 'rumah_kategori';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['id_rumah', 'id_kategori'];
}
