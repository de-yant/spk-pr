{{-- resources/views/pages/followup/edit.blade.php --}}

<x-app-layout>

    <x-slot name="title">
        Edit Follow Up
    </x-slot>

    <x-slot name="header">
        <div class="flex items-center gap-3 min-w-0">
            <x-heroicon-o-chat-bubble-left-right class="w-6 h-6 text-[#1b1b18] dark:text-[#EDEDEC] shrink-0" />
            <h2 class="font-semibold text-lg sm:text-xl text-[#1b1b18] dark:text-[#EDEDEC] leading-tight truncate">
                {{ __('Edit Follow Up') }}
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
            <a href="{{ route('follow-up.index') }}" class="hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] transition">
                Follow Up
            </a>
            <span>/</span>
            <span class="text-[#1b1b18] dark:text-[#EDEDEC] font-medium">
                Edit #{{ $followUp->id }}
            </span>
        </nav>

        {{-- Card Form --}}
        <div
            class="bg-white dark:bg-[#161615] border border-[#e3e3e0] dark:border-[#3E3E3A]
            rounded-lg shadow-sm overflow-hidden">

            <div class="p-5 sm:p-8">

                <form action="{{ route('follow-up.update', $followUp->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- GRID 2 KOLOM: kiri input, kanan catatan --}}
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                        {{-- KOLOM KIRI: INPUT --}}
                        <div
                            class="bg-white dark:bg-[#161615]
                                   border border-[#e3e3e0] dark:border-[#3E3E3A]
                                   rounded-lg p-5">

                            <div class="flex items-center justify-between gap-3">
                                <h3 class="text-base sm:text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                                    Data Follow Up
                                </h3>
                                <span class="text-xs text-[#706f6c] dark:text-[#A1A09A]">
                                    Wajib: Calon Konsumen & Tanggal
                                </span>
                            </div>

                            @php
                                $selectedCalonId = (string) old('calon_konsumen_id', $followUp->calon_konsumen_id);
                                $selectedRespon  = (string) old('respon_followup', $followUp->respon_followup);
                                $tglVal = old('tgl_followup', optional($followUp->tgl_followup)->format('Y-m-d'));
                            @endphp

                            {{-- calon_konsumen_id --}}
                            <div class="mt-4">
                                <label for="calon_konsumen_id"
                                    class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                                    Calon Konsumen
                                </label>

                                <select id="calon_konsumen_id" name="calon_konsumen_id" required
                                    class="mt-1 w-full h-10 px-3 rounded-sm
                                           border bg-white dark:bg-[#0f0f0f]
                                           text-[#1b1b18] dark:text-[#EDEDEC]
                                           focus:outline-none focus:ring-2 focus:ring-black/10 dark:focus:ring-white/10
                                           {{ $errors->has('calon_konsumen_id')
                                               ? 'border-red-500 focus:ring-red-500/20 dark:focus:ring-red-500/20'
                                               : 'border-[#19140035] dark:border-[#3E3E3A]' }}"
                                    aria-invalid="{{ $errors->has('calon_konsumen_id') ? 'true' : 'false' }}">

                                    <option value="" disabled {{ $selectedCalonId === '' ? 'selected' : '' }}>
                                        -- Pilih Calon Konsumen --
                                    </option>

                                    @foreach ($calonKonsumen as $ck)
                                        <option value="{{ $ck->id }}"
                                            {{ $selectedCalonId === (string) $ck->id ? 'selected' : '' }}>
                                            {{ $ck->nama }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('calon_konsumen_id')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">

                                {{-- tgl_followup --}}
                                <div>
                                    <label for="tgl_followup"
                                        class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                                        Tanggal Follow Up
                                    </label>

                                    <input id="tgl_followup" type="date" name="tgl_followup"
                                        value="{{ $tglVal }}" required
                                        class="mt-1 w-full h-10 px-3 rounded-sm border
                                               bg-white dark:bg-[#0f0f0f]
                                               text-[#1b1b18] dark:text-[#EDEDEC]
                                               focus:outline-none focus:ring-2 focus:ring-black/10 dark:focus:ring-white/10
                                               {{ $errors->has('tgl_followup')
                                                   ? 'border-red-500 focus:ring-red-500/20 dark:focus:ring-red-500/20'
                                                   : 'border-[#19140035] dark:border-[#3E3E3A]' }}"
                                        aria-invalid="{{ $errors->has('tgl_followup') ? 'true' : 'false' }}">

                                    @error('tgl_followup')
                                        <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- respon_followup --}}
                                <div>
                                    <label for="respon_followup"
                                        class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                                        Respon Follow Up
                                    </label>

                                    <select id="respon_followup" name="respon_followup" required
                                        class="mt-1 w-full h-10 px-3 rounded-sm border
                                               bg-white dark:bg-[#0f0f0f]
                                               text-[#1b1b18] dark:text-[#EDEDEC]
                                               focus:outline-none focus:ring-2 focus:ring-black/10 dark:focus:ring-white/10
                                               {{ $errors->has('respon_followup')
                                                   ? 'border-red-500 focus:ring-red-500/20 dark:focus:ring-red-500/20'
                                                   : 'border-[#19140035] dark:border-[#3E3E3A]' }}"
                                        aria-invalid="{{ $errors->has('respon_followup') ? 'true' : 'false' }}">

                                        <option value="" disabled {{ $selectedRespon === '' ? 'selected' : '' }}>
                                            -- Pilih Respon --
                                        </option>

                                        <option value="1" {{ $selectedRespon === '1' ? 'selected' : '' }}>
                                            Responsif
                                        </option>
                                        <option value="2" {{ $selectedRespon === '2' ? 'selected' : '' }}>
                                            Lambat
                                        </option>
                                        <option value="3" {{ $selectedRespon === '3' ? 'selected' : '' }}>
                                            Tidak Respon
                                        </option>
                                    </select>

                                    @error('respon_followup')
                                        <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                        </div>

                        {{-- KOLOM KANAN: CATATAN --}}
                        <div
                            class="bg-white dark:bg-[#161615]
                                   border border-[#e3e3e0] dark:border-[#3E3E3A]
                                   rounded-lg p-5">

                            <div class="flex items-center justify-between gap-3">
                                <h3 class="text-base sm:text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                                    Catatan Follow Up
                                </h3>
                                <span class="text-xs text-[#706f6c] dark:text-[#A1A09A]">
                                    Wajib
                                </span>
                            </div>

                            <div class="mt-4">
                                <label class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                                    Catatan
                                </label>

                                <textarea name="catatan_followup" rows="6" required
                                    class="mt-1 w-full px-3 py-2 rounded-sm border border-[#19140035]
                                           dark:border-[#3E3E3A] bg-white dark:bg-[#0f0f0f]
                                           text-[#1b1b18] dark:text-[#EDEDEC]
                                           focus:outline-none focus:ring-2 focus:ring-black/10 dark:focus:ring-white/10"
                                    placeholder="Tulis catatan singkat hasil follow up...">{{ old('catatan_followup', $followUp->catatan_followup) }}</textarea>

                                @error('catatan_followup')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                    </div>

                    {{-- Buttons --}}
                    <div class="flex flex-col sm:flex-row gap-3 justify-end">
                        <a href="{{ route('follow-up.index') }}"
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
