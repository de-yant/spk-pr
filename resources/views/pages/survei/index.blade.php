{{-- resources/views/pages/survei/index.blade.php --}}

@php
    // Aman kalau controller belum ngirim variabel ini
    $q = (string) request('q', '');
    $hasSearch = $q !== '';

    // Deteksi pagination vs collection
    $isPaginated = isset($items) && is_object($items) && method_exists($items, 'links');

    // Total count aman
    if (!isset($totalCount)) {
        if ($isPaginated) {
            $totalCount = $items->total();
        } else {
            $totalCount = isset($items) ? $items->count() : 0;
        }
    }

    $emptyText = $hasSearch ? 'Data tidak ditemukan.' : 'Belum ada data survei.';

    // Helper untuk bikin URL Prev/Next yang tetap membawa query q & per_page
    $baseQuery = request()->except('page');
@endphp

<x-app-layout>

    <x-slot name="title">
        Survei Calon Konsumen
    </x-slot>

    <x-slot name="header">
        <div class="flex items-center gap-3 min-w-0">
            <x-heroicon-o-clipboard-document-check class="w-6 h-6 text-[#1b1b18] dark:text-[#EDEDEC] shrink-0" />
            <h2 class="font-semibold text-lg sm:text-xl text-[#1b1b18] dark:text-[#EDEDEC] leading-tight truncate">
                {{ __('Survei Calon Konsumen') }}
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
        <nav class="flex flex-wrap items-center gap-x-2 gap-y-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">
            <a href="{{ route('dashboard') }}" class="hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] transition">
                Beranda
            </a>
            <span class="opacity-50">/</span>
            <span class="text-[#1b1b18] dark:text-[#EDEDEC] font-medium">
                {{ __('Survei Calon Konsumen') }}
            </span>
        </nav>

        {{-- Header Card: Search + Actions --}}
        <div
            class="bg-white dark:bg-[#161615] border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg
                   shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] overflow-hidden">
            <div class="p-5 sm:p-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div class="min-w-0">
                        <h3 class="text-base sm:text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC] truncate">
                            {{ __('Kelola Data Survei') }}
                        </h3>
                    </div>

                    {{-- Controls --}}
                    <div class="flex flex-col sm:flex-row sm:flex-wrap sm:items-center gap-3 w-full lg:w-auto">

                        {{-- SEARCH --}}
                        <form method="GET" action="{{ route('survei.index') }}"
                            class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">

                            {{-- pertahankan per_page saat search --}}
                            <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">

                            <input type="text" name="q" value="{{ $q }}"
                                placeholder="Cari nama / no HP..."
                                class="h-10 w-full sm:w-64 px-3 rounded-sm border border-[#19140035]
                                       dark:border-[#3E3E3A] bg-white dark:bg-[#0f0f0f]
                                       text-[#1b1b18] dark:text-[#EDEDEC] placeholder:text-[#A1A09A]
                                       focus:outline-none focus:ring-2 focus:ring-black/10 dark:focus:ring-white/10" />

                            <button type="submit"
                                class="h-10 w-full sm:w-auto inline-flex items-center justify-center px-4 rounded-sm
                                       border border-[#19140035] hover:border-[#1915014a]
                                       dark:border-[#3E3E3A] dark:hover:border-[#62605b]
                                       text-[#1b1b18] dark:text-[#EDEDEC] transition whitespace-nowrap">
                                Cari
                            </button>

                            {{-- Reset kalau q ada --}}
                            @if ($hasSearch)
                                <a href="{{ route('survei.index', ['per_page' => request('per_page', 10)]) }}"
                                    class="h-10 w-full sm:w-auto inline-flex items-center justify-center px-4 rounded-sm
                                           border border-[#19140035] hover:border-[#1915014a]
                                           dark:border-[#3E3E3A] dark:hover:border-[#62605b]
                                           text-[#1b1b18] dark:text-[#EDEDEC] transition whitespace-nowrap">
                                    Reset
                                </a>
                            @endif
                        </form>

                        {{-- LIMIT --}}
                        <form method="GET" action="{{ route('survei.index') }}"
                            class="flex items-center gap-2 text-sm w-full sm:w-auto">
                            <input type="hidden" name="q" value="{{ $q }}">

                            <span class="text-[#706f6c] dark:text-[#A1A09A] whitespace-nowrap">Tampilkan</span>

                            <select name="per_page" onchange="this.form.submit()"
                                class="h-10 w-full sm:w-auto px-3 rounded-sm border border-[#19140035]
                                       dark:border-[#3E3E3A] bg-white dark:bg-[#0f0f0f]
                                       text-[#1b1b18] dark:text-[#EDEDEC]
                                       focus:outline-none focus:ring-2 focus:ring-black/10 dark:focus:ring-white/10">
                                <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                                <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                <option value="all" {{ request('per_page') == 'all' ? 'selected' : '' }}>Semua</option>
                            </select>
                        </form>

                        {{-- Create --}}
                        <a href="{{ route('survei.create') }}"
                            class="h-10 w-full sm:w-auto inline-flex items-center justify-center px-5 rounded-sm
                                   bg-[#1b1b18] hover:bg-black text-white border border-black transition whitespace-nowrap">
                            + Tambah Data
                        </a>
                    </div>
                </div>

                {{-- Flash Messages (AUTO HIDE) --}}
                @if (session('success'))
                    <div
                        x-data="{ show: true }"
                        x-init="setTimeout(() => show = false, 3000)"
                        x-show="show"
                        x-transition.opacity.duration.300ms
                        class="mt-5 px-4 py-3 rounded-md border border-green-200 dark:border-green-800 bg-green-50 dark:bg-green-900/30
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
                        class="mt-5 px-4 py-3 rounded-md border border-red-200 dark:border-red-800 bg-red-50 dark:bg-red-900/30
                               text-red-700 dark:text-red-300 text-sm flex items-start justify-between gap-3">
                        <div>{{ session('error') }}</div>
                        <button type="button" @click="show=false" class="text-red-700/70 dark:text-red-200/70 hover:opacity-80">
                            ✕
                        </button>
                    </div>
                @endif
            </div>
        </div>

        {{-- Table --}}
        <div
            class="bg-white dark:bg-[#161615] border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg
                   shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] overflow-hidden">

            <div class="p-4 sm:p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div class="text-sm text-[#706f6c] dark:text-[#A1A09A]">
                        Menampilkan
                        <span class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                            {{ $totalCount }}
                        </span>
                        data
                        @if ($hasSearch)
                            <span class="ml-1">untuk kata kunci: <span class="font-medium">{{ $q }}</span></span>
                        @endif
                    </div>
                </div>

                {{-- Table Wrapper --}}
                <div class="overflow-x-auto -mx-4 sm:mx-0">
                    <div class="min-w-[900px] px-4 sm:px-0">
                        <table class="w-full text-sm">
                            <thead class="text-left">
                                <tr class="border-b border-[#e3e3e0] dark:border-[#3E3E3A]">
                                    <th class="py-3 pr-4 font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">No</th>
                                    <th class="py-3 pr-4 font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">ID</th>
                                    <th class="py-3 pr-4 font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">Nama</th>
                                    <th class="py-3 pr-4 font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">Survei</th>
                                    <th class="py-3 pr-4 font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">Tanggal Survei</th>
                                    <th class="py-3 pr-4 font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">Hasil</th>
                                    <th class="py-3 pr-2 font-semibold text-[#1b1b18] dark:text-[#EDEDEC] text-right">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($items ?? [] as $it)
                                    @php
                                        $id = $it->id_survei ?? $it->id;

                                        // Aman dari calonKonsumen null
                                        $nama = optional($it->calonKonsumen)->nama ?? '-';
                                        $nohp = optional($it->calonKonsumen)->no_hp ?? '';

                                        // Aman dari tgl_survei null / sudah Carbon / string
                                        $tgl = '-';
                                        if (!empty($it->tgl_survei)) {
                                            try {
                                                $tgl = \Illuminate\Support\Carbon::parse($it->tgl_survei)->format('d/m/Y');
                                            } catch (\Throwable $e) {
                                                $tgl = (string) $it->tgl_survei;
                                            }
                                        }

                                        // SURVEI: di DB 1=Ya, 2=Tidak -> jangan tampilkan angka
                                        $surveiLabel = '-';
                                        $sv = $it->survei ?? null;
                                        if ((string)$sv === '1') $surveiLabel = 'Ya';
                                        elseif ((string)$sv === '2') $surveiLabel = 'Tidak';
                                    @endphp

                                    <tr class="border-b border-[#f0f0ee] dark:border-[#2a2a28]">
                                        <td class="py-3 pr-4 text-[#1b1b18] dark:text-[#EDEDEC]">
                                            {{ $isPaginated ? ($items->firstItem() + $loop->index) : ($loop->iteration) }}
                                        </td>

                                        <td class="py-3 pr-4 text-[#1b1b18] dark:text-[#EDEDEC]">
                                            {{ $id }}
                                        </td>

                                        <td class="py-3 pr-4 text-[#1b1b18] dark:text-[#EDEDEC]">
                                            {{ $nama }}
                                            @if ($nohp !== '')
                                                <div class="text-xs text-[#706f6c] dark:text-[#A1A09A]">
                                                    {{ $nohp }}
                                                </div>
                                            @endif
                                        </td>

                                        <td class="py-3 pr-4 text-[#706f6c] dark:text-[#A1A09A]">
                                            {{ $surveiLabel }}
                                        </td>

                                        <td class="py-3 pr-4 text-[#1b1b18] dark:text-[#EDEDEC]">
                                            {{ $tgl }}
                                        </td>

                                        <td class="py-3 pr-4 text-[#706f6c] dark:text-[#A1A09A]">
                                            {{ $it->hasil_survei ?? '-' }}
                                        </td>

                                        <td class="py-3 pr-2 text-right align-middle" x-data="{ open: false }">
                                            <div class="flex items-center justify-end gap-2 flex-wrap">
                                                <a href="{{ route('survei.show', $id) }}"
                                                    class="inline-flex items-center gap-1 px-3 h-9 rounded-md text-sm
                   bg-blue-600 hover:bg-blue-700 text-white transition shadow-sm">
                                                    <x-heroicon-o-eye class="w-4 h-4" />
                                                    Lihat
                                                </a>

                                                <a href="{{ route('survei.edit', $id) }}"
                                                    class="inline-flex items-center gap-1 px-3 h-9 rounded-md text-sm
                   bg-gray-600 hover:bg-gray-700 text-white transition shadow-sm">
                                                    <x-heroicon-o-pencil-square class="w-4 h-4" />
                                                    Edit
                                                </a>

                                                {{-- Tombol buka modal --}}
                                                <button type="button" @click="open = true"
                                                    class="inline-flex items-center gap-1 px-3 h-9 rounded-md text-sm
                   bg-red-600 hover:bg-red-700 text-white transition shadow-sm">
                                                    <x-heroicon-o-trash class="w-4 h-4" />
                                                    Hapus
                                                </button>
                                            </div>

                                            {{-- MODAL --}}
                                            <div x-show="open" x-cloak x-transition.opacity.duration.150ms
                                                class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6"
                                                role="dialog" aria-modal="true"
                                                aria-labelledby="delete-title-{{ $id }}"
                                                aria-describedby="delete-desc-{{ $id }}"
                                                @keydown.escape.window="open = false">

                                                {{-- overlay --}}
                                                <div class="absolute inset-0 bg-black/50 backdrop-blur-[1px]"
                                                    @click="open = false"></div>

                                                {{-- modal box --}}
                                                <div x-transition:enter="transition ease-out duration-200"
                                                    x-transition:enter-start="opacity-0 translate-y-2 sm:translate-y-0 sm:scale-95"
                                                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                                    x-transition:leave="transition ease-in duration-150"
                                                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                                    x-transition:leave-end="opacity-0 translate-y-2 sm:translate-y-0 sm:scale-95"
                                                    class="relative w-full max-w-md rounded-xl bg-white dark:bg-[#161615]
                   border border-[#e3e3e0] dark:border-[#3E3E3A]
                   shadow-[0px_18px_45px_rgba(0,0,0,0.30)] overflow-hidden"
                                                    @click.stop>

                                                    <div class="p-5 sm:p-6">
                                                        <div class="flex items-start gap-4">
                                                            <div class="shrink-0">
                                                                <div
                                                                    class="w-11 h-11 rounded-full flex items-center justify-center
                                    bg-rose-100 dark:bg-rose-900/30">
                                                                    <x-heroicon-o-exclamation-triangle
                                                                        class="w-6 h-6 text-rose-700 dark:text-rose-300" />
                                                                </div>
                                                            </div>

                                                            <div class="min-w-0">
                                                                <h3 id="delete-title-{{ $id }}"
                                                                    class="text-base sm:text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                                                                    Anda yakin ingin menghapus data survei?
                                                                </h3>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="px-5 sm:px-6 pb-5 sm:pb-6">
                                                        <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-2">
                                                            <button type="button" @click="open = false"
                                                                class="h-10 px-4 rounded-sm border border-[#19140035] dark:border-[#3E3E3A]
                               text-[#1b1b18] dark:text-[#EDEDEC]
                               hover:border-[#1915014a] dark:hover:border-[#62605b] transition">
                                                                Batal
                                                            </button>

                                                            <form action="{{ route('survei.destroy', $id) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="h-10 px-4 rounded-sm bg-rose-600 hover:bg-rose-700 text-white transition shadow-sm">
                                                                    Ya, Hapus
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7"
                                            class="py-10 text-center text-sm text-[#706f6c] dark:text-[#A1A09A]">
                                            <div class="space-y-4">
                                                <div>{{ $emptyText }}</div>

                                                @if (!$hasSearch)
                                                    <a href="{{ route('survei.create') }}"
                                                        class="inline-flex items-center justify-center px-5 py-2 rounded-sm
                                                               bg-[#1b1b18] hover:bg-black text-white border border-black transition">
                                                        + Tambah Data Pertama
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>
                </div>

                {{-- Footer: info + pagination --}}
                <div class="mt-6 text-sm">

                    {{-- Info --}}
                    <div class="text-center text-[#706f6c] dark:text-[#A1A09A] mb-4">
                        @if ($isPaginated)
                            @if ($items->total() > 0)
                                Menampilkan {{ $items->firstItem() }}–{{ $items->lastItem() }} dari
                                {{ $items->total() }} data
                            @else
                                Menampilkan 0 dari 0 data
                            @endif
                        @else
                            @if (isset($items) && $items->count() > 0)
                                Menampilkan 1–{{ $items->count() }} dari {{ $items->count() }} data
                            @else
                                Menampilkan 0 dari 0 data
                            @endif
                        @endif
                    </div>

                    {{-- Pagination --}}
                    <div class="flex flex-wrap justify-center items-center gap-2">
                        @if ($isPaginated)
                            @php
                                $current = $items->currentPage();
                                $prevUrl =
                                    $current > 1
                                        ? request()->fullUrlWithQuery(array_merge($baseQuery, ['page' => $current - 1]))
                                        : null;
                                $nextUrl = $items->hasMorePages()
                                    ? request()->fullUrlWithQuery(array_merge($baseQuery, ['page' => $current + 1]))
                                    : null;
                            @endphp

                            {{-- Prev --}}
                            @if (!$prevUrl)
                                <button
                                    class="px-4 py-2 rounded-sm border border-[#19140035] dark:border-[#3E3E3A]
                                           text-[#A1A09A] cursor-not-allowed w-full sm:w-auto"
                                    disabled>
                                    Prev
                                </button>
                            @else
                                <a href="{{ $prevUrl }}"
                                    class="px-4 py-2 rounded-sm border border-[#19140035] dark:border-[#3E3E3A]
                                           text-[#1b1b18] dark:text-[#EDEDEC] hover:border-[#1915014a]
                                           dark:hover:border-[#62605b] transition w-full sm:w-auto text-center">
                                    Prev
                                </a>
                            @endif

                            {{-- current page --}}
                            <button
                                class="px-4 py-2 rounded-sm bg-[#1b1b18] text-white border border-black w-full sm:w-auto">
                                {{ $current }}
                            </button>

                            {{-- Next --}}
                            @if ($nextUrl)
                                <a href="{{ $nextUrl }}"
                                    class="px-4 py-2 rounded-sm border border-[#19140035] dark:border-[#3E3E3A]
                                           text-[#1b1b18] dark:text-[#EDEDEC] hover:border-[#1915014a]
                                           dark:hover:border-[#62605b] transition w-full sm:w-auto text-center">
                                    Next
                                </a>
                            @else
                                <button
                                    class="px-4 py-2 rounded-sm border border-[#19140035] dark:border-[#3E3E3A]
                                           text-[#A1A09A] cursor-not-allowed w-full sm:w-auto"
                                    disabled>
                                    Next
                                </button>
                            @endif
                        @else
                            {{-- per_page=all --}}
                            <button
                                class="px-4 py-2 rounded-sm border border-[#19140035] dark:border-[#3E3E3A]
                                       text-[#A1A09A] cursor-not-allowed w-full sm:w-auto"
                                disabled>
                                Prev
                            </button>
                            <button
                                class="px-4 py-2 rounded-sm bg-[#1b1b18] text-white border border-black w-full sm:w-auto">
                                1
                            </button>
                            <button
                                class="px-4 py-2 rounded-sm border border-[#19140035] dark:border-[#3E3E3A]
                                       text-[#A1A09A] cursor-not-allowed w-full sm:w-auto"
                                disabled>
                                Next
                            </button>
                        @endif
                    </div>
                </div>

            </div>
        </div>

    </div>

</x-app-layout>
