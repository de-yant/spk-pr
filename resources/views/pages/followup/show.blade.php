<x-app-layout>

    <x-slot name="title">
        Detail Follow Up
    </x-slot>

    <x-slot name="header">
        <div class="flex items-center gap-3">
            <x-heroicon-o-eye class="w-6 h-6 text-[#1b1b18] dark:text-[#EDEDEC]" />
            <h2 class="font-semibold text-lg sm:text-xl text-[#1b1b18] dark:text-[#EDEDEC]">
                Detail Follow Up
            </h2>
        </div>
    </x-slot>

    <div class="space-y-6">

        {{-- Breadcrumb --}}
        <nav class="flex flex-wrap items-center gap-2 text-sm text-[#706f6c] dark:text-[#A1A09A]">
            <a href="{{ route('dashboard') }}" class="hover:text-[#1b1b18] dark:hover:text-[#EDEDEC]">
                Beranda
            </a>
            <span>/</span>
            <a href="{{ route('follow-up.index') }}" class="hover:text-[#1b1b18] dark:hover:text-[#EDEDEC]">
                Follow Up
            </a>
            <span>/</span>
            <span class="text-[#1b1b18] dark:text-[#EDEDEC] font-medium">
                Detail
            </span>
        </nav>

        {{-- Card --}}
        <div class="bg-white dark:bg-[#161615]
                    border border-[#e3e3e0] dark:border-[#3E3E3A]
                    rounded-lg shadow-sm">

            <div class="p-6 space-y-6">

                <h3 class="text-base sm:text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                    Informasi Follow Up
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                    {{-- ID --}}
                    <div>
                        <div class="text-sm text-[#706f6c] dark:text-[#A1A09A]">
                            ID Follow Up
                        </div>
                        <div class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                            {{ $followUp->id }}
                        </div>
                    </div>

                    {{-- Nama Konsumen --}}
                    <div>
                        <div class="text-sm text-[#706f6c] dark:text-[#A1A09A]">
                            Nama Konsumen
                        </div>
                        <div class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                            {{ $followUp->calonKonsumen->nama ?? '-' }}
                        </div>
                    </div>

                    {{-- No HP --}}
                    <div>
                        <div class="text-sm text-[#706f6c] dark:text-[#A1A09A]">
                            No HP
                        </div>
                        <div class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                            {{ $followUp->calonKonsumen->no_hp ?? '-' }}
                        </div>
                    </div>

                    {{-- Tanggal --}}
                    <div>
                        <div class="text-sm text-[#706f6c] dark:text-[#A1A09A]">
                            Tanggal Follow Up
                        </div>
                        <div class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                            {{ \Carbon\Carbon::parse($followUp->tgl_followup)->format('d M Y') }}
                        </div>
                    </div>

                    {{-- Respon --}}
                    <div>
                        <div class="text-sm text-[#706f6c] dark:text-[#A1A09A]">
                            Respon Follow Up
                        </div>

                        @php
                            $badge = match($followUp->respon_followup) {
                                1 => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300',
                                2 => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300',
                                3 => 'bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-300',
                                default => 'bg-gray-100 text-gray-700'
                            };

                            $label = match($followUp->respon_followup) {
                                1 => 'Responsif',
                                2 => 'Lambat',
                                3 => 'Tidak Respon',
                                default => '-'
                            };
                        @endphp

                        <span class="inline-flex px-3 py-1 text-xs rounded-full {{ $badge }}">
                            {{ $label }}
                        </span>
                    </div>

                </div>

                {{-- Catatan --}}
                <div>
                    <div class="text-sm text-[#706f6c] dark:text-[#A1A09A]">
                        Catatan Follow Up
                    </div>

                    <div class="mt-2 p-4 rounded-sm border border-[#e3e3e0] dark:border-[#3E3E3A]
                                text-[#1b1b18] dark:text-[#EDEDEC]">
                        {{ $followUp->catatan_followup ?? '-' }}
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="flex justify-end gap-3 pt-4">

                    <a href="{{ route('follow-up.index') }}"
                       class="px-4 py-2 rounded-sm border border-[#19140035]
                              dark:border-[#3E3E3A]
                              text-[#1b1b18] dark:text-[#EDEDEC]">
                        Kembali
                    </a>

                    <a href="{{ route('follow-up.edit', $followUp->id) }}"
                       class="px-4 py-2 rounded-sm bg-[#1b1b18] text-white hover:bg-black">
                        Edit
                    </a>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>
