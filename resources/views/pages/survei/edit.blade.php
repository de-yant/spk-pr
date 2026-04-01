{{-- resources/views/pages/survei/edit.blade.php --}}

@php
    // ID calon konsumen terpilih (old > item)
    $selectedId = (string) old('calon_konsumen_id', $item->calon_konsumen_id ?? $item->id_calon_konsumen ?? '');

    // Survei terpilih (old > item)
    $selectedSurvei = (string) old('survei', $item->survei ?? '');

    // Tanggal survei untuk input date harus Y-m-d
    $tglValue = old('tgl_survei');
    if ($tglValue === null) {
        $tglValue = '';
        if (!empty($item->tgl_survei)) {
            try {
                $tglValue = \Illuminate\Support\Carbon::parse($item->tgl_survei)->format('Y-m-d');
            } catch (\Throwable $e) {
                // fallback kalau format sudah Y-m-d atau string
                $tglValue = (string) $item->tgl_survei;
            }
        }
    }

    // Ringkasan calon konsumen (ambil dari relasi kalau ada)
    $ck = $item->calonKonsumen ?? null;
@endphp

<x-app-layout>

    <x-slot name="title">
        Edit Survei
    </x-slot>

    <x-slot name="header">
        <div class="flex items-center gap-3 min-w-0">
            <x-heroicon-o-clipboard-document-check class="w-6 h-6 text-[#1b1b18] dark:text-[#EDEDEC] shrink-0" />
            <h2 class="font-semibold text-lg sm:text-xl text-[#1b1b18] dark:text-[#EDEDEC] leading-tight truncate">
                {{ __('Edit Survei') }}
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
            <a href="{{ route('survei.index') }}" class="hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] transition">
                Survei
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

                <form action="{{ route('survei.update', $item->id_survei ?? $item->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- GRID 2 KOLOM: kiri input, kanan catatan --}}
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                        {{-- ===================== --}}
                        {{-- KOLOM KIRI: INPUT --}}
                        {{-- ===================== --}}
                        <div
                            class="bg-white dark:bg-[#161615]
                                    border border-[#e3e3e0] dark:border-[#3E3E3A]
                                    rounded-lg p-5">

                            <div class="flex items-center justify-between gap-3">
                                <h3 class="text-base sm:text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                                    Data Survei
                                </h3>
                                <span class="text-xs text-[#706f6c] dark:text-[#A1A09A]">
                                    Wajib: Calon Konsumen
                                </span>
                            </div>

                            <div class="mt-4 space-y-4">

                                {{-- Calon Konsumen --}}
                                <div>
                                    <label class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                                        Calon Konsumen
                                    </label>

                                    <select name="calon_konsumen_id" required
                                        class="mt-1 w-full h-10 px-3 rounded-sm border border-[#19140035]
                                               dark:border-[#3E3E3A] bg-white dark:bg-[#0f0f0f]
                                               text-[#1b1b18] dark:text-[#EDEDEC]
                                               focus:outline-none focus:ring-2 focus:ring-black/10 dark:focus:ring-white/10">
                                        <option value="" disabled {{ $selectedId === '' ? 'selected' : '' }}>
                                            -- Pilih Calon Konsumen --
                                        </option>

                                        @foreach ($calonKonsumen as $c)
                                            <option value="{{ $c->id }}" {{ (string)$c->id === $selectedId ? 'selected' : '' }}>
                                                {{ $c->nama }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('calon_konsumen_id')
                                        <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- 2 kolom: survei & tgl_survei --}}
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                                    {{-- Survei (Ya/Tidak) --}}
                                    <div>
                                        <label class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                                            Survei
                                        </label>

                                        <select name="survei" required
                                            class="mt-1 w-full h-10 px-3 rounded-sm border border-[#19140035]
                                                   dark:border-[#3E3E3A] bg-white dark:bg-[#0f0f0f]
                                                   text-[#1b1b18] dark:text-[#EDEDEC]
                                                   focus:outline-none focus:ring-2 focus:ring-black/10 dark:focus:ring-white/10">
                                            <option value="">-- Pilih --</option>

                                            <option value="1" {{ $selectedSurvei === '1' ? 'selected' : '' }}>
                                                Ya
                                            </option>

                                            <option value="2" {{ $selectedSurvei === '2' ? 'selected' : '' }}>
                                                Tidak
                                            </option>
                                        </select>

                                        @error('survei')
                                            <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Tanggal Survei --}}
                                    <div>
                                        <label class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                                            Tanggal Survei
                                        </label>

                                        <input type="date" name="tgl_survei" value="{{ $tglValue }}"
                                            class="mt-1 w-full h-10 px-3 rounded-sm border border-[#19140035]
                                                   dark:border-[#3E3E3A] bg-white dark:bg-[#0f0f0f]
                                                   text-[#1b1b18] dark:text-[#EDEDEC]
                                                   focus:outline-none focus:ring-2 focus:ring-black/10 dark:focus:ring-white/10">

                                        @error('tgl_survei')
                                            <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- hasil_survei --}}
                                <div>
                                    <label class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                                        Hasil Survei
                                    </label>

                                    <input type="text" name="hasil_survei"
                                        value="{{ old('hasil_survei', $item->hasil_survei ?? '') }}"
                                        placeholder="Contoh: Layak / Tidak Layak / Menunggu..."
                                        class="mt-1 w-full h-10 px-3 rounded-sm border border-[#19140035]
                                               dark:border-[#3E3E3A] bg-white dark:bg-[#0f0f0f]
                                               text-[#1b1b18] dark:text-[#EDEDEC]
                                               focus:outline-none focus:ring-2 focus:ring-black/10 dark:focus:ring-white/10">

                                    @error('hasil_survei')
                                        <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- ===================== --}}
                        {{-- KOLOM KANAN: CATATAN --}}
                        {{-- ===================== --}}
                        <div
                            class="bg-white dark:bg-[#161615]
                                    border border-[#e3e3e0] dark:border-[#3E3E3A]
                                    rounded-lg p-5">

                            <div class="flex items-center justify-between gap-3">
                                <h3 class="text-base sm:text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                                    Catatan Survei
                                </h3>
                                <span class="text-xs text-[#706f6c] dark:text-[#A1A09A]">
                                    Opsional
                                </span>
                            </div>

                            <div class="mt-4">
                                <label class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                                    Catatan
                                </label>

                                <textarea name="catatan_survei" rows="8"
                                    class="mt-1 w-full px-3 py-2 rounded-sm border border-[#19140035]
                                           dark:border-[#3E3E3A] bg-white dark:bg-[#0f0f0f]
                                           text-[#1b1b18] dark:text-[#EDEDEC]
                                           focus:outline-none focus:ring-2 focus:ring-black/10 dark:focus:ring-white/10"
                                    placeholder="Tulis catatan survei...">{{ old('catatan_survei', $item->catatan_survei ?? '') }}</textarea>

                                @error('catatan_survei')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                    </div>

                    {{-- Buttons --}}
                    <div class="flex flex-col sm:flex-row gap-3 justify-end">
                        <a href="{{ route('survei.index') }}"
                            class="w-full sm:w-auto h-10 inline-flex items-center justify-center px-5
                                   rounded-sm border border-[#19140035] dark:border-[#3E3E3A]
                                   text-[#1b1b18] dark:text-[#EDEDEC] transition">
                            Kembali
                        </a>

                        <button type="submit"
                            class="w-full sm:w-auto h-10 inline-flex items-center justify-center px-5
                                   rounded-sm bg-[#1b1b18] hover:bg-black
                                   text-white border border-black transition">
                            Update Survei
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>

</x-app-layout>
