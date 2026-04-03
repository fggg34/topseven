@php
    $inputClass = 'w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3.5 text-[15px] text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#111827] focus:border-transparent transition';
@endphp

<section>
    <header class="mb-6">
        <h2 class="text-lg font-semibold text-[#111827]">
            {{ __('Delete account') }}
        </h2>
        <p class="mt-1 text-sm text-gray-500 leading-relaxed">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <button
        type="button"
        class="inline-flex items-center justify-center rounded-full border border-red-200 bg-white text-red-700 text-sm font-semibold px-8 py-3.5 hover:bg-red-50 transition-colors"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Delete account') }}</button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable maxWidth="md">
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 sm:p-8">
            @csrf
            @method('delete')

            <h2 class="text-lg font-semibold text-[#111827]">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-2 text-sm text-gray-500 leading-relaxed">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <label for="password" class="sr-only">{{ __('Password') }}</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    class="{{ $inputClass }}"
                    placeholder="{{ __('Password') }}"
                    autocomplete="current-password"
                />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-1.5" />
            </div>

            <div class="mt-8 flex flex-col-reverse sm:flex-row sm:justify-end gap-3">
                <button
                    type="button"
                    class="inline-flex items-center justify-center rounded-full border border-gray-200 bg-white text-[#111827] text-sm font-semibold px-6 py-3 hover:bg-gray-50 transition-colors w-full sm:w-auto"
                    x-on:click="$dispatch('close')"
                >{{ __('Cancel') }}</button>

                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-full bg-red-600 text-white text-sm font-semibold px-6 py-3 hover:bg-red-700 transition-colors w-full sm:w-auto"
                >{{ __('Delete account') }}</button>
            </div>
        </form>
    </x-modal>
</section>
