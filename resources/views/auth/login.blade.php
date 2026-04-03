<x-guest-layout>
    <h1 class="text-[28px] sm:text-[32px] font-serif font-semibold text-[#111827] tracking-tight leading-tight mb-2">{{ __('Log in') }}</h1>
    <p class="text-[15px] text-gray-500 mb-8 leading-relaxed">Welcome back — access your enquiries and saved travel packages.</p>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Email') }}</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3.5 text-[15px] text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#111827] focus:border-transparent transition" />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Password') }}</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3.5 text-[15px] text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#111827] focus:border-transparent transition" />
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <div class="flex items-center">
            <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-[#111827] focus:ring-[#111827]" name="remember">
                <span class="text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex flex-col gap-4 pt-2">
            <button type="submit" class="inline-flex items-center justify-center w-full rounded-full bg-[#111827] text-white text-sm font-semibold px-8 py-3.5 hover:bg-gray-900 transition-colors">
                {{ __('Log in') }}
                <i class="fa-solid fa-arrow-right text-xs ml-2"></i>
            </button>
            <div class="flex flex-wrap items-center justify-center gap-x-4 gap-y-2 text-sm">
                @if (Route::has('password.request'))
                    <a class="text-gray-600 hover:text-[#111827] font-medium transition-colors" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
                @if (Route::has('register'))
                    <a class="text-lime-700 hover:text-lime-800 font-semibold transition-colors" href="{{ route('register') }}">
                        {{ __('Create an account') }}
                    </a>
                @endif
            </div>
        </div>
    </form>
</x-guest-layout>
