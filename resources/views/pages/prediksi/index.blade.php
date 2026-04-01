<x-app-layout>

    <x-slot name="title">
        {{ $title ?? 'Prediksi Hasil' }}
    </x-slot>

    <x-slot name="header">
        <div class="flex items-center gap-3 min-w-0">
            <x-heroicon-o-chart-bar class="w-6 h-6 text-[#1b1b18] dark:text-[#EDEDEC] shrink-0" />
            <h2 class="font-semibold text-lg sm:text-xl text-[#1b1b18] dark:text-[#EDEDEC] leading-tight truncate">
                {{ __('Hasil Prediksi') }}
            </h2>
        </div>
    </x-slot>

    <x-slot name="actions">
        <span
            class="hidden sm:inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs
                   border border-emerald-200 dark:border-emerald-800
                   bg-emerald-50 dark:bg-emerald-900/30
                   text-emerald-700 dark:text-emerald-300">
            <span class="text-emerald-500 dark:text-emerald-400">●</span>
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
                {{ __('Hasil Prediksi') }}
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
                            {{ __('Kelola Data Calon Konsumen') }}
                        </h3>
                    </div>

                    {{-- Controls --}}
                    <div class="flex flex-col sm:flex-row sm:flex-wrap sm:items-center gap-3 w-full lg:w-auto">

                        {{-- Search --}}
                        <form method="GET" action="{{ route('prediksi.index') }}"
                              class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
                            <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">

                            <input type="text" name="q" value="{{ request('q') }}"
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
                        </form>

                        {{-- Per Page --}}
                        <form method="GET" action="{{ route('prediksi.index') }}"
                              class="flex items-center gap-2 text-sm w-full sm:w-auto">
                            <input type="hidden" name="q" value="{{ request('q') }}">

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
                    </div>
                </div>

                {{-- Flash --}}
                @if (session('success'))
                    <div class="mt-5 px-4 py-3 rounded-md border border-emerald-200 dark:border-emerald-800
                                bg-emerald-50 dark:bg-emerald-900/30
                                text-emerald-700 dark:text-emerald-300 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mt-5 px-4 py-3 rounded-md border border-rose-200 dark:border-rose-800
                                bg-rose-50 dark:bg-rose-900/30
                                text-rose-700 dark:text-rose-300 text-sm">
                        {{ session('error') }}
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
                            @if (isset($isPaginated) && $isPaginated)
                                {{ $items->total() }}
                            @else
                                {{ $items->count() }}
                            @endif
                        </span>
                        data
                    </div>
                </div>

                <div class="mt-4 overflow-x-auto -mx-4 sm:mx-0">
                    <div class="min-w-[1050px] px-4 sm:px-0">
                        <table class="w-full text-sm">
                            <thead class="text-left">
                                <tr class="border-b border-[#e3e3e0] dark:border-[#3E3E3A]">
                                    <th class="py-3 pr-4 font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">No</th>
                                    <th class="py-3 pr-4 font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">ID</th>
                                    <th class="py-3 pr-4 font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">Nama</th>
                                    <th class="py-3 pr-4 font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                                        Prediksi Membeli (kelas 1)
                                    </th>
                                    <th class="py-3 pr-4 font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                                        Prediksi Tidak Membeli (kelas 0)
                                    </th>
                                    <th class="py-3 pr-4 font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                                        Hasil Prediksi
                                    </th>
                                    <th class="py-3 pr-2 font-semibold text-[#1b1b18] dark:text-[#EDEDEC] text-right">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($items as $it)
                                    @php
                                        $id = $it->id_calon_konsumen ?? $it->id;

                                        // Label dari controller (SUDAH benar: 1=Membeli, 0=Tidak Membeli)
                                        $labelNum  = $it->prediksi_label ?? null; // 0/1
                                        $labelText = $it->prediksi_text ?? null;  // Membeli/Tidak Membeli
                                        $err       = $it->prediksi_error ?? null;

                                        // Prob juga dari controller (SUDAH benar):
                                        // prob_membeli = prob kelas 1
                                        // prob_tidak_membeli = prob kelas 0
                                        $probM = $it->prob_membeli ?? null;
                                        $probT = $it->prob_tidak_membeli ?? null;

                                        $isMembeli = ((string)$labelNum) === '1';
                                    @endphp

                                    <tr class="border-b border-[#f0f0ee] dark:border-[#2a2a28]">
                                        <td class="py-3 pr-4 text-[#1b1b18] dark:text-[#EDEDEC]">
                                            @if (method_exists($items, 'firstItem'))
                                                {{ $items->firstItem() + $loop->index }}
                                            @else
                                                {{ $loop->iteration }}
                                            @endif
                                        </td>

                                        <td class="py-3 pr-4 text-[#1b1b18] dark:text-[#EDEDEC]">
                                            {{ $id }}
                                        </td>

                                        <td class="py-3 pr-4 text-[#1b1b18] dark:text-[#EDEDEC]">
                                            {{ $it->nama ?? '-' }}

                                            @if ($err)
                                                <div class="mt-1 text-xs text-rose-600 dark:text-rose-400">
                                                    {{ $err }}
                                                </div>
                                            @endif
                                        </td>

                                        {{-- Prob Membeli (kelas 1) --}}
                                        <td class="py-3 pr-4 text-[#706f6c] dark:text-[#A1A09A]">
                                            {{ is_numeric($probM) ? number_format(((float)$probM) * 100, 2) . '%' : '-' }}
                                        </td>

                                        {{-- Prob Tidak Membeli (kelas 0) --}}
                                        <td class="py-3 pr-4 text-[#706f6c] dark:text-[#A1A09A]">
                                            {{ is_numeric($probT) ? number_format(((float)$probT) * 100, 2) . '%' : '-' }}
                                        </td>

                                        {{-- Hasil Prediksi --}}
                                        <td class="py-3 pr-4">
                                            @if ($labelNum !== null)
                                                <span
                                                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs border
                                                    {{ $isMembeli
                                                        ? 'bg-emerald-100 text-emerald-700 border-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-300 dark:border-emerald-800'
                                                        : 'bg-rose-100 text-rose-700 border-rose-200 dark:bg-rose-900/30 dark:text-rose-300 dark:border-rose-800' }}">
                                                    {{ $labelText ?? ($isMembeli ? 'Membeli' : 'Tidak Membeli') }}
                                                </span>
                                            @else
                                                <span class="text-[#A1A09A]">Belum diprediksi</span>
                                            @endif
                                        </td>

                                        {{-- Aksi --}}
                                        <td class="py-3 pr-2 text-right align-middle">
                                            <div class="flex items-center justify-end gap-2 flex-wrap">
                                                <a href="{{ route('prediksi.show', $id) }}"
                                                   class="inline-flex items-center gap-1 px-3 py-1.5 rounded-sm text-xs
                                                          bg-blue-600 hover:bg-blue-700
                                                          text-white transition duration-200 shadow-sm hover:shadow-md">
                                                    <x-heroicon-o-chart-bar class="w-4 h-4" />
                                                    Prediksi
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-10 text-center text-[#706f6c] dark:text-[#A1A09A]">
                                            Data tidak ditemukan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Pagination --}}
                <div class="mt-6 text-sm">
                    <div class="text-center text-[#706f6c] dark:text-[#A1A09A] mb-4">
                        @if (isset($isPaginated) && $isPaginated)
                            @if ($items->total() > 0)
                                Menampilkan {{ $items->firstItem() }}–{{ $items->lastItem() }} dari {{ $items->total() }} data
                            @else
                                Menampilkan 0 dari 0 data
                            @endif
                        @else
                            @if ($items->count() > 0)
                                Menampilkan 1–{{ $items->count() }} dari {{ $items->count() }} data
                            @else
                                Menampilkan 0 dari 0 data
                            @endif
                        @endif
                    </div>

                    <div class="flex flex-wrap justify-center items-center gap-2">
                        @if (isset($isPaginated) && $isPaginated)
                            @if ($items->onFirstPage())
                                <button class="px-4 py-2 rounded-sm border border-[#19140035] dark:border-[#3E3E3A]
                                               text-[#A1A09A] cursor-not-allowed w-full sm:w-auto" disabled>
                                    Prev
                                </button>
                            @else
                                <a href="{{ $items->previousPageUrl() }}"
                                   class="px-4 py-2 rounded-sm border border-[#19140035] dark:border-[#3E3E3A]
                                          text-[#1b1b18] dark:text-[#EDEDEC] hover:border-[#1915014a]
                                          dark:hover:border-[#62605b] transition w-full sm:w-auto text-center">
                                    Prev
                                </a>
                            @endif

                            <button class="px-4 py-2 rounded-sm bg-[#1b1b18] text-white border border-black w-full sm:w-auto">
                                {{ $items->currentPage() }}
                            </button>

                            @if ($items->hasMorePages())
                                <a href="{{ $items->nextPageUrl() }}"
                                   class="px-4 py-2 rounded-sm border border-[#19140035] dark:border-[#3E3E3A]
                                          text-[#1b1b18] dark:text-[#EDEDEC] hover:border-[#1915014a]
                                          dark:hover:border-[#62605b] transition w-full sm:w-auto text-center">
                                    Next
                                </a>
                            @else
                                <button class="px-4 py-2 rounded-sm border border-[#19140035] dark:border-[#3E3E3A]
                                               text-[#A1A09A] cursor-not-allowed w-full sm:w-auto" disabled>
                                    Next
                                </button>
                            @endif
                        @else
                            <button class="px-4 py-2 rounded-sm border border-[#19140035] dark:border-[#3E3E3A]
                                           text-[#A1A09A] cursor-not-allowed w-full sm:w-auto" disabled>
                                Prev
                            </button>

                            <button class="px-4 py-2 rounded-sm bg-[#1b1b18] text-white border border-black w-full sm:w-auto">
                                1
                            </button>

                            <button class="px-4 py-2 rounded-sm border border-[#19140035] dark:border-[#3E3E3A]
                                           text-[#A1A09A] cursor-not-allowed w-full sm:w-auto" disabled>
                                Next
                            </button>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

</x-app-layout>
