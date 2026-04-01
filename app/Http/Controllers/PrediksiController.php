<?php

namespace App\Http\Controllers;

use App\Models\CalonKonsumen;
use App\Models\Training;
use Illuminate\Http\Request;

class PrediksiController extends Controller
{
    /**
     * INDEX:
     * - Menampilkan halaman list data calon konsumen
     * - Support search (q) dan pagination (per_page / all)
     * - Setiap item ditambahkan hasil prediksi Naive Bayes agar bisa tampil di tabel index
     */
    public function index(Request $request)
    {
        // keyword pencarian (opsional)
        $q = $request->q;

        // jumlah item per halaman, default 10
        // jika per_page = 'all' => tampilkan semua data tanpa pagination
        $perPage = $request->per_page ?? 10;

        // query builder awal
        $query = CalonKonsumen::query();

        /**
         * Jika ada keyword q:
         * - cari di kolom nama atau no_hp
         */
        if ($q) {
            $query->where(function ($qq) use ($q) {
                $qq->where('nama', 'like', "%{$q}%")
                    ->orWhere('no_hp', 'like', "%{$q}%");
            });
        }

        /**
         * Tentukan mode pagination:
         * - per_page !== 'all' => paginated
         * - per_page === 'all' => ambil semua data
         */
        $isPaginated = $perPage !== 'all';

        if (!$isPaginated) {
            // ambil semua data (tanpa paginate) urut terbaru
            $items = $query->latest()->get();
        } else {
            // ambil data paginated urut terbaru + bawa query string (q/per_page) agar tidak hilang saat pindah halaman
            $items = $query->latest()->paginate((int) $perPage)->withQueryString();
        }

        /**
         * Fungsi untuk menempelkan hasil prediksi ke object CalonKonsumen
         * Tujuan:
         * - agar di blade index bisa langsung tampil: prediksi_text, prob_membeli, prob_tidak_membeli
         */
        $applyPrediction = function (CalonKonsumen $identitas) {
            // bangun fitur (X) dari data calon konsumen
            $x = $this->buildXFromCalonKonsumen($identitas);

            // jalankan prediksi Naive Bayes
            $result = $this->naiveBayesPredict($x);

            /**
             * Default nilai supaya blade aman (tidak error kalau null)
             * prediksi_label:
             * - 1 = Membeli
             * - 0 = Tidak Membeli
             */
            $identitas->prediksi_label = $result['prediksi'] ?? null;
            $identitas->prob_membeli = null;
            $identitas->prob_tidak_membeli = null;
            $identitas->prediksi_error = $result['error'] ?? null;

            /**
             * Jika tidak ada error:
             * ambil probabilitas per kelas untuk ditampilkan di index
             */
            if (!isset($result['error'])) {
                $probs = $result['probabilitas'] ?? [];

                // SESUAI SEEDER:
                // keputusan 1 = Membeli
                // keputusan 0 = Tidak Membeli
                $identitas->prob_membeli = $probs[1] ?? $probs['1'] ?? null;        // kelas 1
                $identitas->prob_tidak_membeli = $probs[0] ?? $probs['0'] ?? null;  // kelas 0
            }

            // Label teks untuk view: "Membeli" / "Tidak Membeli"
            $identitas->prediksi_text = $this->kelasToLabel($identitas->prediksi_label);

            return $identitas;
        };

        /**
         * Terapkan prediksi ke semua item:
         * - Jika paginated => transform collection di dalam paginator
         * - Jika non-paginated => map biasa
         */
        if ($isPaginated) {
            $items->getCollection()->transform($applyPrediction);
        } else {
            $items = $items->map($applyPrediction);
        }

        // kirim ke view index
        return view('pages.prediksi.index', [
            'title' => 'Prediksi Hasil (Data Awal)',
            'items' => $items,
            'isPaginated' => $isPaginated, // penting untuk view index (misal: tampilkan pagination atau tidak)
        ]);
    }

