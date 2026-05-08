@extends('layouts.site')

@section('title', $country->name . ' - ' . config('app.name'))
@section('description', Str::limit(strip_tags($country->description ?? ''), 160))

@push('meta')
<meta property="og:title" content="{{ $country->name }}">
<meta property="og:description" content="{{ Str::limit(strip_tags($country->description ?? ''), 200) }}">
<meta property="og:url" content="{{ request()->url() }}">
@if($country->city_image_url)
<meta property="og:image" content="{{ request()->getSchemeAndHttpHost() . $country->city_image_url }}">
@endif
@endpush

@section('content')
<div class="w-full">
    <div class="px-4 sm:px-6 lg:px-[80px] pt-8 pb-14">
        <div class="max-w-[1400px] mx-auto">

    {{-- Breadcrumb --}}
    <nav class="text-sm mb-8" aria-label="Breadcrumb">
        <ol class="flex flex-wrap items-center gap-1.5 text-[#6a6a6a]">
            <li><a href="{{ route('home') }}" class="hover:text-[#3f4b9a] transition-colors">{{ __('Home') }}</a></li>
            <li class="text-[#d1cdc4]" aria-hidden="true">/</li>
            <li><a href="{{ route('countries.index') }}" class="hover:text-[#3f4b9a] transition-colors">{{ __('Countries') }}</a></li>
            <li class="text-[#d1cdc4]" aria-hidden="true">/</li>
            <li class="text-[#3f4b9a] font-medium">{{ $country->name }}</li>
        </ol>
    </nav>

    @php
        $allImages = collect();
        if ($country->city_image_url) $allImages->push($country->city_image_url);
        if ($country->gallery_urls) $allImages = $allImages->merge($country->gallery_urls);
        $totalPhotos = $allImages->count();
        $thumbImages = $allImages->slice(1)->values();
    @endphp

    {{-- Hero: Gallery left + Title/Description right --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 mb-14">
        {{-- Left: Gallery (big image + thumbnails) --}}
        <div class="city-gallery">
            @if($allImages->isNotEmpty())
                <div class="relative rounded-2xl overflow-hidden bg-[#e8e4dc]" style="aspect-ratio: 16/10;">
                    <a href="{{ $allImages[0] }}" class="glightbox block w-full h-full" data-gallery="city-gallery">
                        <img src="{{ $allImages[0] }}" alt="{{ $country->name }}" class="w-full h-full object-cover">
                    </a>
                    @if($totalPhotos > 1)
                        <div class="absolute bottom-4 right-4 flex items-center gap-2 px-3.5 py-2 rounded-lg bg-[#111827]/85 backdrop-blur-sm text-white text-sm font-medium pointer-events-none">
                            <i class="fa-regular fa-images"></i>
                            {{ $totalPhotos }} photos
                        </div>
                    @endif
                </div>

                @if($thumbImages->isNotEmpty())
                    <div class="grid grid-cols-4 gap-2 mt-2">
                        @foreach($thumbImages->take(4) as $url)
                            <a href="{{ $url }}" class="glightbox group block aspect-[4/3] rounded-xl overflow-hidden bg-[#e8e4dc] ring-1 ring-[#e6e1d8]" data-gallery="city-gallery">
                                <img src="{{ $url }}" alt="{{ $country->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                            </a>
                        @endforeach
                    </div>
                @endif

                {{-- Hidden lightbox links for remaining images --}}
                @foreach($allImages->slice(5) as $url)
                    <a href="{{ $url }}" class="glightbox hidden" data-gallery="city-gallery"></a>
                @endforeach
            @else
                <div class="rounded-2xl bg-[#f8f6f2] h-full flex items-center justify-center text-[#6a6a6a] text-sm" style="min-height: 400px;">
                    {{ __('No images available') }}
                </div>
            @endif
        </div>

        {{-- Right: Title + Description --}}
        <div class="flex flex-col justify-center">
            @if($country->country)
                <p class="text-[11px] font-semibold uppercase tracking-wider text-[#3f4b9a]/50 mb-2">{{ $country->country }}</p>
            @endif
            <h1 class="text-3xl md:text-4xl lg:text-[2.5rem] font-serif font-semibold text-brand-heading tracking-tight leading-[1.1] mb-5">{{ $country->name }}</h1>
            @if($country->description)
                <div class="prose prose-lg max-w-none prose-headings:font-serif prose-headings:text-brand-heading prose-p:text-[#4a4a4a] prose-p:leading-[1.75] prose-a:text-brand-ink prose-a:underline prose-a:underline-offset-4">
                    {!! $country->description !!}
                </div>
            @endif
            <div class="flex flex-wrap items-center gap-4 mt-6 pt-6 border-t border-[#e6e1d8]">
                @if($country->tours->count())
                    <div class="flex items-center gap-2">
                        <span class="w-9 h-9 rounded-lg bg-[#f8f6f2] flex items-center justify-center border border-[#e6e1d8]"><i class="fa-solid fa-route text-brand-ink text-sm"></i></span>
                        <div>
                            <span class="text-lg font-semibold text-brand-ink">{{ $country->tours->where('is_active', true)->count() }}</span>
                            <span class="text-sm text-[#6a6a6a] ml-1">{{ __('Travel packages') }}</span>
                        </div>
                    </div>
                @endif
                @if($country->highlights->count())
                    <div class="flex items-center gap-2">
                        <span class="w-9 h-9 rounded-lg bg-[#f8f6f2] flex items-center justify-center border border-[#e6e1d8]"><i class="fa-solid fa-camera text-brand-ink text-sm"></i></span>
                        <div>
                            <span class="text-lg font-semibold text-brand-ink">{{ $country->highlights->count() }}</span>
                            <span class="text-sm text-[#6a6a6a] ml-1">{{ __('Attractions') }}</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

        </div>
    </div>

    {{-- Places to visit --}}
    @if($country->highlights->isNotEmpty())
    <div class="px-4 sm:px-6 lg:px-[80px] pb-14">
        <div class="max-w-[1400px] mx-auto">
            <section class="mb-0 overflow-hidden">
        <div class="flex items-end justify-between mb-8 gap-4">
            <div>
                <p class="text-[11px] font-semibold uppercase tracking-wider text-[#3f4b9a]/50 mb-1">{{ __('Explore') }}</p>
                <h2 class="text-2xl md:text-3xl font-serif font-semibold text-brand-heading tracking-tight leading-tight">{{ __('Places to visit in :name', ['name' => $country->name]) }}</h2>
            </div>
            <div class="flex items-center gap-2 shrink-0">
                <button type="button" class="city-highlights-prev w-10 h-10 rounded-full border border-[#d1cdc4] bg-white flex items-center justify-center text-[#6a6a6a] hover:text-[#3f4b9a] hover:border-[#3f4b9a] transition-colors">
                    <i class="fa-solid fa-arrow-left text-sm"></i>
                </button>
                <button type="button" class="city-highlights-next w-10 h-10 rounded-full border border-[#d1cdc4] bg-white flex items-center justify-center text-[#6a6a6a] hover:text-[#3f4b9a] hover:border-[#3f4b9a] transition-colors">
                    <i class="fa-solid fa-arrow-right text-sm"></i>
                </button>
            </div>
        </div>
        <div class="swiper city-highlights-swiper overflow-visible">
            <div class="swiper-wrapper">
                @foreach($country->highlights as $highlight)
                <div class="swiper-slide">
                    <a href="{{ route('countries.highlights.show', [$country->slug, $highlight->slug]) }}" class="group block relative rounded-xl overflow-hidden bg-[#e8e4dc] ring-1 ring-[#e6e1d8]" style="aspect-ratio: 4/3;">
                        @if($highlight->image_url)
                            <img src="{{ $highlight->image_url }}" alt="{{ $highlight->title }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent"></div>
                        <div class="absolute bottom-3 left-3 right-3">
                            <h3 class="font-bold text-base drop-shadow line-clamp-2" style="color: #fff !important;">{{ $highlight->title }}</h3>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
            </section>
        </div>
    </div>
    @endif

    {{-- Travel packages (homepage flash-style carousel) --}}
    @if($country->tours->isNotEmpty())
    @php
        $countryTours = $country->tours->take(8);
    @endphp
    <section class="px-4 sm:px-6 lg:px-[80px] pb-16">
        <div class="max-w-[1400px] mx-auto">
            <div class="mb-6 md:mb-8">
                <p class="text-[11px] font-semibold uppercase tracking-wider text-[#3f4b9a]/50 mb-1">{{ __('Curated experiences') }}</p>
                <h2 class="text-3xl sm:text-4xl md:text-[2.125rem] lg:text-[2.5rem] font-serif font-semibold text-brand-heading tracking-tight leading-tight">
                    {{ __('Travel packages in :name', ['name' => $country->name]) }}
                </h2>
            </div>

            <div class="swiper country-packages-swiper overflow-visible">
                <div class="swiper-wrapper">
                    @foreach($countryTours as $tour)
                    <div class="swiper-slide !h-auto">
                        <x-tour-card variant="flash" :tour="$tour" :queryParams="['country' => $country->slug]" :wishlisted="in_array($tour->id, $wishlistedIds ?? [])" />
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mt-8">
                <a href="{{ route('tours.index', ['country' => $country->slug]) }}" class="inline-flex items-center justify-center rounded-full bg-[#111827] text-white text-sm font-semibold px-6 py-2.5 hover:bg-[#1f2937] transition-colors">
                    {{ __('View all travel packages') }}
                </a>
                <div class="flex items-center justify-end gap-2">
                    <button type="button" class="country-packages-prev w-11 h-11 rounded-full border border-[#d1cdc4] bg-white text-[#6a6a6a] flex items-center justify-center transition-colors hover:border-[#3f4b9a] hover:text-[#3f4b9a] disabled:opacity-40 disabled:pointer-events-none" aria-label="{{ __('Previous') }}">
                        <i class="fa-solid fa-arrow-left text-sm"></i>
                    </button>
                    <button type="button" class="country-packages-next w-11 h-11 rounded-full bg-[#111827] text-white flex items-center justify-center transition-colors hover:bg-[#1f2937] disabled:opacity-40 disabled:pointer-events-none" aria-label="{{ __('Next') }}">
                        <i class="fa-solid fa-arrow-right text-sm"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>
    @endif

</div>
@vite(['resources/js/tour-gallery.js'])

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (window.Swiper && document.querySelector('.city-highlights-swiper')) {
        new window.Swiper('.city-highlights-swiper', {
            modules: [window.SwiperNavigation],
            slidesPerView: 2,
            spaceBetween: 20,
            navigation: {
                prevEl: '.city-highlights-prev',
                nextEl: '.city-highlights-next',
            },
            breakpoints: {
                640: { slidesPerView: 2, spaceBetween: 20 },
                1024: { slidesPerView: 4, spaceBetween: 20 },
            },
        });
    }
    if (window.Swiper && document.querySelector('.country-packages-swiper')) {
        new window.Swiper('.country-packages-swiper', {
            modules: [window.SwiperNavigation],
            slidesPerView: 1.15,
            spaceBetween: 16,
            watchOverflow: true,
            navigation: {
                prevEl: '.country-packages-prev',
                nextEl: '.country-packages-next',
            },
            breakpoints: {
                480: { slidesPerView: 1.35, spaceBetween: 16 },
                640: { slidesPerView: 2.15, spaceBetween: 16 },
                1024: { slidesPerView: 3.15, spaceBetween: 16 },
                1280: { slidesPerView: 4.15, spaceBetween: 16 },
            },
        });
    }
});
</script>
@endpush
@endsection
