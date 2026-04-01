{{-- resources/views/pages/survei/show.blade.php --}}

@php
    $id = $item->id_survei ?? $item->id ?? '-';

    // Relasi calon konsumen aman
    $ck = $item->calonKonsumen ?? null;

    $nama = $ck->nama ?? '-';
    $nohp = $ck->no_hp ?? '-';

    // Survei label (DB: 1=Ya, 2=Tidak)
    $surveiLabel = '-';
    $sv = $item->survei ?? null;
    if ((string) $sv === '1') $surveiLabel = 'Ya';
    elseif ((string) $sv === '2') $surveiLabel = 'Tidak';

    // Format tanggal survei
    $tgl = '-';
    if (!empty($item->tgl_survei)) {
        try {
            $tgl = \Illuminate\Support\Carbon::parse($item->tgl_survei)->format('d/m/Y');
        } catch (\Throwable $e) {
            $tgl = (string) $item->tgl_survei;
        }
    }

    $hasil = $item->hasil_survei ?? '-';
    $catatan = $item->catatan_survei ?? '-';
@endphp

<x-app-layout>

    <x-slot name="title">
        Detail Survei
    </x-slot>

    <x-slot name="header">
        <div class="flex items-center gap-3 min-w-0">
            <x-heroicon-o-clipboard-document-check class="w-6 h-6 text-[#1b1b18] dark:text-[#EDEDEC] shrink-0" />
            <h2 class="font-semibold text-lg sm:text-xl text-[#1b1b18] dark:text-[#EDEDEC] leading-tight truncate">
                {{ __('Detail Survei') }}
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
            <a href="{{ route('survei.index') }}" class="hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] transition">
                Survei
            </a>
            <span>/</span>
            <span class="text-[#1b1b18] dark:text-[#EDEDEC] font-medium">
                Detail
            </span>
        </nav>

        {{-- Flash Messages (opsional, auto hide) --}}
        @if (session('success'))
            <div
                x-data="{ show: true }"
                x-init="setTimeout(() => show = false, 3000)"
                x-show="show"
                x-transition.opacity.duration.300ms
                class="px-4 py-3 rounded-md border border-green-200 dark:border-green-800 bg-green-50 dark:bg-green-900/30
                       text-green-700 dark:text-green-300 text-sm flex items-start justify-between gap-3">
                <div>{{ session('success') }}</div>
                <button type="button" @click="show=false" class="text-green-700/70 dark:text-green-200/70 hover:opacity-80">
                    ✕
                </button>
            </div>
        @endif

        @if (session('error'))
            <div
                x-data="{ show: true }"
                x-init="setTimeout(() => show = false, 3500)"
                x-show="show"
                x-transition.opacity.duration.300ms
                class="px-4 py-3 rounded-md border border-red-200 dark:border-red-800 bg-red-50 dark:bg-red-900/30
                       text-red-700 dark:text-red-300 text-sm flex items-start justify-between gap-3">
                <div>{{ session('error') }}</div>
                <button type="button" @click="show=false" class="text-red-700/70 dark:text-red-200/70 hover:opacity-80">
                    ✕
                </button>
            </div>
        @endif

        {{-- Card Detail --}}
        <div
            class="bg-white dark:bg-[#161615] border border-[#e3e3e0] dark:border-[#3E3E3A]
                   rounded-lg shadow-sm overflow-hidden">

            <div class="p-5 sm:p-8 space-y-6">

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <div class="text-sm text-[#706f6c] dark:text-[#A1A09A]">ID Survei</div>
                        <div class="text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                            {{ $id }}
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-2 sm:justify-end">
                        <a href="{{ route('survei.index') }}"
                            class="h-10 inline-flex items-center justify-center px-4 rounded-sm
                                   border border-[#19140035] dark:border-[#3E3E3A]
                                   text-[#1b1b18] dark:text-[#EDEDEC] transition">
                            Kembali
                        </a>

                        <a href="{{ route('survei.edit', $id) }}"
                            class="h-10 inline-flex items-center justify-center px-4 rounded-sm
                                   bg-gray-600 hover:bg-gray-700 text-white transition">
                            Edit
                        </a>

                        <button type="button" @click="open=true"
                            class="h-10 inline-flex items-center justify-center px-4 rounded-sm
                                   bg-rose-600 hover:bg-rose-700 text-white transition"
                            x-data="{ open: false }"
                            x-on:click="open = true"
                            x-ref="btnDelete">
                            Hapus
                        </button>
                    </div>
                </div>

                {{-- Grid detail --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                    {{-- Data Survei --}}
                    <div class="rounded-lg border border-[#e3e3e0] dark:border-[#3E3E3A] p-5">
                        <h3 class="text-base sm:text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                            Data Survei
                        </h3>

                        <div class="mt-4 space-y-3 text-sm">
                            <div class="flex justify-between gap-6">
                                <span class="text-[#706f6c] dark:text-[#A1A09A]">Survei</span>
                                <span class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ $surveiLabel }}</span>
                            </div>

                            <div class="flex justify-between gap-6">
                                <span class="text-[#706f6c] dark:text-[#A1A09A]">Tanggal Survei</span>
                                <span class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ $tgl }}</span>
                            </div>

                            <div class="flex justify-between gap-6">
                                <span class="text-[#706f6c] dark:text-[#A1A09A]">Hasil Survei</span>
                                <span class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                                    {{ $hasil }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Data Calon Konsumen --}}
                    <div class="rounded-lg border border-[#e3e3e0] dark:border-[#3E3E3A] p-5">
                        <h3 class="text-base sm:text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                            Calon Konsumen
                        </h3>

                        <div class="mt-4 space-y-3 text-sm">
                            <div class="flex justify-between gap-6">
                                <span class="text-[#706f6c] dark:text-[#A1A09A]">Nama</span>
                                <span class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ $nama }}</span>
                            </div>

                            <div class="flex justify-between gap-6">
                                <span class="text-[#706f6c] dark:text-[#A1A09A]">No HP</span>
                                <span class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ $nohp }}</span>
                            </div>

                            @if ($ck && isset($ck->alamat))
                                <div class="flex justify-between gap-6">
                                    <span class="text-[#706f6c] dark:text-[#A1A09A]">Alamat</span>
                                    <span class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                                        {{ $ck->alamat ?? '-' }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>

                {{-- Catatan --}}
                <div class="rounded-lg border border-[#e3e3e0] dark:border-[#3E3E3A] p-5">
                    <h3 class="text-base sm:text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                        Catatan Survei
                    </h3>

                    <div class="mt-3 text-sm text-[#1b1b18] dark:text-[#EDEDEC] whitespace-pre-line">
                        {{ $catatan }}
                    </div>
                </div>

            </div>
        </div>

        {{-- MODAL HAPUS (Alpine) --}}
        <div x-data="{ open: false }"
             x-init="$watch('open', val => { if(!val) return; })">

            <div
                x-on:click.window="
                    // kalau tombol Hapus ditekan, set open true
                    // (kita deteksi dari textContent tombol atau bisa kamu ganti pakai dispatch event custom)
                ">
            </div>
        </div>
        <div x-data="{ open: false }" class="hidden">
        </div>
        <div x-data="{ open: false }">
        </div>

        <div x-data="{ open: false }" class="hidden"></div>

    </div>

</x-app-layout>