    public function show($id)
    {
        $identitas = CalonKonsumen::findOrFail($id); // pasti ambil record DB

        $x = $this->buildXFromCalonKonsumen($identitas);
        $result = $this->naiveBayesPredict($x);

        $result['prediksi_text'] = isset($result['prediksi'])
            ? $this->kelasToLabel($result['prediksi'])
            : null;

        return view('pages.prediksi.show', compact('identitas', 'x', 'result'));
    }
    // private function buildXFromCalonKonsumen(CalonKonsumen $c): array
    // {
    //     $toStrOrNull = function ($v): ?string {
    //         if ($v === null)
    //             return null;
    //         $s = trim((string) $v);
    //         return $s === '' ? null : strtolower($s);
    //     };

    //     $toIntOrNull = function ($v): ?int {
    //         if ($v === null || $v === '')
    //             return null;
    //         return is_numeric($v) ? (int) $v : null;
    //     };

    //     // Ambil mentah (sesuai training)
    //     $x = [
    //         'tipe' => $toStrOrNull($c->tipe),
    //         'harga' => ($toIntOrNull($c->harga) !== null) ? (string) $toIntOrNull($c->harga) : null,
    //         'lokasi' => ($toIntOrNull($c->lokasi) !== null) ? (string) $toIntOrNull($c->lokasi) : null,

    //         'bi' => ($toIntOrNull($c->bi) !== null) ? (string) $toIntOrNull($c->bi) : null,
    //         'cicilan' => ($toIntOrNull($c->cicilan) !== null) ? (string) $toIntOrNull($c->cicilan) : null,
    //         'dp' => ($toIntOrNull($c->dp) !== null) ? (string) $toIntOrNull($c->dp) : null,

    //         'usia' => ($toIntOrNull($c->usia) !== null) ? (string) $toIntOrNull($c->usia) : null,
    //         'penghasilan' => ($toIntOrNull($c->penghasilan) !== null) ? (string) $toIntOrNull($c->penghasilan) : null,
    //         'pekerjaan' => $toStrOrNull($c->pekerjaan),

    //         'status_nikah' => ($toIntOrNull($c->status_nikah) !== null) ? (string) $toIntOrNull($c->status_nikah) : null,
    //         'tanggungan' => ($toIntOrNull($c->tanggungan) !== null) ? (string) $toIntOrNull($c->tanggungan) : null,

    //         'metode' => ($toIntOrNull($c->metode) !== null) ? (string) $toIntOrNull($c->metode) : null,
    //         'kunjungan' => ($toIntOrNull($c->kunjungan) !== null) ? (string) $toIntOrNull($c->kunjungan) : null,

    //         // kalau calon_konsumen belum punya respon & survei, ini akan null dan otomatis dibuang
    //         'respon' => ($toIntOrNull($c->respon ?? null) !== null) ? (string) $toIntOrNull($c->respon ?? null) : null,
    //         'survei' => ($toIntOrNull($c->survei ?? null) !== null) ? (string) $toIntOrNull($c->survei ?? null) : null,
    //     ];

    //     return array_filter($x, fn($v) => $v !== null && $v !== '');
    // }

