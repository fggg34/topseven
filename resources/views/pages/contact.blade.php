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
<section class="relative w-full overflow-hidden rounded-b-[40px]" style="height: 440px;">
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ $heroBg }}');"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/25 to-transparent"></div>
    <div class="absolute inset-0 flex flex-col justify-end">
        <div class="w-full max-w-none px-4 sm:px-6 md:px-[80px] pb-12 md:pb-14">
            <nav class="text-sm mb-5 opacity-70" aria-label="Breadcrumb">
                <ol class="flex items-center gap-1.5 text-white/80">
                    <li><a href="{{ route('home') }}" class="hover:text-white transition">Home</a></li>
                    <li>/</li>
                    <li>Contact</li>
                </ol>
            </nav>
            <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold text-white tracking-tight leading-[1.08]">{{ $heroTitle }}</h1>
            @if($heroSubtitle)
                <p class="mt-4 text-lg text-white/70 max-w-lg leading-relaxed">{{ $heroSubtitle }}</p>
            @endif
        </div>
    </div>
</section>

{{-- Contact info cards --}}
@if($contactEmail || $contactPhone || $contactAddress)
<section class="px-4 sm:px-6 md:px-[80px] -mt-8 relative z-10">
    <div class="max-w-[1400px] mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @if($contactEmail)
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-gray-900 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-envelope text-white text-sm"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-[13px] text-gray-400 mb-0.5">Email</p>
                    <a href="mailto:{{ $contactEmail }}" class="text-[15px] font-medium text-gray-900 hover:underline break-all">{{ $contactEmail }}</a>
                </div>
            </div>
            @endif
            @if($contactPhone)
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-gray-900 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-phone text-white text-sm"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-[13px] text-gray-400 mb-0.5">Phone</p>
                    <a href="tel:{{ $contactPhone }}" class="text-[15px] font-medium text-gray-900 hover:underline">{{ $contactPhone }}</a>
                </div>
            </div>
            @endif
            @if($contactAddress)
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-gray-900 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-location-dot text-white text-sm"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-[13px] text-gray-400 mb-0.5">Address</p>
                    <p class="text-[15px] font-medium text-gray-900">{{ $contactAddress }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endif

{{-- Form + sidebar --}}
<section class="px-4 sm:px-6 md:px-[80px] py-16 md:py-24">
    <div class="max-w-[1400px] mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-10 lg:gap-16">

            {{-- Form --}}
            <div class="lg:col-span-3">
                <p class="text-[15px] text-gray-500 mb-2">Send a message</p>
                <h2 class="text-[34px] md:text-[44px] font-serif font-semibold text-gray-900 leading-[1.08] mb-3">{{ $formTitle }}</h2>
                <p class="text-[17px] text-gray-500 mb-10 max-w-lg leading-relaxed">{{ $formDescription }}</p>

                @if(session('success'))
                    <div class="mb-8 p-5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-start gap-3">
                        <i class="fa-solid fa-circle-check text-emerald-600 mt-0.5"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <form action="{{ route('contact.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Name <span class="text-red-400">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3.5 text-[15px] text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition"
                                placeholder="Your name">
                            @error('name')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email <span class="text-red-400">*</span></label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3.5 text-[15px] text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition"
                                placeholder="your@email.com">
                            @error('email')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-1.5">Subject <span class="text-red-400">*</span></label>
                        <input type="text" name="subject" id="subject" value="{{ old('subject') }}" required
                            class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3.5 text-[15px] text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition"
                            placeholder="How can we help?">
                        @error('subject')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-1.5">Message <span class="text-red-400">*</span></label>
                        <textarea name="message" id="message" rows="5" required
                            class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3.5 text-[15px] text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition resize-y"
                            placeholder="Tell us more about your inquiry...">{{ old('message') }}</textarea>
                        @error('message')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <button type="submit" class="inline-flex items-center rounded-full bg-gray-900 text-white text-sm font-semibold px-8 py-3.5 hover:bg-gray-800 transition-colors">
                        Send message
                        <i class="fa-solid fa-arrow-right text-xs ml-2.5"></i>
                    </button>
                </form>
            </div>

            {{-- Sidebar --}}
            <div class="lg:col-span-2">
                <div class="sticky top-28 space-y-5">
                    {{-- How can we help --}}
                    <div class="bg-gray-100 rounded-2xl p-7">
                        <h3 class="text-xl font-bold text-gray-900 mb-5">How can we help?</h3>
                        <div class="space-y-4">
                            <div class="flex items-start gap-3.5">
                                <div class="w-10 h-10 rounded-xl bg-gray-900 flex items-center justify-center flex-shrink-0">
                                    <i class="fa-solid fa-plane-departure text-white text-sm"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-900">Custom Tour Requests</h4>
                                    <p class="text-[13px] text-gray-500 mt-0.5">Tell us your dream itinerary and we'll make it happen.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3.5">
                                <div class="w-10 h-10 rounded-xl bg-gray-900 flex items-center justify-center flex-shrink-0">
                                    <i class="fa-solid fa-users text-white text-sm"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-900">Group Bookings</h4>
                                    <p class="text-[13px] text-gray-500 mt-0.5">Special rates and tailored experiences for groups.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3.5">
                                <div class="w-10 h-10 rounded-xl bg-gray-900 flex items-center justify-center flex-shrink-0">
                                    <i class="fa-solid fa-circle-question text-white text-sm"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-900">General Enquiries</h4>
                                    <p class="text-[13px] text-gray-500 mt-0.5">Questions about destinations, availability, or anything else.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- CTA card --}}
                    <div class="relative rounded-[28px] overflow-hidden" style="min-height: 240px;">
                        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1530789253388-582c481c54b0?w=800&h=600&fit=crop');"></div>
                        <div class="absolute inset-0 bg-black/60"></div>
                        <div class="relative flex flex-col items-center justify-center text-center p-8" style="min-height: 240px;">
                            <i class="fa-solid fa-headset text-3xl text-white/50 mb-4"></i>
                            <h3 class="text-xl font-bold text-white mb-2">{{ $sidebarTitle }}</h3>
                            <p class="text-sm text-white/60 mb-5">{{ $sidebarDescription }}</p>
                            <a href="{{ $sidebarButtonUrl }}" class="inline-flex items-center rounded-full border border-white/40 text-white text-sm font-semibold px-6 py-2.5 hover:bg-white hover:text-gray-900 transition-colors">
                                {{ $sidebarButtonText }}
                            </a>
                        </div>
                    </div>

                    {{-- Response time --}}
                    <div class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white p-5">
                        <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-clock text-emerald-600 text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">Average response time</p>
                            <p class="text-[13px] text-gray-500">We typically reply within 2-4 hours.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
