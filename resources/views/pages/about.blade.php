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

{{-- 1. Hero --}}
<section class="relative w-full overflow-hidden rounded-b-[40px]" style="height: 560px;">
    <div class="absolute inset-0 bg-cover bg-center transition-transform duration-[1.2s] hover:scale-[1.02]" style="background-image: url('{{ $heroBg }}');"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/25 to-transparent"></div>
    <div class="absolute inset-0 flex flex-col justify-end">
        <div class="w-full max-w-none px-4 sm:px-6 md:px-[80px] pb-12 md:pb-14">
            <nav class="text-sm mb-5 opacity-70" aria-label="Breadcrumb">
                <ol class="flex items-center gap-1.5 text-white/80">
                    <li><a href="{{ route('home') }}" class="hover:text-white transition">Home</a></li>
                    <li>/</li>
                    <li>About</li>
                </ol>
            </nav>
            <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold text-white tracking-tight leading-[1.08]">{{ $heroTitle }}</h1>
            <p class="mt-4 text-lg text-white/75 max-w-lg leading-relaxed">The people, the passion, and the places that make every journey unforgettable.</p>
        </div>
    </div>
</section>

{{-- 2. Intro --}}
@if($introTitle || $introContent)
<section class="px-4 sm:px-6 md:px-[80px] py-16 md:py-24">
    <div class="max-w-[1400px] mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-10 lg:gap-20 items-start">
            <div class="lg:col-span-2">
                @if($introLabel)
                    <p class="text-[15px] text-gray-500 mb-3">{{ $introLabel }}</p>
                @endif
                <h2 class="text-[34px] md:text-[44px] font-serif font-semibold text-gray-900 leading-[1.08]">{{ $introTitle }}</h2>
                @if($introBadgeTitle)
                <div class="inline-flex items-center gap-2 mt-6 rounded-full bg-gray-100 px-4 py-2">
                    <span class="w-2 h-2 rounded-full bg-green-500"></span>
                    <span class="text-[13px] font-medium text-gray-700">{{ $introBadgeTitle }}</span>
                </div>
                @endif
            </div>
            <div class="lg:col-span-3">
                @if($introContent)
                <div class="text-[17px] text-gray-600 leading-[1.8] space-y-5">
                    @foreach(explode("\n\n", $introContent) as $para)
                        @if(trim($para))<p>{{ $para }}</p>@endif
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endif

{{-- 3. Image mosaic --}}
<section class="px-4 sm:px-6 md:px-[80px]">
    <div class="max-w-[1400px] mx-auto">
        <div class="grid grid-cols-12 gap-3 md:gap-4">
            <div class="col-span-12 md:col-span-7 rounded-[24px] overflow-hidden">
                <img src="{{ $introImageUrl }}" alt="Our team" class="w-full h-full object-cover" style="aspect-ratio: 16/10; min-height: 300px;">
            </div>
            <div class="col-span-6 md:col-span-5 rounded-[24px] overflow-hidden">
                <img src="{{ $expectImage1Url }}" alt="Our journeys" class="w-full h-full object-cover" style="aspect-ratio: 1/1; min-height: 200px;">
            </div>
            <div class="col-span-6 md:col-span-5 rounded-[24px] overflow-hidden">
                <img src="{{ $expectImage2Url }}" alt="Our destinations" class="w-full h-full object-cover" style="aspect-ratio: 1/1; min-height: 200px;">
            </div>
            <div class="col-span-12 md:col-span-7 rounded-[24px] overflow-hidden bg-gray-900 flex items-center justify-center px-8 py-10" style="min-height: 200px;">
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 text-center w-full">
                    <div>
                        <p class="text-3xl md:text-4xl font-bold text-white">500+</p>
                        <p class="text-sm text-white/50 mt-1">Travellers</p>
                    </div>
                    <div>
                        <p class="text-3xl md:text-4xl font-bold text-white">50+</p>
                        <p class="text-sm text-white/50 mt-1">Tours</p>
                    </div>
                    <div>
                        <p class="text-3xl md:text-4xl font-bold text-white">12</p>
                        <p class="text-sm text-white/50 mt-1">Destinations</p>
                    </div>
                    <div>
                        <p class="text-3xl md:text-4xl font-bold text-white">4.9</p>
                        <p class="text-sm text-white/50 mt-1">Rating</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- 4. Values --}}
