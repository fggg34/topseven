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
<div class="relative w-full overflow-hidden bg-[#111827]" style="height: 420px;">
    <div class="absolute inset-0 bg-cover bg-center opacity-50" style="background-image: url('{{ $heroBg }}');"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-[#111827]/80 via-transparent to-[#111827]/40"></div>
    <div class="absolute inset-0 flex items-end">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 w-full pb-12">
            <nav class="text-sm mb-4" aria-label="Breadcrumb">
                <ol class="flex items-center gap-1.5">
                    <li><a href="{{ route('home') }}" class="text-white/60 hover:text-white transition">Home</a></li>
                    <li class="text-white/40">/</li>
                    <li class="text-white">About us</li>
                </ol>
            </nav>
            <h1 class="text-4xl md:text-6xl font-serif text-white tracking-tight">{{ $heroTitle }}</h1>
            <p class="mt-3 text-lg text-white/70 max-w-xl">Crafting unforgettable journeys with passion, expertise, and attention to every detail.</p>
        </div>
    </div>
</div>

@if($introTitle || $introContent || $introImage)
<section class="py-20 md:py-28">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-14 lg:gap-24 items-center">
            <div>
                @if($introLabel)
                    <p class="text-[13px] font-semibold uppercase tracking-[0.2em] text-[#111827]/50 mb-4">{{ $introLabel }}</p>
                @endif
                @if($introTitle)
                    <h2 class="text-3xl md:text-[42px] font-serif text-[#111827] leading-[1.1] mb-7">{{ $introTitle }}</h2>
                @endif
                @if($introContent)
                    <div class="space-y-5 text-[17px] text-[#4a4a4a] leading-[1.7]">
                        @foreach(explode("\n\n", $introContent) as $para)
                            @if(trim($para))
                                <p>{{ $para }}</p>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="relative">
                <div class="rounded-sm overflow-hidden shadow-2xl">
                    <img src="{{ $introImageUrl }}" alt="Our team" class="w-full h-full object-cover" style="aspect-ratio: 7/5;">
                </div>
                @if($introBadgeTitle || $introBadgeSubtitle)
                <div class="absolute -bottom-5 -left-5 bg-white border border-gray-100 shadow-lg px-6 py-4 hidden lg:block">
                    @if($introBadgeTitle)<p class="text-sm font-semibold text-[#111827]">{{ $introBadgeTitle }}</p>@endif
                    @if($introBadgeSubtitle)<p class="text-xs text-[#6a6a6a]">{{ $introBadgeSubtitle }}</p>@endif
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endif

@if(!empty($values))
<section class="py-20 md:py-28 bg-[#f8f6f2]">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-16">
            @if($valuesLabel)
                <p class="text-[13px] font-semibold uppercase tracking-[0.2em] text-[#111827]/50 mb-4">{{ $valuesLabel }}</p>
            @endif
            @if($valuesTitle)
                <h2 class="text-3xl md:text-[42px] font-serif text-[#111827] leading-[1.1]">{{ $valuesTitle }}</h2>
            @endif
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($values as $val)
            <div class="bg-white border border-[#e6e1d8] p-9">
                @if(!empty($val['icon']))
                <div class="w-14 h-14 rounded-full bg-[#111827] flex items-center justify-center mb-6">
                    <i class="fa-solid {{ $val['icon'] }} text-lg text-white"></i>
                </div>
                @endif
                @if(!empty($val['title']))
                    <h3 class="text-xl font-serif text-[#111827] mb-3">{{ $val['title'] }}</h3>
                @endif
                @if(!empty($val['description']))
                    <p class="text-[15px] text-[#6a6a6a] leading-relaxed">{{ $val['description'] }}</p>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($quoteText)
<section class="py-20 md:py-28 bg-[#111827]">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="w-16 h-[2px] bg-white/30 mx-auto mb-10"></div>
        <blockquote class="text-2xl md:text-[32px] font-serif text-white leading-[1.35] mb-8">
            &ldquo;{{ $quoteText }}&rdquo;
        </blockquote>
        <p class="text-sm text-white/50 tracking-wider uppercase">The {{ $siteName }} team</p>
    </div>
</section>
@endif

@if(!empty($expectItems) || $expectTitle)
<section class="py-20 md:py-28">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-14 lg:gap-24 items-center">
            <div class="order-2 lg:order-1 relative">
                <div class="grid grid-cols-2 gap-4">
                    <div class="overflow-hidden">
                        <img src="{{ $expectImage1Url }}" alt="Destination" class="w-full object-cover" style="aspect-ratio: 4/5;">
                    </div>
                    <div class="overflow-hidden mt-10">
                        <img src="{{ $expectImage2Url }}" alt="Experience" class="w-full object-cover" style="aspect-ratio: 4/5;">
                    </div>
                </div>
            </div>
            <div class="order-1 lg:order-2">
                @if($expectLabel)
                    <p class="text-[13px] font-semibold uppercase tracking-[0.2em] text-[#111827]/50 mb-4">{{ $expectLabel }}</p>
                @endif
                @if($expectTitle)
                    <h2 class="text-3xl md:text-[42px] font-serif text-[#111827] leading-[1.1] mb-10">{{ $expectTitle }}</h2>
                @endif
                @if(!empty($expectItems))
                <div class="space-y-7">
                    @foreach($expectItems as $i => $item)
                    <div class="flex items-start gap-5">
                        <div class="w-10 h-10 rounded-full bg-[#111827] flex items-center justify-center flex-shrink-0 text-white text-sm font-semibold">
                            {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                        </div>
                        <div>
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
@endsection
