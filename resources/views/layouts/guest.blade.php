<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SPK-PR') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600&display=swap" rel="stylesheet" />

    {{-- Theme init paling awal --}}
    <script>
        (function () {
            const theme = localStorage.getItem('theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

            if (theme === 'dark' || (!theme && prefersDark)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC] font-sans antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 px-6">
        <div class="w-full max-w-md">
            <div class="flex items-center justify-between">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-3">
                    <div class="h-10 w-10 rounded-xl bg-[#fff2f2] dark:bg-[#1D0002] flex items-center justify-center border border-[#19140035] dark:border-[#3E3E3A]">
                        <span class="text-[#F53003] dark:text-[#F61500] font-semibold">SPK</span>
                    </div>
                    <div class="font-semibold leading-tight">SPK-PR</div>
                </a>

                {{-- Toggle dark mode (Alpine) --}}
                <div x-data="{ theme: document.documentElement.classList.contains('dark') ? 'dark' : 'light' }">
                    <button type="button" aria-label="Toggle dark mode"
                        class="inline-flex items-center justify-center px-3 py-1.5 border border-[#19140035] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm"
                        @click="
                            if (theme === 'dark') {
                                document.documentElement.classList.remove('dark');
                                localStorage.setItem('theme','light');
                                theme = 'light';
                            } else {
                                document.documentElement.classList.add('dark');
                                localStorage.setItem('theme','dark');
                                theme = 'dark';
                            }
                        "
                    >
                        <span x-show="theme === 'dark'">☀</span>
                        <span x-show="theme === 'light'">🌙</span>
                    </button>
                </div>
            </div>

            <div class="mt-6 w-full bg-white dark:bg-[#161615] border border-[#e3e3e0] dark:border-[#3E3E3A] shadow-sm overflow-hidden sm:rounded-lg p-6">
                {{ $slot }}
            </div>

            <p class="mt-6 text-center text-xs text-[#706f6c] dark:text-[#A1A09A]">
                © {{ date('Y') }} SPK-PR
            </p>
        </div>
    </div>
</body>
</html>
