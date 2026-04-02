@php
    $heroTitle = \App\Models\Setting::get('page_about_hero_title', 'Our Story');
    $heroImage = \App\Models\Setting::get('page_about_hero_image', '');
    $heroBg = $heroImage ? \Illuminate\Support\Facades\Storage::disk('public')->url($heroImage) : 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?w=1920&h=600&fit=crop';
    $introLabel = \App\Models\Setting::get('page_about_intro_label', 'Nice to meet you');
    $introTitle = \App\Models\Setting::get('page_about_intro_title', 'We started with a simple idea: share the Albania we love');
    $introContent = \App\Models\Setting::get('page_about_intro_content', '');
    $introImage = \App\Models\Setting::get('page_about_intro_image', '');
    $introImageUrl = $introImage ? \Illuminate\Support\Facades\Storage::disk('public')->url($introImage) : 'https://images.unsplash.com/photo-1528543606781-2f6e6857f318?w=700&h=500&fit=crop';
    $introBadgeTitle = \App\Models\Setting::get('page_about_intro_badge_title', 'Since day one');
    $introBadgeSubtitle = \App\Models\Setting::get('page_about_intro_badge_subtitle', 'Passionate about Albania');
    $valuesLabel = \App\Models\Setting::get('page_about_values_label', 'What matters to us');
    $valuesTitle = \App\Models\Setting::get('page_about_values_title', "We're not a big corporation. We're a small team that genuinely cares.");
    $values = \App\Models\Setting::get('page_about_values', '');
    $values = is_string($values) ? (json_decode($values, true) ?: []) : $values;
    if (empty($values)) {
        $values = [
            ['icon' => 'fa-heart', 'title' => 'Honesty over hype', 'description' => "We'll tell you honestly which tours are worth it and which spots are overhyped."],
            ['icon' => 'fa-people-group', 'title' => 'Small groups, real connections', 'description' => "We keep groups small on purpose. You're not a ticket number."],
            ['icon' => 'fa-seedling', 'title' => 'Respect the places we visit', 'description' => 'We work with local families and support the communities that make Albania special.'],
        ];
    }
    $quoteText = \App\Models\Setting::get('page_about_quote_text', '');
    $expectLabel = \App\Models\Setting::get('page_about_expect_label', 'What to expect');
    $expectTitle = \App\Models\Setting::get('page_about_expect_title', "When you book with us, here's what you get");
    $expectItems = \App\Models\Setting::get('page_about_expect_items', '');
    $expectItems = is_string($expectItems) ? (json_decode($expectItems, true) ?: []) : $expectItems;
    if (empty($expectItems)) {
        $expectItems = [
            ['title' => 'Guides who actually love this', 'description' => "Our guides aren't reading from a script. They're locals who are genuinely passionate."],
            ['title' => 'No surprise costs', 'description' => 'The price you see is the price you pay.'],
            ['title' => 'Flexibility when life happens', 'description' => 'Plans change, we get it. We make rescheduling as painless as possible.'],
            ['title' => 'A real person to talk to', 'description' => "Have a question? You'll reach a real person, not a chatbot."],
        ];
    }
    $expectImage1 = \App\Models\Setting::get('page_about_expect_image_1', '');
    $expectImage1Url = $expectImage1 ? \Illuminate\Support\Facades\Storage::disk('public')->url($expectImage1) : 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400&h=500&fit=crop';
    $expectImage2 = \App\Models\Setting::get('page_about_expect_image_2', '');
    $expectImage2Url = $expectImage2 ? \Illuminate\Support\Facades\Storage::disk('public')->url($expectImage2) : 'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?w=400&h=500&fit=crop';
    $siteName = \App\Models\Setting::get('site_name', config('app.name'));
@endphp
@extends('layouts.site')

@section('title', \App\Models\Setting::get('page_about_seo_title') ?: ('About Us - ' . config('app.name')))
@section('description', \App\Models\Setting::get('page_about_seo_description') ?: 'The story behind our tours, our team, and why we love sharing Albania with you.')
@if(\App\Models\Setting::get('page_about_seo_og_image'))@section('og_image', \App\Models\Setting::get('page_about_seo_og_image'))@endif

