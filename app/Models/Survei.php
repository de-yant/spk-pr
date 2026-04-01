<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Survei extends Model
{
    protected $table = 'survei';
    protected $primaryKey = 'id_survei';

    protected $fillable = [
        'calon_konsumen_id',
        'survei',
        'tgl_survei',
        'hasil_survei',
        'catatan_survei',
    ];

    // Biar otomatis jadi tipe yang benar
    protected $casts = [
        'survei' => 'integer',
        'tgl_survei' => 'date',
    ];

    // Accessor label (biar di blade gampang)
    public function getSurveiLabelAttribute(): string
    {
        return match ((int) $this->survei) {
            1 => 'Ya',
            2 => 'Tidak',
            default => '-',
        };
    }

    public function calonKonsumen()
    {
        return $this->belongsTo(CalonKonsumen::class, 'calon_konsumen_id', 'id');
    }
}



