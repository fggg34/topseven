@extends('layouts.site')

@section('title', \App\Models\Setting::get('homepage_seo_title') ?: (\App\Models\Setting::get('site_name', config('app.name')) . ' - ' . \App\Models\Setting::get('site_tagline', 'Discover your next adventure')))
@section('description', \App\Models\Setting::get('homepage_seo_description') ?: \App\Models\Setting::get('hero_subtitle', 'Explore stunning destinations with expert guides.'))
@if(\App\Models\Setting::get('homepage_seo_og_image'))@section('og_image', \App\Models\Setting::get('homepage_seo_og_image'))@endif

@section('hero')
@php
    $hero = $hero ?? null;
    $heroTitle = $hero?->title ?? \App\Models\Setting::get('hero_title', "Europe's Best Tours & Things to Do");
    $bgImage = $hero && $hero->banner_type === 'image' && $hero->banner_image ? $hero->banner_image_url : 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=1920';
    $bgVideo = $hero && $hero->banner_type === 'video' && $hero->banner_video ? $hero->banner_video_url : null;
@endphp
<section class="w-full bg-white">
    {{-- Banner Image - 200px wider than container, 520px height --}}
    <div class="max-w-7xl mx-auto px-0 pt-0 sm:px-6 sm:pt-6 lg:px-8">
        <div class="relative w-full md:-mx-[100px] md:w-[calc(100%+200px)] overflow-hidden h-[50vh] max-h-[50vh] md:max-h-none md:h-[520px] rounded-none md:rounded-[25px]">
            @if($bgVideo)
                <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover">
                    <source src="{{ $bgVideo }}" type="video/mp4">
                </video>
            @else
                <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ $bgImage }}');"></div>
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
        </div>
    </div>

    {{-- Title + Search --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-[110px] relative z-10">
        <div class="text-center">
            <h1 class="text-3xl md:text-4xl lg:text-[2.75rem] font-bold text-white leading-tight mb-8">{{ $heroTitle }}</h1>
        </div>

        <x-hero-search-form :action="route('tours.index')" :countries="$countries ?? collect()" />

        {{-- Country tag buttons --}}
        @if(isset($countries) && $countries->isNotEmpty())
        <div class="flex flex-wrap items-center justify-center gap-2.5 mt-7 pb-6">
            @foreach($countries->take(8) as $country)
                <a href="{{ route('countries.show', $country->slug) }}"
                   class="inline-block px-4 py-1.5 text-sm font-medium text-lime-600 border border-lime-300 rounded-full hover:bg-lime-50 hover:border-lime-400 transition-colors">
                    {{ $country->name }}
                </a>
            @endforeach
        </div>
        @endif
    </div>
</section>
@endsection

@section('content')
{{-- Featured Tours Swiper --}}
@if($featuredTours->isNotEmpty())
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="flex items-end justify-between mb-8">
        <div>
            <p class="text-xs font-medium uppercase tracking-wider text-gray-400 mb-1">Our best selling tours at a glance</p>
            <h2 class="text-2xl md:text-3xl font-bold text-lime-900">
                @php $searchSlug = request()->get('country') ?: request()->get('city'); @endphp
                @if($searchSlug && $countryName = ($countries ?? collect())->firstWhere('slug', $searchSlug)?->name)
                    Based on your search in {{ $countryName }}
                @else
                    Most Popular Tours
                @endif
            </h2>
        </div>
        <div class="flex items-center gap-2">
            <button type="button" class="featured-prev w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center text-gray-400 hover:text-lime-600 hover:border-lime-300 transition-colors">
                <i class="fa-solid fa-arrow-left text-sm"></i>
            </button>
            <button type="button" class="featured-next w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center text-gray-400 hover:text-lime-600 hover:border-lime-300 transition-colors">
                <i class="fa-solid fa-arrow-right text-sm"></i>
            </button>
        </div>
    </div>
    <div class="swiper featured-tours-swiper overflow-visible md:overflow-hidden">
        <div class="swiper-wrapper">
            @foreach($featuredTours as $tour)
                <div class="swiper-slide">
                    <x-tour-card :tour="$tour" :queryParams="[]" :wishlisted="in_array($tour->id, $wishlistedIds ?? [])" />
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Booking confidence (dynamic from Admin > Homepage) --}}
@php
    $bookingVisible = filter_var(\App\Models\Setting::get('homepage_booking_visible', true), FILTER_VALIDATE_BOOLEAN);
    $bookingItems = \App\Models\Setting::get('homepage_booking_items', '');
    $bookingItems = is_string($bookingItems) ? (json_decode($bookingItems, true) ?: []) : $bookingItems;
    if (empty($bookingItems)) {
        $bookingItems = [
            ['icon' => 'fa-solid fa-shield-halved', 'title' => 'Feel confident in booking', 'description' => 'Cancel and get a refund up to 7 days before'],
            ['icon' => 'fa-regular fa-calendar', 'title' => 'Change of plans?', 'description' => 'Easily reschedule your booking'],
            ['icon' => 'fa-regular fa-credit-card', 'title' => 'Pay your way', 'description' => 'Fast, secure checkout in your currency'],
        ];
    }
