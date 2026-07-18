<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenghuniRumah extends Model
{
    protected $table = 'penghuni_rumah';
    protected $primaryKey = 'id_penghuni';
    public $timestamps = false;

    protected $fillable = ['id_rumah', 'nama', 'jenis_kelamin', 'umur'];
}
