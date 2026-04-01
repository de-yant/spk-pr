<x-app-layout>

    <x-slot name="title">
        Tambah Identitas Calon Konsumen
    </x-slot>

    <x-slot name="header">
        <div class="flex items-center gap-3 min-w-0">
            <x-heroicon-o-user-plus class="w-6 h-6 text-[#1b1b18] dark:text-[#EDEDEC] shrink-0" />
            <h2 class="font-semibold text-lg sm:text-xl text-[#1b1b18] dark:text-[#EDEDEC] leading-tight truncate">
                {{ __('Tambah Identitas Calon Konsumen') }}
            </h2>
        </div>
    </x-slot>

    <x-slot name="actions">
        <span
            class="hidden sm:inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs
                   border border-green-200 dark:border-green-800
                   bg-green-50 dark:bg-green-900/30
                   text-green-700 dark:text-green-400">
            <span class="text-green-500 dark:text-green-400">●</span>
            {{ __('Aktif') }}
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
                Tambah
            </span>
        </nav>

        {{-- Card Form --}}
        <div
            class="bg-white dark:bg-[#161615] border border-[#e3e3e0] dark:border-[#3E3E3A]
            rounded-lg shadow-sm overflow-hidden">

            <div class="p-5 sm:p-8">

                <form action="{{ route('identitas.store') }}" method="POST" class="space-y-6">
                    @csrf

                    {{-- MASONRY 2 KOLOM: kolom kanan-kiri, bawah bisa naik --}}
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
                                    <label class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                                        Nama
                                    </label>

                                    <input type="text" name="nama" value="{{ old('nama') }}" required
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
                                    <input type="text" name="no_hp" value="{{ old('no_hp') }}" required
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
                                    <input type="text" name="pekerjaan" value="{{ old('pekerjaan') }}"
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
                                        {{-- Input tampilan --}}
                                        <input type="text"
                                            class="rupiah-display mt-1 w-full h-10 px-3 rounded-sm border border-[#19140035]
                   dark:border-[#3E3E3A] bg-white dark:bg-[#0f0f0f]
                   text-[#1b1b18] dark:text-[#EDEDEC]
                   focus:outline-none focus:ring-2 focus:ring-black/10 dark:focus:ring-white/10"
                                            value="{{ old('penghasilan') ? 'Rp. ' . number_format(old('penghasilan'), 0, ',', '.') : '' }}"
                                            placeholder="Rp. 0">

                                        {{-- Hidden input untuk DB --}}
                                        <input type="hidden" name="penghasilan" class="rupiah-hidden"
                                            value="{{ old('penghasilan') }}">
                                    </div>

                                    @error('penghasilan')
                                        <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                                    {{-- Jumlah Tanggungan --}}
                                    <div>
                                        <label class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                                            Tanggungan
                                        </label>
                                        <input type="number" name="tanggungan" value="{{ old('tanggungan') }}"
                                            min="0"
                                            class="mt-1 w-full h-10 px-3 rounded-sm border border-[#19140035]
                   dark:border-[#3E3E3A] bg-white dark:bg-[#0f0f0f]
                   text-[#1b1b18] dark:text-[#EDEDEC]
                   focus:outline-none focus:ring-2 focus:ring-black/10 dark:focus:ring-white/10">
                                        @error('tanggungan')
                                            <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Usia --}}
                                    <div>
                                        <label class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                                            Usia
                                        </label>
                                        <input type="number" name="usia" value="{{ old('usia') }}" min="0"
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

                                    {{-- VALUE DIKIRIM ANGKA SESUAI SEEDER --}}
                                    <select name="status_nikah"
                                        class="mt-1 w-full h-10 px-3 rounded-sm border border-[#19140035]
               dark:border-[#3E3E3A] bg-white dark:bg-[#0f0f0f]
               text-[#1b1b18] dark:text-[#EDEDEC]
               focus:outline-none focus:ring-2 focus:ring-black/10 dark:focus:ring-white/10">

                                        <option value="">-- Pilih Status --</option>
                                        <option value="1" {{ old('status_nikah') == '1' ? 'selected' : '' }}>
                                            Belum Menikah
                                        </option>
                                        <option value="2" {{ old('status_nikah') == '2' ? 'selected' : '' }}>
                                            Menikah
                                        </option>
                                        <option value="3" {{ old('status_nikah') == '3' ? 'selected' : '' }}>
                                            Cerai Hidup
                                        </option>
                                        <option value="4" {{ old('status_nikah') == '4' ? 'selected' : '' }}>
                                            Cerai Mati
                                        </option>
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
                                        <label class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                                            Type Rumah
                                        </label>

                                        <select id="tipe_select" name="tipe_select"
                                            class="mt-1 w-full h-10 px-3 rounded-sm border border-[#19140035]
                           dark:border-[#3E3E3A] bg-white dark:bg-[#0f0f0f]
                           text-[#1b1b18] dark:text-[#EDEDEC]
                           focus:outline-none focus:ring-2 focus:ring-black/10 dark:focus:ring-white/10">
                                            <option value="">-- Type --</option>
                                            <option value="30/60" {{ old('tipe') == '30/60' ? 'selected' : '' }}>30/60
                                            </option>
                                            <option value="36/72" {{ old('tipe') == '36/72' ? 'selected' : '' }}>36/72
                                            </option>
                                            <option value="42/72" {{ old('tipe') == '42/72' ? 'selected' : '' }}>42/72
                                            </option>

                                            <option value="__other__"
                                                {{ old('tipe') && !in_array(old('tipe'), ['30/60', '36/72', '42/72']) ? 'selected' : '' }}>
                                                Lainnya...
                                            </option>
                                        </select>

                                        {{-- Input manual untuk "Lainnya" --}}
                                        <div id="tipe_other_wrap"
                                            class="mt-3 {{ old('tipe') && !in_array(old('tipe'), ['30/60', '36/72', '42/72']) ? '' : 'hidden' }}">
                                            <input id="tipe_other" type="text"
                                                placeholder="Masukkan type rumah (contoh: 70/90)"
                                                value="{{ old('tipe') && !in_array(old('tipe'), ['30/60', '36/72', '42/72']) ? old('tipe') : '' }}"
                                                class="w-full h-10 px-3 rounded-sm border border-[#19140035]
                               dark:border-[#3E3E3A] bg-white dark:bg-[#0f0f0f]
                               text-[#1b1b18] dark:text-[#EDEDEC]
                               focus:outline-none focus:ring-2 focus:ring-black/10 dark:focus:ring-white/10">
                                            <p class="text-xs text-[#706f6c] dark:text-[#A1A09A] mt-1">
                                                Catatan: tipe "Lainnya" tidak ada harga otomatis.
                                            </p>
                                        </div>

                                        {{-- Field final yang dikirim ke backend --}}
                                        <input type="hidden" id="tipe" name="tipe"
                                            value="{{ old('tipe') }}">

                                        @error('tipe')
                                            <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Lokasi --}}
                                    <div>
                                        <label class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                                            Lokasi
                                        </label>

                                        <select name="lokasi"
                                            class="mt-1 w-full h-10 px-3 rounded-sm border border-[#19140035]
                           dark:border-[#3E3E3A] bg-white dark:bg-[#0f0f0f]
                           text-[#1b1b18] dark:text-[#EDEDEC]
                           focus:outline-none focus:ring-2 focus:ring-black/10 dark:focus:ring-white/10">
                                            <option value="">-- Lokasi --</option>
                                            <option value="1" {{ old('lokasi') == '1' ? 'selected' : '' }}>Sangat
                                                Strategis</option>
                                            <option value="2" {{ old('lokasi') == '2' ? 'selected' : '' }}>
                                                Strategis</option>
                                            <option value="3" {{ old('lokasi') == '3' ? 'selected' : '' }}>Cukup
                                                Strategis</option>
                                            <option value="4" {{ old('lokasi') == '4' ? 'selected' : '' }}>Kurang
                                                Strategis</option>
                                        </select>

                                        @error('lokasi')
                                            <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>

                                {{-- Harga Rumah --}}
                                <div>
                                    <label class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                                        Harga Rumah (Rp)
                                    </label>

                                    <input id="harga_display" type="text"
                                        class="mt-1 w-full h-10 px-3 rounded-sm border border-[#19140035]
                       dark:border-[#3E3E3A] bg-white dark:bg-[#0f0f0f]
                       text-[#1b1b18] dark:text-[#EDEDEC]
                       cursor-not-allowed"
                                        value="{{ old('harga') ? 'Rp. ' . number_format(old('harga'), 0, ',', '.') : '' }}"
                                        placeholder="Rp. 0" readonly>

                                    <input id="harga" type="hidden" name="harga"
                                        value="{{ old('harga') }}">

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
                            <h3 class="text-base sm:text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                                Kredit & Pembayaran
                            </h3>

                            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">

                                {{-- Status BI --}}
                                <div>
                                    <label class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                                        Status BI Checking
                                    </label>

                                    <select name="bi"
                                        class="mt-1 w-full h-10 px-3 rounded-sm border border-[#19140035]
                       dark:border-[#3E3E3A] bg-white dark:bg-[#0f0f0f]
                       text-[#1b1b18] dark:text-[#EDEDEC]">
                                        <option value="">-- Pilih Status --</option>
                                        <option value="1" {{ old('bi') == '1' ? 'selected' : '' }}>Lolos</option>
                                        <option value="2" {{ old('bi') == '2' ? 'selected' : '' }}>Tidak Lolos
                                        </option>
                                    </select>

                                    @error('bi')
                                        <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Metode --}}
                                <div>
                                    <label class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                                        Metode Pembayaran
                                    </label>

                                    <select id="metode" name="metode"
                                        class="mt-1 w-full h-10 px-3 rounded-sm border border-[#19140035]
                       dark:border-[#3E3E3A] bg-white dark:bg-[#0f0f0f]
                       text-[#1b1b18] dark:text-[#EDEDEC]">
                                        <option value="">-- Pilih Metode --</option>
                                        <option value="1" {{ old('metode') == '1' ? 'selected' : '' }}>KPR
                                        </option>
                                        <option value="2" {{ old('metode') == '2' ? 'selected' : '' }}>Cash
                                            Bertahap</option>
                                        <option value="3" {{ old('metode') == '3' ? 'selected' : '' }}>Cash Keras
                                        </option>
                                    </select>

                                    @error('metode')
                                        <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- DP (AUTO) --}}
                                <div>
                                    <label class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                                        Uang Muka (DP)
                                    </label>

                                    <input id="dp_display" type="text"
                                        class="mt-1 w-full h-10 px-3 rounded-sm border border-[#19140035]
                       dark:border-[#3E3E3A] bg-white dark:bg-[#0f0f0f]
                       text-[#1b1b18] dark:text-[#EDEDEC]
                       cursor-not-allowed"
                                        placeholder="Rp. 0" readonly
                                        value="{{ old('dp') ? 'Rp. ' . number_format(old('dp'), 0, ',', '.') : '' }}">

                                    <input id="dp" type="hidden" name="dp"
                                        value="{{ old('dp') }}">
                                    @error('dp')
                                        <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Cicilan + Tenor --}}
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                                    <div>
                                        <label class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                                            Cicilan / Bulan
                                        </label>

                                        <input id="cicilan_display" type="text"
                                            class="mt-1 w-full h-10 px-3 rounded-sm border border-[#19140035]
                           dark:border-[#3E3E3A] bg-white dark:bg-[#0f0f0f]
                           text-[#1b1b18] dark:text-[#EDEDEC]
                           cursor-not-allowed"
                                            placeholder="Rp. 0" readonly
                                            value="{{ old('cicilan') ? 'Rp. ' . number_format(old('cicilan'), 0, ',', '.') : '' }}">

                                        <input type="hidden" id="cicilan" name="cicilan"
                                            value="{{ old('cicilan') }}">
                                        @error('cicilan')
                                            <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                                            Tenor
                                        </label>

                                        {{-- tenor dalam tahun (10/15/20). kita konversi ke bulan di script --}}
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
                        {{-- SCRIPT AUTO: TYPE -> HARGA | METODE+TENOR -> DP+CICILAN --}}
                        {{-- ===================== --}}
                        <script>
                            document.addEventListener('DOMContentLoaded', () => {

                                // samakan dengan controller
                                const hargaByTipe = {
                                    '30/60': 304000000,
                                    '36/72': 364000000,
                                    '42/72': 408000000,
                                };

                                const dpPercentDefault = 0.10; // 10%

                                const tipeSelect = document.getElementById('tipe_select');
                                const otherWrap = document.getElementById('tipe_other_wrap');
                                const otherInput = document.getElementById('tipe_other');
                                const tipeFinal = document.getElementById('tipe');

                                const hargaDisplay = document.getElementById('harga_display');
                                const hargaHidden = document.getElementById('harga');

                                const metodeSelect = document.getElementById('metode'); // 1=KPR,2=Cash Bertahap,3=Cash Keras
                                const tenorSelect = document.getElementById('tenor'); // 10/15/20

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
                                    if (Object.prototype.hasOwnProperty.call(hargaByTipe, tipe)) {
                                        return hargaByTipe[tipe];
                                    }
                                    return null;
                                };

                                const setHargaAuto = () => {
                                    const harga = getHarga();
                                    if (harga !== null) {
                                        hargaHidden.value = harga;
                                        hargaDisplay.value = formatRupiah(harga);
                                    } else {
                                        hargaHidden.value = '';
                                        hargaDisplay.value = '';
                                    }
                                };

                                const resetPembayaran = () => {
                                    dpHidden.value = '';
                                    dpDisplay.value = '';
                                    cicilanHidden.value = '';
                                    cicilanDisplay.value = '';
                                };

                                // DP + CICILAN dihitung otomatis dari metode & tenor (tenor mempengaruhi cicilan)
                                const setDpDanCicilanAuto = () => {
                                    const harga = getHarga();
                                    const metode = (metodeSelect?.value || '').trim(); // '1','2','3',''
                                    const tenorTahun = parseInt((tenorSelect?.value || '').trim(), 10); // 10/15/20

                                    resetPembayaran();

                                    if (harga === null) return;
                                    if (!metode) return;

                                    // Cash Keras: DP=Harga, cicilan=0 (tenor tidak relevan)
                                    if (metode === '3') {
                                        const dp = harga;
                                        dpHidden.value = dp;
                                        dpDisplay.value = formatRupiah(dp);

                                        cicilanHidden.value = 0;
                                        cicilanDisplay.value = formatRupiah(0);
                                        return;
                                    }

                                    // KPR / Cash Bertahap: DP default 10%
                                    const dp = Math.round(harga * dpPercentDefault);
                                    dpHidden.value = dp;
                                    dpDisplay.value = formatRupiah(dp);

                                    // butuh tenor untuk hitung cicilan
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
                                    <label class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                                        Kunjungan
                                    </label>

                                    <select name="kunjungan"
                                        class="mt-1 w-full h-10 px-3 rounded-sm border border-[#19140035]
                       dark:border-[#3E3E3A] bg-white dark:bg-[#0f0f0f]
                       text-[#1b1b18] dark:text-[#EDEDEC]
                       focus:outline-none focus:ring-2 focus:ring-black/10 dark:focus:ring-white/10">

                                        <option value="">-- Pilih Jumlah Kunjungan --</option>
                                        <option value="0" {{ old('kunjungan', '0') == '0' ? 'selected' : '' }}>0x
                                        </option>

                                        @for ($i = 1; $i <= 10; $i++)
                                            <option value="{{ $i }}"
                                                {{ old('kunjungan') == $i ? 'selected' : '' }}>
                                                {{ $i }}x
                                            </option>
                                        @endfor
                                    </select>

                                    @error('kunjungan')
                                        <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div>
                                    <label class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                                        Dana Darurat
                                    </label>

                                    {{-- Tahap 1: tidak disimpan, jadi jangan ikut submit --}}
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
                            Simpan Data
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>

</x-app-layout>
