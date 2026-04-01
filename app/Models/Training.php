<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    protected $table = 'training';

    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'nama',
        'no_hp',

        'harga',
        'tipe',
        'lokasi',

        'bi',
        'cicilan',
        'dp',

        'usia',
        'penghasilan',
        'pekerjaan',
        'status_nikah',
        'tanggungan',

        'metode',
        'kunjungan',
        'respon',

        'survei',
        'keputusan',
    ];

    /**
     * Cast tipe data otomatis
     * supaya Naive Bayes tidak membaca string
     */
    protected $casts = [
        'harga' => 'integer',
        'lokasi' => 'integer',
        'bi' => 'integer',
        'usia' => 'integer',
        'penghasilan' => 'integer',
        'cicilan' => 'integer',
        'dp' => 'integer',
        'status_nikah' => 'integer',
        'tanggungan' => 'integer',
        'metode' => 'integer',
        'kunjungan' => 'integer',
        'respon' => 'integer',
        'survei' => 'integer',
        'keputusan' => 'integer',
    ];
}
