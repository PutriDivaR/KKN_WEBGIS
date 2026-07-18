<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaRumah extends Model
{
    protected $table = 'media_rumah';
    protected $primaryKey = 'id_media';
    public $timestamps = false;

    protected $fillable = ['id_rumah', 'nama_file', 'file', 'jenis_media'];
}
