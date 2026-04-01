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
@endphp
@extends('layouts.site')

@section('title', \App\Models\Setting::get('page_contact_seo_title') ?: ('Contact - ' . config('app.name')))
@section('description', \App\Models\Setting::get('page_contact_seo_description') ?: 'Get in touch with us.')
@if(\App\Models\Setting::get('page_contact_seo_og_image'))@section('og_image', \App\Models\Setting::get('page_contact_seo_og_image'))@endif

@section('content')
<div class="relative w-full overflow-hidden bg-[#111827]" style="height: 380px;">
    <div class="absolute inset-0 bg-cover bg-center opacity-40" style="background-image: url('{{ $heroBg }}');"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-[#111827]/80 via-transparent to-[#111827]/40"></div>
    <div class="absolute inset-0 flex items-end">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 w-full pb-12">
            <nav class="text-sm mb-4" aria-label="Breadcrumb">
                <ol class="flex items-center gap-1.5">
                    <li><a href="{{ route('home') }}" class="text-white/60 hover:text-white transition">Home</a></li>
                    <li class="text-white/40">/</li>
                    <li class="text-white">Contact</li>
                </ol>
            </nav>
            <h1 class="text-4xl md:text-6xl font-serif text-white tracking-tight">{{ $heroTitle }}</h1>
            @if($heroSubtitle)
                <p class="mt-3 text-lg text-white/70">{{ $heroSubtitle }}</p>
            @endif
        </div>
    </div>
</div>

<div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-20">
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-14">

        <div class="lg:col-span-3">
            <h2 class="text-3xl md:text-[38px] font-serif text-[#111827] mb-2">{{ $formTitle }}</h2>
            <p class="text-[16px] text-[#6a6a6a] mb-10">{{ $formDescription }}</p>

            @if(session('success'))
                <div class="mb-8 p-5 bg-green-50 text-green-800 border border-green-100 flex items-center gap-3 text-sm">
                    <i class="fa-solid fa-circle-check text-green-500"></i>
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-[13px] font-semibold uppercase tracking-wider text-[#111827]/60 mb-2">Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="w-full border border-[#d1cdc4] bg-white px-4 py-3.5 text-sm text-[#111827] focus:outline-none focus:ring-1 focus:ring-[#111827] focus:border-[#111827] transition"
                            placeholder="Your name">
                        @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="email" class="block text-[13px] font-semibold uppercase tracking-wider text-[#111827]/60 mb-2">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                            class="w-full border border-[#d1cdc4] bg-white px-4 py-3.5 text-sm text-[#111827] focus:outline-none focus:ring-1 focus:ring-[#111827] focus:border-[#111827] transition"
                            placeholder="your@email.com">
                        @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div>
                    <label for="subject" class="block text-[13px] font-semibold uppercase tracking-wider text-[#111827]/60 mb-2">Subject</label>
                    <input type="text" name="subject" id="subject" value="{{ old('subject') }}" required
                        class="w-full border border-[#d1cdc4] bg-white px-4 py-3.5 text-sm text-[#111827] focus:outline-none focus:ring-1 focus:ring-[#111827] focus:border-[#111827] transition"
                        placeholder="How can we help?">
                    @error('subject')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="message" class="block text-[13px] font-semibold uppercase tracking-wider text-[#111827]/60 mb-2">Message</label>
                    <textarea name="message" id="message" rows="6" required
                        class="w-full border border-[#d1cdc4] bg-white px-4 py-3.5 text-sm text-[#111827] focus:outline-none focus:ring-1 focus:ring-[#111827] focus:border-[#111827] transition"
                        placeholder="Tell us more about your inquiry...">{{ old('message') }}</textarea>
                    @error('message')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <button type="submit" class="px-10 py-4 bg-[#111827] hover:bg-[#1f2937] text-white text-sm font-semibold tracking-wider uppercase transition-colors">
                    Send message
                </button>
            </form>
        </div>

        <div class="lg:col-span-2">
            <div class="sticky top-28 space-y-6">
                <div class="bg-[#f8f6f2] border border-[#e6e1d8] p-8">
                    <h3 class="text-xl font-serif text-[#111827] mb-6">Contact details</h3>
                    <div class="space-y-5">
                        @if(\App\Models\Setting::get('contact_email'))
                        <div class="flex items-start gap-4">
                            <div class="w-11 h-11 bg-[#111827] flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-envelope text-white text-sm"></i>
                            </div>
                            <div>
                                <p class="text-[11px] font-semibold uppercase tracking-wider text-[#111827]/50 mb-0.5">Email</p>
                                <a href="mailto:{{ \App\Models\Setting::get('contact_email') }}" class="text-sm text-[#111827] hover:underline break-all">{{ \App\Models\Setting::get('contact_email') }}</a>
                            </div>
                        </div>
                        @endif

                        @if(\App\Models\Setting::get('contact_phone'))
                        <div class="flex items-start gap-4">
                            <div class="w-11 h-11 bg-[#111827] flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-phone text-white text-sm"></i>
                            </div>
                            <div>
                                <p class="text-[11px] font-semibold uppercase tracking-wider text-[#111827]/50 mb-0.5">Phone</p>
                                <a href="tel:{{ \App\Models\Setting::get('contact_phone') }}" class="text-sm text-[#111827] hover:underline">{{ \App\Models\Setting::get('contact_phone') }}</a>
                            </div>
                        </div>
                        @endif

                        @if(\App\Models\Setting::get('contact_address'))
                        <div class="flex items-start gap-4">
                            <div class="w-11 h-11 bg-[#111827] flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-location-dot text-white text-sm"></i>
                            </div>
                            <div>
                                <p class="text-[11px] font-semibold uppercase tracking-wider text-[#111827]/50 mb-0.5">Address</p>
                                <p class="text-sm text-[#111827]">{{ \App\Models\Setting::get('contact_address') }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="bg-[#111827] p-8 text-center">
                    <i class="fa-solid fa-headset text-3xl text-white/80 mb-5"></i>
                    <h3 class="text-xl font-serif text-white mb-2">{{ $sidebarTitle }}</h3>
                    <p class="text-sm text-white/60 mb-6">{{ $sidebarDescription }}</p>
                    <a href="{{ $sidebarButtonUrl }}" class="inline-flex px-7 py-3 border border-white/40 text-white text-sm font-semibold uppercase tracking-wider hover:bg-white hover:text-[#111827] transition-colors">
                        {{ $sidebarButtonText }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
