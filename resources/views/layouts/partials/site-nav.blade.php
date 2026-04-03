@php
    $headerOverlay = request()->routeIs('home');
    $siteName = \App\Models\Setting::get('site_name', config('app.name'));
    $siteLogo = \App\Models\Setting::get('site_logo', '');
    $bookPhone = \App\Models\Setting::get('contact_phone', '');
    $bookPhoneTel = preg_replace('/[^0-9+]/', '', $bookPhone) ?: '';
    $facebookUrl = trim((string) \App\Models\Setting::get('facebook_url', ''));
    $instagramUrl = trim((string) \App\Models\Setting::get('instagram_url', ''));
    $navItems = \App\Models\Setting::get('nav_menu_items', '');
    $navItems = is_string($navItems) ? (json_decode($navItems, true) ?: []) : $navItems;
    if (empty($navItems)) {
        $navItems = [
            ['type' => 'dropdown', 'label' => 'Destinations', 'children' => [['label' => 'All Destinations', 'url' => '/countries']]],
            ['type' => 'dropdown', 'label' => 'Travel Collections', 'children' => [
                ['label' => 'All Travel Packages', 'url' => '/tours'],
                ['label' => 'Popular Travel Packages', 'url' => '/tours?sort=popular'],
                ['label' => 'Travel Stories', 'url' => '/blog'],
            ]],
            ['type' => 'dropdown', 'label' => 'About', 'children' => [
                ['label' => 'About Us', 'url' => '/about'],
                ['label' => 'Blog', 'url' => '/blog'],
                ['label' => 'Contact', 'url' => '/contact'],
            ]],
            ['type' => 'link', 'label' => 'Create Your Trip', 'url' => '/tours'],
            ['type' => 'link', 'label' => 'My Trips', 'url' => '/dashboard'],
        ];
    }
    $resolveUrl = fn ($u) => (str_starts_with($u ?? '', 'http') ? $u : url($u ?? '#'));
@endphp
<header
    class="fixed top-0 inset-x-0 z-50 transition-colors duration-300"
    x-data="{
        mobileOpen: false,
        overlay: @js($headerOverlay),
        scrolled: false,
        checkScroll() {
            this.scrolled = (window.scrollY || document.documentElement.scrollTop) > 12;
        },
    }"
    x-init="checkScroll()"
    @scroll.window="checkScroll()"
    :class="overlay && scrolled ? 'bg-[#000] shadow-md shadow-black/30' : (!overlay ? 'bg-white/95 backdrop-blur-sm border-b border-gray-200 shadow-sm' : '')"
