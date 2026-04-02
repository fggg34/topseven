@php
    $heroTitle = \App\Models\Setting::get('page_contact_hero_title', 'Get in touch');
    $heroSubtitle = \App\Models\Setting::get('page_contact_hero_subtitle', "We'd love to hear from you");
    $heroImage = \App\Models\Setting::get('page_contact_hero_image', '');
    $heroBg = $heroImage ? \Illuminate\Support\Facades\Storage::disk('public')->url($heroImage) : 'https://images.unsplash.com/photo-1423666639041-f56000c27a9a?w=1920&h=600&fit=crop';
    $formTitle = \App\Models\Setting::get('page_contact_form_title', 'Send us a message');
    $formDescription = \App\Models\Setting::get('page_contact_form_description', "Fill out the form below and we'll get back to you as soon as possible.");
    $sidebarTitle = \App\Models\Setting::get('page_contact_sidebar_title', 'Need quick help?');
    $sidebarDescription = \App\Models\Setting::get('page_contact_sidebar_description', 'Check our frequently asked questions for instant answers.');
    $sidebarButtonText = \App\Models\Setting::get('page_contact_sidebar_button_text', 'Browse tours');
    $sidebarButtonUrl = \App\Models\Setting::get('page_contact_sidebar_button_url', '') ?: route('tours.index');
    $contactEmail = \App\Models\Setting::get('contact_email');
    $contactPhone = \App\Models\Setting::get('contact_phone');
    $contactAddress = \App\Models\Setting::get('contact_address');
@endphp
@extends('layouts.site')

@section('title', \App\Models\Setting::get('page_contact_seo_title') ?: ('Contact - ' . config('app.name')))
@section('description', \App\Models\Setting::get('page_contact_seo_description') ?: 'Get in touch with us.')
@if(\App\Models\Setting::get('page_contact_seo_og_image'))@section('og_image', \App\Models\Setting::get('page_contact_seo_og_image'))@endif

@section('content')
{{-- Hero --}}
<div class="relative w-full overflow-hidden bg-[#111827]" style="height: 420px;">
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ $heroBg }}'); opacity: 0.35;"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-[#111827] via-[#111827]/40 to-transparent"></div>
    <div class="absolute inset-0 flex flex-col justify-center">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <nav class="text-sm mb-6" aria-label="Breadcrumb">
                <ol class="flex items-center gap-1.5">
                    <li><a href="{{ route('home') }}" class="text-white/50 hover:text-white transition">Home</a></li>
                    <li class="text-white/30">/</li>
                    <li class="text-white/80">Contact</li>
                </ol>
            </nav>
            <p class="text-[13px] font-semibold uppercase tracking-[0.25em] text-white/50 mb-4">Let's connect</p>
            <h1 class="text-5xl md:text-7xl font-serif text-white tracking-tight leading-[1.05]">{{ $heroTitle }}</h1>
            @if($heroSubtitle)
                <p class="mt-4 text-lg text-white/60 max-w-lg">{{ $heroSubtitle }}</p>
            @endif
        </div>
    </div>
</div>

