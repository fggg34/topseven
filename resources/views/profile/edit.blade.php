<x-account-layout>
    <h1 class="text-[28px] sm:text-[32px] font-serif font-semibold text-[#111827] tracking-tight leading-tight mb-2">{{ __('Account settings') }}</h1>
    <p class="text-[15px] text-gray-500 mb-10 leading-relaxed">{{ __('Update your profile, password, or delete your account.') }}</p>

    <div class="space-y-0">
        <div class="pb-10 mb-10 border-b border-[#e6e1d8]">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="pb-10 mb-10 border-b border-[#e6e1d8]">
            @include('profile.partials.update-password-form')
        </div>

        <div>
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</x-account-layout>
