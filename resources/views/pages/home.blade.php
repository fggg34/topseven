@extends('layouts.site')

@section('title', \App\Models\Setting::get('homepage_seo_title') ?: (\App\Models\Setting::get('site_name', config('app.name')) . ' - ' . \App\Models\Setting::get('site_tagline', __('Discover your next adventure'))))
@section('description', \App\Models\Setting::get('homepage_seo_description') ?: \App\Models\Setting::get('hero_subtitle', __('Explore stunning destinations with expert guides.')))
@if(\App\Models\Setting::get('homepage_seo_og_image'))@section('og_image', \App\Models\Setting::get('homepage_seo_og_image'))@endif

@section('hero')
@php
    $heroSlides = isset($heroSlides) && $heroSlides->isNotEmpty()
        ? $heroSlides
        : collect([
            (object) [
                'title' => __("Europe's Best Travel Packages & Things to Do"),
                'subtitle' => __('Book unforgettable trips with local experts.'),
                'banner_type' => 'image',
                'banner_image_url' => 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=1920',
                'banner_video_url' => null,
                'cta_text' => __('Book now'),
                'cta_url' => route('tours.index'),
            ],
        ]);
    $resolveUrl = fn ($u) => (str_starts_with($u ?? '', 'http') ? $u : url($u ?? '#'));
@endphp
<section class="home-hero-section relative isolate h-[min(85vh,650px)] min-h-[520px] md:h-[650px] bg-black text-white overflow-hidden">
    {{-- Media layer: same box as UI layer below (both absolute inset-0) --}}
    @php $heroSlideCount = $heroSlides->count(); @endphp
    <div @class([
        'swiper home-hero-swiper' => $heroSlideCount > 1,
        'absolute inset-0 z-0 h-full min-h-0',
    ])>
        <div class="{{ $heroSlideCount > 1 ? 'swiper-wrapper' : '' }}" style="height:100%">
            @foreach($heroSlides as $slide)
                @php
                    $videoUrl = $slide->banner_video_url ?? null;
                    $imageUrl = $slide->banner_image_url ?? null;
                    $useVideo = (($slide->banner_type ?? '') === 'video') && ! empty($videoUrl);
                    $useImage = ! empty($imageUrl);
                    $fallbackImage = 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=1920';
                    $ctaUrl = ! empty($slide->cta_url) ? $resolveUrl($slide->cta_url) : route('tours.index');
                @endphp
                <div @class([
                    'swiper-slide' => $heroSlideCount > 1,
                    'relative h-full min-h-0 overflow-hidden',
                ]) style="height:100%;">
                    @if($useVideo)
                        <video autoplay muted loop playsinline class="home-hero-media absolute inset-0 h-full w-full object-cover pointer-events-none">
                            <source src="{{ $videoUrl }}" type="video/mp4">
                        </video>
                    @elseif($useImage)
                        <div class="home-hero-media absolute inset-0 bg-cover bg-center pointer-events-none" style="background-image: url('{{ $imageUrl }}');"></div>
                    @else
                        <div class="home-hero-media absolute inset-0 bg-cover bg-center pointer-events-none" style="background-image: url('{{ $fallbackImage }}');"></div>
                    @endif
                    <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-black/30"></div>

                    {{-- Copy lives inside the slide so it translates with the background --}}
                    <div @class([
                        'home-hero-slide-caption absolute inset-x-0 bottom-0 z-10 px-4 pt-8 sm:px-6 lg:px-[80px] pointer-events-auto',
                        'pb-24 sm:pb-28 md:pb-32' => $heroSlideCount > 1,
                        'pb-12 md:pb-16' => $heroSlideCount <= 1,
                    ])>
                        <div class="mx-auto w-full max-w-[1400px]">
                            <div class="max-w-3xl lg:max-w-4xl">
                                @if($loop->first)
                                    <h1 class="text-4xl font-bold leading-[1.08] tracking-tight sm:text-5xl md:text-5xl lg:text-6xl xl:text-7xl mb-3 lg:mb-4">{{ $slide->title }}</h1>
                                @else
                                    <h2 class="text-4xl font-bold leading-[1.08] tracking-tight sm:text-5xl md:text-5xl lg:text-6xl xl:text-7xl mb-3 lg:mb-4">{{ $slide->title }}</h2>
                                @endif
                                @if(filled($slide->subtitle ?? null))
                                    <p class="mb-6 text-lg leading-relaxed text-white/90 sm:text-xl md:text-xl lg:mb-8 lg:text-2xl">{{ $slide->subtitle }}</p>
                                @endif
                                @if(filled($slide->cta_text ?? null))
                                    <a href="{{ $ctaUrl }}"
                                       class="inline-flex items-center rounded-full border-2 border-white px-8 py-3.5 text-base font-semibold text-white transition-all duration-200 hover:bg-white hover:text-gray-900 lg:px-10 lg:py-4 lg:text-lg">{{ $slide->cta_text }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Search: top strip only (does not cover slide copy) --}}
    <div class="pointer-events-none absolute inset-x-0 top-0 z-30 px-4 pt-20 sm:px-6 md:pt-24 lg:px-[80px]">
        <div class="pointer-events-auto mx-auto mt-2 w-full max-w-[1400px]">
            <x-hero-search-form :action="route('tours.index')" :countries="$countries ?? collect()" />
        </div>
    </div>

    {{-- Pagination only; pointer-events-none wrapper so slide captions stay visible & clickable --}}
    @if($heroSlideCount > 1)
        <div class="pointer-events-none absolute inset-x-0 bottom-0 z-30 flex justify-end px-4 pb-10 sm:px-6 sm:pb-12 md:pb-16 lg:px-[80px]">
            <div class="home-hero-pagination swiper-pagination swiper-pagination-horizontal pointer-events-auto" role="tablist" aria-label="{{ __('Hero slides') }}"></div>
        </div>
    @endif
