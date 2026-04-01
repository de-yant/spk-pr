<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\FollowUp;
use App\Models\Survei;
use App\Models\PrediksiKonsumen;

class CalonKonsumen extends Model
{
    protected $table = 'calon_konsumen';

    // PK ikut training: string 'id'
    protected $primaryKey = 'id';

    public $timestamps = true;

    /**
     * Sama seperti training (tanpa respon & survei)
     */
    protected $fillable = [
        'nama',
        'no_hp',

        // DATA RUMAH
        'harga',
        'tipe',
        'lokasi',

        // DATA KREDIT
        'bi',
        'cicilan',
        'dp',

        // DATA DEMOGRAFI
        'usia',
        'penghasilan',
        'pekerjaan',
        'status_nikah',
        'tanggungan',

        // PERILAKU
        'metode',
        'kunjungan',
    ];

    protected $casts = [
        'harga' => 'integer',
        'lokasi' => 'integer',
        'bi' => 'integer',
        'cicilan' => 'integer',
        'dp' => 'integer',
        'usia' => 'integer',
        'penghasilan' => 'integer',
        'status_nikah' => 'integer',
        'tanggungan' => 'integer',
        'metode' => 'integer',
        'kunjungan' => 'integer',
    ];

    protected $attributes = [
        'kunjungan' => 0,
    ];

    // Mapping tetap boleh dipakai
    public const STATUS_NIKAH = [
        'Belum Menikah' => 1,
        'Menikah' => 2,
        'Cerai Hidup' => 3,
        'Cerai Mati' => 4,
    ];

    public const LOKASI = [
        'Sangat Strategis' => 1,
        'Strategis' => 2,
        'Cukup Strategis' => 3,
        'Kurang Strategis' => 4,
    ];

    public const BI = [
        'Lolos' => 1,
        'Tidak Lolos' => 2,
    ];

    public const METODE = [
        'KPR' => 1,
        'Cash Bertahap' => 2,
        'Cash Keras' => 3,
    ];

    public const HARGA_BY_TIPE = [
        '30/60' => 304000000,
        '36/72' => 364000000,
        '42/72' => 408000000,
    ];

    public const CICILAN_BY_TIPE = [
        '30/60' => 2300000,
        '36/72' => 3000000,
        '42/72' => 4000000,
    ];

    public const DP_PERCENT_DEFAULT = 0.10;

    protected static function booted(): void
    {
        static::saving(function (self $model) {
            $model->applyPricingDefaults();
            $model->normalizeNumbers();
        });
    }

    public function applyPricingDefaults(): void
    {
        $tipe = $this->tipe;
        $metode = (int) ($this->metode ?? 0);

        $harga = self::HARGA_BY_TIPE[$tipe] ?? 0;

        $cicilan = 0;
        if (in_array($metode, [self::METODE['KPR'], self::METODE['Cash Bertahap']], true)) {
            $cicilan = self::CICILAN_BY_TIPE[$tipe] ?? 0;
        }

        $dp = 0;
        if (in_array($metode, [self::METODE['KPR'], self::METODE['Cash Bertahap']], true)) {
            $dp = (int) round($harga * self::DP_PERCENT_DEFAULT);
        } elseif ($metode === self::METODE['Cash Keras']) {
            $dp = $harga;
        }

        if ($this->harga === null)
            $this->harga = (int) $harga;
        if ($this->cicilan === null)
            $this->cicilan = (int) $cicilan;
        if ($this->dp === null)
            $this->dp = (int) $dp;
    }

    public function normalizeNumbers(): void
    {
        foreach ([
            'harga',
            'lokasi',
            'bi',
            'cicilan',
            'dp',
            'usia',
            'penghasilan',
            'status_nikah',
            'tanggungan',
            'metode',
            'kunjungan'
        ] as $f) {
            if ($this->{$f} !== null) {
                $this->{$f} = max(0, (int) $this->{$f});
            }
        }
    }

    protected function statusNikahLabel(): Attribute
    {
        return Attribute::make(
            get: fn() => array_search($this->status_nikah, self::STATUS_NIKAH, true) ?: null
        );
    }

    protected function biLabel(): Attribute
    {
        return Attribute::make(
            get: fn() => array_search($this->bi, self::BI, true) ?: null
        );
    }

    protected function metodeLabel(): Attribute
    {
        return Attribute::make(
            get: fn() => array_search($this->metode, self::METODE, true) ?: null
        );
    }

    /**
     * Relasi: sekarang FK idealnya pakai 'id' juga.
     * Kalau tabel FollowUp/Survei/Prediksi masih pakai id_calon_konsumen, relasi ini harus ikut disesuaikan di tabelnya.
     */
    // public function followUps()
    // {
    //     return $this->hasMany(FollowUp::class, 'id', 'id');
    // }

    // public function surveiData()
    // {
    //     return $this->hasMany(Survei::class, 'id', 'id');
    // }

    public function followUps()
    {
        return $this->hasMany(FollowUp::class, 'calon_konsumen_id', 'id');
    }

    public function surveiItems()
    {
        // karena tabel survei primary key id_survei, tapi FK tetap calon_konsumen_id
        return $this->hasMany(Survei::class, 'calon_konsumen_id', 'id');
    }

    public function prediksi()
    {
        return $this->hasMany(PrediksiKonsumen::class, 'id', 'id');
    }
}
