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
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-16">

    {{-- Breadcrumb --}}
    <nav class="text-sm text-gray-500 mb-8" aria-label="Breadcrumb">
        <ol class="flex items-center gap-1.5">
            <li><a href="{{ route('home') }}" class="text-lime-600 hover:text-lime-700 transition">Home</a></li>
            <li>/</li>
            <li><a href="{{ route('countries.index') }}" class="text-lime-600 hover:text-lime-700 transition">Countries</a></li>
            <li>/</li>
            <li class="text-gray-700">{{ $country->name }}</li>
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
                <div class="relative rounded-2xl overflow-hidden bg-gray-200" style="aspect-ratio: 16/10;">
                    <a href="{{ $allImages[0] }}" class="glightbox block w-full h-full" data-gallery="city-gallery">
                        <img src="{{ $allImages[0] }}" alt="{{ $country->name }}" class="w-full h-full object-cover">
                    </a>
                    @if($totalPhotos > 1)
                        <div class="absolute bottom-4 right-4 flex items-center gap-2 px-3.5 py-2 rounded-lg bg-lime-900/80 backdrop-blur-sm text-white text-sm font-medium pointer-events-none">
                            <i class="fa-regular fa-images"></i>
                            {{ $totalPhotos }} photos
                        </div>
                    @endif
                </div>

                @if($thumbImages->isNotEmpty())
                    <div class="grid grid-cols-4 gap-2 mt-2">
                        @foreach($thumbImages->take(4) as $url)
                            <a href="{{ $url }}" class="glightbox group block aspect-[4/3] rounded-xl overflow-hidden bg-gray-200" data-gallery="city-gallery">
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
                <div class="rounded-2xl bg-gray-100 h-full flex items-center justify-center text-gray-400" style="min-height: 400px;">
                    No images available
                </div>
            @endif
        </div>

        {{-- Right: Title + Description --}}
        <div class="flex flex-col justify-center">
            @if($country->country)
                <p class="text-xs font-medium uppercase tracking-wider text-lime-600 mb-2">{{ $country->country }}</p>
            @endif
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-5">{{ $country->name }}</h1>
            @if($country->description)
                <div class="prose prose-gray max-w-none text-gray-600">
                    {!! $country->description !!}
                </div>
            @endif
            <div class="flex flex-wrap items-center gap-4 mt-6 pt-6 border-t border-gray-100">
                @if($country->tours->count())
                    <div class="flex items-center gap-2">
                        <span class="w-9 h-9 rounded-lg bg-lime-50 flex items-center justify-center"><i class="fa-solid fa-route text-lime-600 text-sm"></i></span>
                        <div>
                            <span class="text-lg font-bold text-gray-900">{{ $country->tours->where('is_active', true)->count() }}</span>
                            <span class="text-sm text-gray-500 ml-1">Tours</span>
                        </div>
                    </div>
                @endif
                @if($country->highlights->count())
                    <div class="flex items-center gap-2">
                        <span class="w-9 h-9 rounded-lg bg-lime-50 flex items-center justify-center"><i class="fa-solid fa-camera text-lime-600 text-sm"></i></span>
                        <div>
                            <span class="text-lg font-bold text-gray-900">{{ $country->highlights->count() }}</span>
                            <span class="text-sm text-gray-500 ml-1">Attractions</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Places to visit --}}
    @if($country->highlights->isNotEmpty())
    <section class="mb-14 overflow-hidden">
        <div class="flex items-end justify-between mb-8">
            <div>
                <p class="text-xs font-medium uppercase tracking-wider text-gray-400 mb-1">Explore</p>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Places to visit in {{ $country->name }}</h2>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" class="city-highlights-prev w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center text-gray-400 hover:text-lime-600 hover:border-lime-300 transition-colors">
                    <i class="fa-solid fa-arrow-left text-sm"></i>
                </button>
                <button type="button" class="city-highlights-next w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center text-gray-400 hover:text-lime-600 hover:border-lime-300 transition-colors">
                    <i class="fa-solid fa-arrow-right text-sm"></i>
                </button>
            </div>
        </div>
        <div class="swiper city-highlights-swiper overflow-visible">
            <div class="swiper-wrapper">
                @foreach($country->highlights as $highlight)
                <div class="swiper-slide">
                    <a href="{{ route('countries.highlights.show', [$country->slug, $highlight->slug]) }}" class="group block relative rounded-xl overflow-hidden bg-gray-200" style="aspect-ratio: 4/3;">
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
    @endif

    {{-- Tours --}}
    @if($country->tours->isNotEmpty())
    <section class="mb-14">
        <div class="flex items-end justify-between mb-8">
            <div>
                <p class="text-xs font-medium uppercase tracking-wider text-gray-400 mb-1">Curated experiences</p>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Tours in {{ $country->name }}</h2>
            </div>
            <div class="flex items-center gap-2">
                <div class="flex items-center gap-2 sm:hidden">
                    <button type="button" class="city-tours-prev w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center text-gray-400 hover:text-lime-600 hover:border-lime-300 transition-colors">
                        <i class="fa-solid fa-arrow-left text-sm"></i>
                    </button>
                    <button type="button" class="city-tours-next w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center text-gray-400 hover:text-lime-600 hover:border-lime-300 transition-colors">
                        <i class="fa-solid fa-arrow-right text-sm"></i>
                    </button>
                </div>
                <a href="{{ route('tours.index', ['country' => $country->slug]) }}" class="text-sm font-medium text-lime-600 hover:text-lime-700 transition hidden sm:block">
                    View all tours &rarr;
                </a>
            </div>
        </div>
        {{-- Grid on desktop --}}
        <div class="hidden sm:grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
            @foreach($country->tours->where('is_active', true)->take(8) as $tour)
                <x-tour-card :tour="$tour" :queryParams="[]" />
            @endforeach
        </div>
        {{-- Slider on mobile --}}
        <div class="swiper city-tours-swiper overflow-visible block sm:!hidden">
            <div class="swiper-wrapper">
                @foreach($country->tours->where('is_active', true)->take(8) as $tour)
                <div class="swiper-slide">
                    <x-tour-card :tour="$tour" :queryParams="['country' => $country->slug]" :slider="true" />
                </div>
                @endforeach
            </div>
        </div>
        <div class="mt-6 text-center sm:hidden">
            <a href="{{ route('tours.index', ['country' => $country->slug]) }}" class="text-sm font-medium text-lime-600 hover:text-lime-700 transition">
                View all tours &rarr;
            </a>
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
    if (window.Swiper && document.querySelector('.city-tours-swiper')) {
        new window.Swiper('.city-tours-swiper', {
            modules: [window.SwiperNavigation],
            slidesPerView: 1.2,
            spaceBetween: 20,
            navigation: {
                prevEl: '.city-tours-prev',
                nextEl: '.city-tours-next',
            },
        });
    }
});
</script>
@endpush
@endsection