@section('content')
{{-- Hero: full-viewport split --}}
<div class="relative w-full bg-white overflow-hidden" style="min-height: 600px;">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 h-full">
        <div class="grid grid-cols-1 lg:grid-cols-2 h-full" style="min-height: 600px;">
            {{-- Left: text --}}
            <div class="flex flex-col justify-center py-16 lg:py-24 lg:pr-16">
                <nav class="text-sm mb-8" aria-label="Breadcrumb">
                    <ol class="flex items-center gap-1.5">
                        <li><a href="{{ route('home') }}" class="text-[#111827]/40 hover:text-[#111827] transition">Home</a></li>
                        <li class="text-[#111827]/25">/</li>
                        <li class="text-[#111827]/70">About us</li>
                    </ol>
                </nav>
                <p class="text-[12px] font-semibold uppercase tracking-[0.3em] text-[#111827]/35 mb-5">Est. {{ date('Y') }}</p>
                <h1 class="text-5xl md:text-[68px] font-serif text-[#111827] tracking-tight leading-[1.02] mb-6">{{ $heroTitle }}</h1>
                <p class="text-lg text-[#6a6a6a] leading-relaxed max-w-md">Crafting unforgettable journeys across Albania with passion, local expertise, and meticulous attention to detail.</p>
                <div class="flex items-center gap-6 mt-10">
                    <a href="#our-story" class="inline-flex items-center gap-2.5 text-sm font-semibold text-[#111827] uppercase tracking-wider hover:text-[#111827]/70 transition">
                        <span class="w-8 h-[1.5px] bg-[#111827]"></span>
                        Our story
                    </a>
                    <a href="{{ route('tours.index') }}" class="inline-flex items-center gap-2.5 text-sm font-semibold text-[#111827]/40 uppercase tracking-wider hover:text-[#111827] transition">
                        <span class="w-8 h-[1.5px] bg-[#111827]/25"></span>
                        View tours
                    </a>
                </div>
            </div>
            {{-- Right: image --}}
            <div class="relative hidden lg:block">
                <div class="absolute inset-0 -right-[100vw] bg-cover bg-center" style="background-image: url('{{ $heroBg }}');"></div>
                <div class="absolute inset-y-0 left-0 w-24 bg-gradient-to-r from-white to-transparent z-10"></div>
            </div>
        </div>
    </div>
    {{-- Mobile image --}}
    <div class="lg:hidden w-full h-[300px] bg-cover bg-center" style="background-image: url('{{ $heroBg }}');"></div>
</div>

{{-- Our story --}}
@if($introTitle || $introContent || $introImage)
<section id="our-story" class="py-20 md:py-32 bg-[#f8f6f2]">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">
            <div class="order-2 lg:order-1">
                @if($introLabel)
                    <p class="text-[12px] font-semibold uppercase tracking-[0.3em] text-[#111827]/35 mb-5">{{ $introLabel }}</p>
                @endif
                @if($introTitle)
                    <h2 class="text-3xl md:text-[44px] font-serif text-[#111827] leading-[1.08] mb-8">{{ $introTitle }}</h2>
                @endif
                @if($introContent)
                    <div class="space-y-5 text-[16px] text-[#5a5a5a] leading-[1.85]">
                        @foreach(explode("\n\n", $introContent) as $para)
                            @if(trim($para))
                                <p>{{ $para }}</p>
                            @endif
                        @endforeach
                    </div>
                @endif
                @if($introBadgeTitle)
                <div class="mt-10 flex items-center gap-4">
                    <div class="w-14 h-14 border-2 border-[#111827] flex items-center justify-center">
                        <i class="fa-solid fa-mountain-sun text-[#111827] text-lg"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-[#111827]">{{ $introBadgeTitle }}</p>
                        @if($introBadgeSubtitle)<p class="text-[13px] text-[#6a6a6a]">{{ $introBadgeSubtitle }}</p>@endif
                    </div>
                </div>
                @endif
            </div>
            <div class="order-1 lg:order-2 relative">
                <div class="relative z-10">
                    <img src="{{ $introImageUrl }}" alt="Our team" class="w-full object-cover shadow-xl" style="aspect-ratio: 4/5;">
                </div>
                <div class="absolute -bottom-6 -left-6 w-2/3 h-2/3 border-2 border-[#111827]/10 hidden lg:block"></div>
            </div>
        </div>
    </div>
</section>
@endif

{{-- Values: horizontal card ticker --}}
@if(!empty($values))
<section class="py-20 md:py-28 bg-white">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row lg:items-start gap-12 lg:gap-20">
            {{-- Left header --}}
            <div class="lg:w-[380px] flex-shrink-0 lg:sticky lg:top-32">
                @if($valuesLabel)
                    <p class="text-[12px] font-semibold uppercase tracking-[0.3em] text-[#111827]/35 mb-5">{{ $valuesLabel }}</p>
                @endif
                @if($valuesTitle)
                    <h2 class="text-3xl md:text-[38px] font-serif text-[#111827] leading-[1.1]">{{ $valuesTitle }}</h2>
                @endif
                <div class="w-12 h-[2px] bg-[#111827] mt-7"></div>
            </div>
            {{-- Right: value cards --}}
            <div class="flex-1 grid grid-cols-1 gap-0 divide-y divide-[#e8e4de]">
                @foreach($values as $i => $val)
                <div class="flex items-start gap-6 py-8 first:pt-0 last:pb-0 group">
                    <span class="text-[56px] font-serif text-[#111827]/[0.06] leading-none flex-shrink-0 -mt-2 select-none">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    <div class="min-w-0">
                        @if(!empty($val['icon']))
                            <i class="fa-solid {{ $val['icon'] }} text-[#111827]/30 text-lg mb-3 block group-hover:text-[#111827] transition-colors"></i>
                        @endif
                        @if(!empty($val['title']))
                            <h3 class="text-xl font-serif text-[#111827] mb-2">{{ $val['title'] }}</h3>
                        @endif
                        @if(!empty($val['description']))
                            <p class="text-[15px] text-[#6a6a6a] leading-relaxed max-w-md">{{ $val['description'] }}</p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

{{-- Full-width image divider with quote --}}
@if($quoteText)
<section class="relative h-[400px] md:h-[480px] overflow-hidden">
    <div class="absolute inset-0 bg-cover bg-center bg-fixed" style="background-image: url('{{ $heroBg }}');"></div>
    <div class="absolute inset-0 bg-[#111827]/70"></div>
    <div class="relative h-full flex items-center justify-center px-4">
        <div class="text-center max-w-3xl">
            <div class="inline-flex items-center justify-center w-14 h-14 border border-white/20 mb-8">
                <i class="fa-solid fa-quote-left text-white/50 text-xl"></i>
            </div>
            <blockquote class="text-2xl md:text-[36px] font-serif text-white leading-[1.25] mb-6">
                &ldquo;{{ $quoteText }}&rdquo;
            </blockquote>
            <div class="flex items-center justify-center gap-3">
                <span class="w-5 h-[1.5px] bg-white/30"></span>
                <p class="text-[13px] text-white/50 tracking-[0.2em] uppercase">{{ $siteName }}</p>
                <span class="w-5 h-[1.5px] bg-white/30"></span>
            </div>
        </div>
    </div>
</section>
@endif

{{-- What to expect --}}
@if(!empty($expectItems) || $expectTitle)
<section class="py-20 md:py-28 bg-white">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-16">
            @if($expectLabel)
                <p class="text-[12px] font-semibold uppercase tracking-[0.3em] text-[#111827]/35 mb-5">{{ $expectLabel }}</p>
            @endif
            @if($expectTitle)
                <h2 class="text-3xl md:text-[44px] font-serif text-[#111827] leading-[1.08]">{{ $expectTitle }}</h2>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-16">
            {{-- Tall image --}}
            <div class="lg:row-span-2 overflow-hidden">
                <img src="{{ $expectImage1Url }}" alt="Destination" class="w-full h-full object-cover" style="min-height: 420px; aspect-ratio: 3/4;">
            </div>
            {{-- 4 items in 2x2 --}}
            @foreach($expectItems as $i => $item)
            <div class="bg-[#f8f6f2] p-8 flex flex-col justify-between group" style="min-height: 200px;">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <span class="w-9 h-9 bg-[#111827] text-white text-xs font-bold flex items-center justify-center">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        @if(!empty($item['title']))
                            <h4 class="text-[17px] font-semibold text-[#111827]">{{ $item['title'] }}</h4>
                        @endif
                    </div>
                    @if(!empty($item['description']))
                        <p class="text-[15px] text-[#6a6a6a] leading-relaxed">{{ $item['description'] }}</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Stats ribbon --}}
