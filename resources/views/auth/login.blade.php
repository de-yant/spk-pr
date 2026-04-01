<x-guest-layout>

    <x-slot name="title">
        Masuk
    </x-slot>

        {{-- Header --}}
        <div class="mb-6 text-center">
            <div
                class="mx-auto h-12 w-12 rounded-2xl bg-[#fff2f2] dark:bg-[#1D0002] flex items-center justify-center border border-[#19140035] dark:border-[#3E3E3A]">
                <span class="text-[#F53003] dark:text-[#F61500] font-semibold">SPK</span>
            </div>

            <h1 class="mt-4 text-2xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                Masuk SPK-PR
            </h1>
            <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">
                Sistem Pendukung Keputusan Prediksi Pembelian Rumah
            </p>
        </div>

        {{-- Session Status --}}
        <x-auth-session-status class="mb-4" :status="session('status')" />

        {{-- Card --}}
        <div class="bg-white dark:bg-[#161615] border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg shadow-sm p-6">
            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                {{-- Email --}}
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

                {{-- Password --}}
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

                {{-- Remember --}}
                <div class="flex items-center">
                    <label for="remember_me" class="inline-flex items-center">
                        <input
                            id="remember_me"
                            type="checkbox"
                            name="remember"
                            class="rounded border-[#e3e3e0] dark:border-[#3E3E3A] text-[#F53003] focus:ring-[#F53003] dark:bg-[#0a0a0a]"
                        >
                        <span class="ms-2 text-sm text-[#706f6c] dark:text-[#A1A09A]">
                            Ingat saya
                        </span>
                    </label>
                </div>

                {{-- Action Links (Back + Forgot) --}}
                <div class="flex items-center justify-between text-sm">
                    <a href="{{ url('/') }}"
                       class="text-[#706f6c] dark:text-[#A1A09A]
                              hover:text-[#F53003] dark:hover:text-[#FF4433]
                              transition underline underline-offset-4">
                        Kembali
                    </a>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="text-[#F53003] dark:text-[#FF4433]
                                  hover:underline underline-offset-4 transition">
                            Lupa password?
                        </a>
                    @endif
                </div>

                {{-- Button --}}
                <x-primary-button
                    class="w-full justify-center bg-[#1b1b18] hover:bg-black
                           text-white border border-black
                           focus:ring-2 focus:ring-offset-2 focus:ring-black
                           dark:focus:ring-offset-[#161615]
                           transition">
                    Masuk
                </x-primary-button>
            </form>
        </div>
    </div>
</x-guest-layout>
