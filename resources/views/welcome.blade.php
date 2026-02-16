{{-- resources/views/welcome.blade.php --}}
<x-guest-layout>
    <div class="w-full max-w-6xl mx-auto">
        <header class="py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-xl bg-[#fff2f2] dark:bg-[#1D0002] flex items-center justify-center border border-[#19140035] dark:border-[#3E3E3A]">
                        <span class="text-[#F53003] dark:text-[#F61500] font-semibold">SPK</span>
                    </div>

                    <div>
                        <div class="font-semibold leading-tight block md:hidden">SPK-PR</div>

                        <div class="hidden md:block">
                            <div class="font-semibold leading-tight">SPK-PR</div>
                            <div class="text-sm text-[#706f6c] dark:text-[#A1A09A] -mt-0.5">
                                Sistem Pendukung Keputusan Prediksi Pembelian Rumah
                            </div>
                        </div>
                    </div>
                </div>

                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}"
                           class="inline-flex items-center gap-2 px-4 py-2 rounded-sm border border-[#19140035] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:hover:border-[#62605b] text-sm">
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
        </header>

        <main class="pb-12">
            <section class="grid lg:grid-cols-2 gap-6 items-stretch">
                <div class="p-6 lg:p-10 bg-white dark:bg-[#161615] rounded-lg border border-[#e3e3e0] dark:border-[#3E3E3A] shadow-sm">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-sm border border-[#19140035] dark:border-[#3E3E3A] bg-[#FDFDFC] dark:bg-[#0a0a0a]">
                        <span class="text-[#F53003] dark:text-[#FF4433]">●</span>
                        <span class="text-[#706f6c] dark:text-[#A1A09A]">Aplikasi untuk Staf Pemasaran</span>
                    </div>

                    <h1 class="mt-4 text-3xl font-semibold leading-tight">
                        Prediksi keputusan pembelian rumah secara lebih objektif.
                    </h1>

                    <p class="mt-3 text-[#706f6c] dark:text-[#A1A09A] leading-relaxed">
                        Sistem membantu mengelola data calon konsumen, mencatat aktivitas follow up/survei,
                        dan menampilkan ringkasan hasil prediksi keputusan pembelian.
                    </p>

                    <div class="mt-7">
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
                    </div>
                </div>

                <div class="relative overflow-hidden rounded-lg border border-[#e3e3e0] dark:border-[#3E3E3A] bg-[#fff2f2] dark:bg-[#1D0002]">
                    <div class="p-6 lg:p-10">
                        <h2 class="text-xl font-semibold">Alur Penggunaan</h2>

                        <ol class="mt-4 space-y-3 text-sm">
                            <li class="flex gap-3">
                                <span class="mt-0.5 h-6 w-6 rounded-full bg-white/70 dark:bg-white/10 flex items-center justify-center border border-[#19140035] dark:border-[#3E3E3A]">1</span>
                                <div>
                                    <div class="font-medium">Input identitas calon konsumen</div>
                                    <div class="text-[#706f6c] dark:text-[#A1A09A]">Mencatat data calon pembeli.</div>
                                </div>
                            </li>

                            <li class="flex gap-3">
                                <span class="mt-0.5 h-6 w-6 rounded-full bg-white/70 dark:bg-white/10 flex items-center justify-center border border-[#19140035] dark:border-[#3E3E3A]">2</span>
                                <div>
                                    <div class="font-medium">Catat follow up / survei</div>
                                    <div class="text-[#706f6c] dark:text-[#A1A09A]">Mendokumentasikan tindak lanjut.</div>
                                </div>
                            </li>

                            <li class="flex gap-3">
                                <span class="mt-0.5 h-6 w-6 rounded-full bg-white/70 dark:bg-white/10 flex items-center justify-center border border-[#19140035] dark:border-[#3E3E3A]">3</span>
                                <div>
                                    <div class="font-medium">Lihat hasil prediksi</div>
                                    <div class="text-[#706f6c] dark:text-[#A1A09A]">Sistem menampilkan hasil keputusan.</div>
                                </div>
                            </li>
                        </ol>

                        <div class="mt-8 rounded-md bg-white/70 dark:bg-white/10 p-4 border border-[#19140035] dark:border-[#3E3E3A]">
                            <div class="font-medium">Output</div>
                            <div class="text-sm text-[#706f6c] dark:text-[#A1A09A] mt-1">
                                Ringkasan hasil prediksi keputusan pembelian rumah.
                            </div>
                        </div>
                    </div>

                    <div class="absolute inset-0 pointer-events-none shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d]"></div>
                </div>
            </section>
        </main>

        <footer class="pb-10 text-sm text-[#706f6c] dark:text-[#A1A09A] text-center">
            © {{ date('Y') }} SPK-PR — Sistem Pendukung Keputusan Prediksi Pembelian Rumah.
        </footer>
    </div>
</x-guest-layout>