</section>
@endsection

@section('content')
<x-home-flash-sale-slider :rows="$homepageFlashSaleTours ?? collect()" />

<x-home-why-book :heading="$whyBookHeading" :cards="$whyBookCards" />

<x-home-where-next :countries="$whereNextCountries ?? collect()" />

@if(($homepageReviews ?? collect())->isNotEmpty())
<section class="home-testimonials-section px-4 sm:px-6 lg:px-[80px] pt-16 pb-16">
    <div class="mx-auto w-full max-w-[1400px]">
        <h2 class="text-center text-3xl md:text-[40px] font-semibold text-[#2f2419] tracking-tight mb-7">
            {{ __('What do Top 7 Agency travellers say') }}
        </h2>

        <div class="relative overflow-visible">

            <button type="button" class="home-testimonials-prev absolute left-0 top-1/2 -translate-y-1/2 -translate-x-1/2 z-20 w-12 h-12 rounded-full bg-white text-gray-500 border border-gray-100 shadow-[0_10px_22px_rgba(15,23,42,0.12)] flex items-center justify-center hover:text-gray-700 transition-colors" aria-label="{{ __('Previous review') }}">
                <i class="fa-solid fa-arrow-left text-sm"></i>
            </button>
            <button type="button" class="home-testimonials-next absolute right-0 top-1/2 -translate-y-1/2 translate-x-1/2 z-20 w-12 h-12 rounded-full bg-white text-gray-500 border border-gray-100 shadow-[0_10px_22px_rgba(15,23,42,0.12)] flex items-center justify-center hover:text-gray-700 transition-colors" aria-label="{{ __('Next review') }}">
                <i class="fa-solid fa-arrow-right text-sm"></i>
            </button>

            <div class="relative rounded-md overflow-hidden bg-cover bg-center" style="background-image: linear-gradient(rgba(0,0,0,0.05), rgba(0,0,0,0.05)), url('https://images.unsplash.com/photo-1530789253388-582c481c54b0?auto=format&fit=crop&w=1800&q=80');">
                <div class="absolute inset-0 bg-gradient-to-r from-[#ab6f2e]/20 via-transparent to-[#f0ca79]/25 pointer-events-none"></div>
                <div class="swiper home-testimonials-swiper">
                    <div class="swiper-wrapper">
                @foreach($homepageReviews as $review)
                    @php
                        $name = $review->display_name;
                        $safeComment = trim((string) $review->comment);
                        $comment = $safeComment !== '' ? $safeComment : __('Great service, smooth planning, and an unforgettable trip from start to finish.');
                        $title = trim((string) ($review->title ?? '')) ?: $comment;
                    @endphp
                    <div class="swiper-slide">
                        <div class="home-testimonial-slide relative min-h-[230px] md:min-h-[250px]">
                            <div class="relative z-10 px-6 md:px-10 py-6 md:py-8 flex items-center justify-center min-h-[230px] md:min-h-[250px]">
                                <article class="w-full max-w-4xl bg-white/95 border border-[#efe7dc] shadow-[0_18px_40px_rgba(15,23,42,0.13)] px-5 md:px-10 py-5 md:py-6">
                                    <h3 class="text-[22px] md:text-[34px] leading-tight font-medium text-[#3f2f23] mb-3">
                                        &ldquo;{{ \Illuminate\Support\Str::limit($title, 90) }}&rdquo;
                                    </h3>
                                    <p class="text-[15px] md:text-[17px] leading-relaxed text-[#4d3f33] mb-4">
                                        {{ \Illuminate\Support\Str::limit($comment, 220) }}
                                    </p>
                                    <div class="flex items-center justify-between gap-3 flex-wrap">
                                        <p class="text-[15px] font-semibold text-[#2f2419]">{{ $name }}</p>
                                        @if($review->platform)
                                            <span class="inline-flex items-center gap-2 rounded bg-white px-2 py-1 border border-gray-200 text-[12px] text-gray-700">
                                                <span class="inline-block w-2 h-2 rounded-full bg-green-500"></span>
                                                {{ $review->platform }}
                                            </span>
                                        @endif
                                    </div>
                                </article>
                            </div>
                        </div>
                    </div>
                @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<x-home-flash-sale-slider :rows="$homepageFlashSaleToursSecondary ?? collect()" />