>
    <nav class="w-full px-4 sm:px-6 lg:px-[80px] pt-5 pb-4">
        <div class="flex items-center justify-between">
            {{-- Left: nav links --}}
            <nav class="hidden md:flex items-center gap-8 text-sm lg:text-base font-medium tracking-wide">
                @foreach($navItems as $item)
                    <a href="{{ $resolveUrl(($item['type'] ?? 'link') === 'dropdown' ? (($item['children'][0]['url'] ?? '#')) : ($item['url'] ?? '#')) }}"
                       class="{{ $headerOverlay ? 'text-white/85 hover:text-white' : 'text-gray-700 hover:text-lime-700' }} transition-colors">
                        {{ $item['label'] ?? '' }}
                    </a>
                @endforeach
            </nav>

            {{-- Center: logo --}}
            <a href="{{ route('home') }}" class="absolute left-1/2 -translate-x-1/2 md:static md:translate-x-0 md:mx-auto">
                @if($siteLogo)
                    <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($siteLogo) }}" alt="{{ $siteName }}"
                         class="h-9 md:h-10 lg:h-12 w-auto object-contain {{ $headerOverlay ? 'brightness-0 invert' : '' }}" />
                @else
                    <span class="text-2xl md:text-3xl lg:text-4xl font-black tracking-wider uppercase {{ $headerOverlay ? 'text-white' : 'text-gray-900' }}">{{ $siteName }}</span>
                @endif
            </a>

            {{-- Right: phone + social --}}
            <div class="hidden md:flex items-center gap-6 lg:gap-8 text-sm lg:text-base font-medium">
                @if($bookPhone)
                    <a href="tel:{{ $bookPhoneTel }}" class="{{ $headerOverlay ? 'text-white/85 hover:text-white' : 'text-gray-700 hover:text-lime-700' }} transition-colors">
                        Book now: {{ $bookPhone }}
                    </a>
                @endif
                @if($facebookUrl || $instagramUrl)
                    <div class="flex items-center gap-4 lg:gap-5">
                        @if($facebookUrl)
                            <a href="{{ $facebookUrl }}" target="_blank" rel="noopener noreferrer"
                               class="{{ $headerOverlay ? 'text-white/90 hover:text-white' : 'text-gray-700 hover:text-lime-700' }} transition-colors"
                               aria-label="Facebook">
                                <i class="fa-brands fa-facebook-f text-lg lg:text-xl"></i>
                            </a>
                        @endif
                        @if($instagramUrl)
                            <a href="{{ $instagramUrl }}" target="_blank" rel="noopener noreferrer"
                               class="{{ $headerOverlay ? 'text-white/90 hover:text-white' : 'text-gray-700 hover:text-lime-700' }} transition-colors"
                               aria-label="Instagram">
                                <i class="fa-brands fa-instagram text-xl lg:text-2xl"></i>
                            </a>
                        @endif
                    </div>
                @endif
                @auth
                    <a href="{{ route('dashboard') }}"
                       class="{{ $headerOverlay ? 'text-white/90 hover:text-white' : 'text-gray-700 hover:text-lime-700' }} transition-colors inline-flex"
                       title="My account" aria-label="My account">
                        <x-icons.user-circled class="w-6 h-6 lg:w-[26px] lg:h-[26px] shrink-0" />
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="{{ $headerOverlay ? 'text-white/90 hover:text-white' : 'text-gray-700 hover:text-lime-700' }} transition-colors"
                       title="Log in" aria-label="Log in">
                        <i class="fa-regular fa-circle-user text-2xl lg:text-[26px] leading-none"></i>
                    </a>
                @endauth
            </div>

            {{-- Mobile hamburger --}}
            <button @click="mobileOpen = !mobileOpen" type="button"
                    class="md:hidden p-2 -mr-2 {{ $headerOverlay ? 'text-white/80 hover:text-white' : 'text-gray-600 hover:text-gray-900' }}">
                <svg x-show="!mobileOpen" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                <svg x-show="mobileOpen" x-cloak class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </nav>

    {{-- Mobile overlay --}}
    <div x-show="mobileOpen" x-cloak x-transition @click="mobileOpen = false"
         class="md:hidden fixed inset-0 z-[9998] bg-black/40"></div>
    <div x-show="mobileOpen" x-cloak
         x-transition:enter="transition ease-out duration-200" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in duration-150" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
         class="md:hidden fixed top-0 right-0 bottom-0 z-[9999] w-72 max-w-[85vw] bg-white shadow-xl flex flex-col text-gray-800">
        <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100">
            <span class="text-sm font-medium text-gray-500">Menu</span>
            <button @click="mobileOpen = false" type="button" class="p-2 -mr-2 text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="flex-1 overflow-y-auto py-4">
            @foreach($navItems as $item)
                @if(($item['type'] ?? 'link') === 'dropdown' && !empty($item['children'] ?? []))
                    @foreach($item['children'] as $child)
                        <a href="{{ $resolveUrl($child['url'] ?? '') }}" @click="mobileOpen = false" class="block px-5 py-2.5 text-sm text-gray-700 hover:bg-gray-50">{{ $child['label'] ?? '' }}</a>
                    @endforeach
                @else
                    <a href="{{ $resolveUrl($item['url'] ?? '') }}" @click="mobileOpen = false" class="block px-5 py-2.5 text-sm text-gray-700 hover:bg-gray-50">{{ $item['label'] ?? '' }}</a>
                @endif
            @endforeach
        </div>
        <div class="flex-shrink-0 border-t border-gray-100 py-4">
            @if($facebookUrl || $instagramUrl)
                <div class="flex items-center gap-5 px-5 pb-3">
                    @if($facebookUrl)
                        <a href="{{ $facebookUrl }}" target="_blank" rel="noopener noreferrer" @click="mobileOpen = false" class="text-gray-700 hover:text-lime-700 transition-colors" aria-label="Facebook">
                            <i class="fa-brands fa-facebook-f text-xl"></i>
                        </a>
                    @endif
                    @if($instagramUrl)
                        <a href="{{ $instagramUrl }}" target="_blank" rel="noopener noreferrer" @click="mobileOpen = false" class="text-gray-700 hover:text-lime-700 transition-colors" aria-label="Instagram">
                            <i class="fa-brands fa-instagram text-2xl"></i>
                        </a>
                    @endif
                </div>
            @endif
            <div class="px-5 pb-3 flex items-center gap-4 border-b border-gray-100">
                @auth
                    <a href="{{ route('dashboard') }}" @click="mobileOpen = false" class="text-sm font-medium text-gray-800 hover:text-lime-700 transition-colors flex items-center gap-2">
                        <x-icons.user-circled class="w-[1.125rem] h-[1.125rem] shrink-0 text-gray-500" /> My account
                    </a>
                @else
                    <a href="{{ route('login') }}" @click="mobileOpen = false" class="text-sm font-medium text-gray-800 hover:text-lime-700 transition-colors">Log in</a>
                    @if(Route::has('register'))
                        <a href="{{ route('register') }}" @click="mobileOpen = false" class="text-sm font-medium text-lime-600 hover:text-lime-700 transition-colors">Register</a>
                    @endif
                @endauth
            </div>
            @auth
                <form method="POST" action="{{ route('logout') }}" class="px-5 pb-2">@csrf
                    <button type="submit" class="text-sm text-gray-500 hover:text-red-600 transition-colors">Log out</button>
                </form>
            @endauth
            <a href="{{ route('contact') }}" @click="mobileOpen = false" class="flex items-center gap-2 px-5 py-2.5 text-sm text-gray-700 hover:bg-gray-50"><i class="fa-solid fa-envelope text-gray-400 w-5"></i>Contact</a>
            @if($bookPhone)
                <a href="tel:{{ $bookPhoneTel }}" @click="mobileOpen = false" class="flex items-center gap-2 px-5 py-2.5 text-sm text-gray-700 hover:bg-gray-50"><i class="fa-solid fa-phone text-gray-400 w-5"></i>{{ $bookPhone }}</a>
            @endif
            @if($contactEmail = \App\Models\Setting::get('contact_email'))
                <a href="mailto:{{ $contactEmail }}" @click="mobileOpen = false" class="flex items-center gap-2 px-5 py-2.5 text-sm text-gray-700 hover:bg-gray-50 break-all"><i class="fa-solid fa-envelope text-gray-400 w-5 flex-shrink-0"></i>{{ $contactEmail }}</a>
            @endif
        </div>
    </div>
</header>
