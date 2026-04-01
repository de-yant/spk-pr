<header class="bg-white dark:bg-[#161615] border-b border-[#e3e3e0] dark:border-[#3E3E3A]">
    {{-- Topbar --}}
    <div class="max-w-7xl mx-auto h-16 px-4 sm:px-6 lg:px-8 flex items-center justify-between gap-4">
        {{-- Left --}}
        <div class="flex items-center gap-3 min-w-0">
            {{-- Mobile hamburger --}}
            <button type="button" aria-label="Open menu"
                class="lg:hidden inline-flex items-center justify-center p-2 rounded-md border border-[#19140035] dark:border-[#3E3E3A]
                       text-[#706f6c] dark:text-[#A1A09A] hover:bg-black/5 dark:hover:bg-white/5 transition"
                onclick="window.dispatchEvent(new Event('open-sidebar'))">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            {{-- Header slot --}}
            <div class="min-w-0">
                @isset($header)
                    {{ $header }}
                @else
                    <h2 class="font-semibold text-lg text-[#1b1b18] dark:text-[#EDEDEC] truncate">SPK-PR</h2>
                @endisset
            </div>
        </div>

        {{-- Right --}}
        <div class="flex items-center gap-2 sm:gap-3">


            {{-- Theme toggle --}}
            <button type="button" aria-label="Toggle dark mode"
                class="p-2 rounded-md
           text-[#706f6c] dark:text-[#A1A09A]
           hover:bg-black/5 dark:hover:bg-white/5
           transition"
                onclick="
        const root = document.documentElement;
        const next = root.classList.contains('dark') ? 'light' : 'dark';
        root.classList.toggle('dark', next === 'dark');
        localStorage.setItem('theme', next);
    ">
                <span class="hidden dark:inline">☀</span>
                <span class="inline dark:hidden">🌙</span>
            </button>

            {{-- Actions (desktop only) --}}
            @isset($actions)
                <div class="hidden sm:flex items-center gap-2">
                    {{ $actions }}
                </div>
            @endisset

            {{-- User dropdown --}}
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button
                        class="inline-flex items-center gap-2 px-3 py-2 rounded-md border border-[#19140035] dark:border-[#3E3E3A]
                               text-sm text-[#706f6c] dark:text-[#A1A09A]
                               hover:bg-black/5 dark:hover:bg-white/5 transition">
                        <span class="hidden sm:inline truncate max-w-[160px]">{{ Auth::user()->name }}</span>
                        <span class="sm:hidden">👤</span>

                        <svg class="h-4 w-4 text-[#706f6c] dark:text-[#A1A09A]" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.25a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-dropdown-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>
    </div>
</header>
