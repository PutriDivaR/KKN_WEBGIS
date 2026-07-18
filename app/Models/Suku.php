<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suku extends Model
{
    protected $table = 'suku';
    protected $primaryKey = 'id_suku';
    public $timestamps = false;

    protected $fillable = ['nama_suku'];
}
