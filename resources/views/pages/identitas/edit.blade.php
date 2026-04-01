<x-app-layout>

    <x-slot name="title">
        {{ $title ?? 'Edit Identitas Calon Konsumen' }}
    </x-slot>

    <x-slot name="header">
        <div class="flex items-center gap-3 min-w-0">
            <x-heroicon-o-pencil-square class="w-6 h-6 text-[#1b1b18] dark:text-[#EDEDEC] shrink-0" />
            <h2 class="font-semibold text-lg sm:text-xl text-[#1b1b18] dark:text-[#EDEDEC] leading-tight truncate">
                {{ __('Edit Identitas Calon Konsumen') }}
            </h2>
        </div>
    </x-slot>

    <x-slot name="actions">
        <span
            class="hidden sm:inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs
                   border border-amber-200 dark:border-amber-800
                   bg-amber-50 dark:bg-amber-900/30
                   text-amber-700 dark:text-amber-400">
            <span class="text-amber-500 dark:text-amber-400">●</span>
            {{ __('Edit') }}
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
                Edit
            </span>
        </nav>

        {{-- Card Form --}}
        <div
            class="bg-white dark:bg-[#161615] border border-[#e3e3e0] dark:border-[#3E3E3A]
            rounded-lg shadow-sm overflow-hidden">

            <div class="p-5 sm:p-8">

                <form action="{{ route('identitas.update', $item->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- MASONRY 2 KOLOM --}}
                    <div class="columns-1 lg:columns-2 [column-gap:1.5rem]">

                        {{-- ===================== --}}
                        {{-- IDENTITAS --}}
                        {{-- ===================== --}}
                        <div
                            class="break-inside-avoid mb-6 bg-white dark:bg-[#161615] border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg p-5">
                            <div class="flex items-center justify-between gap-3">
                                <h3 class="text-base sm:text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                                    Identitas
                                </h3>
                                <span class="text-xs text-[#706f6c] dark:text-[#A1A09A]">
                                    Wajib: Nama & No HP
                                </span>
                            </div>

                            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">Nama</label>
                                    <input type="text" name="nama" value="{{ old('nama', $item->nama) }}" required
                                        class="capitalize-input mt-1 w-full h-10 px-3 rounded-sm border border-[#19140035]
                                          dark:border-[#3E3E3A] bg-white dark:bg-[#0f0f0f]
                                          text-[#1b1b18] dark:text-[#EDEDEC]
                                          focus:outline-none focus:ring-2 focus:ring-black/10 dark:focus:ring-white/10">
                                    @error('nama')
                                        <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div>
                                    <label class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">No HP</label>
                                    <input type="text" name="no_hp" value="{{ old('no_hp', $item->no_hp) }}"
                                        required
                                        class="mt-1 w-full h-10 px-3 rounded-sm border border-[#19140035]
                                          dark:border-[#3E3E3A] bg-white dark:bg-[#0f0f0f]
                                          text-[#1b1b18] dark:text-[#EDEDEC]
                                          focus:outline-none focus:ring-2 focus:ring-black/10 dark:focus:ring-white/10">
                                    @error('no_hp')
                                        <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div>
                                    <label
                                        class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">Pekerjaan</label>
                                    <input type="text" name="pekerjaan"
                                        value="{{ old('pekerjaan', $item->pekerjaan) }}"
                                        class="mt-1 w-full h-10 px-3 rounded-sm border border-[#19140035]
                                          dark:border-[#3E3E3A] bg-white dark:bg-[#0f0f0f]
                                          text-[#1b1b18] dark:text-[#EDEDEC]
                                          focus:outline-none focus:ring-2 focus:ring-black/10 dark:focus:ring-white/10">
                                    @error('pekerjaan')
                                        <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div>
                                    <label class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                                        Penghasilan (Rp)
                                    </label>

                                    <div class="rupiah-wrapper">
                                        @php $penghasilan = old('penghasilan', $item->penghasilan); @endphp

                                        <input type="text"
                                            class="rupiah-display mt-1 w-full h-10 px-3 rounded-sm border border-[#19140035]
                                              dark:border-[#3E3E3A] bg-white dark:bg-[#0f0f0f]
                                              text-[#1b1b18] dark:text-[#EDEDEC]
                                              focus:outline-none focus:ring-2 focus:ring-black/10 dark:focus:ring-white/10"
                                            value="{{ $penghasilan ? 'Rp. ' . number_format($penghasilan, 0, ',', '.') : '' }}"
                                            placeholder="Rp. 0">

                                        <input type="hidden" name="penghasilan" class="rupiah-hidden"
                                            value="{{ $penghasilan }}">
                                    </div>

                                    @error('penghasilan')
                                        <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label
                                            class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">Tanggungan</label>
                                        <input type="number" name="tanggungan" min="0"
                                            value="{{ old('tanggungan', $item->tanggungan) }}"
                                            class="mt-1 w-full h-10 px-3 rounded-sm border border-[#19140035]
                                              dark:border-[#3E3E3A] bg-white dark:bg-[#0f0f0f]
                                              text-[#1b1b18] dark:text-[#EDEDEC]
                                              focus:outline-none focus:ring-2 focus:ring-black/10 dark:focus:ring-white/10">
                                        @error('tanggungan')
                                            <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div>
                                        <label
                                            class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">Usia</label>
                                        <input type="number" name="usia" min="0"
                                            value="{{ old('usia', $item->usia) }}"
                                            class="mt-1 w-full h-10 px-3 rounded-sm border border-[#19140035]
                                              dark:border-[#3E3E3A] bg-white dark:bg-[#0f0f0f]
                                              text-[#1b1b18] dark:text-[#EDEDEC]
                                              focus:outline-none focus:ring-2 focus:ring-black/10 dark:focus:ring-white/10">
                                        @error('usia')
                                            <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div>
                                    <label class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                                        Status Pernikahan
                                    </label>

                                    @php $statusNikah = old('status_nikah', $item->status_nikah); @endphp
                                    <select name="status_nikah"
                                        class="mt-1 w-full h-10 px-3 rounded-sm border border-[#19140035]
                                           dark:border-[#3E3E3A] bg-white dark:bg-[#0f0f0f]
                                           text-[#1b1b18] dark:text-[#EDEDEC]
                                           focus:outline-none focus:ring-2 focus:ring-black/10 dark:focus:ring-white/10">
                                        <option value="">-- Pilih Status --</option>
                                        <option value="1" {{ (string) $statusNikah === '1' ? 'selected' : '' }}>
                                            Belum Menikah</option>
                                        <option value="2" {{ (string) $statusNikah === '2' ? 'selected' : '' }}>
                                            Menikah</option>
                                        <option value="3" {{ (string) $statusNikah === '3' ? 'selected' : '' }}>
                                            Cerai Hidup</option>
                                        <option value="4" {{ (string) $statusNikah === '4' ? 'selected' : '' }}>
                                            Cerai Mati</option>
                                    </select>

                                    @error('status_nikah')
                                        <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- ===================== --}}
                        {{-- INFORMASI RUMAH --}}
                        {{-- ===================== --}}
                        <div
                            class="break-inside-avoid mb-6 bg-white dark:bg-[#161615] border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg p-5">
                            <h3 class="text-base sm:text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                                Informasi Rumah
                            </h3>

                            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                                    {{-- Type Rumah --}}
                                    <div>
                                        <label class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">Type
                                            Rumah</label>

                                        @php
                                            $tipe = old('tipe', $item->tipe);
                                            $isPreset = in_array((string) $tipe, ['30/60', '36/72', '42/72'], true);
                                        @endphp

                                        <select id="tipe_select" name="tipe_select"
                                            class="mt-1 w-full h-10 px-3 rounded-sm border border-[#19140035]
                                               dark:border-[#3E3E3A] bg-white dark:bg-[#0f0f0f]
                                               text-[#1b1b18] dark:text-[#EDEDEC]
                                               focus:outline-none focus:ring-2 focus:ring-black/10 dark:focus:ring-white/10">
                                            <option value="">-- Type --</option>
                                            <option value="30/60" {{ (string) $tipe === '30/60' ? 'selected' : '' }}>
                                                30/60</option>
                                            <option value="36/72" {{ (string) $tipe === '36/72' ? 'selected' : '' }}>
                                                36/72</option>
                                            <option value="42/72" {{ (string) $tipe === '42/72' ? 'selected' : '' }}>
                                                42/72</option>
                                            <option value="__other__" {{ !$isPreset && $tipe ? 'selected' : '' }}>
                                                Lainnya...</option>
                                        </select>

                                        <div id="tipe_other_wrap"
                                            class="mt-3 {{ !$isPreset && $tipe ? '' : 'hidden' }}">
                                            <input id="tipe_other" type="text"
                                                placeholder="Masukkan type rumah (contoh: 70/90)"
                                                value="{{ !$isPreset && $tipe ? $tipe : '' }}"
                                                class="w-full h-10 px-3 rounded-sm border border-[#19140035]
                                                  dark:border-[#3E3E3A] bg-white dark:bg-[#0f0f0f]
                                                  text-[#1b1b18] dark:text-[#EDEDEC]
                                                  focus:outline-none focus:ring-2 focus:ring-black/10 dark:focus:ring-white/10">
                                            <p class="text-xs text-[#706f6c] dark:text-[#A1A09A] mt-1">
                                                Catatan: tipe "Lainnya" tidak ada harga otomatis.
                                            </p>
                                        </div>

                                        <input type="hidden" id="tipe" name="tipe"
                                            value="{{ $tipe }}">

                                        @error('tipe')
                                            <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Lokasi --}}
                                    <div>
                                        <label
                                            class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">Lokasi</label>

                                        @php $lokasi = old('lokasi', $item->lokasi); @endphp
                                        <select name="lokasi"
                                            class="mt-1 w-full h-10 px-3 rounded-sm border border-[#19140035]
                                               dark:border-[#3E3E3A] bg-white dark:bg-[#0f0f0f]
                                               text-[#1b1b18] dark:text-[#EDEDEC]
                                               focus:outline-none focus:ring-2 focus:ring-black/10 dark:focus:ring-white/10">
                                            <option value="">-- Lokasi --</option>
                                            <option value="1" {{ (string) $lokasi === '1' ? 'selected' : '' }}>
                                                Sangat Strategis</option>
                                            <option value="2" {{ (string) $lokasi === '2' ? 'selected' : '' }}>
                                                Strategis</option>
                                            <option value="3" {{ (string) $lokasi === '3' ? 'selected' : '' }}>
                                                Cukup Strategis</option>
                                            <option value="4" {{ (string) $lokasi === '4' ? 'selected' : '' }}>
                                                Kurang Strategis</option>
                                        </select>

                                        @error('lokasi')
                                            <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Harga Rumah (AUTO) --}}
                                <div>
                                    <label class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">Harga Rumah
                                        (Rp)</label>

                                    <input id="harga_display" type="text"
                                        class="mt-1 w-full h-10 px-3 rounded-sm border border-[#19140035]
                                          dark:border-[#3E3E3A] bg-white dark:bg-[#0f0f0f]
                                          text-[#1b1b18] dark:text-[#EDEDEC] cursor-not-allowed"
                                        placeholder="Rp. 0" readonly>

                                    <input id="harga" type="hidden" name="harga"
                                        value="{{ old('harga', $item->harga) }}">

                                    @error('harga')
                                        <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- ===================== --}}
                        {{-- KREDIT & PEMBAYARAN --}}
                        {{-- ===================== --}}
                        <div
                            class="break-inside-avoid mb-6 bg-white dark:bg-[#161615] border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg p-5">
                            <h3 class="text-base sm:text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">Kredit &
                                Pembayaran</h3>

                            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">

                                <div>
                                    <label class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">Status BI
                                        Checking</label>
                                    @php $bi = old('bi', $item->bi); @endphp
                                    <select name="bi"
                                        class="mt-1 w-full h-10 px-3 rounded-sm border border-[#19140035]
                                           dark:border-[#3E3E3A] bg-white dark:bg-[#0f0f0f]
                                           text-[#1b1b18] dark:text-[#EDEDEC]">
                                        <option value="">-- Pilih Status --</option>
                                        <option value="1" {{ (string) $bi === '1' ? 'selected' : '' }}>Lolos
                                        </option>
                                        <option value="2" {{ (string) $bi === '2' ? 'selected' : '' }}>Tidak Lolos
                                        </option>
                                    </select>
                                    @error('bi')
                                        <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div>
                                    <label class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">Metode
                                        Pembayaran</label>
                                    @php $metode = old('metode', $item->metode); @endphp
                                    <select id="metode" name="metode"
                                        class="mt-1 w-full h-10 px-3 rounded-sm border border-[#19140035]
                                           dark:border-[#3E3E3A] bg-white dark:bg-[#0f0f0f]
                                           text-[#1b1b18] dark:text-[#EDEDEC]">
                                        <option value="">-- Pilih Metode --</option>
                                        <option value="1" {{ (string) $metode === '1' ? 'selected' : '' }}>KPR
                                        </option>
                                        <option value="2" {{ (string) $metode === '2' ? 'selected' : '' }}>Cash
                                            Bertahap</option>
                                        <option value="3" {{ (string) $metode === '3' ? 'selected' : '' }}>Cash
                                            Keras</option>
                                    </select>
                                    @error('metode')
                                        <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div>
                                    <label class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">Uang Muka
                                        (DP)</label>

                                    <input id="dp_display" type="text"
                                        class="mt-1 w-full h-10 px-3 rounded-sm border border-[#19140035]
                                          dark:border-[#3E3E3A] bg-white dark:bg-[#0f0f0f]
                                          text-[#1b1b18] dark:text-[#EDEDEC] cursor-not-allowed"
                                        placeholder="Rp. 0" readonly>

                                    <input id="dp" type="hidden" name="dp"
                                        value="{{ old('dp', $item->dp) }}">
                                    @error('dp')
                                        <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">Cicilan /
                                            Bulan</label>

                                        <input id="cicilan_display" type="text"
                                            class="mt-1 w-full h-10 px-3 rounded-sm border border-[#19140035]
                                              dark:border-[#3E3E3A] bg-white dark:bg-[#0f0f0f]
                                              text-[#1b1b18] dark:text-[#EDEDEC] cursor-not-allowed"
                                            placeholder="Rp. 0" readonly>

                                        <input type="hidden" id="cicilan" name="cicilan"
                                            value="{{ old('cicilan', $item->cicilan) }}">
                                        @error('cicilan')
                                            <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div>
                                        <label
                                            class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">Tenor</label>

                                        {{-- edit: tenor tidak disimpan DB, jadi ambil dari old() saja --}}
                                        <select id="tenor" name="tenor"
                                            class="mt-1 w-full h-10 px-3 rounded-sm border border-[#19140035]
                                               dark:border-[#3E3E3A] bg-white dark:bg-[#0f0f0f]">
                                            <option value="">-- Pilih Tenor --</option>
                                            <option value="10" {{ old('tenor') == '10' ? 'selected' : '' }}>10
                                                Tahun</option>
                                            <option value="15" {{ old('tenor') == '15' ? 'selected' : '' }}>15
                                                Tahun</option>
                                            <option value="20" {{ old('tenor') == '20' ? 'selected' : '' }}>20
                                                Tahun</option>
                                        </select>

                                        @error('tenor')
                                            <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ===================== --}}
                        {{-- PERILAKU & KESIAPAN (TAHAP 1 HANYA KUNJUNGAN) --}}
                        {{-- ===================== --}}
                        <div
                            class="break-inside-avoid mb-6 bg-white dark:bg-[#161615] border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg p-5">
                            <h3 class="text-base sm:text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                                Perilaku & Kesiapan
                            </h3>

                            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">Kunjungan</label>

                                    @php $kunjungan = old('kunjungan', $item->kunjungan); @endphp
                                    <select name="kunjungan"
                                        class="mt-1 w-full h-10 px-3 rounded-sm border border-[#19140035]
                                           dark:border-[#3E3E3A] bg-white dark:bg-[#0f0f0f]
                                           text-[#1b1b18] dark:text-[#EDEDEC]
                                           focus:outline-none focus:ring-2 focus:ring-black/10 dark:focus:ring-white/10">
                                        <option value="">-- Pilih Jumlah Kunjungan --</option>
                                        <option value="0" {{ (string) $kunjungan === '0' ? 'selected' : '' }}>0x
                                        </option>
                                        @for ($i = 1; $i <= 10; $i++)
                                            <option value="{{ $i }}"
                                                {{ (int) $kunjungan === $i ? 'selected' : '' }}>
                                                {{ $i }}x
                                            </option>
                                        @endfor
                                    </select>

                                    @error('kunjungan')
                                        <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div>
                                    <label class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">Dana
                                        Darurat</label>
                                    {{-- Tahap 1: tidak disimpan --}}
                                    <select id="respon_select"
                                        class="mt-1 w-full h-10 px-3 rounded-sm border border-[#19140035]
                                           dark:border-[#3E3E3A] bg-white dark:bg-[#0f0f0f]
                                           text-[#1b1b18] dark:text-[#EDEDEC]
                                           focus:outline-none focus:ring-2 focus:ring-black/10 dark:focus:ring-white/10">
                                        <option value="">-- Pilih Status --</option>
                                        <option value="Ada" {{ old('respon_ui') == 'Ada' ? 'selected' : '' }}>Ada
                                        </option>
                                        <option value="Tidak Ada"
                                            {{ old('respon_ui') == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ===================== --}}
                    {{-- SCRIPT AUTO: TYPE -> HARGA | METODE+TENOR -> DP+CICILAN --}}
                    {{-- ===================== --}}
                    <script>
                        document.addEventListener('DOMContentLoaded', () => {

                            const hargaByTipe = {
                                '30/60': 304000000,
                                '36/72': 364000000,
                                '42/72': 408000000,
                            };

                            const dpPercentDefault = 0.10;

                            const tipeSelect = document.getElementById('tipe_select');
                            const otherWrap = document.getElementById('tipe_other_wrap');
                            const otherInput = document.getElementById('tipe_other');
                            const tipeFinal = document.getElementById('tipe');

                            const hargaDisplay = document.getElementById('harga_display');
                            const hargaHidden = document.getElementById('harga');

                            const metodeSelect = document.getElementById('metode');
                            const tenorSelect = document.getElementById('tenor');

                            const dpDisplay = document.getElementById('dp_display');
                            const dpHidden = document.getElementById('dp');

                            const cicilanDisplay = document.getElementById('cicilan_display');
                            const cicilanHidden = document.getElementById('cicilan');

                            const formatRupiah = (n) => {
                                if (n === null || n === undefined || n === '') return '';
                                const num = Number(n);
                                if (Number.isNaN(num)) return '';
                                return 'Rp. ' + num.toLocaleString('id-ID');
                            };

                            const setFinalTipe = () => {
                                if (!tipeSelect) return;

                                if (tipeSelect.value === '__other__') {
                                    otherWrap?.classList.remove('hidden');
                                    tipeFinal.value = (otherInput?.value || '').trim();
                                } else {
                                    otherWrap?.classList.add('hidden');
                                    tipeFinal.value = tipeSelect.value;
                                }
                            };

                            const getHarga = () => {
                                const tipe = (tipeFinal?.value || '').trim();
                                if (Object.prototype.hasOwnProperty.call(hargaByTipe, tipe)) return hargaByTipe[tipe];
                                return null;
                            };

                            const setHargaAuto = () => {
                                const harga = getHarga();

                                // kalau tipe preset: override harga
                                if (harga !== null) {
                                    hargaHidden.value = harga;
                                    hargaDisplay.value = formatRupiah(harga);
                                    return;
                                }

                                // kalau tipe lainnya: tampilkan nilai yang sudah tersimpan di DB (jangan dihapus)
                                const existing = hargaHidden?.value;
                                if (existing) hargaDisplay.value = formatRupiah(existing);
                            };

                            const setDpDanCicilanAuto = () => {
                                const hargaAuto = getHarga();
                                const harga = hargaAuto !== null ? hargaAuto : Number(hargaHidden?.value || 0);

                                const metode = (metodeSelect?.value || '').trim();
                                const tenorTahun = parseInt((tenorSelect?.value || '').trim(), 10);

                                if (!harga || !metode) return;

                                if (metode === '3') {
                                    dpHidden.value = harga;
                                    dpDisplay.value = formatRupiah(harga);
                                    cicilanHidden.value = 0;
                                    cicilanDisplay.value = formatRupiah(0);
                                    return;
                                }

                                const dp = Math.round(harga * dpPercentDefault);
                                dpHidden.value = dp;
                                dpDisplay.value = formatRupiah(dp);

                                if (!tenorTahun || tenorTahun <= 0) return;

                                const tenorBulan = tenorTahun * 12;
                                const pokok = harga - dp;
                                const cicilan = Math.max(0, Math.round(pokok / tenorBulan));

                                cicilanHidden.value = cicilan;
                                cicilanDisplay.value = formatRupiah(cicilan);
                            };

                            const syncAll = () => {
                                setFinalTipe();
                                setHargaAuto();
                                setDpDanCicilanAuto();
                            };

                            tipeSelect?.addEventListener('change', syncAll);
                            otherInput?.addEventListener('input', syncAll);
                            metodeSelect?.addEventListener('change', syncAll);
                            tenorSelect?.addEventListener('change', syncAll);

                            // init
                            syncAll();
                        });
                    </script>

                    {{-- Buttons --}}
                    <div class="flex flex-col sm:flex-row gap-3 justify-end">
                        <a href="{{ route('identitas.index') }}"
                            class="w-full sm:w-auto h-10 inline-flex items-center justify-center px-5
                          rounded-sm border border-[#19140035] dark:border-[#3E3E3A]
                          text-[#1b1b18] dark:text-[#EDEDEC] transition">
                            Kembali
                        </a>

                        <button type="submit"
                            class="w-full sm:w-auto h-10 inline-flex items-center justify-center px-5
                               rounded-sm bg-[#1b1b18] hover:bg-black
                               text-white border border-black transition">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

</x-app-layout>
