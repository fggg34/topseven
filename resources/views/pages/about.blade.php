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
{{-- Full-screen hero --}}
<div class="relative w-full overflow-hidden bg-[#111827]" style="height: 520px;">
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ $heroBg }}'); opacity: 0.4;"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-[#111827] via-[#111827]/40 to-transparent"></div>
    <div class="absolute inset-0 flex flex-col justify-center">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <nav class="text-sm mb-6" aria-label="Breadcrumb">
                <ol class="flex items-center gap-1.5">
                    <li><a href="{{ route('home') }}" class="text-white/50 hover:text-white transition">Home</a></li>
                    <li class="text-white/30">/</li>
                    <li class="text-white/80">About us</li>
                </ol>
            </nav>
            <p class="text-[13px] font-semibold uppercase tracking-[0.25em] text-white/50 mb-4">Who we are</p>
            <h1 class="text-5xl md:text-7xl font-serif text-white tracking-tight leading-[1.05]">{{ $heroTitle }}</h1>
            <div class="w-16 h-[2px] bg-white/40 mt-6"></div>
        </div>
    </div>
</div>

{{-- Intro section --}}
@if($introTitle || $introContent || $introImage)
<section class="relative">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-0 items-stretch">
            {{-- Image side --}}
            <div class="lg:col-span-5 relative -mt-20 lg:-mt-24 z-10">
                <div class="overflow-hidden shadow-2xl">
                    <img src="{{ $introImageUrl }}" alt="Our team" class="w-full object-cover" style="aspect-ratio: 5/6; min-height: 450px;">
                </div>
                @if($introBadgeTitle || $introBadgeSubtitle)
                <div class="absolute bottom-6 right-6 bg-[#111827] text-white px-6 py-4 shadow-xl">
                    @if($introBadgeTitle)<p class="text-sm font-semibold">{{ $introBadgeTitle }}</p>@endif
                    @if($introBadgeSubtitle)<p class="text-xs text-white/60 mt-0.5">{{ $introBadgeSubtitle }}</p>@endif
                </div>
                @endif
            </div>
            {{-- Text side --}}
            <div class="lg:col-span-7 flex items-center">
                <div class="py-16 md:py-24 lg:pl-16 xl:pl-24">
                    @if($introLabel)
                        <p class="text-[13px] font-semibold uppercase tracking-[0.25em] text-[#111827]/40 mb-4">{{ $introLabel }}</p>
                    @endif
                    @if($introTitle)
                        <h2 class="text-3xl md:text-[40px] font-serif text-[#111827] leading-[1.12] mb-8">{{ $introTitle }}</h2>
                    @endif
                    @if($introContent)
                        <div class="space-y-5 text-[16px] text-[#5a5a5a] leading-[1.8]">
                            @foreach(explode("\n\n", $introContent) as $para)
                                @if(trim($para))
                                    <p>{{ $para }}</p>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endif

{{-- Values --}}
@if(!empty($values))
<section class="py-20 md:py-28 bg-[#111827]">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mb-14">
            @if($valuesLabel)
                <p class="text-[13px] font-semibold uppercase tracking-[0.25em] text-white/40 mb-4">{{ $valuesLabel }}</p>
            @endif
            @if($valuesTitle)
                <h2 class="text-3xl md:text-[40px] font-serif text-white leading-[1.12]">{{ $valuesTitle }}</h2>
            @endif
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-px bg-white/10">
            @foreach($values as $val)
            <div class="bg-[#111827] p-10 group hover:bg-[#1a2332] transition-colors">
                @if(!empty($val['icon']))
                <div class="w-12 h-12 border border-white/20 flex items-center justify-center mb-7 group-hover:border-white/40 transition-colors">
                    <i class="fa-solid {{ $val['icon'] }} text-white/70 text-lg"></i>
                </div>
                @endif
                @if(!empty($val['title']))
                    <h3 class="text-xl font-serif text-white mb-3">{{ $val['title'] }}</h3>
                @endif
                @if(!empty($val['description']))
                    <p class="text-[15px] text-white/55 leading-relaxed">{{ $val['description'] }}</p>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Quote --}}
