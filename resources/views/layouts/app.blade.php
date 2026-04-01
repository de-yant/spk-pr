<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ isset($title) ? $title . ' - ' . config('app.name', 'SPK-PR') : config('app.name', 'SPK-PR') }}
    </title>

    {{-- Theme init sebelum CSS --}}
    <script>
        (function() {
            const theme = localStorage.getItem('theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (theme === 'dark' || (!theme && prefersDark)) document.documentElement.classList.add('dark');
            else document.documentElement.classList.remove('dark');
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>[x-cloak]{ display:none !important; }</style>
</head>

<body class="min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 antialiased">
    <div class="min-h-screen flex">
        {{-- Sidebar (desktop) + drawer (mobile) --}}
        @include('layouts.navigation')

        {{-- Main column --}}
        <div class="flex-1 lg:pl-64 min-h-screen flex flex-col">
            {{-- Topbar --}}
            @include('layouts.topbar')

            {{-- Content --}}
            <main class="flex-1">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                    {{ $slot }}
                </div>
            </main>

            {{-- Footer --}}
            <footer class="bg-white dark:bg-[#161615] border-t border-[#e3e3e0] dark:border-[#3E3E3A]">
                <div
                    class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-center text-sm text-[#706f6c] dark:text-[#A1A09A]">

                    {{-- Mobile --}}
                    <span class="sm:hidden">
                        © {{ date('Y') }} SPK-PR
                    </span>

                    {{-- Desktop --}}
                    <span class="hidden sm:inline">
                        © {{ date('Y') }} SPK-PR — Sistem Pendukung Keputusan Prediksi Pembelian Rumah
                    </span>

                </div>
            </footer>

        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            function formatRupiah(angka) {
                let numberString = angka.replace(/[^0-9]/g, '');
                let sisa = numberString.length % 3;
                let rupiah = numberString.substr(0, sisa);
                let ribuan = numberString.substr(sisa).match(/\d{3}/g);

                if (ribuan) {
                    let separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                return rupiah ? 'Rp. ' + rupiah : '';
            }

            document.querySelectorAll(".rupiah-wrapper").forEach(function(wrapper) {

                const display = wrapper.querySelector(".rupiah-display");
                const hidden = wrapper.querySelector(".rupiah-hidden");

                display.addEventListener("input", function() {
                    let rawValue = this.value.replace(/[^0-9]/g, '');
                    hidden.value = rawValue;
                    this.value = formatRupiah(rawValue);
                });

            });

        });
    </script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>

</html>
