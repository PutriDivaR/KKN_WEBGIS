<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MediaFasilitas extends Model
{
    protected $table = 'media_fasilitas';

    protected $primaryKey = 'id_medfas';

    public $timestamps = false;

    protected $fillable = [
        'id_fasilitas',
        'nama_file',
        'file',
        'jenis_media',
    ];

    /**
     * Folder fisik tempat semua foto fasilitas disimpan, relatif dari public/.
     * Kolom `file` di database HANYA berisi nama file (bukan path lengkap),
     * jadi URL selalu dibentuk dengan menggabungkan folder ini + nama file.
     */
    public const PUBLIC_FOLDER = 'assets/fasilitas';

    public function fasilitas(): BelongsTo
    {
        return $this->belongsTo(FasilitasWisata::class, 'id_fasilitas', 'id_fasilitas');
    }

    public function getUrlAttribute(): string
    {
        return asset(self::PUBLIC_FOLDER . '/' . $this->file);
    }

    /**
     * Path fisik absolut ke file di server (dipakai saat hapus file).
     */
    public function getAbsolutePathAttribute(): string
    {
        return public_path(self::PUBLIC_FOLDER . '/' . $this->file);
    }
}
