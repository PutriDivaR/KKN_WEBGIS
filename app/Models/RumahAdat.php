<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class RumahAdat extends Model
{
    protected $table = 'rumah_adat';
    protected $primaryKey = 'id_rumah';
    public $timestamps = false;

    protected $casts = [
        'latitude'  => 'float',
        'longitude' => 'float',
    ];

    /**
     * Tabel lookup `status_rumah` & `kategori_rumah` di DB masih kosong
     * (belum diisi), padahal `rumah_adat.id_status` dan pivot
     * `rumah_kategori.id_kategori` sudah terisi angka. Jadi sementara
     * dipetakan manual sesuai urutan enum aslinya:
     *   status_rumah.status  enum('Aktif Dihuni','Kosong')
     *   kategori_rumah.nama  enum('Rumah Tinggal','Rumah Adat','Rumah Pusaka','Rumah Kaum')
     *
     * PALING BENAR: isi tabel status_rumah dan kategori_rumah, lalu ganti
     * accessor di bawah jadi relasi belongsTo/belongsToMany asli.
     */
    public const STATUS_MAP = [
        1 => 'Aktif Dihuni',
        2 => 'Kosong',
    ];

    public const KATEGORI_MAP = [
        1 => 'Rumah Tinggal',
        2 => 'Rumah Adat',
        3 => 'Rumah Pusaka',
        4 => 'Rumah Kaum',
    ];

    // ------------------------------------------------------------------
    // Relasi
    // ------------------------------------------------------------------

    public function suku(): BelongsTo
    {
        return $this->belongsTo(Suku::class, 'id_suku', 'id_suku');
    }

    public function jorong(): BelongsTo
    {
        return $this->belongsTo(Jorong::class, 'id_jorong', 'id_jorong');
    }

    public function pemilik(): BelongsTo
    {
        return $this->belongsTo(Pemilik::class, 'id_pemilik', 'id_pemilik');
    }

    public function penghuni(): HasMany
    {
        return $this->hasMany(PenghuniRumah::class, 'id_rumah', 'id_rumah');
    }

    public function sejarah(): HasOne
    {
        return $this->hasOne(SejarahRumah::class, 'id_rumah', 'id_rumah');
    }

    public function media(): HasMany
    {
        return $this->hasMany(MediaRumah::class, 'id_rumah', 'id_rumah');
    }

    /** Baris di tabel penghubung rumah_kategori untuk rumah ini (bisa lebih dari satu). */
    public function kategori(): HasMany
    {
        return $this->hasMany(RumahKategori::class, 'id_rumah', 'id_rumah');
    }

    public function kondisi(): HasOne
    {
        return $this->hasOne(KondisiRumah::class, 'id_rumah', 'id_rumah');
    }

    // ------------------------------------------------------------------
    // Accessor tampilan (null-safe, dipakai langsung di Blade)
    // ------------------------------------------------------------------

    public function getNamaTampilAttribute(): string
    {
        return $this->nama_rumah ?: 'Rumah Gadang No. ' . ($this->nomor_rumah ?? '-');
    }

    public function getStatusKeyAttribute(): string
    {
        return match ($this->id_status) {
            1 => 'dihuni',
            2 => 'kosong',
            default => 'unknown',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_MAP[$this->id_status] ?? 'Belum Diketahui';
    }

    public function getStatusDotAttribute(): string
    {
        return match ($this->id_status) {
            1 => 'bg-green-600',
            2 => 'bg-orange-500',
            default => 'bg-neutral-300',
        };
    }

    public function getKategoriLabelAttribute(): string
    {
        $ids = $this->relationLoaded('kategori')
            ? $this->kategori->pluck('id_kategori')
            : $this->kategori()->pluck('id_kategori');

        if ($ids->isEmpty()) {
            return 'Belum dikategorikan';
        }

        return $ids->map(fn ($id) => self::KATEGORI_MAP[$id] ?? null)
            ->filter()
            ->unique()
            ->implode(', ');
    }

    public function getJumlahPenghuniLabelAttribute(): string
    {
        if (! is_null($this->jumlah_penghuni_laki) || ! is_null($this->jumlah_penghuni_perempuan)) {
            $total = ($this->jumlah_penghuni_laki ?? 0) + ($this->jumlah_penghuni_perempuan ?? 0);

            return $total > 0 ? "{$total} Orang" : 'Belum terdata';
        }

        $count = $this->relationLoaded('penghuni') ? $this->penghuni->count() : $this->penghuni()->count();

        return $count > 0 ? "{$count} Orang" : 'Belum terdata';
    }

    public function getJumlahKkLabelAttribute(): string
    {
        return ! is_null($this->jumlah_kk) ? "{$this->jumlah_kk} KK" : 'Belum terdata';
    }

    public function getTahunDibangunLabelAttribute(): string
    {
        return $this->tahun_dibangun ?: 'Tidak diketahui';
    }

    public function getAlamatLabelAttribute(): string
    {
        return $this->alamat_rumah ?: 'Alamat belum terdata';
    }

    public function getPemilikLabelAttribute(): string
    {
        return $this->pemilik->nama ?? 'Belum terdata';
    }

    public function getNinikMamakLabelAttribute(): string
    {
        return $this->ninik_mamak ?: 'Belum terdata';
    }

    public function getSukuLabelAttribute(): string
    {
        return $this->suku->nama_suku ?? 'Belum diketahui';
    }

    public function getJorongLabelAttribute(): string
    {
        return $this->jorong->nama_jorong ?? 'Belum diketahui';
    }

    public function getSejarahTeksAttribute(): string
    {
        return $this->sejarah->sejarah ?? 'Sejarah rumah ini belum didokumentasikan oleh tim survei.';
    }

    // ------------------------------------------------------------------
    // Media (foto/video) — tabel media_rumah masih kosong untuk semua
    // rumah, jadi accessor ini akan sering mengembalikan kosong/null.
    // Path file diasumsikan disimpan lewat Storage::disk('public'),
    // sesuaikan prefix 'storage/' di bawah kalau konvensi upload beda.
    // ------------------------------------------------------------------

    public function getFotoUtamaAttribute(): string
    {
        $items = $this->relationLoaded('media') ? $this->media : $this->media()->get();
        $foto = $items->firstWhere('jenis_media', 'foto');

        return $foto ? asset('storage/' . $foto->file) : '';
    }

    public function getGaleriFotoAttribute()
    {
        $items = $this->relationLoaded('media') ? $this->media : $this->media()->get();

        return $items->where('jenis_media', 'foto')->values();
    }

    public function getVideoUtamaAttribute(): ?string
    {
        $items = $this->relationLoaded('media') ? $this->media : $this->media()->get();
        $video = $items->firstWhere('jenis_media', 'video');

        return $video ? asset('storage/' . $video->file) : null;
    }

    // ------------------------------------------------------------------
    // Lokasi
    // ------------------------------------------------------------------

    public function getHasLokasiAttribute(): bool
    {
        return $this->latitude !== null && $this->longitude !== null;
    }

    public function getKoordinatLabelAttribute(): string
    {
        if (! $this->has_lokasi) {
            return 'Koordinat belum tersedia';
        }

        $ns = $this->latitude < 0 ? 'LS' : 'LU';

        return number_format(abs($this->latitude), 6) . ' ' . $ns . ', ' . number_format($this->longitude, 6) . ' BT';
    }
}