@endphp
@if($bookingVisible && count($bookingItems) > 0)
<section class="bg-white py-12 md:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-12">
            @foreach($bookingItems as $item)
            <div class="flex items-center gap-4">
                <div class="flex-shrink-0 flex items-center justify-center">
                    @if(!empty($item['icon']))
                    <i class="{{ $item['icon'] }} text-lime-600 text-[40px]"></i>
                    @endif
                </div>
                <div class="flex flex-col min-w-0">
                    @if(!empty($item['title']))
                    <h3 class="text-lg font-semibold text-lime-600 mb-0">{{ $item['title'] }}</h3>
                    @endif
                    @if(!empty($item['description']))
                    <p class="text-gray-600 text-[15px] leading-relaxed">{{ $item['description'] }}</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Tour Packages --}}
@if(isset($tourPackages) && $tourPackages->isNotEmpty())
<section class="bg-gray-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-8">
            <div class="flex items-center gap-4">
                <h2 class="text-2xl md:text-3xl font-bold text-lime-900">Our Packages</h2>
                <a href="{{ route('tour-packages.index') }}" class="text-sm font-medium text-lime-600 hover:text-lime-700 transition-colors">View all</a>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" class="packages-prev w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center text-gray-400 hover:text-lime-600 hover:border-lime-300 transition-colors">
                    <i class="fa-solid fa-arrow-left text-sm"></i>
                </button>
                <button type="button" class="packages-next w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center text-gray-400 hover:text-lime-600 hover:border-lime-300 transition-colors">
                    <i class="fa-solid fa-arrow-right text-sm"></i>
                </button>
            </div>
        </div>
        <div class="swiper packages-swiper overflow-visible md:overflow-hidden">
            <div class="swiper-wrapper">
                @foreach($tourPackages as $package)
                <div class="swiper-slide">
                    @php
                        $imageUrl = $package->image_url ? asset($package->image_url) : 'https://placehold.co/400x300/e5e7eb/6b7280?text=' . urlencode($package->title);
                        $linkUrl = $package->instagram_post_url ?: '#';
                    @endphp
                    <a href="{{ $linkUrl }}" target="{{ $package->instagram_post_url ? '_blank' : '_self' }}" rel="{{ $package->instagram_post_url ? 'noopener noreferrer' : '' }}"
                       class="group block rounded-xl overflow-hidden bg-gray-200 border border-gray-200 hover:border-lime-300 transition-all duration-300">
                        <img src="{{ $imageUrl }}" alt="{{ $package->title }}"
                             class="w-full h-auto object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

{{-- The Difference Section (dynamic from Admin > Homepage) --}}
@php
    $diffVisible = filter_var(\App\Models\Setting::get('homepage_difference_visible', true), FILTER_VALIDATE_BOOLEAN);
    $diffTitle = \App\Models\Setting::get('homepage_difference_title', '');
    $diffTitle = $diffTitle ?: 'The ' . \App\Models\Setting::get('site_name', config('app.name')) . ' Difference';
    $diffP1 = \App\Models\Setting::get('homepage_difference_paragraph_1', '');
    $diffP2 = \App\Models\Setting::get('homepage_difference_paragraph_2', '');
    $diffCtaText = \App\Models\Setting::get('homepage_difference_cta_text', 'Read more about us');
    $diffCtaUrl = \App\Models\Setting::get('homepage_difference_cta_url', '') ?: route('about');
    $diffImg1 = \App\Models\Setting::get('homepage_difference_image_1', '');
    $diffImg1 = $diffImg1 ? '/storage/' . ltrim($diffImg1, '/') : 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=700&h=480&fit=crop';
    $diffImg2 = \App\Models\Setting::get('homepage_difference_image_2', '');
    $diffImg2 = $diffImg2 ? '/storage/' . ltrim($diffImg2, '/') : 'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?w=500&h=400&fit=crop';
