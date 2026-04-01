<x-app-layout>

    <x-slot name="title">
        {{ $title ?? 'Detail Identitas Calon Konsumen' }}
    </x-slot>

    <x-slot name="header">
        <div class="flex items-center gap-3 min-w-0">
            <x-heroicon-o-document-text class="w-6 h-6 text-[#1b1b18] dark:text-[#EDEDEC] shrink-0" />
            <h2 class="font-semibold text-lg sm:text-xl text-[#1b1b18] dark:text-[#EDEDEC] leading-tight truncate">
                {{ __('Detail Identitas Calon Konsumen') }}
            </h2>
        </div>
    </x-slot>

    <x-slot name="actions">
        <span
            class="hidden sm:inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs
                   border border-emerald-200 dark:border-emerald-800
                   bg-emerald-50 dark:bg-emerald-900/30
                   text-emerald-700 dark:text-emerald-400">
            <span class="text-emerald-500 dark:text-emerald-400">●</span>
            {{ __('Detail') }}
        </span>
    </x-slot>

    <div class="space-y-6">

        {{-- Breadcrumb --}}
        <nav class="flex flex-wrap items-center gap-2 text-sm text-[#706f6c] dark:text-[#A1A09A]">
            <a href="{{ route('dashboard') }}" class="hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] transition">
                Beranda
            </a>
            <span>/</span>
            <a href="{{ route('identitas.index') }}" class="hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] transition">
                Identitas Calon Konsumen
            </a>
            <span>/</span>
            <span class="text-[#1b1b18] dark:text-[#EDEDEC] font-medium">
                Detail
            </span>
        </nav>

        <div
            class="bg-white dark:bg-[#161615] border border-[#e3e3e0] dark:border-[#3E3E3A]
                   rounded-lg shadow-sm overflow-hidden">


            <div class="p-5 sm:p-8 space-y-6">

                {{-- 2 GRID BESAR --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                    @php
                        $row = 'grid grid-cols-4 gap-4 py-2 border-b border-[#e3e3e0] dark:border-[#3E3E3A]';
                        $label = 'text-sm text-[#706f6c] dark:text-[#A1A09A]';
                        $value = 'col-span-3 text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]';

                        // ===== mapping angka -> teks =====
                        $statusNikahText = [
                            1 => 'Belum Menikah',
                            2 => 'Menikah',
                            3 => 'Cerai Hidup',
                            4 => 'Cerai Mati',
                        ];

                        $lokasiText = [
                            1 => 'Sangat Strategis',
                            2 => 'Strategis',
                            3 => 'Cukup Strategis',
                            4 => 'Kurang Strategis',
                        ];

                        $biText = [
                            1 => 'Lolos',
                            2 => 'Tidak Lolos',
                        ];

                        $metodeText = [
                            1 => 'KPR',
                            2 => 'Cash Bertahap',
                            3 => 'Cash Keras',
                        ];

                        $mapLabel = function ($map, $val) {
                            if ($val === null || $val === '') {
                                return '-';
                            }
                            $key = is_numeric($val) ? (int) $val : $val;
                            return $map[$key] ?? 'Kode: ' . $val;
                        };
                    @endphp

                    {{-- ================= LEFT COLUMN ================= --}}
                    <div class="space-y-6">

                        {{-- IDENTITAS --}}
                        <div
                            class="bg-[#fafaf9] dark:bg-[#1f1f23]
                        border border-[#e3e3e0] dark:border-[#3a3a40]
                        rounded-lg p-5 shadow-sm">
                            <h3 class="text-base sm:text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC] mb-4">
                                Identitas
                            </h3>

                            <div class="{{ $row }}">
                                <div class="{{ $label }}">Nama</div>
                                <div class="{{ $value }}">{{ $item->nama ?? '-' }}</div>
                            </div>

                            <div class="{{ $row }}">
                                <div class="{{ $label }}">No HP</div>
                                <div class="{{ $value }}">{{ $item->no_hp ?? '-' }}</div>
                            </div>

                            <div class="{{ $row }}">
                                <div class="{{ $label }}">Pekerjaan</div>
                                <div class="{{ $value }}">{{ $item->pekerjaan ?? '-' }}</div>
                            </div>

                            <div class="{{ $row }}">
                                <div class="{{ $label }}">Penghasilan</div>
                                <div class="{{ $value }}">
                                    {{ $item->penghasilan ? 'Rp. ' . number_format($item->penghasilan, 0, ',', '.') : '-' }}
                                </div>
                            </div>

                            <div class="{{ $row }}">
                                <div class="{{ $label }}">Tanggungan</div>
                                <div class="{{ $value }}">{{ $item->tanggungan ?? '-' }}</div>
                            </div>

                            <div class="grid grid-cols-4 gap-4 py-2">
                                <div class="{{ $label }}">Status Pernikahan</div>
                                <div class="{{ $value }}">
                                    {{ $mapLabel($statusNikahText, $item->status_nikah) }}</div>
                            </div>
                        </div>

                        {{-- INFORMASI RUMAH --}}
                        <div
                            class="bg-[#fafaf9] dark:bg-[#1f1f23]
                        border border-[#e3e3e0] dark:border-[#3a3a40]
                        rounded-lg p-5 shadow-sm">
                            <h3 class="text-base sm:text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC] mb-4">
                                Informasi Rumah
                            </h3>

                            <div class="{{ $row }}">
                                <div class="{{ $label }}">Harga Rumah</div>
                                <div class="{{ $value }}">
                                    {{ $item->harga ? 'Rp. ' . number_format($item->harga, 0, ',', '.') : '-' }}
                                </div>
                            </div>

                            <div class="{{ $row }}">
                                <div class="{{ $label }}">Type Rumah</div>
                                <div class="{{ $value }}">{{ $item->tipe ?? '-' }}</div>
                            </div>

                            <div class="grid grid-cols-4 gap-4 py-2">
                                <div class="{{ $label }}">Lokasi</div>
                                <div class="{{ $value }}">{{ $mapLabel($lokasiText, $item->lokasi) }}</div>
                            </div>
                        </div>

                    </div>

                    {{-- ================= RIGHT COLUMN ================= --}}
                    <div class="space-y-6">

                        {{-- KREDIT & PEMBAYARAN --}}
                        <div
                            class="bg-[#fafaf9] dark:bg-[#1f1f23]
                        border border-[#e3e3e0] dark:border-[#3a3a40]
                        rounded-lg p-5 shadow-sm">
                            <h3 class="text-base sm:text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC] mb-4">
                                Kredit & Pembayaran
                            </h3>

                            <div class="{{ $row }}">
                                <div class="{{ $label }}">Status BI Checking</div>
                                <div class="{{ $value }}">{{ $mapLabel($biText, $item->bi) }}</div>
                            </div>

                            <div class="{{ $row }}">
                                <div class="{{ $label }}">Metode Pembayaran</div>
                                <div class="{{ $value }}">{{ $mapLabel($metodeText, $item->metode) }}</div>
                            </div>

                            <div class="{{ $row }}">
                                <div class="{{ $label }}">Uang Muka</div>
                                <div class="{{ $value }}">
                                    {{ $item->dp ? 'Rp. ' . number_format($item->dp, 0, ',', '.') : '-' }}
                                </div>
                            </div>

                            {{-- kalau kamu sudah simpan tenor, tampilkan --}}
                            @if (isset($item->tenor))
                                <div class="{{ $row }}">
                                    <div class="{{ $label }}">Tenor</div>
                                    <div class="{{ $value }}">
                                        {{ $item->tenor ? $item->tenor . ' Tahun' : '-' }}</div>
                                </div>
                            @endif

                            <div class="grid grid-cols-4 gap-4 py-2">
                                <div class="{{ $label }}">Cicilan</div>
                                <div class="{{ $value }}">
                                    {{ $item->cicilan !== null ? 'Rp. ' . number_format($item->cicilan, 0, ',', '.') : '-' }}
                                </div>
                            </div>
                        </div>

                        {{-- PERILAKU & KESIAPAN --}}
                        <div
                            class="bg-[#fafaf9] dark:bg-[#1f1f23]
                        border border-[#e3e3e0] dark:border-[#3a3a40]
                        rounded-lg p-5 shadow-sm">
                            <h3 class="text-base sm:text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC] mb-4">
                                Perilaku & Kesiapan
                            </h3>

                            <div class="{{ $row }}">
                                <div class="{{ $label }}">Kunjungan</div>
                                <div class="{{ $value }}">
                                    {{ $item->kunjungan !== null ? $item->kunjungan . 'x' : '-' }}
                                </div>
                            </div>

                            <div class="grid grid-cols-4 gap-4 py-2">
                                <div class="{{ $label }}">Usia</div>
                                <div class="{{ $value }}">{{ $item->usia ?? '-' }}</div>
                            </div>
                        </div>

                    </div>

                </div>

                {{-- BUTTON --}}
                <div class="flex justify-end gap-3">
                    <a href="{{ route('identitas.index') }}"
                        class="h-10 inline-flex items-center justify-center px-5
                   rounded-sm border border-[#19140035] dark:border-[#3E3E3A]
                   text-[#1b1b18] dark:text-[#EDEDEC] transition">
                        Kembali
                    </a>

                    <a href="{{ route('identitas.edit', $item->id) }}"
                        class="h-10 inline-flex items-center justify-center px-5
                   rounded-sm bg-[#1b1b18] hover:bg-black
                   text-white border border-black transition">
                        Edit
                    </a>
                </div>

            </div>
        </div>

    </div>

</x-app-layout>
