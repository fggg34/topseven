@php
    $footerLogo = \App\Models\Setting::get('footer_logo', '') ?: \App\Models\Setting::get('site_logo', '');
    $footerLogoUrl = $footerLogo ? \Illuminate\Support\Facades\Storage::disk('public')->url($footerLogo) : null;
    $instagramUrl = \App\Models\Setting::get('instagram_url', '');
    $facebookUrl = \App\Models\Setting::get('facebook_url', '');
    $tiktokUrl = \App\Models\Setting::get('tiktok_url', '');
    $youtubeUrl = \App\Models\Setting::get('youtube_url', '');
    $footerMenu1 = \App\Models\Setting::get('footer_menu_1', '');
    $footerMenu1 = is_string($footerMenu1) ? (json_decode($footerMenu1, true) ?: []) : $footerMenu1;
    if (empty($footerMenu1) || !isset($footerMenu1['title'])) {
        $footerMenu1 = ['title' => 'Quick links', 'items' => [
            ['label' => 'Tours', 'url' => '/tours'],
            ['label' => 'Destinations', 'url' => '/countries'],
            ['label' => 'Blog', 'url' => '/blog'],
            ['label' => 'About us', 'url' => '/about'],
            ['label' => 'Contact', 'url' => '/contact'],
        ]];
    }
    $footerMenu2 = \App\Models\Setting::get('footer_menu_2', '');
    $footerMenu2 = is_string($footerMenu2) ? (json_decode($footerMenu2, true) ?: []) : $footerMenu2;
    if (empty($footerMenu2) || !isset($footerMenu2['title'])) {
        $footerMenu2 = ['title' => 'Company', 'items' => [
            ['label' => 'About us', 'url' => '/about'],
            ['label' => 'Contact', 'url' => '/contact'],
            ['label' => 'FAQ', 'url' => '/faq'],
        ]];
    }
    $resolveUrl = fn ($u) => (str_starts_with($u ?? '', 'http') ? $u : url($u ?? '#'));
@endphp
<footer class="bg-brand-footer text-gray-300 mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            {{-- Logo + Tagline + Social --}}
            <div>
                @if($footerLogoUrl)
                    <a href="{{ route('home') }}" class="inline-block mb-4">
                        <img src="{{ $footerLogoUrl }}" alt="{{ \App\Models\Setting::get('site_name', config('app.name')) }}" class="h-10 w-auto object-contain object-left">
                    </a>
                @else
                    <h3 class="text-white font-semibold text-lg mb-4">{{ \App\Models\Setting::get('site_name', config('app.name')) }}</h3>
                @endif
                <p class="text-sm text-gray-400 mb-4">{{ \App\Models\Setting::get('site_tagline', 'Discover your next adventure') }}</p>
                @if($instagramUrl || $facebookUrl || $tiktokUrl || $youtubeUrl)
                    <div class="flex items-center gap-6">
                        @if($instagramUrl)
                            <a href="{{ $instagramUrl }}" target="_blank" rel="noopener noreferrer" class="text-brand-btn hover:text-brand-btn-hover transition-colors" aria-label="Instagram">
                                <i class="fa-brands fa-instagram text-2xl"></i>
                            </a>
                        @endif
                        @if($facebookUrl)
                            <a href="{{ $facebookUrl }}" target="_blank" rel="noopener noreferrer" class="text-brand-btn hover:text-brand-btn-hover transition-colors" aria-label="Facebook">
                                <i class="fa-brands fa-facebook-f text-2xl"></i>
                            </a>
                        @endif
                        @if($tiktokUrl)
                            <a href="{{ $tiktokUrl }}" target="_blank" rel="noopener noreferrer" class="text-brand-btn hover:text-brand-btn-hover transition-colors" aria-label="TikTok">
                                <i class="fa-brands fa-tiktok text-2xl"></i>
                            </a>
                        @endif
                        @if($youtubeUrl)
                            <a href="{{ $youtubeUrl }}" target="_blank" rel="noopener noreferrer" class="text-brand-btn hover:text-brand-btn-hover transition-colors" aria-label="YouTube">
                                <i class="fa-brands fa-youtube text-2xl"></i>
                            </a>
                        @endif
                    </div>
                @endif
            </div>
            {{-- Footer Menu 1 (dynamic) --}}
            @if(!empty($footerMenu1['items']))
            <div>
                <h3 class="text-white font-semibold text-sm uppercase tracking-wider mb-4">{{ $footerMenu1['title'] }}</h3>
                <ul class="space-y-2.5 text-sm">
                    @foreach($footerMenu1['items'] as $item)
                        <li><a href="{{ $resolveUrl($item['url'] ?? '') }}" class="text-gray-400 hover:text-white transition">{{ $item['label'] ?? '' }}</a></li>
                    @endforeach
                </ul>
            </div>
            @endif
            {{-- Footer Menu 2 (dynamic) --}}
            @if(!empty($footerMenu2['items']))
            <div>
                <h3 class="text-white font-semibold text-sm uppercase tracking-wider mb-4">{{ $footerMenu2['title'] }}</h3>
                <ul class="space-y-2.5 text-sm">
                    @foreach($footerMenu2['items'] as $item)
                        <li><a href="{{ $resolveUrl($item['url'] ?? '') }}" class="text-gray-400 hover:text-white transition">{{ $item['label'] ?? '' }}</a></li>
                    @endforeach
                </ul>
            </div>
            @endif
            {{-- Contact --}}
            <div>
                <h3 class="text-white font-semibold text-sm uppercase tracking-wider mb-4">Contact</h3>
                <ul class="space-y-2.5 text-sm text-gray-400">
                    @if(\App\Models\Setting::get('contact_email'))
                        <li class="flex items-center gap-2">
                            <i class="fa-solid fa-envelope text-xs text-gray-500"></i>
                            <a href="mailto:{{ \App\Models\Setting::get('contact_email') }}" class="hover:text-white transition">{{ \App\Models\Setting::get('contact_email') }}</a>
                        </li>
                    @endif
                    @if(\App\Models\Setting::get('contact_phone'))
                        <li class="flex items-center gap-2">
                            <i class="fa-solid fa-phone text-xs text-gray-500"></i>
                            <a href="tel:{{ \App\Models\Setting::get('contact_phone') }}" class="hover:text-white transition">{{ \App\Models\Setting::get('contact_phone') }}</a>
                        </li>
                    @endif
                    @if(\App\Models\Setting::get('contact_address'))
                        <li class="flex items-start gap-2">
                            <i class="fa-solid fa-location-dot text-xs text-gray-500 mt-0.5"></i>
                            <span>{{ \App\Models\Setting::get('contact_address') }}</span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="border-t border-brand-footer-border mt-10 pt-8 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} {{ \App\Models\Setting::get('site_name', config('app.name')) }}. All rights reserved.
        </div>
    </div>
</footer>
