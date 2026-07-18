<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemilik extends Model
{
    protected $table = 'pemilik';
    protected $primaryKey = 'id_pemilik';
    public $timestamps = false;

    protected $fillable = ['nama', 'pekerjaan', 'alamat'];
}
