<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\CalonKonsumen;

class CalonKonsumenSeeder extends Seeder
{
    public function run()
    {
        // Matikan FK sementara (SQLite)
        DB::statement('PRAGMA foreign_keys = OFF;');

        // Hapus tabel anak dulu (kalau ada)
        DB::table('survei')->delete();           // kalau tabel survei ada
        DB::table('calon_konsumen')->delete();

        // Hidupkan FK
        DB::statement('PRAGMA foreign_keys = ON;');

        $data = [
            [
                'nama' => 'Andi Saputra',
                'no_hp' => '081234560001',
                'harga' => 304000000,
                'tipe' => '30/60',
                'lokasi' => 2,
                'bi' => 1,
                'cicilan' => 2300000,
                'dp' => 30400000,
                'usia' => 30,
                'penghasilan' => 9000000,
                'pekerjaan' => 'karyawan',
                'status_nikah' => 2,
                'tanggungan' => 1,
                'metode' => 1,
                'kunjungan' => 2
            ],
            [
                'nama' => 'Bambang Setiawan',
                'no_hp' => '081234560002',
                'harga' => 364000000,
                'tipe' => '36/72',
                'lokasi' => 3,
                'bi' => 1,
                'cicilan' => 3000000,
                'dp' => 36400000,
                'usia' => 35,
                'penghasilan' => 8500000,
                'pekerjaan' => 'wiraswasta',
                'status_nikah' => 2,
                'tanggungan' => 2,
                'metode' => 1,
                'kunjungan' => 1
            ],
            [
                'nama' => 'Candra Wijaya',
                'no_hp' => '081234560003',
                'harga' => 408000000,
                'tipe' => '42/72',
                'lokasi' => 1,
                'bi' => 1,
                'cicilan' => 4000000,
                'dp' => 40800000,
                'usia' => 40,
                'penghasilan' => 15000000,
                'pekerjaan' => 'asn',
                'status_nikah' => 2,
                'tanggungan' => 3,
                'metode' => 1,
                'kunjungan' => 3
            ],
            [
                'nama' => 'Dedi Pratama',
                'no_hp' => '081234560004',
                'harga' => 304000000,
                'tipe' => '30/60',
                'lokasi' => 4,
                'bi' => 2,
                'cicilan' => 2300000,
                'dp' => 30400000,
                'usia' => 28,
                'penghasilan' => 6000000,
                'pekerjaan' => 'freelance',
                'status_nikah' => 1,
                'tanggungan' => 0,
                'metode' => 1,
                'kunjungan' => 1
            ],
            [
                'nama' => 'Eka Nugraha',
                'no_hp' => '081234560005',
                'harga' => 364000000,
                'tipe' => '36/72',
                'lokasi' => 2,
                'bi' => 1,
                'cicilan' => 3000000,
                'dp' => 36400000,
                'usia' => 33,
                'penghasilan' => 10000000,
                'pekerjaan' => 'karyawan',
                'status_nikah' => 2,
                'tanggungan' => 2,
                'metode' => 2,
                'kunjungan' => 2
            ],
        ];

        foreach ($data as $row) {
            CalonKonsumen::create($row);
        }
    }
}
