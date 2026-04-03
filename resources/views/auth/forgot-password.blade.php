<x-guest-layout>
    <h1 class="text-[28px] sm:text-[32px] font-serif font-semibold text-[#111827] tracking-tight leading-tight mb-2">{{ __('Forgot Password') }}</h1>
    <p class="text-[15px] text-gray-500 mb-8 leading-relaxed">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </p>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Email') }}</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3.5 text-[15px] text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#111827] focus:border-transparent transition" />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-2">
            <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-[#111827] transition-colors order-2 sm:order-1">{{ __('Back to log in') }}</a>
            <button type="submit" class="order-1 sm:order-2 inline-flex items-center justify-center rounded-full bg-[#111827] text-white text-sm font-semibold px-8 py-3.5 hover:bg-gray-900 transition-colors w-full sm:w-auto">
                {{ __('Email Password Reset Link') }}
            </button>
        </div>
    </form>
</x-guest-layout>
