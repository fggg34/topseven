@php
    $inputClass = 'w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3.5 text-[15px] text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#111827] focus:border-transparent transition';
@endphp

<section>
    <header class="mb-6">
        <h2 class="text-lg font-semibold text-[#111827]">
            {{ __('Update password') }}
        </h2>
        <p class="mt-1 text-sm text-gray-500 leading-relaxed">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Current password') }}</label>
            <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password" class="{{ $inputClass }}" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-1.5" />
        </div>

        <div>
            <label for="update_password_password" class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('New password') }}</label>
            <input id="update_password_password" name="password" type="password" autocomplete="new-password" class="{{ $inputClass }}" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-1.5" />
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Confirm password') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" class="{{ $inputClass }}" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-1.5" />
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center gap-4 pt-2">
            <button type="submit" class="inline-flex items-center justify-center rounded-full bg-[#111827] text-white text-sm font-semibold px-8 py-3.5 hover:bg-gray-900 transition-colors w-full sm:w-auto">
                {{ __('Save') }}
                <i class="fa-solid fa-arrow-right text-xs ml-2"></i>
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm font-medium text-emerald-700"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
