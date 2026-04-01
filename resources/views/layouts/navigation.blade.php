<nav x-data="{ open: false, logoutOpen: false }" @open-sidebar.window="open = true" class="relative">

    {{-- Desktop Sidebar --}}
    <aside
        class="hidden lg:flex lg:fixed lg:inset-y-0 lg:left-0 lg:w-64 lg:flex-col
                  bg-white dark:bg-[#161615] border-r border-[#e3e3e0] dark:border-[#3E3E3A]">

        {{-- Brand --}}
        <div class="h-16 px-6 flex items-center justify-between border-b border-[#e3e3e0] dark:border-[#3E3E3A]">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2">
                <div
                    class="h-9 w-9 rounded-xl bg-[#fff2f2] dark:bg-[#1D0002] flex items-center justify-center border border-[#19140035] dark:border-[#3E3E3A]">
                    <span class="text-[#F53003] dark:text-[#F61500] font-semibold text-sm">SPK</span>
                </div>
                <span class="font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">SPK-PR</span>
            </a>
        </div>

        {{-- Menu --}}
        <div class="flex-1 px-4 py-4 space-y-1">
            <a href="{{ route('dashboard') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-md text-sm
                      {{ request()->routeIs('dashboard') ? 'bg-black/5 dark:bg-white/10 text-[#1b1b18] dark:text-[#EDEDEC]' : 'text-[#706f6c] dark:text-[#A1A09A] hover:bg-black/5 dark:hover:bg-white/5' }}">
                <span>🏠</span><span>Dashboard</span>
            </a>

            {{-- Dropdown: Calon Konsumen --}}
            <div x-data="{ ccOpen: {{ request()->routeIs('konsumen.*', 'followup.*', 'survei.*', 'prediksi.*') ? 'true' : 'false' }} }" class="space-y-1">
                <button type="button" @click="ccOpen = !ccOpen"
                    class="w-full flex items-center justify-between gap-3 px-3 py-2 rounded-md text-sm
               text-[#706f6c] dark:text-[#A1A09A]
               hover:bg-black/5 dark:hover:bg-white/5 transition">
                    <span class="flex items-center gap-3">
                        <span>👥</span>
                        <span>Calon Konsumen</span>
                    </span>

                    <svg class="h-4 w-4 transition-transform" :class="ccOpen ? 'rotate-180' : ''" viewBox="0 0 20 20"
                        fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.25a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z"
                            clip-rule="evenodd" />
                    </svg>
                </button>

                <div x-show="ccOpen" x-collapse class="pl-3 space-y-1">
                    <a href="{{ route('identitas.index') }}"
                        class="flex items-center gap-2 px-3 py-2 rounded-md text-sm
                  text-[#706f6c] dark:text-[#A1A09A]
                  hover:bg-black/5 dark:hover:bg-white/5 transition">
                        <span>🧾</span><span>Identitas</span>
                    </a>

                    <a href="{{ route('follow-up.index') }}"
                        class="flex items-center gap-2 px-3 py-2 rounded-md text-sm
                  text-[#706f6c] dark:text-[#A1A09A]
                  hover:bg-black/5 dark:hover:bg-white/5 transition">
                        <span>📌</span><span>Follow Up</span>
                    </a>

                    <a href="{{ route('survei.index') }}"
                        class="flex items-center gap-2 px-3 py-2 rounded-md text-sm
                  text-[#706f6c] dark:text-[#A1A09A]
                  hover:bg-black/5 dark:hover:bg-white/5 transition">
                        <span>🗓️</span><span>Survei</span>
                    </a>

                    <a href="{{ route('prediksi.index') }}"
                        class="flex items-center gap-2 px-3 py-2 rounded-md text-sm
                  text-[#706f6c] dark:text-[#A1A09A]
                  hover:bg-black/5 dark:hover:bg-white/5 transition">
                        <span>📊</span><span>Hasil Prediksi</span>
                    </a>
                </div>
            </div>

            {{-- Logout --}}
            <div class="h-16 px-4 border-t border-[#e3e3e0] dark:border-[#3E3E3A] flex items-center">
                <form method="POST" action="{{ route('logout') }}" class="w-full" x-ref="logoutFormDesktop">
                    @csrf
                    <button
                        type="button"
                        @click="logoutOpen = true"
                        class="w-full flex items-center justify-center gap-2 px-3 py-2 rounded-md text-sm
                   text-[#706f6c] dark:text-[#A1A09A]
                   border border-[#19140035] dark:border-[#3E3E3A]
                   hover:bg-black/5 dark:hover:bg-white/5
                   transition">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- Mobile Drawer Sidebar --}}
    <div x-show="open" x-cloak class="lg:hidden">
        <div class="fixed inset-0 bg-black/40" @click="open = false"></div>

        <div
            class="fixed inset-y-0 left-0 w-72 max-w-[85vw] bg-white dark:bg-[#161615]
                    border-r border-[#e3e3e0] dark:border-[#3E3E3A] shadow-xl p-4">
            <div class="flex items-center justify-between">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2">
                    <div
                        class="h-9 w-9 rounded-xl bg-[#fff2f2] dark:bg-[#1D0002] flex items-center justify-center border border-[#19140035] dark:border-[#3E3E3A]">
                        <span class="text-[#F53003] dark:text-[#F61500] font-semibold text-sm">SPK</span>
                    </div>
                    <span class="font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">SPK-PR</span>
                </a>

                <button @click="open = false"
                    class="p-2 rounded-md text-[#706f6c] dark:text-[#A1A09A] hover:bg-black/5 dark:hover:bg-white/5 transition"
                    aria-label="Close menu">✕</button>
            </div>

            <div class="mt-4 space-y-1">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-md text-sm text-[#706f6c] dark:text-[#A1A09A]
                          hover:bg-black/5 dark:hover:bg-white/5 transition">
                    🏠 <span>Home</span>
                </a>

                {{-- Dropdown: Calon Konsumen (Mobile) --}}
                <div x-data="{ ccOpen: false }" class="space-y-1">
                    <button type="button" @click="ccOpen = !ccOpen"
                        class="w-full flex items-center justify-between gap-3 px-3 py-2 rounded-md text-sm
               text-[#706f6c] dark:text-[#A1A09A]
               hover:bg-black/5 dark:hover:bg-white/5 transition">
                        <span class="flex items-center gap-3">
                            <span>👥</span>
                            <span>Calon Konsumen</span>
                        </span>

                        <span class="text-xs" x-text="ccOpen ? '−' : '+'"></span>
                    </button>

                    <div x-show="ccOpen" x-collapse class="pl-3 space-y-1">
                        <a href="{{ route('identitas.index') }}"
                            class="flex items-center gap-2 px-3 py-2 rounded-md text-sm
                  text-[#706f6c] dark:text-[#A1A09A]
                  hover:bg-black/5 dark:hover:bg-white/5 transition">
                            <span>🧾</span><span>Identitas</span>
                        </a>

                        <a href="{{ route('follow-up.index') }}"
                            class="flex items-center gap-2 px-3 py-2 rounded-md text-sm
                  text-[#706f6c] dark:text-[#A1A09A]
                  hover:bg-black/5 dark:hover:bg-white/5 transition">
                            <span>📌</span><span>Follow Up</span>
                        </a>

                        <a href="{{ route('survei.index') }}"
                            class="flex items-center gap-2 px-3 py-2 rounded-md text-sm
                  text-[#706f6c] dark:text-[#A1A09A]
                  hover:bg-black/5 dark:hover:bg-white/5 transition">
                            <span>🗓️</span><span>Survei</span>
                        </a>

                        <a href="{{ route('prediksi.index') }}"
                            class="flex items-center gap-2 px-3 py-2 rounded-md text-sm
                  text-[#706f6c] dark:text-[#A1A09A]
                  hover:bg-black/5 dark:hover:bg-white/5 transition">
                            <span>📊</span><span>Hasil Prediksi</span>
                        </a>
                    </div>
                </div>

                <a href="{{ route('profile.edit') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-md text-sm text-[#706f6c] dark:text-[#A1A09A]
                          hover:bg-black/5 dark:hover:bg-white/5 transition">
                    👤 <span>Profile</span>
                </a>

                <div class="pt-3 mt-3 border-t border-[#e3e3e0] dark:border-[#3E3E3A]">
                    <form method="POST" action="{{ route('logout') }}" x-ref="logoutFormMobile">
                        @csrf
                        <button
                            type="button"
                            @click="logoutOpen = true"
                            class="w-full flex items-center gap-3 px-3 py-2 rounded-md text-sm
                   text-[#706f6c] dark:text-[#A1A09A]
                   hover:bg-black/5 dark:hover:bg-white/5
                   transition">
                            <span>🚪</span>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    {{-- Logout Confirmation Modal (Desktop + Mobile) --}}
    <div
        x-show="logoutOpen"
        x-cloak
        @keydown.escape.window="logoutOpen = false"
        class="fixed inset-0 z-[9999] flex items-center justify-center"
        aria-labelledby="logout-modal-title"
        role="dialog"
        aria-modal="true"
    >
        <div class="absolute inset-0 bg-black/50" @click="logoutOpen = false"></div>

        <div
            x-transition
            class="relative w-[92%] max-w-md rounded-xl bg-white dark:bg-[#161615]
                   border border-[#e3e3e0] dark:border-[#3E3E3A] shadow-xl p-5"
        >
            <div class="flex items-start justify-between gap-3">
                <div>
                    <h2 id="logout-modal-title" class="text-base font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                        Konfirmasi Logout
                    </h2>
                    <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">
                        Kamu yakin mau keluar dari aplikasi?
                    </p>
                </div>

                <button
                    type="button"
                    @click="logoutOpen = false"
                    class="p-2 rounded-md text-[#706f6c] dark:text-[#A1A09A] hover:bg-black/5 dark:hover:bg-white/5 transition"
                    aria-label="Close"
                >✕</button>
            </div>

            <div class="mt-5 flex items-center justify-end gap-2">
                <button
                    type="button"
                    @click="logoutOpen = false"
                    class="px-4 py-2 rounded-md text-sm
                           text-[#706f6c] dark:text-[#A1A09A]
                           border border-[#19140035] dark:border-[#3E3E3A]
                           hover:bg-black/5 dark:hover:bg-white/5 transition"
                >
                    Batal
                </button>

                <button
                    type="button"
                    @click="
                        logoutOpen = false;
                        // submit form yang tersedia (desktop atau mobile)
                        if ($refs.logoutFormDesktop) { $refs.logoutFormDesktop.submit(); }
                        else if ($refs.logoutFormMobile) { $refs.logoutFormMobile.submit(); }
                    "
                    class="px-4 py-2 rounded-md text-sm
                           bg-[#F53003] text-white hover:opacity-90 transition"
                >
                    Ya, Logout
                </button>
            </div>
        </div>
    </div>

</nav>