    private function buildXFromCalonKonsumen(CalonKonsumen $c): array
{
    $toStrOrNull = function ($v): ?string {
        if ($v === null) return null;
        $s = trim((string) $v);
        return $s === '' ? null : strtolower($s);
    };

    $toIntOrNull = function ($v): ?int {
        if ($v === null || $v === '') return null;
        return is_numeric($v) ? (int) $v : null;
    };

    // Ambil follow up terbaru (kalau ada)
    $latestFollowUp = $c->relationLoaded('followUps')
        ? $c->followUps->sortByDesc('tgl_followup')->first()
        : $c->followUps()->latest('tgl_followup')->first();

    // Ambil survei terbaru (kalau ada)
    $latestSurvei = $c->relationLoaded('surveiItems')
        ? $c->surveiItems->sortByDesc('tgl_survei')->first()
        : $c->surveiItems()->latest('tgl_survei')->first();

    // Nilai fitur tambahan:
    // - respon dari follow up => respon_followup (1/2/3)
    // - survei => survei (1=Ya, 2=Tidak)
    $respon = $latestFollowUp?->respon_followup; // int|null
    $survei = $latestSurvei?->survei;           // int|null

    $x = [
        'tipe' => $toStrOrNull($c->tipe),
        'harga' => ($toIntOrNull($c->harga) !== null) ? (string) $toIntOrNull($c->harga) : null,
        'lokasi' => ($toIntOrNull($c->lokasi) !== null) ? (string) $toIntOrNull($c->lokasi) : null,

        'bi' => ($toIntOrNull($c->bi) !== null) ? (string) $toIntOrNull($c->bi) : null,
        'cicilan' => ($toIntOrNull($c->cicilan) !== null) ? (string) $toIntOrNull($c->cicilan) : null,
        'dp' => ($toIntOrNull($c->dp) !== null) ? (string) $toIntOrNull($c->dp) : null,

        'usia' => ($toIntOrNull($c->usia) !== null) ? (string) $toIntOrNull($c->usia) : null,
        'penghasilan' => ($toIntOrNull($c->penghasilan) !== null) ? (string) $toIntOrNull($c->penghasilan) : null,
        'pekerjaan' => $toStrOrNull($c->pekerjaan),

        'status_nikah' => ($toIntOrNull($c->status_nikah) !== null) ? (string) $toIntOrNull($c->status_nikah) : null,
        'tanggungan' => ($toIntOrNull($c->tanggungan) !== null) ? (string) $toIntOrNull($c->tanggungan) : null,

        'metode' => ($toIntOrNull($c->metode) !== null) ? (string) $toIntOrNull($c->metode) : null,
        'kunjungan' => ($toIntOrNull($c->kunjungan) !== null) ? (string) $toIntOrNull($c->kunjungan) : null,

        // tambahan dari follow up & survei
        'respon' => ($toIntOrNull($respon) !== null) ? (string) $toIntOrNull($respon) : null,
        'survei' => ($toIntOrNull($survei) !== null) ? (string) $toIntOrNull($survei) : null,
    ];

    return array_filter($x, fn($v) => $v !== null && $v !== '');
}

    private function kelasToLabel($kelas): ?string
    {
        if ($kelas === null)
            return null;

        $k = (string) $kelas;

        // mapping utama
        if ($k === '1')
            return 'Membeli';
        if ($k === '0')
            return 'Tidak Membeli';

        // fallback jika ternyata kelas disimpan sebagai string
        $lower = strtolower($k);
        if (in_array($lower, ['membeli', 'beli', 'ya', 'yes'], true))
            return 'Membeli';
        if (in_array($lower, ['tidak membeli', 'tidak', 'no'], true))
            return 'Tidak Membeli';

        // kalau tidak cocok, kembalikan apa adanya (agar tetap terbaca)
        return $k;
    }


