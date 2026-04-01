<x-app-layout>

    <x-slot name="title">
        Identitas Calon Konsumen
    </x-slot>

    <x-slot name="header">
        <div class="flex items-center gap-3 min-w-0">
            <x-heroicon-o-user class="w-6 h-6 text-[#1b1b18] dark:text-[#EDEDEC] shrink-0" />
            <h2 class="font-semibold text-lg sm:text-xl text-[#1b1b18] dark:text-[#EDEDEC] leading-tight truncate">
                {{ __('Identitas Calon Konsumen') }}
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

    @php
        $isPaginated = method_exists($items, 'links');
        $q = request('q');
        $perPage = request('per_page', 10);

        $totalCount = $isPaginated ? $items->total() : $items->count();
        $hasSearch = filled($q);
    @endphp

    <div class="space-y-6">

        {{-- Breadcrumb (Responsive) --}}
        <nav class="flex flex-wrap items-center gap-x-2 gap-y-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">
            <a href="{{ route('dashboard') }}" class="hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] transition">
                Beranda
            </a>
            <span class="opacity-50">/</span>
            <span class="text-[#1b1b18] dark:text-[#EDEDEC] font-medium">
                {{ __('Identitas Calon Konsumen') }}
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

                    {{-- Controls (Responsive) --}}
                    <div class="flex flex-col sm:flex-row sm:flex-wrap sm:items-center gap-3 w-full lg:w-auto">

                        {{-- SEARCH (HANYA KIRIM q) --}}
                        <form method="GET" action="{{ route('identitas.index') }}"
                            class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
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

                            {{-- tombol reset search (opsional tapi enak) --}}
                            @if ($hasSearch)
                                <a href="{{ route('identitas.index') }}"
                                    class="h-10 w-full sm:w-auto inline-flex items-center justify-center px-4 rounded-sm
                                          border border-[#19140035] hover:border-[#1915014a]
                                          dark:border-[#3E3E3A] dark:hover:border-[#62605b]
                                          text-[#1b1b18] dark:text-[#EDEDEC] transition whitespace-nowrap">
                                    Reset
                                </a>
                            @endif
                        </form>

                        {{-- LIMIT (HANYA KIRIM per_page, TAPI PERTAHANKAN q) --}}
                        <form method="GET" action="{{ route('identitas.index') }}"
                            class="flex items-center gap-2 text-sm w-full sm:w-auto">
                            @if ($hasSearch)
                                <input type="hidden" name="q" value="{{ $q }}">
                            @endif

                            <span class="text-[#706f6c] dark:text-[#A1A09A] whitespace-nowrap">Tampilkan</span>

                            <select name="per_page" onchange="this.form.submit()"
                                class="h-10 w-full sm:w-auto px-3 rounded-sm border border-[#19140035]
                                       dark:border-[#3E3E3A] bg-white dark:bg-[#0f0f0f]
                                       text-[#1b1b18] dark:text-[#EDEDEC]
                                       focus:outline-none focus:ring-2 focus:ring-black/10 dark:focus:ring-white/10">
                                <option value="10" {{ (string) $perPage === '10' ? 'selected' : '' }}>10</option>
                                <option value="20" {{ (string) $perPage === '20' ? 'selected' : '' }}>20</option>
                                <option value="50" {{ (string) $perPage === '50' ? 'selected' : '' }}>50</option>
                                <option value="100" {{ (string) $perPage === '100' ? 'selected' : '' }}>100</option>
                                <option value="all" {{ (string) $perPage === 'all' ? 'selected' : '' }}>Semua
                                </option>
                            </select>
                        </form>

                        {{-- Create --}}
                        <a href="{{ route('identitas.create') }}"
                            class="h-10 w-full sm:w-auto inline-flex items-center justify-center px-5 rounded-sm
                                   bg-[#1b1b18] hover:bg-black text-white border border-black transition whitespace-nowrap">
                            + Tambah Data
                        </a>
                    </div>
                </div>

                {{-- Flash Messages --}}
                @if (session('success'))
                    <div
                        class="mt-5 px-4 py-3 rounded-md border border-green-200 dark:border-green-800 bg-green-50 dark:bg-green-900/30
                               text-green-700 dark:text-green-300 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div
                        class="mt-5 px-4 py-3 rounded-md border border-red-200 dark:border-red-800 bg-red-50 dark:bg-red-900/30
                               text-red-700 dark:text-red-300 text-sm">
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
                            {{ $totalCount }}
                        </span>
                        data
                        @if ($hasSearch)
                            <span class="ml-1">untuk kata kunci: <span
                                    class="font-medium">{{ $q }}</span></span>
                        @endif
                    </div>
                </div>

                <div class="mt-4 overflow-x-auto -mx-4 sm:mx-0">
                    <div class="min-w-[900px] px-4 sm:px-0">
                        <table class="w-full text-sm">
                            <thead class="text-left">
                                <tr class="border-b border-[#e3e3e0] dark:border-[#3E3E3A]">
                                    <th class="py-3 pr-4 font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">No</th>
                                    <th class="py-3 pr-4 font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">ID</th>
                                    <th class="py-3 pr-4 font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">Nama</th>
                                    <th class="py-3 pr-4 font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">No HP</th>
                                    <th class="py-3 pr-4 font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">Pekerjaan
                                    </th>
                                    <th class="py-3 pr-4 font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">Penghasilan
                                    </th>
                                    <th class="py-3 pr-2 font-semibold text-[#1b1b18] dark:text-[#EDEDEC] text-right">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($items as $it)
                                    <tr class="border-b border-[#f0f0ee] dark:border-[#2a2a28]">
                                        <td class="py-3 pr-4 text-[#1b1b18] dark:text-[#EDEDEC]">
                                            @if ($isPaginated)
                                                {{ $items->firstItem() + $loop->index }}
                                            @else
                                                {{ $loop->iteration }}
                                            @endif
                                        </td>

                                        <td class="py-3 pr-4 text-[#1b1b18] dark:text-[#EDEDEC]">
                                            {{ $it->id }}
                                        </td>

                                        <td class="py-3 pr-4 text-[#1b1b18] dark:text-[#EDEDEC]">
                                            {{ $it->nama }}
                                        </td>

                                        <td class="py-3 pr-4 text-[#1b1b18] dark:text-[#EDEDEC]">
                                            {{ $it->no_hp }}
                                        </td>

                                        <td class="py-3 pr-4 text-[#706f6c] dark:text-[#A1A09A]">
                                            {{ $it->pekerjaan ?? '-' }}
                                        </td>

                                        <td class="py-3 pr-4 text-[#706f6c] dark:text-[#A1A09A]">
                                            @if (!is_null($it->penghasilan))
                                                Rp {{ number_format($it->penghasilan, 0, ',', '.') }}
                                            @else
                                                -
                                            @endif
                                        </td>

                                        <td class="py-3 pr-2 text-right align-middle" x-data="{ open: false }">
                                            <div class="flex items-center justify-end gap-2 flex-wrap">
                                                <a href="{{ route('identitas.show', $it->id) }}"
                                                    class="inline-flex items-center gap-1 px-3 h-9 rounded-md text-sm
                   bg-blue-600 hover:bg-blue-700 text-white transition shadow-sm">
                                                    <x-heroicon-o-eye class="w-4 h-4" />
                                                    Lihat
                                                </a>

                                                <a href="{{ route('identitas.edit', $it->id) }}"
                                                    class="inline-flex items-center gap-1 px-3 h-9 rounded-md text-sm
                   bg-gray-600 hover:bg-gray-700 text-white transition shadow-sm">
                                                    <x-heroicon-o-pencil-square class="w-4 h-4" />
                                                    Edit
                                                </a>

                                                <a href="{{ route('prediksi.show', $it->id) }}"
                                                    class="inline-flex items-center px-3 h-9 rounded-md text-sm
                   bg-indigo-600 hover:bg-indigo-700 text-white transition shadow-sm">
                                                    <x-heroicon-o-chart-bar class="w-4 h-4" />
                                                    Prediksi
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
                                                aria-labelledby="delete-title-{{ $it->id }}"
                                                aria-describedby="delete-desc-{{ $it->id }}"
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
                                                                <h3 id="delete-title-{{ $it->id }}"
                                                                    class="text-base sm:text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                                                                    Anda yakin ingin menghapus data ?<br>
                                                                    <span class="text-rose-700 dark:text-rose-300">
                                                                        {{ $it->nama ?? 'ini' }}
                                                                    </span>
                                                                </h3>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="px-5 sm:px-6 pb-5 sm:pb-6">
                                                        <div
                                                            class="flex flex-col-reverse sm:flex-row sm:justify-end gap-2">
                                                            <button type="button" @click="open = false"
                                                                class="h-10 px-4 rounded-sm border border-[#19140035] dark:border-[#3E3E3A]
                               text-[#1b1b18] dark:text-[#EDEDEC]
                               hover:border-[#1915014a] dark:hover:border-[#62605b] transition">
                                                                Batal
                                                            </button>

                                                            <form action="{{ route('identitas.destroy', $it->id) }}"
                                                                method="POST">
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
                                                @if ($hasSearch)
                                                    <div>
                                                        Data tidak ditemukan untuk pencarian:
                                                        <span class="font-medium">{{ $q }}</span>
                                                    </div>

                                                    <a href="{{ route('identitas.index') }}"
                                                        class="inline-flex items-center justify-center px-5 py-2 rounded-sm
                                                               border border-[#19140035] dark:border-[#3E3E3A]
                                                               text-[#1b1b18] dark:text-[#EDEDEC] transition">
                                                        Reset pencarian
                                                    </a>
                                                @else
                                                    <div>
                                                        Belum ada data calon konsumen.
                                                    </div>

                                                    <a href="{{ route('identitas.create') }}"
                                                        class="inline-flex items-center justify-center px-5 py-2 rounded-sm
                                                               bg-[#1b1b18] hover:bg-black text-white border border-black
                                                               transition">
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

                {{-- Footer info + pagination --}}
                <div class="mt-6 text-sm">

                    <div class="text-center text-[#706f6c] dark:text-[#A1A09A] mb-4">
                        @if ($isPaginated)
                            @if ($items->total() > 0)
                                Menampilkan {{ $items->firstItem() }}–{{ $items->lastItem() }} dari
                                {{ $items->total() }} data
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
                        @if ($isPaginated)
                            {{-- Prev --}}
                            @if ($items->onFirstPage())
                                <button
                                    class="px-4 py-2 rounded-sm border border-[#19140035] dark:border-[#3E3E3A]
                                               text-[#A1A09A] cursor-not-allowed w-full sm:w-auto"
                                    disabled>
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

                            {{-- Page --}}
                            <button
                                class="px-4 py-2 rounded-sm bg-[#1b1b18] text-white border border-black w-full sm:w-auto">
                                {{ $items->currentPage() }}
                            </button>

                            {{-- Next --}}
                            @if ($items->hasMorePages())
                                <a href="{{ $items->nextPageUrl() }}"
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
