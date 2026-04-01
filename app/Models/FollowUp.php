<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class FollowUp extends Model
{
    protected $table = 'follow_ups';

    protected $fillable = [
        'calon_konsumen_id',
        'tgl_followup',
        'respon_followup',
        'catatan_followup',
    ];

    protected $casts = [
        'respon_followup' => 'integer',
        'tgl_followup'    => 'date',
    ];

    /**
     * Mapping kategori respon
     */
    public const RESPON = [
        1 => 'Responsif',
        2 => 'Lambat',
        3 => 'Tidak Respon',
    ];

    /**
     * Relasi ke calon konsumen
     */
    public function calonKonsumen()
    {
        return $this->belongsTo(CalonKonsumen::class, 'calon_konsumen_id', 'id');
    }

    /**
     * Label respon (agar otomatis jadi teks)
     */
    protected function responLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => self::RESPON[$this->respon_followup] ?? null
        );
    }
}