@endphp
@if($diffVisible && ($diffTitle || $diffP1 || $diffP2))
<section class="bg-white py-16 md:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-20">

            {{-- Left: Text --}}
            <div class="flex-1 max-w-xl">
                @if($diffTitle)
                <h2 class="text-3xl md:text-[2.6rem] font-bold text-lime-900 leading-tight mb-6">
                    {{ $diffTitle }}
                </h2>
                @endif
                @if($diffP1)
                <p class="text-gray-500 text-[15px] leading-relaxed mb-4">
                    {{ $diffP1 }}
                </p>
                @endif
                @if($diffP2)
                <p class="text-gray-500 text-[15px] leading-relaxed mb-8">
                    {{ $diffP2 }}
                </p>
                @endif
                @if($diffCtaText && $diffCtaUrl)
                <a href="{{ $diffCtaUrl }}" class="inline-flex items-center px-6 py-3 bg-brand-btn hover:bg-brand-btn-hover text-white text-sm font-medium rounded-md transition-colors">
                    {{ $diffCtaText }}
                </a>
                @endif
            </div>

            {{-- Right: Two overlapping images --}}
            <div class="flex-1 relative w-full" style="min-height: 380px;">
                {{-- Back image: landscape, tilted counter-clockwise --}}
                <div class="absolute" style="left: 5%; top: 0; width: 54%; z-index: 1; transform: rotate(-4deg); transform-origin: bottom left;">
                    <img src="{{ $diffImg1 }}"
                         alt="Travel destination"
                         class="w-full object-cover rounded-lg shadow-md"
                         style="height: 300px;">
                </div>
                {{-- Front image: portrait, tilted clockwise --}}
                <div class="absolute" style="right: 0; bottom: 0; width: 50%; z-index: 2; transform: rotate(4deg); transform-origin: top right;">
                    <img src="{{ $diffImg2 }}"
                         alt="Travel experience"
                         class="w-full object-cover rounded-lg shadow-md"
                         style="height: 260px;">
                </div>
            </div>

        </div>
    </div>
</section>
@endif

{{-- Tour Category Rows (Day Tours, Multi Day Tours) --}}
@if(isset($homepageCategories) && $homepageCategories->isNotEmpty())
<section class="bg-gray-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">

        @foreach($homepageCategories as $category)
        @php $catSlug = $category->slug; @endphp
        {{-- Category card + Tours slider inline (side by side on desktop) --}}
        <div class="flex flex-col lg:flex-row gap-5 items-stretch">
            {{-- Category card --}}
            <a href="{{ route('tours.index', ['category' => $category->slug]) }}"
               class="group relative flex-shrink-0 rounded-lg overflow-hidden bg-gray-300 lg:w-[340px]"
               style="min-height: 360px;">
                <img src="{{ $category->image_url ? asset($category->image_url) : 'https://placehold.co/600x700/e5e7eb/6b7280?text=' . urlencode($category->name) }}"
                     alt="{{ $category->name }}"
                     class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                <div class="absolute inset-0 flex flex-col justify-between p-5">
                    <span class="text-white text-2xl font-bold drop-shadow">{{ $category->name }}</span>
                    <span class="inline-flex items-center self-start px-4 py-2 bg-white/90 hover:bg-white text-gray-900 text-sm font-semibold rounded-md transition-colors shadow-sm">
                        View Tours
                    </span>
                </div>
            </a>
            {{-- Tours slider with arrows above top right --}}
            <div class="flex-1 min-w-0 flex flex-col">
                <div class="flex justify-end mb-4">
                    <div class="flex items-center gap-2">
                        <button type="button" class="category-{{ $catSlug }}-prev w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center text-gray-400 hover:text-lime-600 hover:border-lime-300 transition-colors">
                            <i class="fa-solid fa-arrow-left text-sm"></i>
                        </button>
                        <button type="button" class="category-{{ $catSlug }}-next w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center text-gray-400 hover:text-lime-600 hover:border-lime-300 transition-colors">
                            <i class="fa-solid fa-arrow-right text-sm"></i>
                        </button>
                    </div>
                </div>
                <div style="padding: 7px 3px;" class="swiper category-{{ $catSlug }}-swiper overflow-visible md:overflow-hidden flex-1">
                    <div class="swiper-wrapper">
                        @foreach($category->tours as $tour)
                        <div class="swiper-slide">
                            <x-tour-card :tour="$tour" :queryParams="['category' => $category->slug]" :wishlisted="in_array($tour->id, $wishlistedIds ?? [])" :slider="true" />
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endforeach

    </div>