<div class="bg-[#111827] py-14">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div>
                <p class="text-4xl md:text-5xl font-serif text-white mb-1">500+</p>
                <p class="text-[13px] text-white/40 uppercase tracking-wider">Happy Travellers</p>
            </div>
            <div>
                <p class="text-4xl md:text-5xl font-serif text-white mb-1">50+</p>
                <p class="text-[13px] text-white/40 uppercase tracking-wider">Curated Tours</p>
            </div>
            <div>
                <p class="text-4xl md:text-5xl font-serif text-white mb-1">12</p>
                <p class="text-[13px] text-white/40 uppercase tracking-wider">Destinations</p>
            </div>
            <div>
                <p class="text-4xl md:text-5xl font-serif text-white mb-1">4.9</p>
                <p class="text-[13px] text-white/40 uppercase tracking-wider">Average Rating</p>
            </div>
        </div>
    </div>
</div>

{{-- CTA --}}
<section class="py-24 md:py-32 bg-[#f8f6f2]">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <p class="text-[12px] font-semibold uppercase tracking-[0.3em] text-[#111827]/35 mb-5">Your next chapter</p>
                <h2 class="text-3xl md:text-[48px] font-serif text-[#111827] leading-[1.05] mb-5">Ready to explore with us?</h2>
                <p class="text-[16px] text-[#6a6a6a] leading-relaxed max-w-lg mb-8">Every journey we craft is built around you. Tell us your dream and let's make it real.</p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('tours.index') }}" class="inline-flex items-center px-9 py-4 bg-[#111827] text-white text-sm font-semibold uppercase tracking-wider hover:bg-[#1f2937] transition-colors">
                        Browse tours
                    </a>
                    <a href="{{ route('contact') }}" class="inline-flex items-center px-9 py-4 border-2 border-[#111827] text-[#111827] text-sm font-semibold uppercase tracking-wider hover:bg-[#111827] hover:text-white transition-all">
                        Get in touch
                    </a>
                </div>
            </div>
            <div class="relative hidden lg:block">
                <img src="{{ $expectImage2Url }}" alt="Explore" class="w-full object-cover shadow-xl" style="aspect-ratio: 16/10;">
                <div class="absolute -top-5 -right-5 w-1/2 h-1/2 border-2 border-[#111827]/10"></div>
            </div>
        </div>
    </div>
</section>
@endsection
