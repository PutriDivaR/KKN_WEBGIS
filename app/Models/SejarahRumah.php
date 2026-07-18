<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SejarahRumah extends Model
{
    protected $table = 'sejarah_rumah';
    protected $primaryKey = 'id_sejarah';
    public $timestamps = false;

    protected $fillable = ['id_rumah', 'sejarah'];
}
