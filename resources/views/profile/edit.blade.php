<x-app-layout>

    <x-slot name="title">
        Profil Pengguna
    </x-slot>

    <x-slot name="header">
        <div class="flex items-center gap-3 min-w-0">

            {{-- Icon User --}}
            <x-heroicon-o-user class="w-6 h-6 text-[#1b1b18] dark:text-[#EDEDEC]" />

            <h2 class="font-semibold text-xl text-[#1b1b18] dark:text-[#EDEDEC] leading-tight truncate">
                {{ __('Profil') }}
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
        <nav class="text-sm text-[#706f6c] dark:text-[#A1A09A]">
            <a href="{{ route('dashboard') }}"
               class="hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] transition">
                Beranda
            </a>

            <span class="opacity-50 mx-2">/</span>

            <span class="text-[#1b1b18] dark:text-[#EDEDEC] font-medium">
                Profil
            </span>
        </nav>

        {{-- Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

            {{-- Update Profil --}}
            <div class="bg-white dark:bg-[#161615]
                        border border-[#e3e3e0] dark:border-[#3E3E3A]
                        shadow-sm rounded-lg p-6">
                <div class="max-w-full">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Ubah Password --}}
            <div class="bg-white dark:bg-[#161615]
                        border border-[#e3e3e0] dark:border-[#3E3E3A]
                        shadow-sm rounded-lg p-6">
                <div class="max-w-full">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Hapus Akun --}}
            <div class="bg-white dark:bg-[#161615]
                        border border-[#e3e3e0] dark:border-[#3E3E3A]
                        shadow-sm rounded-lg p-6">
                <div class="max-w-full">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