<x-home-seasonal-banners-slider :banners="$homepageSeasonalBanners ?? collect()" />
<x-home-blog-stories :posts="$homepageBlogPosts ?? collect()" />

@push('styles')
<style>
    /* Swiper below search/pagination; media ignores clicks (swipe hits slide), captions/links stay clickable */
    .home-hero-swiper {
        z-index: 0 !important;
        pointer-events: auto;
    }
    .home-hero-swiper .home-hero-media {
        pointer-events: none;
    }
    .home-hero-swiper,
    .home-hero-swiper .swiper-wrapper,
    .home-hero-swiper .swiper-slide {
        height: 100% !important;
    }
    .home-hero-pagination .swiper-pagination-bullet {
        display: inline-block;
        width: 12px;
        height: 12px;
        background: transparent;
        border: 2px solid rgba(255, 255, 255, 0.6);
        opacity: 1;
        border-radius: 50%;
        cursor: pointer;
    }
    .home-hero-pagination .swiper-pagination-bullet-active {
        background: #ffffff;
        border-color: #ffffff;
    }
    /* Bullets: visible row (Swiper defaults to absolute full-width) */
    .home-hero-section .home-hero-pagination.swiper-pagination {
        position: relative !important;
        left: auto !important;
        right: auto !important;
        bottom: auto !important;
        top: auto !important;
        width: auto !important;
        max-width: 100%;
        transform: none !important;
        display: flex !important;
        flex-direction: row !important;
        flex-wrap: wrap !important;
        align-items: center !important;
        gap: 0.5rem !important;
        justify-content: flex-start !important;
    }
    @media (min-width: 640px) {
        .home-hero-section .home-hero-pagination.swiper-pagination {
            justify-content: flex-end !important;
        }
    }
    .home-testimonials-prev.swiper-button-disabled,
    .home-testimonials-next.swiper-button-disabled {
        opacity: 0.35;
        pointer-events: none;
    }
    .home-testimonial-slide article {
        backdrop-filter: blur(1px);
    }
    .home-testimonials-swiper .swiper-slide {
        display: flex;
        justify-content: center;
    }
    .home-seasonal-next.swiper-button-disabled {
        opacity: 0.35;
        pointer-events: none;
    }
    .home-blog-stories-prev.swiper-button-disabled,
    .home-blog-stories-next.swiper-button-disabled {
        opacity: 0.35;
        pointer-events: none;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var heroSwiperEl = document.querySelector('.home-hero-swiper');
    if (window.Swiper && heroSwiperEl) {
        var heroSlideCount = heroSwiperEl.querySelectorAll('.swiper-slide').length;
        var heroSection = document.querySelector('.home-hero-section');
        var pagEl = heroSection ? heroSection.querySelector('.home-hero-pagination') : null;

        new window.Swiper(heroSwiperEl, {
            modules: [window.SwiperAutoplay, window.SwiperPagination],
            slidesPerView: 1,
            speed: 600,
            loop: false,
            rewind: heroSlideCount > 1,
            autoplay: heroSlideCount > 1 ? { delay: 6000, disableOnInteraction: false } : false,
            pagination: pagEl ? {
                el: pagEl,
                clickable: true,
                type: 'bullets',
            } : undefined,
        });
    }
    if (window.Swiper) {
        document.querySelectorAll('.home-flash-sale-swiper').forEach(function (el) {
            var section = el.closest('.home-flash-sale-section');
            var prev = section ? section.querySelector('.home-flash-sale-prev') : null;
            var next = section ? section.querySelector('.home-flash-sale-next') : null;
            new window.Swiper(el, {
                modules: [window.SwiperNavigation],
                slidesPerView: 1.15,
                spaceBetween: 16,
                watchOverflow: true,
                navigation: {
                    prevEl: prev,
                    nextEl: next,
                },
                breakpoints: {
                    480: { slidesPerView: 1.35, spaceBetween: 16 },
                    640: { slidesPerView: 2.15, spaceBetween: 16 },
                    1024: { slidesPerView: 3.15, spaceBetween: 16 },
                    1280: { slidesPerView: 4.15, spaceBetween: 16 },
                },
            });
        });
        document.querySelectorAll('.home-blog-stories-swiper').forEach(function (el) {
            var section = el.closest('.home-blog-stories-section');
            var prev = section ? section.querySelector('.home-blog-stories-prev') : null;
            var next = section ? section.querySelector('.home-blog-stories-next') : null;
            new window.Swiper(el, {
                modules: [window.SwiperNavigation],
                slidesPerView: 1.15,
                spaceBetween: 16,
                watchOverflow: true,
                navigation: {
                    prevEl: prev,
                    nextEl: next,
                },
                breakpoints: {
                    480: { slidesPerView: 1.35, spaceBetween: 16 },
                    640: { slidesPerView: 2.15, spaceBetween: 16 },
                    1024: { slidesPerView: 3.15, spaceBetween: 16 },
                    1280: { slidesPerView: 4.15, spaceBetween: 16 },
                },
            });
        });
    }
    if (window.Swiper && document.querySelector('.featured-tours-swiper')) {
        new window.Swiper('.featured-tours-swiper', {
            modules: [window.SwiperNavigation],
            slidesPerView: 1.2,
            spaceBetween: 20,
            navigation: {
                prevEl: '.featured-prev',
                nextEl: '.featured-next',
            },
            breakpoints: {
                640: { slidesPerView: 2.2, spaceBetween: 20 },
                1024: { slidesPerView: 3.2, spaceBetween: 20 },
                1280: { slidesPerView: 4, spaceBetween: 20 },
            },
        });
    }
    if (window.Swiper && document.querySelector('.home-testimonials-swiper')) {
        new window.Swiper('.home-testimonials-swiper', {
            modules: [window.SwiperNavigation, window.SwiperAutoplay],
            slidesPerView: 1,
            centeredSlides: true,
            speed: 650,
            loop: true,
            autoplay: { delay: 7000, disableOnInteraction: false },
            navigation: {
                prevEl: '.home-testimonials-prev',
                nextEl: '.home-testimonials-next',
            },
        });
    }
    if (window.Swiper && document.querySelector('.home-seasonal-banners-swiper')) {
        new window.Swiper('.home-seasonal-banners-swiper', {
            modules: [window.SwiperNavigation, window.SwiperAutoplay],
            slidesPerView: 2.3,
            spaceBetween: 14,
            speed: 700,
            watchOverflow: true,
            autoplay: { delay: 5500, disableOnInteraction: false },
            navigation: {
                nextEl: '.home-seasonal-next',
            },
            breakpoints: {
                640: { slidesPerView: 1.2, spaceBetween: 12 },
                1024: { slidesPerView: 2.2, spaceBetween: 14 },
                1280: { slidesPerView: 2.3, spaceBetween: 14 },
            },
        });
    }
});
</script>
@endpush
@endsection
