@php
    $headerPhone = \App\Models\Setting::get('contact_phone', '');
    $headerPhoneTel = preg_replace('/[^0-9+]/', '', $headerPhone) ?: '';
    $navItems = \App\Models\Setting::get('nav_menu_items', '');
    $navItems = is_string($navItems) ? (json_decode($navItems, true) ?: []) : $navItems;
    if (empty($navItems)) {
        $navItems = [
            ['type' => 'dropdown', 'label' => 'Destinations', 'children' => [['label' => 'All Destinations', 'url' => '/countries']]],
            ['type' => 'dropdown', 'label' => 'Travel Collections', 'children' => [
                ['label' => 'All Tours', 'url' => '/tours'],
                ['label' => 'Popular Tours', 'url' => '/tours?sort=popular'],
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
    $isActive = function ($url) use ($resolveUrl) {
        $path = parse_url($resolveUrl($url), PHP_URL_PATH);
        $path = trim($path ?? '', '/');
        if ($path === '') {
            return request()->path() === '';
        }
        return request()->is($path, $path . '/*');
    };
    $isDropdownActive = function ($children) use ($isActive) {
        foreach ($children ?? [] as $child) {
            if ($isActive($child['url'] ?? '')) {
                return true;
            }
        }
        return false;
    };
@endphp
<header class="z-50 overflow-visible bg-white border-b border-gray-200" x-data="{ mobileOpen: false }">
    <nav class="overflow-visible bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-14">

                {{-- Logo --}}
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 text-lg font-black uppercase tracking-widest text-lime-800 hover:text-lime-600 transition-colors">
                        @if($siteLogo = \App\Models\Setting::get('site_logo'))
                            <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($siteLogo) }}" alt="{{ \App\Models\Setting::get('site_name', config('app.name')) }}" class="h-[2.5rem] w-auto object-contain" />
                        @else
                            {{ \App\Models\Setting::get('site_name', config('app.name')) }}
                        @endif
                    </a>
                </div>

                {{-- Desktop Nav Links (dynamic from Settings) --}}
                <div class="hidden lg:flex lg:items-center lg:gap-0.5">
                    @foreach($navItems as $item)
                        @if(($item['type'] ?? 'link') === 'dropdown' && !empty($item['children'] ?? []))
                            @php $dropdownActive = $isDropdownActive($item['children'] ?? []); @endphp
                            <div x-data="{ open: false }" class="relative" @mouseenter="open = true" @mouseleave="open = false">
                                <button class="inline-flex items-center gap-1 px-3 py-2 text-sm font-medium transition-colors cursor-pointer {{ $dropdownActive ? 'text-brand-btn font-semibold' : 'text-gray-700 hover:text-lime-600' }}">
                                    {{ $item['label'] ?? '' }}
                                    <svg class="w-3 h-3 text-gray-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                </button>
                                <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="absolute top-full left-0 pt-1 -mt-1 w-56 z-50">
                                    <div class="bg-white rounded-md shadow-lg border border-gray-100 py-1.5">
                                        @foreach($item['children'] as $child)
                                            @php $childActive = $isActive($child['url'] ?? ''); @endphp
                                            <a href="{{ $resolveUrl($child['url'] ?? '') }}" class="block px-4 py-2 text-sm transition-colors {{ $childActive ? 'text-brand-btn font-semibold bg-brand-btn/5' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">{{ $child['label'] ?? '' }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @else
                            @php $linkActive = $isActive($item['url'] ?? ''); @endphp
                            <a href="{{ $resolveUrl($item['url'] ?? '') }}" class="px-3 py-2 text-sm font-medium transition-colors {{ $linkActive ? 'text-brand-btn font-semibold' : 'text-gray-700 hover:text-lime-600' }}">{{ $item['label'] ?? '' }}</a>
                        @endif
                    @endforeach
                </div>

                {{-- Right Side: Phone, Contact, User --}}
                @php
                    $headerPhone = \App\Models\Setting::get('contact_phone', '');
                    $headerPhoneTel = preg_replace('/[^0-9+]/', '', $headerPhone) ?: '';
                @endphp
                <div class="hidden lg:flex lg:items-center lg:gap-4">

                    {{-- Phone (direct call link, no dropdown) --}}
                    @if($headerPhone)
                        <a href="tel:{{ $headerPhoneTel }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-700 hover:text-lime-600 transition-colors">
                            <svg class="w-4 h-4 text-gray-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                            {{ $headerPhone }}
                        </a>
                        <span class="w-px h-4 bg-gray-200"></span>
                    @endif

                    {{-- Contact us --}}
                    <a href="{{ route('contact') }}" class="inline-flex items-center gap-1.5 text-sm font-medium transition-colors {{ $isActive(route('contact')) ? 'text-brand-btn font-semibold' : 'text-gray-700 hover:text-lime-600' }}">
                    <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>    
                    Contact us
                    </a>

                    {{-- Spacing + User icon --}}
                    <div class="ml-4 pl-3">
                        @auth
                            <a href="{{ route('dashboard') }}" class="flex items-center justify-center w-9 h-9 rounded-full transition-colors {{ $isActive(route('dashboard')) ? 'bg-brand-btn/15 text-brand-btn' : 'bg-lime-50 text-lime-700 hover:bg-lime-100 hover:text-lime-800' }}" title="My Dashboard">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="flex items-center justify-center w-9 h-9 rounded-full bg-lime-50 text-lime-700 hover:bg-lime-100 hover:text-lime-800 transition-colors" title="Login">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </a>
                        @endauth
                    </div>

                </div>

                {{-- Mobile hamburger --}}
                <div class="flex items-center lg:hidden">
                    <button @click="mobileOpen = !mobileOpen" type="button" class="p-2 rounded-md text-gray-500 hover:bg-gray-100 transition-colors">
                        <svg x-show="!mobileOpen" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        <svg x-show="mobileOpen" x-cloak class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

            </div>
        </div>

        {{-- Mobile Side Panel Overlay --}}
        <div x-show="mobileOpen" x-cloak x-transition
             @click="mobileOpen = false"
             class="lg:hidden fixed inset-0 z-[9998] bg-black/30"
             aria-hidden="true"></div>

        {{-- Mobile Side Panel --}}
        <div x-show="mobileOpen" x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="lg:hidden fixed top-0 right-0 bottom-0 z-[9999] w-72 max-w-[85vw] bg-white shadow-xl flex flex-col">
            <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100">
                <span class="text-sm font-medium text-gray-600">Menu</span>
                <button @click="mobileOpen = false" type="button" class="p-2 -mr-2 text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto py-4">
                {{-- Nav links (dynamic from Settings) --}}
                @foreach($navItems as $item)
                    @if(($item['type'] ?? 'link') === 'dropdown' && !empty($item['children'] ?? []))
                        @foreach($item['children'] as $child)
                            @php $childActive = $isActive($child['url'] ?? ''); @endphp
                            <a href="{{ $resolveUrl($child['url'] ?? '') }}" @click="mobileOpen = false" class="block px-4 py-2.5 transition-colors {{ $childActive ? 'text-brand-btn font-semibold bg-brand-btn/5' : 'text-gray-700 hover:bg-gray-50 hover:text-lime-600' }}">{{ $child['label'] ?? '' }}</a>
                        @endforeach
                    @else
                        @php $linkActive = $isActive($item['url'] ?? ''); @endphp
                        <a href="{{ $resolveUrl($item['url'] ?? '') }}" @click="mobileOpen = false" class="block px-4 py-2.5 transition-colors {{ $linkActive ? 'text-brand-btn font-semibold bg-brand-btn/5' : 'text-gray-700 hover:bg-gray-50 hover:text-lime-600' }}">{{ $item['label'] ?? '' }}</a>
                    @endif
                @endforeach

                @auth
                    <div class="mt-2 pt-2 border-t border-gray-100">
                        <form method="POST" action="{{ route('logout') }}">@csrf
                            <button type="submit" class="flex items-center gap-2 w-full px-4 py-2.5 text-left text-gray-500 hover:bg-gray-50 hover:text-red-600">
                                <i class="fa-solid fa-right-from-bracket text-gray-400 w-5"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                @endauth
            </div>

            {{-- Bottom: Account + Contact --}}
            <div class="flex-shrink-0 border-t border-gray-100 py-4">
                @auth
                    <a href="{{ route('dashboard') }}" @click="mobileOpen = false" class="flex items-center gap-2 px-4 py-2.5 transition-colors {{ $isActive(route('dashboard')) ? 'text-brand-btn font-semibold bg-brand-btn/5' : 'text-gray-700 hover:bg-gray-50 hover:text-lime-600' }}">
                        <i class="fa-solid fa-user text-gray-400 w-5"></i>
                        My Account
                    </a>
                @else
                    <a href="{{ route('login') }}" @click="mobileOpen = false" class="flex items-center gap-2 px-4 py-2.5 text-gray-700 hover:bg-gray-50 hover:text-lime-600">
                        <i class="fa-solid fa-user text-gray-400 w-5"></i>
                        Sign in
                    </a>
                @endauth
                <a href="{{ route('contact') }}" @click="mobileOpen = false" class="flex items-center gap-2 px-4 py-2.5 transition-colors {{ $isActive(route('contact')) ? 'text-brand-btn font-semibold bg-brand-btn/5' : 'text-gray-700 hover:bg-gray-50 hover:text-lime-600' }}">
                    <i class="fa-solid fa-envelope text-gray-400 w-5"></i>
                    Contact us
                </a>
                @if($headerPhone ?? false)
                    <a href="tel:{{ $headerPhoneTel ?? '' }}" @click="mobileOpen = false" class="flex items-center gap-2 px-4 py-2.5 text-gray-700 hover:bg-gray-50 hover:text-lime-600">
                        <i class="fa-solid fa-phone text-gray-400 w-5"></i>
                        {{ $headerPhone }}
                    </a>
                @endif
                @if($contactEmail = \App\Models\Setting::get('contact_email'))
                    <a href="mailto:{{ $contactEmail }}" @click="mobileOpen = false" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-lime-600 break-all">
                        <i class="fa-solid fa-envelope text-gray-400 w-5 flex-shrink-0"></i>
                        {{ $contactEmail }}
                    </a>
                @endif
            </div>
        </div>

    </nav>
</header>