{{-- Contact info bar --}}
@if($contactEmail || $contactPhone || $contactAddress)
<div class="bg-[#111827] border-t border-white/10">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 divide-y md:divide-y-0 md:divide-x divide-white/10">
            @if($contactEmail)
            <div class="flex items-center gap-4 py-6 md:pr-8">
                <div class="w-11 h-11 border border-white/20 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-envelope text-white/60 text-sm"></i>
                </div>
                <div>
                    <p class="text-[11px] font-semibold uppercase tracking-wider text-white/35 mb-0.5">Email</p>
                    <a href="mailto:{{ $contactEmail }}" class="text-sm text-white hover:text-white/70 transition break-all">{{ $contactEmail }}</a>
                </div>
            </div>
            @endif
            @if($contactPhone)
            <div class="flex items-center gap-4 py-6 md:px-8">
                <div class="w-11 h-11 border border-white/20 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-phone text-white/60 text-sm"></i>
                </div>
                <div>
                    <p class="text-[11px] font-semibold uppercase tracking-wider text-white/35 mb-0.5">Phone</p>
                    <a href="tel:{{ $contactPhone }}" class="text-sm text-white hover:text-white/70 transition">{{ $contactPhone }}</a>
                </div>
            </div>
            @endif
            @if($contactAddress)
            <div class="flex items-center gap-4 py-6 md:pl-8">
                <div class="w-11 h-11 border border-white/20 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-location-dot text-white/60 text-sm"></i>
                </div>
                <div>
                    <p class="text-[11px] font-semibold uppercase tracking-wider text-white/35 mb-0.5">Address</p>
                    <p class="text-sm text-white">{{ $contactAddress }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endif

{{-- Form + sidebar --}}
<section class="py-20 md:py-28">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-14 lg:gap-20">

            {{-- Form --}}
            <div class="lg:col-span-7">
                <p class="text-[13px] font-semibold uppercase tracking-[0.25em] text-[#111827]/40 mb-4">Send a message</p>
                <h2 class="text-3xl md:text-[40px] font-serif text-[#111827] leading-[1.12] mb-3">{{ $formTitle }}</h2>
                <p class="text-[16px] text-[#6a6a6a] mb-10 max-w-lg">{{ $formDescription }}</p>

                @if(session('success'))
                    <div class="mb-8 p-5 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-start gap-3">
                        <i class="fa-solid fa-circle-check text-emerald-600 mt-0.5"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-[12px] font-semibold uppercase tracking-wider text-[#111827]/50 mb-2">Name <span class="text-red-400">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                class="w-full border-b-2 border-[#d1cdc4] bg-transparent px-0 py-3 text-[15px] text-[#111827] placeholder-[#aaa] focus:outline-none focus:border-[#111827] transition-colors"
                                placeholder="Your name">
                            @error('name')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="email" class="block text-[12px] font-semibold uppercase tracking-wider text-[#111827]/50 mb-2">Email <span class="text-red-400">*</span></label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                class="w-full border-b-2 border-[#d1cdc4] bg-transparent px-0 py-3 text-[15px] text-[#111827] placeholder-[#aaa] focus:outline-none focus:border-[#111827] transition-colors"
                                placeholder="your@email.com">
                            @error('email')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div>
                        <label for="subject" class="block text-[12px] font-semibold uppercase tracking-wider text-[#111827]/50 mb-2">Subject <span class="text-red-400">*</span></label>
                        <input type="text" name="subject" id="subject" value="{{ old('subject') }}" required
                            class="w-full border-b-2 border-[#d1cdc4] bg-transparent px-0 py-3 text-[15px] text-[#111827] placeholder-[#aaa] focus:outline-none focus:border-[#111827] transition-colors"
                            placeholder="How can we help?">
                        @error('subject')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="message" class="block text-[12px] font-semibold uppercase tracking-wider text-[#111827]/50 mb-2">Message <span class="text-red-400">*</span></label>
                        <textarea name="message" id="message" rows="5" required
                            class="w-full border-b-2 border-[#d1cdc4] bg-transparent px-0 py-3 text-[15px] text-[#111827] placeholder-[#aaa] focus:outline-none focus:border-[#111827] transition-colors resize-y"
                            placeholder="Tell us more about your inquiry...">{{ old('message') }}</textarea>
                        @error('message')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <button type="submit" class="inline-flex items-center gap-3 px-10 py-4 bg-[#111827] hover:bg-[#1f2937] text-white text-sm font-semibold tracking-wider uppercase transition-colors mt-2">
                        Send message
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </button>
                </form>
            </div>

            {{-- Sidebar --}}
            <div class="lg:col-span-5">
                <div class="sticky top-28 space-y-6">
                    {{-- Why reach out --}}
                    <div class="bg-[#f8f6f2] border border-[#e6e1d8] p-8">
                        <h3 class="text-xl font-serif text-[#111827] mb-6">How can we help?</h3>
                        <div class="space-y-5">
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 bg-[#111827] flex items-center justify-center flex-shrink-0">
                                    <i class="fa-solid fa-plane-departure text-white text-sm"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-[#111827] mb-0.5">Custom Tour Requests</h4>
                                    <p class="text-[13px] text-[#6a6a6a]">Tell us your dream itinerary and we'll make it happen.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 bg-[#111827] flex items-center justify-center flex-shrink-0">
                                    <i class="fa-solid fa-users text-white text-sm"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-[#111827] mb-0.5">Group Bookings</h4>
                                    <p class="text-[13px] text-[#6a6a6a]">Special rates and tailored experiences for groups.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 bg-[#111827] flex items-center justify-center flex-shrink-0">
                                    <i class="fa-solid fa-circle-question text-white text-sm"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-[#111827] mb-0.5">General Enquiries</h4>
                                    <p class="text-[13px] text-[#6a6a6a]">Questions about destinations, availability, or anything else.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- CTA card --}}
                    <div class="relative overflow-hidden" style="min-height: 260px;">
                        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1530789253388-582c481c54b0?w=800&h=600&fit=crop'); opacity: 0.25;"></div>
                        <div class="absolute inset-0 bg-[#111827]/90"></div>
                        <div class="relative p-8 flex flex-col justify-center h-full text-center" style="min-height: 260px;">
                            <i class="fa-solid fa-headset text-3xl text-white/60 mb-5"></i>
                            <h3 class="text-xl font-serif text-white mb-2">{{ $sidebarTitle }}</h3>
                            <p class="text-sm text-white/50 mb-6">{{ $sidebarDescription }}</p>
                            <a href="{{ $sidebarButtonUrl }}" class="inline-flex mx-auto px-7 py-3 border border-white/30 text-white text-sm font-semibold uppercase tracking-wider hover:bg-white hover:text-[#111827] transition-colors">
                                {{ $sidebarButtonText }}
                            </a>
                        </div>
                    </div>

                    {{-- Response time --}}
                    <div class="flex items-center gap-4 p-5 border border-[#e6e1d8]">
                        <div class="w-10 h-10 bg-emerald-50 border border-emerald-200 flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-clock text-emerald-600 text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-[#111827]">Average response time</p>
                            <p class="text-[13px] text-[#6a6a6a]">We typically reply within 2-4 hours during business hours.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
