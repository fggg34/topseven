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
                        <h3 class="text-[36px] leading-[1.02] font-serif text-[#1f1f1f]">Ofertat tona, direkt tek ju.</h3>
                    </div>
                </div>
                <div class="lg:col-span-4 px-6 py-7 border-t lg:border-t-0 lg:border-l lg:border-[#e6e1d8]">
                    @if(session('newsletter_success'))
                        <p class="text-sm text-green-700 mb-2">{{ session('newsletter_success') }}</p>
                    @endif
                    <form method="POST" action="{{ route('newsletter.subscribe') }}" class="space-y-2">
                        @csrf
                        <input type="text" name="full_name" value="{{ old('full_name') }}" placeholder="Emri" class="w-full h-10 border border-[#e1ddd4] px-3 text-sm bg-white focus:outline-none focus:ring-1 focus:ring-[#9d8f7b]">
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="E-mail" class="w-full h-10 border border-[#e1ddd4] px-3 text-sm bg-white focus:outline-none focus:ring-1 focus:ring-[#9d8f7b]">
                        @error('email')
                            <p class="text-xs text-red-600">{{ $message }}</p>
                        @enderror
                        <label class="flex items-start gap-2 text-[11px] text-[#666] leading-snug">
                            <input type="checkbox" name="opt_in" value="1" checked class="mt-0.5 border-[#cbc4b8]">
                            <span>Regjistrohu dhe bëhu i pari që mëson për paketat e reja.</span>
                        </label>
                        <button type="submit" class="w-full h-10 bg-[#d9c9a8] hover:bg-[#cfbe9a] transition-colors text-[#1f1f1f] text-sm font-semibold inline-flex items-center justify-center gap-2">
                            <i class="fa-solid fa-envelope text-xs"></i>
                            Regjistrohu
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h4 class="text-[20px] font-serif text-[#1f1f1f] mb-3">{{ $footerMenu1['title'] }}</h4>
                <ul class="space-y-1.5 text-[15px]">
                    @foreach(($footerMenu1['items'] ?? []) as $item)
                        <li>
                            <a href="{{ $resolveUrl($item['url'] ?? '') }}" class="text-[#3f4b9a] hover:text-[#1f2937] hover:underline">{{ $item['label'] ?? '' }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h4 class="text-[20px] font-serif text-[#1f1f1f] mb-3">{{ $footerMenu2['title'] }}</h4>
                <ul class="space-y-1.5 text-[15px]">
                    @foreach(($footerMenu2['items'] ?? []) as $item)
                        <li>
                            <a href="{{ $resolveUrl($item['url'] ?? '') }}" class="text-[#3f4b9a] hover:text-[#1f2937] hover:underline">{{ $item['label'] ?? '' }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h4 class="text-[20px] font-serif text-[#1f1f1f] mb-3">Na kontaktoni</h4>
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
                            <a href="mailto:{{ $contactEmail }}" class="text-[#3f4b9a] hover:text-[#1f2937] hover:underline">{{ $contactEmail }}</a>
                        </p>
                    @endif
                    @if($contactPhone)
                        <p>
                            <i class="fa-solid fa-phone text-xs mr-1.5 text-[#7a746b]"></i>
                            <a href="tel:{{ $contactPhone }}" class="text-[#3f4b9a] hover:text-[#1f2937] hover:underline">{{ $contactPhone }}</a>
                        </p>
                    @endif
                    @if($contactAddress)
                        <p class="flex items-start gap-1.5">
                            <i class="fa-solid fa-location-dot text-xs mt-0.5 text-[#7a746b] flex-shrink-0"></i>
                            <span class="text-[#3f4b9a]">{{ $contactAddress }}</span>
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <div class="mt-8 pt-4 border-t border-[#ded8ce] flex flex-wrap items-center justify-between gap-4 text-[13px]">
            <p class="text-[#6a6a6a]">
                &copy; {{ date('Y') }} {{ $siteName }}. {{ __('All rights reserved.') }}
            </p>
            <div class="flex flex-wrap items-center gap-5 text-[#3f4b9a]">
                <a href="https://impactstudio.al" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 hover:opacity-90 transition-opacity">
                    <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 32.53 39.89" class="h-8 w-auto shrink-0" aria-hidden="true">
                        <defs>
                            <style>
                                .impact-studio-logo .cls-1 { fill: #f10066; }
                                .impact-studio-logo .cls-2 { fill: #fff; stroke: #000; stroke-miterlimit: 10; stroke-width: .84px; }
                            </style>
                        </defs>
                        <g class="impact-studio-logo">
                            <path class="cls-2" d="M23.42,22.11c-3.34-.82-5.03-1.63-5.68-2.9-.35-.68-.34-1.22-.33-1.44,0-.03,0-.04,0-.06,.07-.7,.37-1.33,.54-1.59,.55-.85,1.86-1.27,2.86-1.31,.49-.02,1.74,0,2.85,.91,.92,.75,1.44,1.93,1.55,3.39h6.5c-.6-5.1-3.7-9-10.7-9-5.4,0-10.3,3-10.3,8.3,0,.37-.16,2.28,.97,4,1.08,1.63,2.77,2.26,5.13,3.15,.53,.2,1.38,.44,3.06,.93,1.4,.41,2.15,.61,3.19,1.1,1.56,.73,1.99,1.27,2.18,1.57,.16,.25,.62,.93,.55,1.83-.1,1.29-1.22,2.07-1.54,2.3-.86,.61-1.71,.72-3.39,.82-3.41,.22-5.58,.12-6.86,.06-2.01-.1-3.08-.22-4.2-.94-.37-.24-.9-.64-1.37-1.23-1.52-1.91-1.28-4.35-1.34-9.66,0-.26,0-1.14-.03-2.43-.02-.96-.04-1.94-.05-2.93-.01-1.17-.01-2.31,0-3.44,0-.33,0-1.57-.9-2.48-1.24-1.25-3.52-1.24-4.76-.01-.88,.87-.93,2.05-.94,2.39v15.8c0,1.7,.4,3.5,1.2,5,0,0,.71,1.3,1.81,2.34,1.52,1.43,3.59,2.37,10.89,2.76,9.19,.49,11.82-.56,13.34-1.43,1.57-.9,2.33-1.77,2.73-2.31,1.62-2.18,2.38-5.66,.96-8.45-1.41-2.78-4.47-3.84-6.51-4.59-.59-.21-1.08-.36-1.42-.45Z"></path>
                            <path class="cls-1" d="M4.07,0h0c1.86,0,3.36,1.5,3.36,3.36h0c0,1.86-1.5,3.36-3.36,3.36h0c-1.86,0-3.36-1.5-3.36-3.36H.71C.71,1.5,2.21,0,4.07,0Z"></path>
                        </g>
                    </svg>
                    <span>Impact Studio</span>
                </a>
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
