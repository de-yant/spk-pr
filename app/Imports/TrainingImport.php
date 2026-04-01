<?php

namespace App\Imports;

use App\Models\Training;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TrainingImport implements ToModel, WithHeadingRow
{
    private ?int $counter = null;

    private array $statusNikahMap = [
        'belum menikah' => 1,
        'menikah' => 2,
        'cerai hidup' => 3,
        'cerai mati' => 4,
    ];

    private array $lokasiMap = [
        'sangat strategis' => 1,
        'strategis' => 2,
        'cukup strategis' => 3,
        'kurang strategis' => 4,
    ];

    private array $biMap = [
        'lolos' => 1,
        'tidak lolos' => 2,
    ];

    private array $metodeMap = [
        'kpr' => 1,
        'cash bertahap' => 2,
        'cash keras' => 3,
        'cash' => 3,
    ];

    private array $responMap = [
        'responsif' => 1,
        'lambat' => 2,
        'tidak respon' => 3,
    ];

    private array $surveiMap = [
        'ya' => 1,
        'tidak' => 0,
    ];

    private array $keputusanMap = [
        'membeli' => 1,
        'tidak membeli' => 0,
    ];

    private function norm($v): string
    {
        return strtolower(trim((string) $v));
    }

    private function encode($value, array $map, array $allowedNumeric, string $fieldName)
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (is_numeric($value)) {
            $n = (int) $value;
            if (!in_array($n, $allowedNumeric, true)) {
                throw new \Exception("Nilai {$fieldName} angka '{$n}' tidak valid.");
            }
            return $n;
        }

        $key = $this->norm($value);
        if (!array_key_exists($key, $map)) {
            throw new \Exception("Nilai {$fieldName} '{$value}' tidak dikenal.");
        }

        return (int) $map[$key];
    }

    private function generateId(): string
    {
        if ($this->counter === null) {
            $last = Training::orderBy('id', 'desc')->value('id');
            $num = 0;

            if ($last && preg_match('/^(\d+)\s*TR$/i', trim($last), $m)) {
                $num = (int) $m[1];
            }

            $this->counter = $num;
        }

        $this->counter++;
        return str_pad((string) $this->counter, 3, '0', STR_PAD_LEFT) . 'TR';
    }

    public function model(array $row)
    {
        // ===== SKIP baris kosong (biasanya baris bawah di excel) =====
        $nama = trim((string) ($row['nama'] ?? ''));
        $noHp = trim((string) ($row['no_hp'] ?? ''));

        if ($nama === '' && $noHp === '') {
            return null; // <--- ini penting, supaya baris kosong tidak diinsert
        }

        // ===== ID =====
        $id = trim((string) ($row['id'] ?? ''));
        if ($id === '') {
            $id = $this->generateId();
        } else {
            if (Training::where('id', $id)->exists()) {
                throw new \Exception("ID {$id} sudah terdaftar.");
            }
        }

        // ===== Encode kategori =====
        $lokasi = $this->encode($row['lokasi'] ?? null, $this->lokasiMap, [1,2,3,4], 'lokasi');
        $bi = $this->encode($row['bi'] ?? null, $this->biMap, [1,2], 'bi');
        $statusNikah = $this->encode($row['status_nikah'] ?? null, $this->statusNikahMap, [1,2,3,4], 'status_nikah');
        $metode = $this->encode($row['metode'] ?? null, $this->metodeMap, [1,2,3], 'metode');
        $respon = $this->encode($row['respon'] ?? null, $this->responMap, [1,2,3], 'respon');
        $survei = $this->encode($row['survei'] ?? 0, $this->surveiMap, [0,1], 'survei');
        $keputusan = $this->encode($row['keputusan'] ?? null, $this->keputusanMap, [0,1], 'keputusan');

        // ===== WAJIB: kategori penting tidak boleh null =====
        $required = [
            'lokasi' => $lokasi,
            'bi' => $bi,
            'status_nikah' => $statusNikah,
            'metode' => $metode,
            'respon' => $respon,
            'keputusan' => $keputusan,
        ];

        foreach ($required as $field => $val) {
            if ($val === null) {
                throw new \Exception("Kolom '{$field}' wajib diisi (angka/kode) pada baris data: {$nama} ({$noHp}).");
            }
        }

        return new Training([
            'id' => $id,
            'nama' => $nama,
            'no_hp' => $noHp,

            'harga' => (int) ($row['harga'] ?? 0),
            'tipe' => (string) ($row['tipe'] ?? ''),

            'lokasi' => $lokasi,
            'bi' => $bi,

            'usia' => (int) ($row['usia'] ?? 0),
            'penghasilan' => (int) ($row['penghasilan'] ?? 0),
            'cicilan' => (int) ($row['cicilan'] ?? 0),
            'dp' => (int) ($row['dp'] ?? 0),

            'pekerjaan' => (string) ($row['pekerjaan'] ?? ''),

            'status_nikah' => $statusNikah,
            'tanggungan' => (int) ($row['tanggungan'] ?? 0),

            'metode' => $metode,
            'kunjungan' => (int) ($row['kunjungan'] ?? 0),
            'respon' => $respon,

            'survei' => $survei ?? 0,
            'keputusan' => $keputusan,
        ]);
    }
}
