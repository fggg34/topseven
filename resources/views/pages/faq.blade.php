@php
    $heroTitle = \App\Models\Setting::get('page_faq_hero_title', 'Frequently Asked Questions');
    $heroSubtitle = \App\Models\Setting::get('page_faq_hero_subtitle', 'Everything you need to know');
    $heroImage = \App\Models\Setting::get('page_faq_hero_image', '');
    $heroBg = $heroImage ? \Illuminate\Support\Facades\Storage::disk('public')->url($heroImage) : 'https://images.unsplash.com/photo-1488085061387-422e29b40080?w=1920&h=600&fit=crop';
    $sections = \App\Models\Setting::get('page_faq_sections', '');
    $sections = is_string($sections) ? (json_decode($sections, true) ?: []) : $sections;
    if (empty($sections)) {
        $sections = [
            ['category_label' => 'Enquiries & payments', 'category_title' => 'How enquiries work', 'items' => [
                ['q' => 'How do I enquire about a travel package?', 'a' => 'Browse our travel packages, open the one you like, and submit the enquiry form with your dates, guest count, and message. Our team will contact you with availability and next steps.'],
                ['q' => 'What payment methods do you accept?', 'a' => 'We accept all major credit and debit cards, as well as bank transfers. Payment is arranged after we confirm your trip details.'],
            ]],
            ['category_label' => 'Cancellations & changes', 'category_title' => 'Flexibility when you need it', 'items' => [
                ['q' => 'What is your cancellation policy?', 'a' => 'Most travel packages offer free cancellation up to 7 days before the departure date.'],
            ]],
            ['category_label' => 'Tours & experiences', 'category_title' => 'About our tours', 'items' => [
                ['q' => 'Are your tours guided?', 'a' => 'Most tours include professional local guides.'],
            ]],
        ];
    }
    $ctaTitle = \App\Models\Setting::get('page_faq_cta_title', 'Still have questions?');
    $ctaDescription = \App\Models\Setting::get('page_faq_cta_description', "Can't find what you're looking for? Our team is happy to help.");
    $ctaButtonText = \App\Models\Setting::get('page_faq_cta_button_text', 'Contact us');
    $ctaButtonUrl = \App\Models\Setting::get('page_faq_cta_button_url', '') ?: route('contact');
@endphp
@extends('layouts.site')

@section('title', \App\Models\Setting::get('page_faq_seo_title') ?: ('FAQ - ' . config('app.name')))
@section('description', \App\Models\Setting::get('page_faq_seo_description') ?: 'Frequently asked questions about our travel packages, enquiries and services.')
@if(\App\Models\Setting::get('page_faq_seo_og_image'))@section('og_image', \App\Models\Setting::get('page_faq_seo_og_image'))@endif

@section('content')
{{-- Hero (aligned with blog / legal-style interior pages) --}}
<div class="relative w-full overflow-hidden bg-[#111827]" style="height: 340px;">
    <div class="absolute inset-0 bg-cover bg-center opacity-40" style="background-image: url({{ json_encode($heroBg) }});"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-[#111827]/80 via-transparent to-[#111827]/40"></div>
    <div class="absolute inset-0 flex items-end">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-[80px] w-full pb-12">
            <nav class="text-sm mb-4" aria-label="{{ __('Breadcrumb') }}">
                <ol class="flex flex-wrap items-center gap-1.5">
                    <li><a href="{{ route('home') }}" class="text-white/60 hover:text-white transition-colors">{{ __('Home') }}</a></li>
                    <li class="text-white/40" aria-hidden="true">/</li>
                    <li class="text-white font-medium">{{ __('FAQ') }}</li>
                </ol>
            </nav>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-serif font-semibold text-white tracking-tight leading-[1.1]">{{ $heroTitle }}</h1>
            @if($heroSubtitle)
                <p class="mt-3 text-lg text-white/70 max-w-xl leading-relaxed">{{ $heroSubtitle }}</p>
            @endif
        </div>
    </div>
</div>

<div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-[80px] py-16 md:py-20">
    <div class="max-w-3xl mx-auto">
        @foreach($sections as $sIdx => $section)
        <section class="mb-14 last:mb-0">
            @if(! empty($section['category_label']))
                <p class="text-[11px] font-semibold uppercase tracking-wider text-[#111827]/50 mb-2">{{ $section['category_label'] }}</p>
            @endif
            @if(! empty($section['category_title']))
                <h2 class="text-2xl md:text-3xl font-serif font-semibold text-[#111827] tracking-tight leading-tight mb-6">{{ $section['category_title'] }}</h2>
            @endif
            @if(! empty($section['items']))
            <div class="space-y-3" x-data="{ open: null }">
                @foreach($section['items'] as $i => $faq)
                    <div class="rounded-xl border border-[#e6e1d8] bg-white overflow-hidden shadow-sm ring-1 ring-black/[0.03]">
                        <button type="button"
                            @click="open === 's{{ $sIdx }}_{{ $i }}' ? open = null : open = 's{{ $sIdx }}_{{ $i }}'"
                            class="w-full flex items-center justify-between gap-4 px-5 sm:px-6 py-4 text-left transition-colors hover:bg-[#f8f6f2]/80">
                            <span class="font-semibold text-[#111827] text-[15px] sm:text-base pr-2">{{ $faq['q'] ?? '' }}</span>
                            <span class="shrink-0 w-8 h-8 rounded-full border border-[#d1cdc4] bg-[#f8f6f2] flex items-center justify-center">
                                <i class="fa-solid fa-chevron-down text-[10px] text-[#111827]/60 transition-transform duration-200" :class="open === 's{{ $sIdx }}_{{ $i }}' && 'rotate-180'"></i>
                            </span>
                        </button>
                        <div x-show="open === 's{{ $sIdx }}_{{ $i }}'" x-collapse x-cloak>
                            <div class="px-5 sm:px-6 pb-5 pt-0 text-[15px] text-[#4a4a4a] leading-[1.75] border-t border-[#f0ebe3]">
                                <div class="pt-4">{{ $faq['a'] ?? '' }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @endif
        </section>
        @endforeach

        {{-- CTA --}}
        <section class="mt-16 rounded-2xl bg-[#f8f6f2] border border-[#e6e1d8] p-8 md:p-12 text-center">
            <div class="inline-flex w-12 h-12 rounded-full bg-white border border-[#e6e1d8] items-center justify-center mb-5">
                <i class="fa-solid fa-comment-dots text-lg text-[#111827]"></i>
            </div>
            <h2 class="text-xl md:text-2xl font-serif font-semibold text-[#111827] mb-3">{{ $ctaTitle }}</h2>
            <p class="text-[#6a6a6a] mb-8 max-w-md mx-auto leading-relaxed">{{ $ctaDescription }}</p>
            <a href="{{ $ctaButtonUrl }}" class="inline-flex items-center justify-center rounded-full bg-[#111827] hover:bg-[#1f2937] text-white text-sm font-semibold px-8 py-3.5 transition-colors">
                {{ $ctaButtonText }}
            </a>
        </section>
    </div>
</div>
@endsection
