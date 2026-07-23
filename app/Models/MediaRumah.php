<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaRumah extends Model
{
    protected $table = 'media_rumah';
    protected $primaryKey = 'id_media';
    public $timestamps = false;

    protected $fillable = ['id_rumah', 'nama_file', 'file', 'jenis_media'];


    public function rumah()
    {
        return $this->belongsTo(RumahAdat::class, 'id_rumah', 'id_rumah');
    }
 
    /**
     * URL publik foto/video. Mengikuti konvensi yang sudah dipakai di
     * halaman detail rumah (pages.detailrumah, tab Galeri): file disimpan
     * lewat Storage::disk('public'), diakses lewat /storage/...
     * (pastikan `php artisan storage:link` sudah pernah dijalankan).
     */
    public function getUrlAttribute(): string
    {
        if (! $this->file) {
            return '';
        }
 
        if (str_starts_with($this->file, 'http://') || str_starts_with($this->file, 'https://')) {
            return $this->file;
        }
 
        return asset('storage/' . ltrim($this->file, '/'));
    }
}