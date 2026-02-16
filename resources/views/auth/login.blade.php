<x-guest-layout>
    <div class="w-full max-w-md mx-auto relative">

        <!-- Top Action (Home + Dark Mode) -->
        <div class="flex items-center justify-between mb-6">
            <!-- Kembali ke Home -->
            <a href="{{ url('/') }}"
               class="text-sm text-[#706f6c] dark:text-[#A1A09A] hover:text-[#F53003] dark:hover:text-[#FF4433] underline underline-offset-4">
                ← Kembali ke Home
            </a>

            <!-- Toggle Dark Mode -->
            <button type="button"
                class="inline-flex items-center justify-center px-3 py-1.5 border border-[#19140035] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm"
                onclick="
                    const isDark = document.documentElement.classList.contains('dark');
                    if (isDark) {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('theme','light');
                    } else {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('theme','dark');
                    }
                ">
                <span class="hidden dark:inline">☀</span>
                <span class="inline dark:hidden">🌙</span>
            </button>
        </div>

        <!-- Header -->
        <div class="mb-6 text-center">
            <div class="mx-auto h-12 w-12 rounded-2xl bg-[#fff2f2] dark:bg-[#1D0002] flex items-center justify-center border border-[#19140035] dark:border-[#3E3E3A]">
                <span class="text-[#F53003] dark:text-[#F61500] font-semibold">SPK</span>
            </div>

            <h1 class="mt-4 text-2xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                Masuk SPK-PR
            </h1>
            <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">
                Sistem Pendukung Keputusan Prediksi Pembelian Rumah
            </p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Card -->
        <div class="bg-white dark:bg-[#161615] border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg shadow-sm p-6">
            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input
                        id="email"
                        class="block mt-1 w-full rounded-md border-[#e3e3e0] dark:border-[#3E3E3A] dark:bg-[#0a0a0a] dark:text-[#EDEDEC] focus:border-[#F53003] focus:ring-[#F53003]"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder="nama@email.com"
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input
                        id="password"
                        class="block mt-1 w-full rounded-md border-[#e3e3e0] dark:border-[#3E3E3A] dark:bg-[#0a0a0a] dark:text-[#EDEDEC] focus:border-[#F53003] focus:ring-[#F53003]"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        placeholder="••••••••"
                    />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember + Forgot -->
                <div class="flex items-center justify-between">
                    <label for="remember_me" class="inline-flex items-center">
                        <input
                            id="remember_me"
                            type="checkbox"
                            name="remember"
                            class="rounded border-[#e3e3e0] dark:border-[#3E3E3A] text-[#F53003] focus:ring-[#F53003] dark:bg-[#0a0a0a]"
                        >
                        <span class="ms-2 text-sm text-[#706f6c] dark:text-[#A1A09A]">
                            Remember me
                        </span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="text-sm text-[#F53003] dark:text-[#FF4433] hover:underline underline-offset-4">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <!-- Button -->
                <x-primary-button
                    class="w-full justify-center bg-[#1b1b18] hover:bg-black text-white border border-black">
                    Log in
                </x-primary-button>
            </form>
        </div>

        <!-- Footer -->
        <p class="mt-6 text-center text-xs text-[#706f6c] dark:text-[#A1A09A]">
            © {{ date('Y') }} SPK-PR
        </p>
    </div>
</x-guest-layout>
