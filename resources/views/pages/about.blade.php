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

{{-- Minimal text hero --}}
<section class="bg-white">
    <div class="max-w-[900px] mx-auto px-4 sm:px-6 lg:px-8 pt-12 pb-16 md:pt-16 md:pb-20 text-center">
        <nav class="text-[13px] mb-10" aria-label="Breadcrumb">
            <ol class="flex items-center justify-center gap-1.5 text-[#111827]/35">
                <li><a href="{{ route('home') }}" class="hover:text-[#111827] transition">Home</a></li>
                <li>/</li>
                <li class="text-[#111827]/60">About</li>
            </ol>
        </nav>
        <h1 class="text-5xl md:text-[72px] font-serif text-[#111827] tracking-tight leading-[1]">{{ $heroTitle }}</h1>
        <div class="w-10 h-[1px] bg-[#111827]/20 mx-auto mt-8 mb-8"></div>
        <p class="text-lg md:text-xl text-[#777] leading-relaxed max-w-xl mx-auto">Crafting unforgettable journeys with passion, local expertise, and attention to every detail.</p>
    </div>
</section>

{{-- Full-bleed image --}}
<div class="w-full">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="w-full overflow-hidden">
            <img src="{{ $heroBg }}" alt="{{ $heroTitle }}" class="w-full object-cover" style="aspect-ratio: 21/9; max-height: 520px;">
        </div>
    </div>
</div>

{{-- Story --}}
@if($introTitle || $introContent)
<section class="py-20 md:py-28">
    <div class="max-w-[900px] mx-auto px-4 sm:px-6 lg:px-8">
        @if($introLabel)
            <p class="text-[11px] font-semibold uppercase tracking-[0.3em] text-[#111827]/30 mb-6 text-center">{{ $introLabel }}</p>
        @endif
        @if($introTitle)
            <h2 class="text-2xl md:text-[36px] font-serif text-[#111827] leading-[1.2] text-center mb-10">{{ $introTitle }}</h2>
        @endif
        @if($introContent)
            <div class="columns-1 md:columns-2 gap-10 text-[15px] text-[#555] leading-[1.9]">
                @foreach(explode("\n\n", $introContent) as $para)
                    @if(trim($para))
                        <p class="mb-5">{{ $para }}</p>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
</section>
@endif

{{-- Two images side by side --}}
@if($introImage || $expectImage1)
<div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 pb-20 md:pb-28">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="overflow-hidden">
            <img src="{{ $introImageUrl }}" alt="Our team" class="w-full object-cover" style="aspect-ratio: 4/3;">
        </div>
        <div class="overflow-hidden">
            <img src="{{ $expectImage1Url }}" alt="Our destinations" class="w-full object-cover" style="aspect-ratio: 4/3;">
        </div>
    </div>
    @if($introBadgeTitle)
    <div class="mt-6 text-center">
        <p class="text-[13px] text-[#111827]/40 tracking-wider">{{ $introBadgeTitle }} &mdash; {{ $introBadgeSubtitle }}</p>
    </div>
    @endif
</div>
@endif

{{-- Values --}}
@if(!empty($values))
<section class="py-20 md:py-28 border-t border-[#eee]">
    <div class="max-w-[900px] mx-auto px-4 sm:px-6 lg:px-8 text-center mb-14">
        @if($valuesLabel)
            <p class="text-[11px] font-semibold uppercase tracking-[0.3em] text-[#111827]/30 mb-6">{{ $valuesLabel }}</p>
        @endif
        @if($valuesTitle)
            <h2 class="text-2xl md:text-[36px] font-serif text-[#111827] leading-[1.2]">{{ $valuesTitle }}</h2>
        @endif
    </div>
    <div class="max-w-[1100px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 md:gap-16 text-center">
            @foreach($values as $val)
            <div>
                @if(!empty($val['icon']))
                    <i class="fa-solid {{ $val['icon'] }} text-[#111827]/20 text-2xl mb-5"></i>
                @endif
                @if(!empty($val['title']))
                    <h3 class="text-[17px] font-semibold text-[#111827] mb-2">{{ $val['title'] }}</h3>
                @endif
                @if(!empty($val['description']))
                    <p class="text-[14px] text-[#888] leading-relaxed">{{ $val['description'] }}</p>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Quote --}}
@if($quoteText)
<section class="border-t border-[#eee] py-20 md:py-28">
    <div class="max-w-[800px] mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <blockquote class="text-2xl md:text-[32px] font-serif text-[#111827] leading-[1.35] italic">
            &ldquo;{{ $quoteText }}&rdquo;
        </blockquote>
        <p class="mt-6 text-[13px] text-[#111827]/35 tracking-[0.2em] uppercase">{{ $siteName }}</p>
    </div>
</section>
@endif

{{-- Promises --}}
@if(!empty($expectItems))
<section class="py-20 md:py-28 bg-[#f9f8f6] border-t border-[#eee]">
    <div class="max-w-[900px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            @if($expectLabel)
                <p class="text-[11px] font-semibold uppercase tracking-[0.3em] text-[#111827]/30 mb-6">{{ $expectLabel }}</p>
            @endif
            @if($expectTitle)
                <h2 class="text-2xl md:text-[36px] font-serif text-[#111827] leading-[1.2]">{{ $expectTitle }}</h2>
            @endif
        </div>
        <div class="space-y-0">
            @foreach($expectItems as $i => $item)
            <div class="flex items-baseline gap-6 py-7 border-b border-[#e4e0da] first:border-t">
                <span class="text-[13px] font-semibold text-[#111827]/25 flex-shrink-0 w-6 text-right tabular-nums">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                <div class="min-w-0 flex-1">
                    @if(!empty($item['title']))
                        <h4 class="text-[16px] font-semibold text-[#111827]">{{ $item['title'] }}</h4>
                    @endif
                    @if(!empty($item['description']))
                        <p class="text-[14px] text-[#888] leading-relaxed mt-1">{{ $item['description'] }}</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- CTA --}}
<section class="py-20 md:py-28 border-t border-[#eee]">
    <div class="max-w-[700px] mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-2xl md:text-[36px] font-serif text-[#111827] leading-[1.2] mb-4">Ready to explore?</h2>
        <p class="text-[15px] text-[#888] leading-relaxed mb-8">Browse our curated collection or get in touch to plan your perfect trip.</p>
        <div class="flex flex-wrap justify-center gap-3">
            <a href="{{ route('tours.index') }}" class="px-8 py-3.5 bg-[#111827] text-white text-[13px] font-semibold uppercase tracking-wider hover:bg-[#222] transition-colors">
                View tours
            </a>
            <a href="{{ route('contact') }}" class="px-8 py-3.5 border border-[#ccc] text-[#111827] text-[13px] font-semibold uppercase tracking-wider hover:border-[#111827] transition-colors">
                Contact us
            </a>
        </div>
    </div>
</section>

@endsection