@if(!empty($values))
<section class="px-4 sm:px-6 md:px-[80px] py-16 md:py-24">
    <div class="max-w-[1400px] mx-auto">
        <div class="mb-10 md:mb-14">
            @if($valuesLabel)
                <p class="text-[15px] text-gray-500 mb-2">{{ $valuesLabel }}</p>
            @endif
            <h2 class="text-[34px] md:text-[48px] font-serif font-semibold text-gray-900 leading-[1.05] tracking-tight">{{ $valuesTitle }}</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            @foreach($values as $val)
            <div class="bg-gray-100 rounded-2xl p-8 lg:p-10">
                @if(!empty($val['icon']))
                <div class="w-12 h-12 rounded-xl bg-gray-900 flex items-center justify-center mb-6">
                    <i class="fa-solid {{ $val['icon'] }} text-white text-base"></i>
                </div>
                @endif
                @if(!empty($val['title']))
                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $val['title'] }}</h3>
                @endif
                @if(!empty($val['description']))
                    <p class="text-[15px] text-gray-600 leading-relaxed">{{ $val['description'] }}</p>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- 5. Quote --}}
@if($quoteText)
<section class="px-4 sm:px-6 md:px-[80px] pb-16 md:pb-24">
    <div class="max-w-[1400px] mx-auto">
        <div class="relative rounded-[28px] overflow-hidden" style="min-height: 340px;">
            <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ $heroBg }}');"></div>
            <div class="absolute inset-0 bg-black/60"></div>
            <div class="relative flex items-center justify-center px-6 md:px-16 py-14 text-center" style="min-height: 340px;">
                <div class="max-w-3xl">
                    <i class="fa-solid fa-quote-left text-white/15 text-5xl mb-5"></i>
                    <blockquote class="text-2xl md:text-[34px] font-serif text-white leading-[1.25]">
                        &ldquo;{{ $quoteText }}&rdquo;
                    </blockquote>
                    <p class="mt-6 text-sm text-white/45">{{ $siteName }} Team</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

{{-- 6. What to expect --}}
<!-- @if(!empty($expectItems))
<section class="px-4 sm:px-6 md:px-[80px] pb-16 md:pb-24">
    <div class="max-w-[1400px] mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-10 lg:gap-20 items-start mb-12">
            <div class="lg:col-span-2">
                @if($expectLabel)
                    <p class="text-[15px] text-gray-500 mb-3">{{ $expectLabel }}</p>
                @endif
                <h2 class="text-[34px] md:text-[44px] font-serif font-semibold text-gray-900 leading-[1.08]">{{ $expectTitle }}</h2>
            </div>
            <div class="lg:col-span-3">
                <p class="text-[17px] text-gray-600 leading-relaxed">Every journey with us is built on these simple promises. No fine print, no surprises &mdash; just a great experience from start to finish.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            @foreach($expectItems as $i => $item)
            <div class="flex gap-5 rounded-2xl border border-gray-200 bg-white p-7 hover:border-gray-300 hover:shadow-sm transition-all">
                <span class="w-10 h-10 rounded-full bg-gray-900 text-white text-sm font-bold flex items-center justify-center flex-shrink-0">{{ $i + 1 }}</span>
                <div class="min-w-0">
                    @if(!empty($item['title']))
                        <h4 class="text-[17px] font-bold text-gray-900 mb-1">{{ $item['title'] }}</h4>
                    @endif
                    @if(!empty($item['description']))
                        <p class="text-[15px] text-gray-500 leading-relaxed">{{ $item['description'] }}</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif -->

{{-- 7. CTA --}}
<section class="px-4 sm:px-6 md:px-[80px] pb-16 md:pb-24">
    <div class="max-w-[1400px] mx-auto">
        <div class="rounded-[28px] bg-gray-900 px-8 md:px-16 py-14 md:py-20 flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="max-w-lg text-center md:text-left">
                <h2 class="text-3xl md:text-[42px] font-bold text-white leading-[1.1] tracking-tight mb-3">Ready for your next adventure?</h2>
                <p class="text-white/60 text-[17px] leading-relaxed">Explore our hand-picked tours or tell us about your dream trip.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('tours.index') }}" class="inline-flex items-center rounded-full bg-white text-gray-900 text-sm font-semibold px-7 py-3.5 hover:bg-gray-100 transition-colors">
                    Browse tours
                </a>
                <a href="{{ route('contact') }}" class="inline-flex items-center rounded-full border border-white/30 text-white text-sm font-semibold px-7 py-3.5 hover:bg-white/10 transition-colors">
                    Get in touch
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
