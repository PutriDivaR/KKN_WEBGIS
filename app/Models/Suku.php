<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suku extends Model
{
    protected $table = 'suku';
    protected $primaryKey = 'id_suku';
    public $timestamps = false;

    protected $fillable = ['nama_suku'];

    /**
     * Peta konsolidasi: nama suku MENTAH hasil survei (sering typo, variasi
     * penulisan, atau sub-klan) -> salah satu dari 6 kelompok suku resmi
     * yang ditampilkan ke publik.
     *
     * PENTING:
     * - Key harus PERSIS SAMA (case-sensitive) dengan nilai `nama_suku` di
     *   tabel `suku`. Data di DB TIDAK diubah sama sekali — hanya cara
     *   menampilkannya yang dikonsolidasi lewat mapping ini.
     * - Baris bertanda "// cek" adalah mapping yang masih perlu dikonfirmasi
     *   validitas historis/adatnya. Silakan sesuaikan nilainya kalau salah,
     *   sisanya otomatis ikut berubah (popup peta, detail rumah, filter).
     */
    public const GROUP_MAP = [
        'Piliang'             => 'Piliang',
        'Caniago'             => 'Chaniago',
        'Panai'               => 'Panai',
        'Melayu'              => 'Malayu',
        'Bodi Caniago'        => 'Chaniago',            // cek
        'Melayu Tak Timbago'  => 'Malayu Tak Timbago',
        'Patopang'            => 'Piliang',              // cek
        'Bodi'                => 'Chaniago',             // cek
        'Melayu Panai'        => 'Panai',                // cek
        'Bendang'             => 'Piliang',               // cek
        'Tobo'                => 'Tobo',
        'Melayu Kopa'         => 'Malayu',
        'Melayu Tanjung'      => 'Malayu',
        'Melayu Tobo'         => 'Tobo',                 // cek
    ];

    /**
     * 6 kelompok suku resmi. Urutan ini juga dipakai untuk urutan checkbox
     * filter suku di sidebar peta.
     */
    public const GROUPS = [
        'Chaniago',
        'Malayu',
        'Malayu Tak Timbago',
        'Panai',
        'Piliang',
        'Tobo',
    ];

    /**
     * Nama suku yang sudah dikonsolidasikan ke salah satu dari 6 kelompok
     * resmi. Pakai accessor ini (BUKAN nama_suku mentah) di mana pun suku
     * ditampilkan ke pengguna: popup peta, halaman detail rumah, dsb.
     */
    public function getNamaKelompokAttribute(): string
    {
        return self::GROUP_MAP[$this->nama_suku] ?? $this->nama_suku;
    }

    /**
     * Semua nama_suku mentah (varian/typo/sub-klan) yang termasuk dalam
     * satu kelompok suku resmi. Dipakai MapController untuk menerjemahkan
     * pilihan filter (berupa nama kelompok, misal "Chaniago") kembali ke
     * daftar nama_suku asli saat query database.
     */
    public static function namesInGroup(string $group): array
    {
        return array_keys(array_filter(
            self::GROUP_MAP,
            fn (string $mappedGroup) => $mappedGroup === $group
        ));
    }

    public function rumahAdat()
    {
        return $this->hasMany(RumahAdat::class, 'id_suku', 'id_suku');
    }
}