<x-guest-layout>
    <h1 class="text-[28px] sm:text-[32px] font-serif font-semibold text-[#111827] tracking-tight leading-tight mb-2">{{ __('Reset Password') }}</h1>
    <p class="text-[15px] text-gray-500 mb-8 leading-relaxed">Choose a new password for your account.</p>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Email') }}</label>
            <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username"
                class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3.5 text-[15px] text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#111827] focus:border-transparent transition" />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Password') }}</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3.5 text-[15px] text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#111827] focus:border-transparent transition" />
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Confirm Password') }}</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3.5 text-[15px] text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#111827] focus:border-transparent transition" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5" />
        </div>

        <button type="submit" class="w-full inline-flex items-center justify-center rounded-full bg-[#111827] text-white text-sm font-semibold px-8 py-3.5 hover:bg-gray-900 transition-colors">
            {{ __('Reset Password') }}
        </button>
    </form>
</x-guest-layout>
