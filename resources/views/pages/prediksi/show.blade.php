<x-app-layout>

    <x-slot name="title">
        {{ $title ?? 'Detail Prediksi' }}
    </x-slot>

    <x-slot name="header">
        <div class="flex items-center gap-3 min-w-0">
            <x-heroicon-o-chart-bar class="w-6 h-6 text-[#1b1b18] dark:text-[#EDEDEC] shrink-0" />
            <h2 class="font-semibold text-lg sm:text-xl text-[#1b1b18] dark:text-[#EDEDEC] leading-tight truncate">
                {{ __('Detail Prediksi Konsumen') }}
            </h2>
        </div>
    </x-slot>

    @php
        // =========================
        // 1) Data utama
        // =========================

        // ID konsumen (support id_calon_konsumen / id)
        $id = $identitas->id_calon_konsumen ?? ($identitas->id ?? '-');

        // hasil prediksi
        $pred = $result['prediksi'] ?? null; // 0/1
        $predText = $result['prediksi_text'] ?? null; // Membeli/Tidak Membeli
        $err = $result['error'] ?? null;

        // probabilitas (prioritas: probabilitas_raw karena lebih mudah dipahami)
        $probsRaw = $result['probabilitas_raw'] ?? null;
        $probsSoft = $result['probabilitas'] ?? null;

        $pM_raw = is_array($probsRaw) ? $probsRaw[1] ?? ($probsRaw['1'] ?? null) : null;
        $pT_raw = is_array($probsRaw) ? $probsRaw[0] ?? ($probsRaw['0'] ?? null) : null;

        $pM_soft = is_array($probsSoft) ? $probsSoft[1] ?? ($probsSoft['1'] ?? null) : null;
        $pT_soft = is_array($probsSoft) ? $probsSoft[0] ?? ($probsSoft['0'] ?? null) : null;

        // fallback: kalau raw tidak ada, pakai softmax
        $pM = is_numeric($pM_raw) ? (float) $pM_raw : (is_numeric($pM_soft) ? (float) $pM_soft : null);
        $pT = is_numeric($pT_raw) ? (float) $pT_raw : (is_numeric($pT_soft) ? (float) $pT_soft : null);

        // skor
        $scoresLog = $result['scores_log'] ?? [];
        $scoresRaw = $result['scores_raw'] ?? [];

        // breakdown per kelas dan fitur
        $breakdown = $result['breakdown'] ?? [];

        // helper format angka/persen
        $pct = fn($v) => is_numeric($v) ? number_format(((float) $v) * 100, 2) . '%' : '-';
        $num = fn($v, $d = 6) => is_numeric($v) ? number_format((float) $v, $d, '.', '') : '-';

        // untuk progress bar
        $barM = is_numeric($pM) ? max(0, min(100, $pM * 100)) : 0;
        $barT = is_numeric($pT) ? max(0, min(100, $pT * 100)) : 0;

        $isMembeli = ((string) $pred) === '1';

        // =========================
        // 2) Mapping angka -> label
        // =========================
        $map = [
            'lokasi' => [
                '1' => 'Sangat Strategis',
                '2' => 'Strategis',
                '3' => 'Cukup Strategis',
                '4' => 'Kurang Strategis',
            ],
            'bi' => [
                '1' => 'Lolos',
                '2' => 'Tidak Lolos',
            ],
            'metode' => [
                '1' => 'KPR',
                '2' => 'Cash Bertahap',
                '3' => 'Cash Keras',
            ],
            'status_nikah' => [
                '1' => 'Belum Menikah',
                '2' => 'Menikah',
                '3' => 'Cerai Hidup',
                '4' => 'Cerai Mati',
            ],

            // OPTIONAL (kalau fitur ini ada di training / model kamu)
            'respon' => [
                '1' => 'Responsif',
                '2' => 'Cukup Responsif',
                '3' => 'Tidak Responsif',
            ],
            'survei' => [
                '1' => 'Ya',
                '0' => 'Tidak',
            ],
        ];

        // Nama field agar rapi
        $featureName = [
            'nama' => 'Nama',
            'no_hp' => 'No HP',
            'harga' => 'Harga Rumah',
            'tipe' => 'Tipe Rumah',
            'lokasi' => 'Lokasi',
            'bi' => 'BI Checking',
            'cicilan' => 'Cicilan',
            'dp' => 'DP',
            'usia' => 'Usia',
            'penghasilan' => 'Penghasilan',
            'pekerjaan' => 'Pekerjaan',
            'status_nikah' => 'Status Nikah',
            'tanggungan' => 'Jumlah Tanggungan',
            'metode' => 'Metode Pembayaran',
            'kunjungan' => 'Jumlah Kunjungan',
            'respon' => 'Respon',
            'survei' => 'Survei',

            // jika kamu pakai bucket di X (opsional)
            'usia_kat' => 'Kategori Usia',
            'penghasilan_kat' => 'Kategori Penghasilan',
            'dp_kat' => 'Kategori DP',
            'kunjungan_kat' => 'Kategori Kunjungan',
            'harga_kat' => 'Kategori Harga',
        ];

        $moneyFields = ['harga', 'dp', 'cicilan', 'penghasilan'];

        // Format Rupiah
        $rupiah = function ($n) {
            if (!is_numeric($n)) {
                return (string) $n;
            }
            return 'Rp ' . number_format((int) $n, 0, ',', '.');
        };

        /**
         * Formatter: ubah value fitur menjadi label human-readable
         * - uang => Rupiah
         * - mapping angka => label (lokasi/bi/metode/status_nikah/...)
         * - satuan => kali / orang
         */
        $fmtValue = function ($key, $val) use ($map, $moneyFields, $rupiah) {
            $k = (string) $key;
            $v = (string) $val;

            // uang
            if (in_array($k, $moneyFields, true) && is_numeric($v)) {
                return $rupiah($v);
            }

            // mapping angka -> label
            if (isset($map[$k][$v])) {
                // tampilkan label + kode angka (biar tetap traceable)
                return $map[$k][$v] . " ({$v})";
            }

            // satuan
            if ($k === 'tanggungan' && is_numeric($v)) {
                return $v . ' orang';
            }
            if ($k === 'kunjungan' && is_numeric($v)) {
                return $v . ' kali';
            }
            if ($k === 'usia' && is_numeric($v)) {
                return $v . ' tahun';
            }

            return $val;
        };

        /**
         * Formatter nama fitur agar rapi:
         * - gunakan $featureName jika ada
         * - fallback: ubah underscore jadi spasi
         */
        $fmtKey = function ($key) use ($featureName) {
            if (isset($featureName[$key])) {
                return $featureName[$key];
            }
            return ucwords(str_replace('_', ' ', (string) $key));
        };
    @endphp

    <div class="space-y-6">

        {{-- Breadcrumb --}}
        <nav class="flex flex-wrap items-center gap-x-2 gap-y-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">
            <a href="{{ route('dashboard') }}" class="hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] transition">
                Beranda
            </a>
            <span class="opacity-50">/</span>
            <a href="{{ route('prediksi.index') }}" class="hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] transition">
                Hasil Prediksi
            </a>
            <span class="opacity-50">/</span>
            <span class="text-[#1b1b18] dark:text-[#EDEDEC] font-medium">
                Detail Konsumen #{{ $id }}
            </span>
        </nav>

        {{-- Error jika ada --}}
        @if ($err)
            <div
                class="px-4 py-3 rounded-md border border-rose-200 dark:border-rose-800
                        bg-rose-50 dark:bg-rose-900/30
                        text-rose-700 dark:text-rose-300 text-sm">
                {{ $err }}
            </div>
        @endif

        {{-- Ringkasan Konsumen + Hasil --}}
        <div
            class="bg-white dark:bg-[#161615] border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg
                    shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] overflow-hidden">
            <div class="p-5 sm:p-8 space-y-4">

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div class="min-w-0">
                        <h3 class="text-base sm:text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC] truncate">
                            Detail Konsumen #{{ $id }}
                        </h3>
                        <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">
                            Nama:
                            <span class="text-[#1b1b18] dark:text-[#EDEDEC] font-medium">
                                {{ $identitas->nama ?? '-' }}
                            </span>
                            • No HP:
                            <span class="text-[#1b1b18] dark:text-[#EDEDEC] font-medium">
                                {{ $identitas->no_hp ?? '-' }}
                            </span>
                        </p>

                        {{-- Ringkasan data penting (optional) --}}
                        <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">
                            Tipe: <span
                                class="text-[#1b1b18] dark:text-[#EDEDEC] font-medium">{{ $identitas->tipe ?? '-' }}</span>
                            • Harga: <span
                                class="text-[#1b1b18] dark:text-[#EDEDEC] font-medium">{{ isset($identitas->harga) ? $rupiah($identitas->harga) : '-' }}</span>
                            • Lokasi: <span
                                class="text-[#1b1b18] dark:text-[#EDEDEC] font-medium">{{ isset($identitas->lokasi) ? $fmtValue('lokasi', $identitas->lokasi) : '-' }}</span>
                        </p>
                    </div>

                    <div>
                        @if ($pred !== null)
                            <span
                                class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs border
                                {{ $isMembeli
                                    ? 'bg-emerald-100 text-emerald-700 border-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-300 dark:border-emerald-800'
                                    : 'bg-rose-100 text-rose-700 border-rose-200 dark:bg-rose-900/30 dark:text-rose-300 dark:border-rose-800' }}">
                                Hasil: {{ $predText ?? ($isMembeli ? 'Membeli' : 'Tidak Membeli') }}
                            </span>
                        @else
                            <span class="text-[#A1A09A]">Belum diprediksi</span>
                        @endif
                    </div>
                </div>

                {{-- Probabilitas --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <div class="rounded-md border border-[#e3e3e0] dark:border-[#3E3E3A] p-4">
                        <div class="flex items-center justify-between">
                            <div class="text-sm font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                                Probabilitas Membeli (kelas 1)
                            </div>
                            <div class="text-sm text-[#1b1b18] dark:text-[#EDEDEC] font-semibold">
                                {{ $pct($pM) }}
                            </div>
                        </div>
                        <div class="mt-3 h-2 rounded-full bg-[#f0f0ee] dark:bg-[#2a2a28] overflow-hidden">
                            <div class="h-2 bg-emerald-600" style="width: {{ $barM }}%"></div>
                        </div>
                    </div>

                    <div class="rounded-md border border-[#e3e3e0] dark:border-[#3E3E3A] p-4">
                        <div class="flex items-center justify-between">
                            <div class="text-sm font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                                Probabilitas Tidak Membeli (kelas 0)
                            </div>
                            <div class="text-sm text-[#1b1b18] dark:text-[#EDEDEC] font-semibold">
                                {{ $pct($pT) }}
                            </div>
                        </div>
                        <div class="mt-3 h-2 rounded-full bg-[#f0f0ee] dark:bg-[#2a2a28] overflow-hidden">
                            <div class="h-2 bg-rose-600" style="width: {{ $barT }}%"></div>
                        </div>
                    </div>
                </div>

                {{-- Kesimpulan / Pembuktian --}}
                <div class="rounded-md border border-[#e3e3e0] dark:border-[#3E3E3A] p-4">
                    <h4 class="text-sm font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                        Pembuktian (kenapa hasilnya {{ $predText ?? '-' }})
                    </h4>

                    <div class="mt-3 text-sm text-[#706f6c] dark:text-[#A1A09A] space-y-2">
                        <div>
                            Model menghitung skor untuk masing-masing kelas:
                            <span class="text-[#1b1b18] dark:text-[#EDEDEC] font-medium">kelas 1 (Membeli)</span> dan
                            <span class="text-[#1b1b18] dark:text-[#EDEDEC] font-medium">kelas 0 (Tidak Membeli)</span>.
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div class="rounded-md border border-[#e3e3e0] dark:border-[#3E3E3A] p-3">
                                <div class="text-xs text-[#706f6c] dark:text-[#A1A09A]">Log Score kelas 1</div>
                                <div class="text-sm font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                                    {{ $num($scoresLog[1] ?? ($scoresLog['1'] ?? null), 6) }}
                                </div>
                                <div class="mt-2 text-xs text-[#706f6c] dark:text-[#A1A09A]">Raw Score kelas 1</div>
                                <div class="text-sm font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                                    {{ $num($scoresRaw[1] ?? ($scoresRaw['1'] ?? null), 10) }}
                                </div>
                            </div>

                            <div class="rounded-md border border-[#e3e3e0] dark:border-[#3E3E3A] p-3">
                                <div class="text-xs text-[#706f6c] dark:text-[#A1A09A]">Log Score kelas 0</div>
                                <div class="text-sm font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                                    {{ $num($scoresLog[0] ?? ($scoresLog['0'] ?? null), 6) }}
                                </div>
                                <div class="mt-2 text-xs text-[#706f6c] dark:text-[#A1A09A]">Raw Score kelas 0</div>
                                <div class="text-sm font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                                    {{ $num($scoresRaw[0] ?? ($scoresRaw['0'] ?? null), 10) }}
                                </div>
                            </div>
                        </div>

                        <div class="pt-2">
                            Keputusan diambil dari skor terbesar (lebih stabil pakai <span class="font-medium">log
                                score</span>):
                            <span class="text-[#1b1b18] dark:text-[#EDEDEC] font-semibold">
                                {{ $predText ?? '-' }}
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- Fitur X yang dipakai --}}
        <div
            class="bg-white dark:bg-[#161615] border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg
                    shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] overflow-hidden">
            <div class="p-5 sm:p-6">
                <h3 class="text-base font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                    Fitur yang dipakai (X)
                </h3>
                <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">
                    Berikut fitur yang dipakai oleh Naive Bayes (sudah dibuat readable).
                </p>

                <div class="mt-4 overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="text-left">
                            <tr class="border-b border-[#e3e3e0] dark:border-[#3E3E3A]">
                                <th class="py-2 pr-4 font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">Fitur</th>
                                <th class="py-2 pr-4 font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(($x ?? []) as $k => $v)
                                @php
                                    $labelK = $fmtKey($k);
                                    $labelV = $fmtValue($k, $v);
                                @endphp
                                <tr class="border-b border-[#f0f0ee] dark:border-[#2a2a28]">
                                    <td class="py-2 pr-4 text-[#1b1b18] dark:text-[#EDEDEC]">
                                        {{ $labelK }}
                                        <div class="text-xs text-[#A1A09A]">{{ $k }}</div>
                                    </td>
                                    <td class="py-2 pr-4 text-[#706f6c] dark:text-[#A1A09A]">
                                        {{ $labelV }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="py-6 text-center text-[#706f6c] dark:text-[#A1A09A]">
                                        Tidak ada fitur (semua kosong).
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Detail Perhitungan Naive Bayes --}}
        <div
            class="bg-white dark:bg-[#161615] border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg
                    shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] overflow-hidden">
            <div class="p-5 sm:p-6 space-y-6">
                <div>
                    <h3 class="text-base font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                        Langkah Perhitungan (Prior → Likelihood → Skor)
                    </h3>
                    <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">
                        Rumus likelihood dengan Laplace smoothing:
                        <span class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">(count(f=value, class)+1) /
                            (count(class)+k)</span>
                    </p>
                </div>

                @foreach ([1 => 'Membeli (kelas 1)', 0 => 'Tidak Membeli (kelas 0)'] as $cls => $clsTitle)
                    @php
                        $b = $breakdown[$cls] ?? ($breakdown[(string) $cls] ?? null);
                    @endphp

                    <div class="rounded-md border border-[#e3e3e0] dark:border-[#3E3E3A] p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <h4 class="text-sm font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                                    {{ $clsTitle }}
                                </h4>
                                <div class="mt-1 text-xs text-[#706f6c] dark:text-[#A1A09A]">
                                    Prior = class_count / total
                                </div>
                            </div>

                            @if ($b)
                                <div class="text-right">
                                    <div class="text-xs text-[#706f6c] dark:text-[#A1A09A]">Prior</div>
                                    <div class="text-sm font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                                        {{ $num($b['prior'] ?? null, 6) }}
                                    </div>
                                </div>
                            @endif
                        </div>

                        @if (!$b)
                            <div class="mt-3 text-sm text-rose-600 dark:text-rose-400">
                                Breakdown untuk kelas {{ $cls }} tidak tersedia.
                            </div>
                        @else
                            <div class="mt-4 overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead class="text-left">
                                        <tr class="border-b border-[#e3e3e0] dark:border-[#3E3E3A]">
                                            <th class="py-2 pr-4 font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                                                Fitur
                                            </th>

                                            <th class="py-2 pr-4 font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                                                Nilai Fitur
                                            </th>

                                            <th class="py-2 pr-4 font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                                                Jumlah Data Sama<br>
                                                <span class="text-xs font-normal">(Frekuensi fitur pada kelas)</span>
                                            </th>

                                            <th class="py-2 pr-4 font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                                                Jumlah Kategori (k)
                                            </th>

                                            <th class="py-2 pr-4 font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                                                Probabilitas<br>
                                                <span class="text-xs font-normal">(Likelihood)</span>
                                            </th>

                                            <th class="py-2 pr-4 font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                                                Rumus Perhitungan
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($b['features'] ?? [] as $fname => $fd)
                                            @php
                                                $fnameLabel = $fmtKey($fname);
                                                $valLabel = isset($fd['value']) ? $fmtValue($fname, $fd['value']) : '-';
                                            @endphp
                                            <tr class="border-b border-[#f0f0ee] dark:border-[#2a2a28]">
                                                <td class="py-2 pr-4 text-[#1b1b18] dark:text-[#EDEDEC]">
                                                    {{ $fnameLabel }}
                                                    <div class="text-xs text-[#A1A09A]">{{ $fname }}</div>
                                                </td>
                                                <td class="py-2 pr-4 text-[#706f6c] dark:text-[#A1A09A]">
                                                    {{ $valLabel }}
                                                </td>
                                                <td class="py-2 pr-4 text-[#706f6c] dark:text-[#A1A09A]">
                                                    {{ $fd['count_fv'] ?? '-' }}</td>
                                                <td class="py-2 pr-4 text-[#706f6c] dark:text-[#A1A09A]">
                                                    {{ $fd['k'] ?? '-' }}</td>
                                                <td class="py-2 pr-4 text-[#706f6c] dark:text-[#A1A09A]">
                                                    {{ $num($fd['likelihood'] ?? null, 8) }}
                                                </td>
                                                <td class="py-2 pr-4 text-xs text-[#706f6c] dark:text-[#A1A09A]">
                                                    {{ $fd['formula'] ?? '-' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div class="rounded-md border border-[#e3e3e0] dark:border-[#3E3E3A] p-3">
                                    <div class="text-xs text-[#706f6c] dark:text-[#A1A09A]">Skor Akhir (Raw)</div>
                                    <div class="text-sm font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                                        {{ $num($b['raw_score'] ?? null, 12) }}
                                    </div>
                                    <div class="text-xs text-[#706f6c] dark:text-[#A1A09A] mt-1">
                                        Raw = Prior × semua Likelihood
                                    </div>
                                </div>

                                <div class="rounded-md border border-[#e3e3e0] dark:border-[#3E3E3A] p-3">
                                    <div class="text-xs text-[#706f6c] dark:text-[#A1A09A]">Skor Akhir (Log)</div>
                                    <div class="text-sm font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                                        {{ $num($b['log_score'] ?? null, 6) }}
                                    </div>
                                    <div class="text-xs text-[#706f6c] dark:text-[#A1A09A] mt-1">
                                        Log = log(Prior) + Σ log(Likelihood)
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach

                {{-- tombol kembali --}}
                <div class="flex items-center justify-end">
                    <a href="{{ route('prediksi.index') }}"
                        class="inline-flex items-center justify-center px-4 py-2 rounded-sm
                              border border-[#19140035] hover:border-[#1915014a]
                              dark:border-[#3E3E3A] dark:hover:border-[#62605b]
                              text-sm text-[#1b1b18] dark:text-[#EDEDEC] transition">
                        Kembali
                    </a>
                </div>
            </div>
        </div>

    </div>

</x-app-layout>