@if($quoteText)
<section class="relative py-24 md:py-32 overflow-hidden">
    <div class="absolute inset-0 bg-cover bg-center opacity-10" style="background-image: url('{{ $heroBg }}');"></div>
    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <i class="fa-solid fa-quote-left text-[#111827]/10 text-6xl mb-6"></i>
        <blockquote class="text-2xl md:text-[34px] font-serif text-[#111827] leading-[1.3] mb-8">
            &ldquo;{{ $quoteText }}&rdquo;
        </blockquote>
        <div class="w-10 h-[2px] bg-[#111827]/20 mx-auto mb-4"></div>
        <p class="text-sm text-[#111827]/50 tracking-[0.2em] uppercase">The {{ $siteName }} team</p>
    </div>
</section>
@endif

{{-- What to expect --}}
@if(!empty($expectItems) || $expectTitle)
<section class="py-20 md:py-28 bg-[#f8f6f2]">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-14 lg:gap-20 items-start">
            {{-- Images --}}
            <div class="relative">
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-7 overflow-hidden shadow-lg">
                        <img src="{{ $expectImage1Url }}" alt="Destination" class="w-full object-cover" style="aspect-ratio: 3/4;">
                    </div>
                    <div class="col-span-5 mt-16 overflow-hidden shadow-lg">
                        <img src="{{ $expectImage2Url }}" alt="Experience" class="w-full object-cover" style="aspect-ratio: 3/4;">
                    </div>
                </div>
                <div class="absolute -bottom-4 left-8 bg-[#111827] text-white px-6 py-3 shadow-xl hidden lg:block">
                    <p class="text-sm font-semibold tracking-wider uppercase">{{ count($expectItems) }} Promises We Keep</p>
                </div>
            </div>
            {{-- Content --}}
            <div class="lg:pt-4">
                @if($expectLabel)
                    <p class="text-[13px] font-semibold uppercase tracking-[0.25em] text-[#111827]/40 mb-4">{{ $expectLabel }}</p>
                @endif
                @if($expectTitle)
                    <h2 class="text-3xl md:text-[40px] font-serif text-[#111827] leading-[1.12] mb-10">{{ $expectTitle }}</h2>
                @endif
                @if(!empty($expectItems))
                <div class="space-y-0 divide-y divide-[#e6e1d8]">
                    @foreach($expectItems as $i => $item)
                    <div class="flex items-start gap-5 py-6 first:pt-0">
                        <span class="text-[32px] font-serif text-[#111827]/15 leading-none flex-shrink-0 w-10 text-right">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        <div class="min-w-0">
                            @if(!empty($item['title']))
                                <h4 class="text-lg font-semibold text-[#111827] mb-1">{{ $item['title'] }}</h4>
                            @endif
                            @if(!empty($item['description']))
                                <p class="text-[15px] text-[#6a6a6a] leading-relaxed">{{ $item['description'] }}</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endif

{{-- CTA --}}
<section class="relative py-20 md:py-24 bg-[#111827] overflow-hidden">
    <div class="absolute inset-0 bg-cover bg-center opacity-15" style="background-image: url('{{ $heroBg }}');"></div>
    <div class="relative max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-[42px] font-serif text-white leading-[1.12] mb-4">Ready to explore with us?</h2>
        <p class="text-white/55 text-lg mb-8 max-w-xl mx-auto">Let us craft your perfect journey. Browse our curated collection of tours and experiences.</p>
        <a href="{{ route('tours.index') }}" class="inline-flex items-center px-10 py-4 border-2 border-white text-white text-sm font-semibold uppercase tracking-wider hover:bg-white hover:text-[#111827] transition-all">
            Browse our tours
        </a>
    </div>
</section>
@endsection
