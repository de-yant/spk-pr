<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        {{ isset($title) ? $title . ' - ' . config('app.name', 'SPK-PR') : config('app.name', 'SPK-PR') }}
    </title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600&display=swap" rel="stylesheet" />

    {{-- Theme init harus SEBELUM CSS (@vite) agar tidak flicker & konsisten --}}
    <script>
        (function() {
            function setTheme(mode) {
                const root = document.documentElement;
                root.classList.toggle('dark', mode === 'dark');
                localStorage.setItem('theme', mode);
            }

            const saved = localStorage.getItem('theme'); // 'dark' | 'light' | null
            const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;

            setTheme(saved ?? (prefersDark ? 'dark' : 'light'));

            // expose helper for button
            window.__setTheme = setTheme;
            window.__toggleTheme = function() {
                const isDark = document.documentElement.classList.contains('dark');
                setTheme(isDark ? 'light' : 'dark');
            };
        })();
    </script>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="min-h-screen bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC] antialiased">
    {{-- Header --}}
    <header class="mx-auto w-full max-w-6xl px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex items-center justify-between gap-4">
            {{-- Brand --}}
            <div class="flex items-center gap-3 min-w-0">
                <div
                    class="h-10 w-10 shrink-0 rounded-xl bg-[#fff2f2] dark:bg-[#1D0002] flex items-center justify-center border border-[#19140035] dark:border-[#3E3E3A]">
                    <span class="text-[#F53003] dark:text-[#F61500] font-semibold">SPK</span>
                </div>

                <div class="min-w-0">
                    <div class="font-semibold leading-tight truncate">SPK-PR</div>
                    <div class="hidden sm:block text-sm text-[#706f6c] dark:text-[#A1A09A] -mt-0.5">
                        Sistem Pendukung Keputusan Prediksi Pembelian Rumah
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-2 sm:gap-3">
                {{-- Toggle theme --}}
                <button type="button" aria-label="Toggle dark mode"
                    class="inline-flex items-center justify-center px-3 py-2 rounded-sm text-sm border-[#19140035] hover:border-[#1915014a]
                           dark:border-[#3E3E3A] dark:hover:border-[#62605b]"
                    onclick="window.__toggleTheme()">
                    <span class="hidden dark:inline">☀</span>
                    <span class="inline dark:hidden">🌙</span>
                </button>

                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-sm text-sm border border-[#19140035] hover:border-[#1915014a]
                                  dark:border-[#3E3E3A] dark:hover:border-[#62605b]">
                            Dashboard →
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-sm bg-[#1b1b18] hover:bg-black text-white text-sm border border-black">
                            Masuk
                        </a>
                    @endauth
                @endif
            </div>
        </div>
    </header>

    {{-- Main --}}
    <main class="mx-auto w-full max-w-6xl px-4 sm:px-6 lg:px-8 pb-12">
        <section class="grid lg:grid-cols-2 gap-6 items-stretch">
            {{-- Kiri --}}
            <div
                class="p-6 lg:p-10 bg-white dark:bg-[#161615] rounded-lg border border-[#e3e3e0] dark:border-[#3E3E3A]
                        shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)]">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-sm border border-[#19140035] dark:border-[#3E3E3A] bg-[#FDFDFC] dark:bg-[#0a0a0a]">
                    <span class="text-[#F53003] dark:text-[#FF4433]">●</span>
                    <span class="text-[#706f6c] dark:text-[#A1A09A]">Aplikasi untuk Staf Pemasaran</span>
                </div>

                <h1 class="mt-4 text-3xl sm:text-4xl font-semibold leading-tight">
                    Prediksi keputusan pembelian rumah secara lebih objektif.
                </h1>

                <p class="mt-3 text-[#706f6c] dark:text-[#A1A09A] leading-relaxed">
                    Sistem membantu mengelola data calon konsumen, aktivitas follow up/survei,
                    dan menghasilkan ringkasan hasil prediksi keputusan pembelian.
                </p>

                <div class="mt-7 flex flex-wrap gap-3">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="inline-flex items-center justify-center px-5 py-2 rounded-sm bg-[#1b1b18] hover:bg-black text-white border border-black">
                                Buka Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="inline-flex items-center justify-center px-5 py-2 rounded-sm bg-[#1b1b18] hover:bg-black text-white border border-black">
                                Masuk
                            </a>
                        @endauth
                    @endif

                    <a href="#alur"
                        class="inline-flex items-center justify-center px-5 py-2 rounded-sm border border-[#19140035] hover:border-[#1915014a]
                              dark:border-[#3E3E3A] dark:hover:border-[#62605b]">
                        Lihat Alur
                    </a>
                </div>
            </div>

            {{-- Kanan --}}
            <div id="alur"
                class="relative overflow-hidden rounded-lg border border-[#e3e3e0] dark:border-[#3E3E3A] bg-[#fff2f2] dark:bg-[#1D0002]">
                <div class="p-6 lg:p-10">
                    <h2 class="text-xl font-semibold">Alur Penggunaan</h2>

                    <ol class="mt-4 space-y-3 text-sm">
                        <li class="flex gap-3">
                            <span
                                class="mt-0.5 h-6 w-6 shrink-0 rounded-full bg-white/70 dark:bg-white/10 flex items-center justify-center border border-[#19140035] dark:border-[#3E3E3A]">1</span>
                            <div>
                                <div class="font-medium">Input identitas calon konsumen</div>
                                <div class="text-[#706f6c] dark:text-[#A1A09A]">Mencatat data calon pembeli.</div>
                            </div>
                        </li>

                        <li class="flex gap-3">
                            <span
                                class="mt-0.5 h-6 w-6 shrink-0 rounded-full bg-white/70 dark:bg-white/10 flex items-center justify-center border border-[#19140035] dark:border-[#3E3E3A]">2</span>
                            <div>
                                <div class="font-medium">Catat follow up / survei</div>
                                <div class="text-[#706f6c] dark:text-[#A1A09A]">Mendokumentasikan tindak lanjut.</div>
                            </div>
                        </li>

                        <li class="flex gap-3">
                            <span
                                class="mt-0.5 h-6 w-6 shrink-0 rounded-full bg-white/70 dark:bg-white/10 flex items-center justify-center border border-[#19140035] dark:border-[#3E3E3A]">3</span>
                            <div>
                                <div class="font-medium">Lihat hasil prediksi</div>
                                <div class="text-[#706f6c] dark:text-[#A1A09A]">Sistem menampilkan hasil keputusan.
                                </div>
                            </div>
                        </li>
                    </ol>

                    <div
                        class="mt-8 rounded-md bg-white/70 dark:bg-white/10 p-4 border border-[#19140035] dark:border-[#3E3E3A]">
                        <div class="font-medium">Output</div>
                        <div class="text-sm text-[#706f6c] dark:text-[#A1A09A] mt-1">
                            Ringkasan hasil prediksi keputusan pembelian rumah.
                        </div>
                    </div>
                </div>

                <div
                    class="absolute inset-0 pointer-events-none shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d]">
                </div>
            </div>
        </section>
    </main>

    {{-- Footer --}}
    <footer class="mx-auto w-full max-w-6xl px-4 sm:px-6 lg:px-8 pb-10 text-sm text-[#706f6c] dark:text-[#A1A09A]">
        © {{ date('Y') }} SPK-PR — Sistem Pendukung Keputusan Prediksi Pembelian Rumah.
    </footer>
</body>

</html>
