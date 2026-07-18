<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KondisiRumah extends Model
{
    protected $table = 'kondisi_rumah';
    protected $primaryKey = 'id_kondisi';
    public $timestamps = false;

    protected $fillable = ['id_rumah', 'bagian_rusak', 'tingkat_kerusakan', 'status_renovasi'];
}
