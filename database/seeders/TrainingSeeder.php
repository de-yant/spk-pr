<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Training;

class TrainingSeeder extends Seeder
{
    public function run()
    {
        // Biar tidak bentrok PK "1".."100"
        Training::truncate();

        // Target distribusi
        $targetMembeli = 55;
        $targetTidak   = 45;

        // Kategori dasar
        $tipeList = ['30/60', '36/72', '42/72'];
        $pekerjaanList = ['karyawan', 'asn', 'wiraswasta', 'freelance'];

        $hargaByTipe = [
            '30/60' => 304000000,
            '36/72' => 364000000,
            '42/72' => 408000000,
        ];

        $cicilanByTipe = [
            '30/60' => 2300000,
            '36/72' => 3000000,
            '42/72' => 4000000,
        ];

        $dpPercentDefault = 0.10;

        $rows = [];

        /**
         * Helper membuat 1 row data dengan kelas tertentu (1 = membeli, 0 = tidak)
         * Dibuat "realistis" dengan bias fitur berbeda antar kelas.
         */
        $makeRow = function (int $i, int $kelas) use (
            $tipeList, $pekerjaanList, $hargaByTipe, $cicilanByTipe, $dpPercentDefault
        ) {
            $tipe = $tipeList[array_rand($tipeList)];
            $harga = $hargaByTipe[$tipe];

            // Kelas MEMBELI cenderung BI lolos, lokasi bagus, respon bagus, survei ya
            if ($kelas === 1) {
                $bi = 1; // lolos
                $lokasi = $this->weightedPick([1 => 35, 2 => 35, 3 => 20, 4 => 10]);
                $metode = $this->weightedPick([1 => 50, 2 => 30, 3 => 20]); // KPR banyak
                $respon = $this->weightedPick([1 => 60, 2 => 30, 3 => 10]); // responsif dominan
                $survei = $this->weightedPick([1 => 70, 0 => 30]);          // ya dominan
                $kunjungan = $this->weightedPick([1 => 10, 2 => 30, 3 => 35, 4 => 25]); // lebih sering
                $statusNikah = $this->weightedPick([1 => 15, 2 => 70, 3 => 10, 4 => 5]);
                $tanggungan = $this->weightedPick([0 => 10, 1 => 25, 2 => 35, 3 => 20, 4 => 10]);
                $usia = rand(27, 50);
                $penghasilan = rand(7000000, 20000000);
            } else {
                // Kelas TIDAK MEMBELI cenderung BI tidak lolos / lokasi kurang / respon buruk / survei tidak
                $bi = $this->weightedPick([2 => 60, 1 => 40]);
                $lokasi = $this->weightedPick([4 => 35, 3 => 35, 2 => 20, 1 => 10]);
                $metode = $this->weightedPick([1 => 45, 2 => 20, 3 => 35]); // cash keras lebih banyak
                $respon = $this->weightedPick([3 => 45, 2 => 40, 1 => 15]);
                $survei = $this->weightedPick([0 => 70, 1 => 30]);
                $kunjungan = $this->weightedPick([1 => 50, 2 => 30, 3 => 15, 4 => 5]); // jarang
                $statusNikah = $this->weightedPick([1 => 45, 2 => 40, 3 => 10, 4 => 5]);
                $tanggungan = $this->weightedPick([0 => 35, 1 => 30, 2 => 20, 3 => 10, 4 => 5]);
                $usia = rand(23, 45);
                $penghasilan = rand(4000000, 14000000);
            }

            // cicilan & dp tergantung metode
            $cicilan = 0;
            if (in_array($metode, [1, 2], true)) {
                $cicilan = $cicilanByTipe[$tipe] ?? 0;
            }

            $dp = 0;
            if (in_array($metode, [1, 2], true)) {
                $dp = (int) round($harga * $dpPercentDefault);
            } elseif ($metode === 3) {
                $dp = $harga;
            }

            $pekerjaan = $pekerjaanList[array_rand($pekerjaanList)];

            return [
                'id' => (string) $i, // <=== sesuai permintaan: 1..100 tanpa TR

                'nama' => 'Konsumen ' . $i,
                'no_hp' => '08123' . rand(1000000, 9999999),

                'harga' => (int) $harga,
                'tipe' => $tipe,
                'lokasi' => (int) $lokasi,

                'bi' => (int) $bi,
                'cicilan' => (int) $cicilan,
                'dp' => (int) $dp,

                'usia' => (int) $usia,
                'penghasilan' => (int) $penghasilan,
                'pekerjaan' => $pekerjaan,

                'status_nikah' => (int) $statusNikah,
                'tanggungan' => (int) $tanggungan,

                'metode' => (int) $metode,
                'kunjungan' => (int) $kunjungan,
                'respon' => (int) $respon,

                'survei' => (int) $survei,
                'keputusan' => (int) $kelas,
            ];
        };

        // buat 55 membeli
        $i = 1;
        for ($m = 0; $m < $targetMembeli; $m++, $i++) {
            $rows[] = $makeRow($i, 1);
        }

        // buat 45 tidak membeli
        for ($t = 0; $t < $targetTidak; $t++, $i++) {
            $rows[] = $makeRow($i, 0);
        }

        // acak supaya tidak urut (biar realistis)
        shuffle($rows);

        // pastikan id tetap unik 1..100 (set ulang id setelah shuffle)
        foreach ($rows as $idx => &$row) {
            $row['id'] = (string) ($idx + 1);
        }
        unset($row);

        // insert
        foreach ($rows as $row) {
            Training::create($row);
        }
    }

    /**
     * Weighted random pick: [value => weight]
     */
    private function weightedPick(array $weights): int
    {
        $sum = array_sum($weights);
        $r = rand(1, $sum);
        $running = 0;
        foreach ($weights as $value => $w) {
            $running += $w;
            if ($r <= $running) return (int) $value;
        }
        // fallback
        return (int) array_key_first($weights);
    }
}
