<x-app-layout>
    <x-slot name="title">
        Dashboard
    </x-slot>

    <x-slot name="header">
        <div class="flex items-center gap-3 min-w-0">
            <x-heroicon-o-home class="w-6 h-6 text-[#1b1b18] dark:text-[#EDEDEC] shrink-0" />

            <h2 class="font-semibold text-lg sm:text-xl text-[#1b1b18] dark:text-[#EDEDEC] leading-tight truncate">
                {{ __('Dashboard') }}
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
        {{-- Breadcrumb (Responsive) --}}
        <nav class="flex flex-wrap items-center gap-x-2 gap-y-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">
            <a href="{{ route('dashboard') }}" class="hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] transition">
                Beranda
            </a>

            <span class="opacity-50">/</span>

            <span class="text-[#1b1b18] dark:text-[#EDEDEC] font-medium">
                Dashboard
            </span>
        </nav>

        {{-- Welcome Card --}}
        <div
            class="bg-white dark:bg-[#161615] border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg
           shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] overflow-hidden">

            <div class="p-5 sm:p-8">

                {{-- Header --}}
                <div class="flex items-start gap-4">
                    <div
                        class="h-10 w-10 rounded-xl bg-[#fff2f2] dark:bg-[#1D0002] flex items-center justify-center
                       border border-[#19140035] dark:border-[#3E3E3A] shrink-0">
                        <span class="text-[#F53003] dark:text-[#F61500] font-semibold">SPK</span>
                    </div>

                    <div class="min-w-0">
                        <h3 class="text-base sm:text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                            @auth
                                Hallo, {{ auth()->user()->name }} 👋
                            @else
                                Hallo 👋
                            @endauth
                        </h3>

                        <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">
                            Selamat datang di <strong>SPK-PR</strong>. Dari sini Anda bisa mengelola data calon
                            konsumen, mencatat follow up/survei, serta melihat hasil prediksi sistem.
                        </p>
                    </div>
                </div>

                {{-- Section Data Training + Button --}}
                <div class="mt-6 flex flex-col lg:flex-row gap-6">

                    {{-- LEFT: Button --}}
                    <div class="flex flex-col gap-3">

                        <div>
                            <a href="{{ asset('template/template_training.xlsx') }}"
                                class="w-full inline-flex items-center justify-center px-5 py-3 rounded-md
        bg-[#1b1b18] hover:bg-black text-white border border-black transition text-sm font-medium"
                                download>
                                Download Template
                            </a>
                        </div>

                        @if (session('success'))
                            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                                class="mb-4 p-4 rounded-md bg-green-50 border border-green-200 text-green-700 text-sm">
                                ✅ {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                                class="mb-4 p-4 rounded-md bg-red-50 border border-red-200 text-red-700 text-sm">
                                ❌ {{ session('error') }}
                            </div>
                        @endif

                        <div x-data="{ openImport: false }">
                            <!-- Button trigger -->
                            <button @click="openImport = true"
                                class="w-full inline-flex items-center justify-center px-5 py-3 rounded-md
        bg-[#1b1b18] hover:bg-black text-white border border-black transition text-sm font-medium">
                                Import Data Training
                            </button>

                            <!-- Modal -->
                            <div x-show="openImport" x-cloak
                                class="fixed inset-0 z-50 flex items-center justify-center">

                                <!-- Backdrop -->
                                <div class="absolute inset-0 bg-black/50" @click="openImport=false"></div>

                                <!-- Card -->
                                <div x-transition
                                    class="relative w-full max-w-md mx-4 bg-white rounded-xl shadow-lg border border-gray-200">

                                    <div class="flex items-center justify-between px-5 py-4 border-b">
                                        <h3 class="text-base font-semibold text-gray-800">Import Data Training</h3>
                                        <button @click="openImport=false"
                                            class="text-gray-500 hover:text-black text-2xl leading-none">&times;</button>
                                    </div>

                                    <form action="{{ route('training.import') }}" method="POST"
                                        enctype="multipart/form-data" class="p-5">
                                        @csrf

                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Pilih File Excel (.xlsx / .xls)
                                        </label>

                                        <input type="file" name="file" required accept=".xlsx,.xls"
                                            class="block w-full text-sm text-gray-600
                    file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0
                    file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700
                    hover:file:bg-gray-200 border rounded-md p-2" />

                                        <p class="mt-2 text-xs text-gray-500">
                                            Pastikan kolom sesuai template (id, nama, no_hp, dst).
                                        </p>

                                        <div class="mt-5 flex gap-2">
                                            <button type="button" @click="openImport=false"
                                                class="w-1/2 inline-flex items-center justify-center px-4 py-2 rounded-md
                        bg-white hover:bg-gray-50 text-gray-700 border border-gray-300 transition text-sm font-medium">
                                                Batal
                                            </button>

                                            <button type="submit"
                                                class="w-1/2 inline-flex items-center justify-center px-4 py-2 rounded-md
                        bg-[#1b1b18] hover:bg-black text-white border border-black transition text-sm font-medium">
                                                Upload & Import
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- RIGHT: Penjelasan --}}
                    <div
                        class="lg:w-4/5 p-4 rounded-md bg-[#f9f9f7] dark:bg-[#1e1e1c]
                       border border-[#e3e3e0] dark:border-[#3E3E3A]">

                        <h4 class="text-sm font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                            Apa itu Data Training?
                        </h4>

                        <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">
                            <strong>Data Training</strong> adalah kumpulan data historis yang digunakan untuk
                            melatih sistem dalam melakukan analisis dan menghasilkan prediksi.
                            Data ini berisi karakteristik calon konsumen beserta hasil akhirnya
                            (misalnya <strong>Membeli</strong> atau <strong>Tidak Membeli</strong>).
                        </p>

                        <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">
                            Semakin lengkap dan akurat data training yang dimasukkan,
                            semakin baik pula kualitas hasil prediksi yang diberikan oleh sistem SPK-PR.
                        </p>
                    </div>

                </div>

            </div>
        </div>

        {{-- Quick Stats (sudah responsive) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4">

            <!-- Data Training -->
            <div class="bg-white dark:bg-[#161615] border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg p-5">
                <div class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Data Training</div>
                <div class="mt-2 text-2xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                    {{ $totalTraining ?? 0 }}
                </div>
                <div class="mt-1 text-xs text-[#706f6c] dark:text-[#A1A09A]">
                    Total data training tersimpan
                </div>
            </div>

            <!-- Data Calon Konsumen -->
            <div class="bg-white dark:bg-[#161615] border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg p-5">
                <div class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Data Calon Konsumen</div>
                <div class="mt-2 text-2xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                    {{ $totalCalon ?? 0 }}
                </div>
                <div class="mt-1 text-xs text-[#706f6c] dark:text-[#A1A09A]">
                    Total calon konsumen masuk
                </div>
            </div>

            <!-- Data Follow Up -->
            <div class="bg-white dark:bg-[#161615] border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg p-5">
                <div class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Data Follow Up</div>
                <div class="mt-2 text-2xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                    {{ $totalFollowup ?? 0 }}
                </div>
                <div class="mt-1 text-xs text-[#706f6c] dark:text-[#A1A09A]">
                    Total aktivitas follow up
                </div>
            </div>

            <!-- Data Survei -->
            <div class="bg-white dark:bg-[#161615] border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg p-5">
                <div class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Data Survei</div>
                <div class="mt-2 text-2xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                    {{ $totalSurvei ?? 0 }}
                </div>
                <div class="mt-1 text-xs text-[#706f6c] dark:text-[#A1A09A]">
                    Total survei terisi
                </div>
            </div>

            <!-- Prediksi Membeli -->
            <div class="bg-white dark:bg-[#161615] border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg p-5">
                <div class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Prediksi Membeli</div>
                <div class="mt-2 text-2xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                    {{ $prediksiMembeli ?? 0 }}
                </div>
                <div class="mt-1 text-xs text-[#706f6c] dark:text-[#A1A09A]">
                    Total hasil: Membeli
                </div>
            </div>

            <!-- Prediksi Tidak Membeli -->
            <div class="bg-white dark:bg-[#161615] border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg p-5">
                <div class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Prediksi Tidak Membeli</div>
                <div class="mt-2 text-2xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                    {{ $prediksiTidakMembeli ?? 0 }}
                </div>
                <div class="mt-1 text-xs text-[#706f6c] dark:text-[#A1A09A]">
                    Total hasil: Tidak Membeli
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