    private function naiveBayesPredict(array $x): array
    {
        // list nama fitur yang dipakai dari X
        $features = array_keys($x);

        // total data training
        $total = Training::count();
        if ($total === 0) {
            return ['prediksi' => null, 'error' => 'Data training kosong'];
        }

        /**
         * Ambil daftar kelas dari kolom keputusan (distinct)
         * Contoh: [0, 1]
         */
        $classes = Training::select('keputusan')
            ->groupBy('keputusan')
            ->pluck('keputusan')
            ->toArray();

        $logScores = [];   // log-score per kelas
        $rawScores = [];   // raw-score per kelas (prior * semua likelihood)
        $breakdown = [];   // detail per kelas dan per fitur

        /**
         * Loop tiap kelas:
         * hitung P(class) dan P(feature=value | class)
         */
        foreach ($classes as $class) {
            // jumlah data training pada kelas ini
            $classCount = Training::where('keputusan', $class)->count();
            if ($classCount === 0)
                continue;

            /**
             * PRIOR:
             * P(class) = classCount / total
             */
            $prior = $classCount / $total;

            /**
             * Inisialisasi:
             * - logProb mulai dari log(prior)
             * - rawScore mulai dari prior
             */
            $logProb = log($prior);
            $rawScore = $prior;

            // siapkan struktur breakdown untuk kelas ini
            $breakdown[$class] = [
                'class' => $class,
                'class_count' => $classCount,
                'total' => $total,
                'prior' => $prior,
                'log_prior' => log($prior),
                'raw_score' => null, // nanti diisi setelah selesai
                'log_score' => null, // nanti diisi setelah selesai
                'features' => [],
            ];

            /**
             * Loop tiap fitur:
             * hitung likelihood dengan Laplace smoothing
             */
            foreach ($features as $f) {
                $value = $x[$f];

                /**
                 * k = jumlah kategori unik untuk fitur ini (distinct)
                 * dipakai untuk Laplace smoothing:
                 * (countFV + 1) / (classCount + k)
                 */
                $k = Training::whereNotNull($f)->distinct()->count($f);
                $k = max($k, 1);

                /**
                 * countFV = jumlah data training dengan:
                 * keputusan = class
                 * dan fitur f = value
                 */
                $countFV = Training::where('keputusan', $class)
                    ->where($f, $value)
                    ->count();

                /**
                 * Laplace smoothing:
                 * likelihood = (countFV + 1) / (classCount + k)
                 */
                $likelihood = ($countFV + 1) / ($classCount + $k);
                $logLike = log($likelihood);

                // akumulasi untuk skor kelas ini
                $logProb += $logLike;
                $rawScore *= $likelihood;

                // simpan detail per fitur
                $breakdown[$class]['features'][$f] = [
                    'value' => $value,
                    'count_fv' => $countFV,
                    'k' => $k,
                    'likelihood' => $likelihood,
                    'log_likelihood' => $logLike,
                    'formula' => "($countFV + 1) / ($classCount + $k)",
                ];
            }

            // simpan skor akhir kelas ini
            $logScores[$class] = $logProb;
            $rawScores[$class] = $rawScore;

            // simpan skor ke breakdown
            $breakdown[$class]['log_score'] = $logProb;
            $breakdown[$class]['raw_score'] = $rawScore;
        }

        // jika tidak ada skor yang bisa dihitung
        if (empty($logScores)) {
            return ['prediksi' => null, 'error' => 'Tidak bisa menghitung skor kelas.'];
        }

        /**
         * Prediksi:
         * ambil kelas dengan log-score terbesar (paling stabil dibanding rawScore)
         */
        arsort($logScores);
        $prediksi = array_key_first($logScores);

        /**
         * Probabilitas dari logScores pakai softmax:
         * - menghindari underflow (angka jadi 0) kalau fitur banyak
         */
        $probSoftmax = $this->softmax($logScores);

        /**
         * Probabilitas versi rawScore:
         * - lebih mudah dipahami (normalisasi dari hasil perkalian)
         */
        $sumRaw = array_sum($rawScores);
        $probRaw = [];
        foreach ($rawScores as $cls => $v) {
            $probRaw[$cls] = $sumRaw > 0 ? $v / $sumRaw : 0.0;
        }

        return [
            'prediksi' => $prediksi,
            'scores_log' => $logScores,
            'scores_raw' => $rawScores,
            'probabilitas' => $probSoftmax,       // output utama (stabil)
            'probabilitas_raw' => $probRaw,       // output tambahan (mudah dibaca)
            'breakdown' => $breakdown,
        ];
    }

    /**
     * softmax:
     * - mengubah log-score menjadi probabilitas normalisasi
     * - trik stabil: kurangi dengan max(logScores) sebelum exp()
     */
    private function softmax(array $logScores): array
    {
        // ambil log-score terbesar untuk stabilitas
        $max = max($logScores);

        $sum = 0.0;
        $exp = [];

        // hitung exp(logScore - max)
        foreach ($logScores as $cls => $ls) {
            $e = exp($ls - $max);
            $exp[$cls] = $e;
            $sum += $e;
        }

        // normalisasi jadi probabilitas
        foreach ($exp as $cls => $e) {
            $exp[$cls] = $sum > 0 ? $e / $sum : 0.0;
        }

        return $exp;
    }
}
