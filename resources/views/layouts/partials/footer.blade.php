@php
    $instagramUrl = \App\Models\Setting::get('instagram_url', '');
    $facebookUrl = \App\Models\Setting::get('facebook_url', '');
    $tiktokUrl = \App\Models\Setting::get('tiktok_url', '');
    $youtubeUrl = \App\Models\Setting::get('youtube_url', '');
    $siteName = \App\Models\Setting::get('site_name', config('app.name'));
    $contactEmail = \App\Models\Setting::get('contact_email', '');
    $contactPhone = \App\Models\Setting::get('contact_phone', '');
    $contactAddress = \App\Models\Setting::get('contact_address', '');
    $footerMenu1 = \App\Models\Setting::get('footer_menu_1', '');
    $footerMenu1 = is_string($footerMenu1) ? (json_decode($footerMenu1, true) ?: []) : $footerMenu1;
    if (empty($footerMenu1) || ! isset($footerMenu1['title'])) {
        $footerMenu1 = ['title' => __('Company'), 'items' => []];
    }
    $footerMenu2 = \App\Models\Setting::get('footer_menu_2', '');
    $footerMenu2 = is_string($footerMenu2) ? (json_decode($footerMenu2, true) ?: []) : $footerMenu2;
    if (empty($footerMenu2) || ! isset($footerMenu2['title'])) {
        $footerMenu2 = ['title' => __('Popular Destinations'), 'items' => []];
    }
    $resolveUrl = fn ($u) => (str_starts_with($u ?? '', 'http') ? $u : url($u ?? '#'));
@endphp

