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
            ['type' => 'dropdown', 'label' => __('Destinations'), 'children' => [['label' => __('All Destinations'), 'url' => '/countries']]],
            ['type' => 'dropdown', 'label' => __('Travel Collections'), 'children' => [
                ['label' => __('All Travel Packages'), 'url' => '/tours'],
                ['label' => __('Popular Travel Packages'), 'url' => '/tours?sort=popular'],
                ['label' => __('Travel Stories'), 'url' => '/blog'],
            ]],
            ['type' => 'dropdown', 'label' => __('About'), 'children' => [
                ['label' => __('About Us'), 'url' => '/about'],
                ['label' => __('Blog'), 'url' => '/blog'],
                ['label' => __('Contact'), 'url' => '/contact'],
            ]],
            ['type' => 'link', 'label' => __('Create Your Trip'), 'url' => '/tours'],
            ['type' => 'link', 'label' => __('My Trips'), 'url' => '/dashboard'],
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
            {{-- Left: nav links (dropdowns match hero destination panel: white panel, shadow, lime active row) --}}
            <nav class="hidden md:flex items-center gap-6 lg:gap-8 text-sm lg:text-base font-medium tracking-wide">
                @foreach($navItems as $item)
                    @php
                        $isDropdown = ($item['type'] ?? 'link') === 'dropdown' && ! empty($item['children'] ?? []);
                    @endphp
                    @if($isDropdown)
                        <div class="relative" x-data="{ open: false }" @keydown.escape.window="open = false">
                            <button type="button"
                                    id="nav-menu-trigger-{{ $loop->index }}"
                                    @click="open = !open"
                                    :aria-expanded="open"
                                    aria-haspopup="true"
                                    aria-controls="nav-menu-panel-{{ $loop->index }}"
                                    class="inline-flex items-center gap-1.5 {{ $headerOverlay ? 'text-white/85 hover:text-white' : 'text-gray-700 hover:text-lime-700' }} transition-colors py-1">
                                <span>{{ $item['label'] ?? '' }}</span>
                                <svg class="w-4 h-4 opacity-70 flex-shrink-0 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div id="nav-menu-panel-{{ $loop->index }}"
                                 x-show="open"
                                 x-cloak
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0 -translate-y-1"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-100"
                                 x-transition:leave-start="opacity-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 -translate-y-1"
                                 @click.outside="open = false"
                                 class="absolute left-0 top-full mt-2 z-[60] min-w-[240px] max-w-[min(100vw-2rem,320px)] bg-white rounded-xl shadow-xl border border-gray-200 py-1.5"
                                 style="display: none;">
                                <div class="max-h-64 overflow-y-auto">
                                    @foreach($item['children'] as $child)
                                        @php
                                            $childHref = $resolveUrl($child['url'] ?? '');
                                            $childPath = parse_url($childHref, PHP_URL_PATH);
                                            $childPathNorm = $childPath === null || $childPath === '' ? '/' : '/'.ltrim($childPath, '/');
                                            $reqPath = '/'.ltrim(request()->path(), '/');
                                            $navChildActive = rtrim($childPathNorm, '/') === rtrim($reqPath, '/') || ($childPathNorm !== '/' && request()->is(trim($childPathNorm, '/')));
                                        @endphp
                                        <a href="{{ $childHref }}"
                                           @click="open = false"
                                           class="flex items-center px-4 py-2.5 text-sm transition-colors {{ $navChildActive ? 'bg-lime-50 text-lime-700 font-medium' : 'text-gray-700 hover:bg-gray-50' }}">
                                            {{ $child['label'] ?? '' }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ $resolveUrl($item['url'] ?? '#') }}"
                           class="{{ $headerOverlay ? 'text-white/85 hover:text-white' : 'text-gray-700 hover:text-lime-700' }} transition-colors py-1">
                            {{ $item['label'] ?? '' }}
                        </a>
                    @endif
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
                        {{ __('Book now: ') }}{{ $bookPhone }}
                    </a>
                @endif
                @if($facebookUrl || $instagramUrl)
                    <div class="flex items-center gap-4 lg:gap-5">
                        @if($facebookUrl)
                            <a href="{{ $facebookUrl }}" target="_blank" rel="noopener noreferrer"
                               class="{{ $headerOverlay ? 'text-white/90 hover:text-white' : 'text-gray-700 hover:text-lime-700' }} transition-colors"
                               aria-label="{{ __('Facebook') }}">
                                <i class="fa-brands fa-facebook-f text-lg lg:text-xl"></i>
                            </a>
                        @endif
                        @if($instagramUrl)
                            <a href="{{ $instagramUrl }}" target="_blank" rel="noopener noreferrer"
                               class="{{ $headerOverlay ? 'text-white/90 hover:text-white' : 'text-gray-700 hover:text-lime-700' }} transition-colors"
                               aria-label="{{ __('Instagram') }}">
                                <i class="fa-brands fa-instagram text-xl lg:text-2xl"></i>
                            </a>
                        @endif
                    </div>
                @endif
                @auth
                    <a href="{{ route('dashboard') }}"
                       class="{{ $headerOverlay ? 'text-white/90 hover:text-white' : 'text-gray-700 hover:text-lime-700' }} transition-colors inline-flex"
                       title="{{ __('My account') }}" aria-label="{{ __('My account') }}">
                        <x-icons.user-circled class="w-6 h-6 lg:w-[26px] lg:h-[26px] shrink-0" />
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="{{ $headerOverlay ? 'text-white/90 hover:text-white' : 'text-gray-700 hover:text-lime-700' }} transition-colors"
                       title="{{ __('Log in') }}" aria-label="{{ __('Log in') }}">
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
            <span class="text-sm font-medium text-gray-500">{{ __('Menu') }}</span>
            <button @click="mobileOpen = false" type="button" class="p-2 -mr-2 text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="flex-1 overflow-y-auto py-4">
            @foreach($navItems as $item)
                @if(($item['type'] ?? 'link') === 'dropdown' && !empty($item['children'] ?? []))
                    <div class="mb-1">
                        <p class="px-5 pt-2 pb-1 text-[11px] font-semibold uppercase tracking-wide text-gray-400">{{ $item['label'] ?? '' }}</p>
                        <div class="rounded-xl mx-3 border border-gray-100 bg-gray-50/80 overflow-hidden">
                            @foreach($item['children'] as $child)
                                <a href="{{ $resolveUrl($child['url'] ?? '') }}" @click="mobileOpen = false" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-white border-b border-gray-100/80 last:border-0">{{ $child['label'] ?? '' }}</a>
                            @endforeach
                        </div>
                    </div>
                @else
                    <a href="{{ $resolveUrl($item['url'] ?? '') }}" @click="mobileOpen = false" class="block px-5 py-2.5 text-sm text-gray-700 hover:bg-gray-50">{{ $item['label'] ?? '' }}</a>
                @endif
            @endforeach
        </div>
        <div class="flex-shrink-0 border-t border-gray-100 py-4">
            @if($facebookUrl || $instagramUrl)
                <div class="flex items-center gap-5 px-5 pb-3">
                    @if($facebookUrl)
                        <a href="{{ $facebookUrl }}" target="_blank" rel="noopener noreferrer" @click="mobileOpen = false" class="text-gray-700 hover:text-lime-700 transition-colors" aria-label="{{ __('Facebook') }}">
                            <i class="fa-brands fa-facebook-f text-xl"></i>
                        </a>
                    @endif
                    @if($instagramUrl)
                        <a href="{{ $instagramUrl }}" target="_blank" rel="noopener noreferrer" @click="mobileOpen = false" class="text-gray-700 hover:text-lime-700 transition-colors" aria-label="{{ __('Instagram') }}">
                            <i class="fa-brands fa-instagram text-2xl"></i>
                        </a>
                    @endif
                </div>
            @endif
            <div class="px-5 pb-3 flex items-center gap-4 border-b border-gray-100">
                @auth
                    <a href="{{ route('dashboard') }}" @click="mobileOpen = false" class="text-sm font-medium text-gray-800 hover:text-lime-700 transition-colors flex items-center gap-2">
                        <x-icons.user-circled class="w-[1.125rem] h-[1.125rem] shrink-0 text-gray-500" /> {{ __('My account') }}
                    </a>
                @else
                    <a href="{{ route('login') }}" @click="mobileOpen = false" class="text-sm font-medium text-gray-800 hover:text-lime-700 transition-colors">{{ __('Log in') }}</a>
                    @if(Route::has('register'))
                        <a href="{{ route('register') }}" @click="mobileOpen = false" class="text-sm font-medium text-lime-600 hover:text-lime-700 transition-colors">{{ __('Register') }}</a>
                    @endif
                @endauth
            </div>
            @auth
                <form method="POST" action="{{ route('logout') }}" class="px-5 pb-2">@csrf
                    <button type="submit" class="text-sm text-gray-500 hover:text-red-600 transition-colors">{{ __('Log out') }}</button>
                </form>
            @endauth
            <a href="{{ route('contact') }}" @click="mobileOpen = false" class="flex items-center gap-2 px-5 py-2.5 text-sm text-gray-700 hover:bg-gray-50"><i class="fa-solid fa-envelope text-gray-400 w-5"></i>{{ __('Contact') }}</a>
            @if($bookPhone)
                <a href="tel:{{ $bookPhoneTel }}" @click="mobileOpen = false" class="flex items-center gap-2 px-5 py-2.5 text-sm text-gray-700 hover:bg-gray-50"><i class="fa-solid fa-phone text-gray-400 w-5"></i>{{ $bookPhone }}</a>
            @endif
            @if($contactEmail = \App\Models\Setting::get('contact_email'))
                <a href="mailto:{{ $contactEmail }}" @click="mobileOpen = false" class="flex items-center gap-2 px-5 py-2.5 text-sm text-gray-700 hover:bg-gray-50 break-all"><i class="fa-solid fa-envelope text-gray-400 w-5 flex-shrink-0"></i>{{ $contactEmail }}</a>
            @endif
        </div>
    </div>
</header>