</section>
@endif

{{-- Testimonials --}}
@if(isset($testimonials) && $testimonials->isNotEmpty())
<section class="bg-white py-16 md:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-8">
            <div>
                <p class="text-xs font-medium uppercase tracking-wider text-gray-400 mb-1">What our clients say</p>
                <h2 class="text-2xl md:text-3xl font-bold text-lime-900">
                    Over {{ number_format($totalReviews ?? $testimonials->count()) }}+ Happy Travellers
                </h2>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" class="testimonials-prev w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center text-gray-400 hover:text-lime-600 hover:border-lime-300 transition-colors">
                    <i class="fa-solid fa-arrow-left text-sm"></i>
                </button>
                <button type="button" class="testimonials-next w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center text-gray-400 hover:text-lime-600 hover:border-lime-300 transition-colors">
                    <i class="fa-solid fa-arrow-right text-sm"></i>
                </button>
            </div>
        </div>
        <div class="swiper testimonials-swiper">
            <div class="swiper-wrapper pb-2">
                @foreach($testimonials as $review)
                @php
                    $reviewerName = $review->user?->name ?? 'Anonymous';
                    $words = explode(' ', trim($reviewerName), 2);
                    $initials = count($words) >= 2
                        ? strtoupper(mb_substr($words[0], 0, 1) . mb_substr($words[1], 0, 1))
                        : strtoupper(mb_substr($reviewerName, 0, 2));
                    $tourTitle = $review->tour?->title ?? null;
                    $rating = (int) ($review->rating ?? 5);
                @endphp
                <div class="swiper-slide" style="height: auto;">
                    <div class="flex flex-col h-full bg-white rounded-xl border border-gray-200 p-6 transition-shadow hover:shadow-md">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-0.5">
                                @for($i = 0; $i < $rating; $i++)
                                    <i class="fa-solid fa-star text-amber-400 text-sm"></i>
                                @endfor
                                @for($i = $rating; $i < 5; $i++)
                                    <i class="fa-regular fa-star text-gray-300 text-sm"></i>
                                @endfor
                            </div>
                            <svg class="w-8 h-8 text-brand-btn/20" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10H14.017zM0 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151C7.546 6.068 5.983 8.789 5.983 11H10v10H0z"/></svg>
                        </div>
                        <p class="text-gray-600 text-[15px] leading-relaxed flex-1">{{ Str::limit($review->comment, 200) }}</p>
                        <div class="flex items-center gap-3 mt-5 pt-4 border-t border-gray-100">
                            <div class="w-10 h-10 rounded-full bg-lime-50 flex items-center justify-center text-brand-btn text-sm font-bold flex-shrink-0">
                                {{ $initials }}
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-gray-900">{{ $reviewerName }}</p>
                                @if($tourTitle)
                                    <p class="text-xs text-gray-400 truncate">{{ $tourTitle }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

{{-- Top destinations (countries) --}}
@if(isset($destinationCountries) && $destinationCountries->isNotEmpty())
<section class="w-full bg-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-end justify-between mb-8">
        <div>
            <p class="text-xs font-medium uppercase tracking-wider text-gray-400 mb-1">Experience the world like a local</p>
            <h2 class="text-2xl md:text-3xl font-bold text-lime-900">Top Countries</h2>
        </div>
        <div class="flex items-center gap-2">
            <button type="button" class="destinations-prev w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center text-gray-400 hover:text-lime-600 hover:border-lime-300 transition-colors">
                <i class="fa-solid fa-arrow-left text-sm"></i>
            </button>
            <button type="button" class="destinations-next w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center text-gray-400 hover:text-lime-600 hover:border-lime-300 transition-colors">
                <i class="fa-solid fa-arrow-right text-sm"></i>
            </button>
        </div>
    </div>
    <div class="swiper destinations-swiper overflow-visible md:overflow-hidden">
        <div class="swiper-wrapper">
            @foreach($destinationCountries as $country)
            <div class="swiper-slide">
                <a href="{{ route('countries.show', $country->slug) }}" class="group block relative rounded-xl overflow-hidden bg-gray-200" style="aspect-ratio: 4/3;">
                    <img src="{{ $country->city_image_url ?? 'https://placehold.co/600x450/e5e7eb/6b7280?text=' . urlencode($country->name) }}"
                         alt="{{ $country->name }}"
                         class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent"></div>

                    {{-- Price badge --}}
                    @php
                        $cheapestPrice = $country->tours?->where('is_active', true)->min('price');
                    @endphp
                    @if($cheapestPrice)
                    <div class="absolute top-3 left-3">
                        <span class="inline-flex items-center px-2 py-0.5 text-[11px] font-semibold bg-white/90 backdrop-blur-sm text-gray-800 rounded">
                            From €{{ number_format($cheapestPrice, 2) }}
                        </span>
                    </div>
                    @endif

                    {{-- Region + name --}}
                    <div class="absolute bottom-3 left-3 right-3">
                        @if($country->country)
                        <div class="flex items-center gap-1.5 mb-1">
                            <span class="text-[11px] text-white/80">{{ $country->country }}</span>
                        </div>
                        @endif
                        <h3 style="color: #fff !important;" class="text-white font-bold text-base md:text-lg drop-shadow">{{ $country->name }}</h3>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    </div>
</section>
@endif

{{-- Visit us: map + agency location --}}
@php
    $agencyMapLat = 41.3280314;
    $agencyMapLng = 19.8226907;
    $agencyMapEmbed = 'https://www.google.com/maps?q=' . $agencyMapLat . ',' . $agencyMapLng . '&z=16&output=embed';
    $agencyMapOpen = 'https://www.google.com/maps/search/?api=1&query=' . $agencyMapLat . ',' . $agencyMapLng;
    $siteNameForMap = \App\Models\Setting::get('site_name', config('app.name'));
    $contactAddress = trim((string) \App\Models\Setting::get('contact_address', ''));
    $googleRatingRaw = \App\Models\Setting::get('google_business_rating', '');
    $googleRating = is_numeric($googleRatingRaw) ? min(5, max(0, (float) $googleRatingRaw)) : 0.0;
    $googleReviewCountRaw = \App\Models\Setting::get('google_business_review_count', '');
    $googleReviewCount = is_numeric($googleReviewCountRaw) ? max(0, (int) $googleReviewCountRaw) : 0;
    $googleReviewsUrl = trim((string) \App\Models\Setting::get('google_business_reviews_url', ''));
    $googleReviewsLink = $googleReviewsUrl !== '' ? $googleReviewsUrl : $agencyMapOpen;
@endphp
<section class="bg-white py-16 md:py-20 border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-12 lg:items-start">
            <div class="flex flex-col justify-center min-w-0">
                <p class="text-xs font-medium uppercase tracking-wider text-lime-600/90 mb-2">Visit us</p>
                <h2 class="text-2xl md:text-3xl font-bold text-lime-900 leading-tight mb-4">
                    Plan your next trip with us in person
                </h2>
                <p class="text-gray-600 text-[15px] leading-relaxed mb-6">
                    {{ $siteNameForMap }} is based in the heart of Tirana. Drop by to chat about itineraries, get local tips, or book your adventures face to face with our team.
                </p>
                <ul class="space-y-3 mb-8">
                    <li class="flex items-start gap-3 text-[15px] text-gray-600">
                        <span class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-lime-50 text-lime-600">
                            <i class="fa-solid fa-location-dot text-sm" aria-hidden="true"></i>
                        </span>
                        <span>
                            <span class="font-semibold text-gray-900 block">{{ $contactAddress ? 'Our office' : 'Central Tirana' }}</span>
                            @if($contactAddress)
                                <span class="whitespace-pre-line">{{ $contactAddress }}</span>
                            @else
                                Easy to find in central Tirana — the pin on the map marks our door.
                            @endif
                        </span>
                    </li>
                    <li class="flex items-start gap-3 text-[15px] text-gray-600">
                        <span class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-lime-50 text-lime-600">
                            <i class="fa-regular fa-clock text-sm" aria-hidden="true"></i>
                        </span>
                        <span>
                            <span class="font-semibold text-gray-900 block">We are here for you</span>
                            Contact us to arrange a meeting time that suits your schedule.
                        </span>
                    </li>
                </ul>
                @if($googleRating > 0)
                <a href="{{ $googleReviewsLink }}" target="_blank" rel="noopener noreferrer"
                   class="group flex flex-col gap-4 rounded-2xl border border-gray-200/90 bg-white px-5 py-4 md:px-6 md:py-5 shadow-sm hover:border-amber-200/80 hover:shadow-md transition-all">
                    <div class="flex items-start gap-4 min-w-0">
                        <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-gray-50 text-[#4285F4] ring-1 ring-gray-100 group-hover:ring-amber-100 transition-shadow" aria-hidden="true">
                            <i class="fa-brands fa-google text-2xl"></i>
                        </span>
                        <div class="min-w-0 flex-1">
                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1">Google reviews</p>
                            <div class="flex flex-wrap items-center gap-2 sm:gap-3">
                                <span class="text-3xl font-bold text-gray-900 tabular-nums leading-none">{{ number_format($googleRating, 1) }}</span>
                                <div class="flex items-center gap-0.5 text-amber-400 text-lg" role="img" aria-label="Rating {{ number_format($googleRating, 1) }} out of 5">
                                    @for($si = 1; $si <= 5; $si++)
                                        @if($googleRating >= $si)
                                            <i class="fa-solid fa-star" aria-hidden="true"></i>
                                        @elseif($googleRating >= $si - 0.5)
                                            <i class="fa-solid fa-star-half-stroke" aria-hidden="true"></i>
                                        @else
                                            <i class="fa-regular fa-star text-gray-200" aria-hidden="true"></i>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                            @if($googleReviewCount > 0)
                                <p class="text-sm text-gray-500 mt-2">Based on <span class="font-medium text-gray-700">{{ number_format($googleReviewCount) }}</span> reviews</p>
                            @else
                                <p class="text-sm text-gray-500 mt-2">See what travellers say about us on Google</p>
                            @endif
                        </div>
                    </div>
                    <span class="inline-flex w-full sm:w-auto items-center justify-center gap-2 rounded-lg bg-gray-50 px-4 py-2.5 text-sm font-semibold text-gray-700 group-hover:bg-amber-50 group-hover:text-amber-900 transition-colors">
                        Read reviews
                        <i class="fa-solid fa-chevron-right text-xs opacity-60" aria-hidden="true"></i>
                    </span>
                </a>
                @else
                <a href="{{ $googleReviewsLink }}" target="_blank" rel="noopener noreferrer"
                   class="flex flex-col gap-3 rounded-2xl border border-gray-200/90 bg-gradient-to-br from-white to-gray-50/80 px-5 py-4 shadow-sm hover:border-amber-200/70 hover:shadow transition-all">
                    <span class="flex items-start gap-3 text-[15px] text-gray-600">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-[#4285F4] ring-1 ring-gray-100" aria-hidden="true">
                            <i class="fa-brands fa-google text-xl"></i>
                        </span>
                        <span><span class="font-semibold text-gray-900">Google reviews</span> — see what guests say about {{ $siteNameForMap }}.</span>
                    </span>
                    <span class="text-sm font-semibold text-amber-700">View on Google →</span>
                </a>
                @endif
            </div>
            <div class="flex flex-col min-w-0">
                <div class="flex-1 min-h-[300px] lg:min-h-[min(52vh,520px)] rounded-2xl overflow-hidden border border-gray-200/80 shadow-[0_24px_60px_-12px_rgba(15,20,6,0.14)] bg-gray-100">
                    <iframe
                        title="{{ $siteNameForMap }} — location map"
                        src="{{ $agencyMapEmbed }}"
                        class="w-full h-full min-h-[300px] lg:min-h-[min(52vh,520px)] border-0"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</section>

@if($latestPosts->isNotEmpty())
<section class="bg-gray-50 py-16 md:py-20 pb-0" style="padding-bottom:0 !important;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-8">
            <h2 class="text-3xl md:text-4xl font-bold text-lime-900">From the blog</h2>
            {{-- Arrows only on mobile for slider --}}
            <div class="flex items-center gap-2 sm:hidden">
                <button type="button" class="blog-prev w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center text-gray-400 hover:text-lime-600 hover:border-lime-300 transition-colors">
                    <i class="fa-solid fa-arrow-left text-sm"></i>
                </button>
                <button type="button" class="blog-next w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center text-gray-400 hover:text-lime-600 hover:border-lime-300 transition-colors">
                    <i class="fa-solid fa-arrow-right text-sm"></i>
                </button>
            </div>
        </div>
        {{-- Grid on desktop --}}
        <div class="hidden sm:grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach($latestPosts as $post)
                <x-blog-card :post="$post" />
            @endforeach
        </div>
        {{-- Slider on mobile with overflow visible, hidden on desktop --}}
        <div class="swiper blog-swiper overflow-visible block sm:!hidden">
            <div class="swiper-wrapper">
                @foreach($latestPosts as $post)
                <div class="swiper-slide">
                    <x-blog-card :post="$post" />
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
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
    @if(isset($homepageCategories) && $homepageCategories->isNotEmpty())
    @foreach($homepageCategories as $cat)
    if (window.Swiper && document.querySelector('.category-{{ $cat->slug }}-swiper')) {
        new window.Swiper('.category-{{ $cat->slug }}-swiper', {
            modules: [window.SwiperNavigation],
            slidesPerView: 1.2,
            spaceBetween: 20,
            navigation: {
                prevEl: '.category-{{ $cat->slug }}-prev',
                nextEl: '.category-{{ $cat->slug }}-next',
            },
            breakpoints: {
                640: { slidesPerView: 2.2, spaceBetween: 20 },
                1024: { slidesPerView: 3, spaceBetween: 20 },
                1280: { slidesPerView: 3, spaceBetween: 20 },
            },
        });
    }
    @endforeach
    @endif
    @if(isset($tourPackages) && $tourPackages->isNotEmpty())
    if (window.Swiper && document.querySelector('.packages-swiper')) {
        new window.Swiper('.packages-swiper', {
            modules: [window.SwiperNavigation],
            slidesPerView: 1.2,
            spaceBetween: 20,
            navigation: {
                prevEl: '.packages-prev',
                nextEl: '.packages-next',
            },
            breakpoints: {
                640: { slidesPerView: 2.2, spaceBetween: 20 },
                1024: { slidesPerView: 4, spaceBetween: 20 },
                1280: { slidesPerView: 4, spaceBetween: 20 },
            },
        });
    }
    @endif
    if (window.Swiper && document.querySelector('.destinations-swiper')) {
        new window.Swiper('.destinations-swiper', {
            modules: [window.SwiperNavigation],
            slidesPerView: 2,
            spaceBetween: 20,
            navigation: {
                prevEl: '.destinations-prev',
                nextEl: '.destinations-next',
            },
            breakpoints: {
                640: { slidesPerView: 3, spaceBetween: 20 },
                1024: { slidesPerView: 5, spaceBetween: 20 },
                1280: { slidesPerView: 5, spaceBetween: 20 },
            },
        });
    }
    if (window.Swiper && document.querySelector('.testimonials-swiper')) {
        new window.Swiper('.testimonials-swiper', {
            modules: [window.SwiperNavigation],
            slidesPerView: 1.1,
            spaceBetween: 20,
            navigation: {
                prevEl: '.testimonials-prev',
                nextEl: '.testimonials-next',
            },
            breakpoints: {
                640: { slidesPerView: 2.2, spaceBetween: 20 },
                1024: { slidesPerView: 3.2, spaceBetween: 20 },
                1280: { slidesPerView: 4, spaceBetween: 20 },
            },
        });
    }
    if (window.Swiper && document.querySelector('.blog-swiper')) {
        new window.Swiper('.blog-swiper', {
            modules: [window.SwiperNavigation],
            slidesPerView: 1.2,
            spaceBetween: 20,
            navigation: {
                prevEl: '.blog-prev',
                nextEl: '.blog-next',
            },
        });
    }
});
</script>
@endpush
@endsection