<footer class="mt-16 bg-[#f8f6f2] text-[#222] border-t border-[#e6e1d8]">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="border border-[#ddd6cb] bg-[#faf8f4]">
            <div class="grid grid-cols-1 lg:grid-cols-12 min-h-[170px]">
                <div class="hidden lg:block lg:col-span-4 h-full bg-cover bg-center footer-newsletter-image-clip" style="background-image:url('https://images.unsplash.com/photo-1516483638261-f4dbaf036963?auto=format&fit=crop&w=900&q=80')"></div>
                <div class="lg:col-span-4 flex items-center px-6 py-7 border-t lg:border-t-0 lg:border-l lg:border-[#e6e1d8]">
                    <div>
                        <h3 class="text-[36px] leading-[1.02] font-serif text-[#1f1f1f]">{{ __('The latest ideas in luxury travel') }}</h3>
                        <p class="mt-2 text-sm text-[#555]">{{ __('Join our weekly travel newsletter') }}</p>
                    </div>
                </div>
                <div class="lg:col-span-4 px-6 py-7 border-t lg:border-t-0 lg:border-l lg:border-[#e6e1d8]">
                    @if(session('newsletter_success'))
                        <p class="text-sm text-green-700 mb-2">{{ session('newsletter_success') }}</p>
                    @endif
                    <form method="POST" action="{{ route('newsletter.subscribe') }}" class="space-y-2">
                        @csrf
                        <input type="text" name="full_name" value="{{ old('full_name') }}" placeholder="{{ __('Full name') }}" class="w-full h-10 border border-[#e1ddd4] px-3 text-sm bg-white focus:outline-none focus:ring-1 focus:ring-[#9d8f7b]">
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="{{ __('Email address') }}" class="w-full h-10 border border-[#e1ddd4] px-3 text-sm bg-white focus:outline-none focus:ring-1 focus:ring-[#9d8f7b]">
                        @error('email')
                            <p class="text-xs text-red-600">{{ $message }}</p>
                        @enderror
                        <label class="flex items-start gap-2 text-[11px] text-[#666] leading-snug">
                            <input type="checkbox" name="opt_in" value="1" checked class="mt-0.5 border-[#cbc4b8]">
                            <span>{{ __('I would like to receive weekly travel inspiration and ideas from the newsletter of :site', ['site' => $siteName]) }}</span>
                        </label>
                        <button type="submit" class="w-full h-10 bg-[#d9c9a8] hover:bg-[#cfbe9a] transition-colors text-[#1f1f1f] text-sm font-semibold inline-flex items-center justify-center gap-2">
                            <i class="fa-solid fa-envelope text-xs"></i>
                            {{ __('Subscribe') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="mt-5 text-sm text-[#4a4a4a]">
            {{ __('Are you a top travel specialist?') }}
            <a href="{{ route('contact') }}" class="text-[#111827] font-semibold hover:text-[#1f2937] hover:underline">{{ __('Click here to contact us.') }}</a>
        </div>

        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h4 class="text-[20px] font-serif text-[#1f1f1f] mb-3">{{ $footerMenu1['title'] }}</h4>
                <ul class="space-y-1.5 text-[15px]">
                    @foreach(($footerMenu1['items'] ?? []) as $item)
                        <li>
                            <a href="{{ $resolveUrl($item['url'] ?? '') }}" class="text-[#111827] hover:text-[#1f2937] hover:underline">{{ $item['label'] ?? '' }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h4 class="text-[20px] font-serif text-[#1f1f1f] mb-3">{{ $footerMenu2['title'] }}</h4>
                <ul class="space-y-1.5 text-[15px]">
                    @foreach(($footerMenu2['items'] ?? []) as $item)
                        <li>
                            <a href="{{ $resolveUrl($item['url'] ?? '') }}" class="text-[#111827] hover:text-[#1f2937] hover:underline">{{ $item['label'] ?? '' }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h4 class="text-[20px] font-serif text-[#1f1f1f] mb-3">{{ __('Connect With Us') }}</h4>
                <div class="flex items-center gap-2">
                    @if($facebookUrl)<a href="{{ $facebookUrl }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-full border border-[#b8b2a7] text-[#6c6c6c] flex items-center justify-center hover:text-[#1f1f1f]"><i class="fa-brands fa-facebook-f text-sm"></i></a>@endif
                    @if($instagramUrl)<a href="{{ $instagramUrl }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-full border border-[#b8b2a7] text-[#6c6c6c] flex items-center justify-center hover:text-[#1f1f1f]"><i class="fa-brands fa-instagram text-sm"></i></a>@endif
                    @if($youtubeUrl)<a href="{{ $youtubeUrl }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-full border border-[#b8b2a7] text-[#6c6c6c] flex items-center justify-center hover:text-[#1f1f1f]"><i class="fa-brands fa-youtube text-sm"></i></a>@endif
                    @if($tiktokUrl)<a href="{{ $tiktokUrl }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-full border border-[#b8b2a7] text-[#6c6c6c] flex items-center justify-center hover:text-[#1f1f1f]"><i class="fa-brands fa-tiktok text-sm"></i></a>@endif
                </div>
                <div class="mt-4 text-sm text-[#6a6a6a] space-y-1.5">
                    @if($contactEmail)
                        <p>
                            <i class="fa-solid fa-envelope text-xs mr-1.5 text-[#7a746b]"></i>
                            <a href="mailto:{{ $contactEmail }}" class="text-[#111827] hover:text-[#1f2937] hover:underline">{{ $contactEmail }}</a>
                        </p>
                    @endif
                    @if($contactPhone)
                        <p>
                            <i class="fa-solid fa-phone text-xs mr-1.5 text-[#7a746b]"></i>
                            <a href="tel:{{ $contactPhone }}" class="text-[#111827] hover:text-[#1f2937] hover:underline">{{ $contactPhone }}</a>
                        </p>
                    @endif
                </div>
                @if($contactAddress)
                    <p class="mt-2 text-sm text-[#6a6a6a]">{{ $contactAddress }}</p>
                @endif
            </div>
        </div>

        <div class="mt-8 pt-4 border-t border-[#ded8ce] flex flex-wrap items-center justify-between gap-4 text-[13px]">
            <p class="text-[#6a6a6a]">
                &copy; {{ date('Y') }} {{ $siteName }}. {{ __('All rights reserved.') }}
            </p>
            <div class="flex flex-wrap items-center gap-5 text-[#111827]">
                <a href="{{ route('contact') }}" class="hover:text-[#1f2937] hover:underline">{{ __('Privacy Policy') }}</a>
                <a href="{{ route('contact') }}" class="hover:text-[#1f2937] hover:underline">{{ __('Terms of Use') }}</a>
                <a href="{{ route('contact') }}" class="hover:text-[#1f2937] hover:underline">{{ __('Contact Support') }}</a>
            </div>
        </div>
    </div>
</footer>

@once
    @push('styles')
        <style>
            .footer-newsletter-image-clip {
                clip-path: polygon(0 0, 82% 0, 100% 50%, 82% 100%, 0 100%);
            }
        </style>
    @endpush
@endonce
