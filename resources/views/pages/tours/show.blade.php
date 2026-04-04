@extends('layouts.site')

@section('title', $tour->meta_title ?: $tour->title . ' - ' . config('app.name'))
@section('description', $tour->meta_description ?: Str::limit($tour->short_description, 160))

@push('meta')
@if($tour->meta_title)<meta property="og:title" content="{{ $tour->meta_title }}">@endif
<meta property="og:description" content="{{ $tour->meta_description ?: $tour->short_description }}">
<meta property="og:url" content="{{ request()->url() }}">
@endpush

@push('styles')
<style>
.prose ul { list-style: disc; padding-left: 17px; }
.prose ul li { margin-bottom: 10px; }
/* intl-tel-input: match enquiry card (flags + visible dial prefix) */
.enquiry-intl-wrap {
    --iti-border-color: #e5e7eb;
    width: 100%;
    display: block;
}
.enquiry-intl-wrap .iti__tel-input {
    width: 100% !important;
    border-radius: 0.75rem !important;
    border: 1px solid #e5e7eb !important;
    background-color: #f9fafb !important;
    padding-top: 0.75rem !important;
    padding-bottom: 0.75rem !important;
    font-size: 0.875rem !important;
    line-height: 1.25rem !important;
    color: #111827 !important;
}
.enquiry-intl-wrap .iti__tel-input:focus {
    outline: none !important;
    box-shadow: 0 0 0 2px #111827 !important;
    border-color: transparent !important;
}
.enquiry-intl-wrap .iti__selected-country {
    border-radius: 0.75rem 0 0 0.75rem;
    background-color: #f3f4f6;
}
.enquiry-intl-wrap .iti__selected-dial-code {
    color: #374151;
    font-weight: 500;
}
.enquiry-intl-wrap .iti__dropdown-content {
    border-radius: 0.75rem;
    box-shadow: 0 10px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
    border: 1px solid #e5e7eb;
}
</style>
@endpush

@section('content')
@php
    $images = $tour->images->isEmpty() ? collect([null]) : $tour->images;
    $firstImage = $images->first();
    $mainImageUrl = $firstImage && $firstImage->path ? $firstImage->url : 'https://placehold.co/1200x600?text=Travel+Package';
    $galleryImages = $tour->images->isEmpty()
        ? collect([(object) ['url' => $mainImageUrl, 'alt' => $tour->title]])
        : $tour->images;
    $img1 = $galleryImages->get(0);
    $img2 = $galleryImages->get(1) ?? $img1;
    $img3 = $galleryImages->get(2) ?? $galleryImages->get(1) ?? $img1;
    $totalImages = $tour->images->isEmpty() ? 1 : $tour->images->count();
    $galleryLightboxLinks = $totalImages > 1;
@endphp

{{-- Title + bento gallery (2/3 main | 1/3 stacked thumbs + view all) --}}
<section class="px-4 sm:px-6 md:px-[80px] pt-6 md:pt-10 pb-2">
    <div class="max-w-[1400px] mx-auto">
        <nav class="text-sm mb-4" aria-label="{{ __('Breadcrumb') }}">
            <ol class="flex flex-wrap items-center gap-1.5 text-[#6a6a6a]">
                <li><a href="{{ route('home') }}" class="hover:text-[#111827] transition-colors">{{ __('Home') }}</a></li>
                <li class="text-[#d1cdc4]" aria-hidden="true">/</li>
                <li><a href="{{ route('tours.index') }}" class="hover:text-[#111827] transition-colors">{{ __('Travel Packages') }}</a></li>
                <li class="text-[#d1cdc4]" aria-hidden="true">/</li>
                <li class="text-[#111827] font-medium truncate max-w-[min(100%,280px)]">{{ $tour->title }}</li>
            </ol>
        </nav>
        @if($tour->category)
            <span class="inline-flex rounded-full bg-gray-100 px-3.5 py-1 text-[12px] font-semibold text-[#111827] mb-3">{{ $tour->category->name }}</span>
        @endif
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-serif font-semibold text-[#111827] tracking-tight leading-[1.1] max-w-4xl">{{ $tour->title }}</h1>
        @if($tour->approvedReviews->count() > 0)
            <div class="mt-3 flex items-center gap-2 text-[#111827]">
                <x-review-stars :rating="(float) $tour->average_rating" />
                @php $rc = $tour->approvedReviews->count(); @endphp
                <span class="text-sm text-[#6a6a6a]">({{ $rc }} {{ $rc === 1 ? __('review') : __('reviews') }})</span>
            </div>
        @endif

        <div class="tour-gallery mt-8 md:mt-10">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 lg:gap-4 lg:h-[min(32rem,calc(100vh-12rem))] lg:max-h-[560px] lg:min-h-[380px]">
                {{-- Left: main hero image --}}
                <a href="{{ $img1->url ?? $mainImageUrl }}"
                   class="glightbox group relative block h-full w-full min-h-[220px] overflow-hidden rounded-2xl bg-gray-100 lg:col-span-2 lg:min-h-0"
                   data-gallery="tour-gallery-{{ $tour->id }}"
                   role="listitem">
                    <img src="{{ $img1->url ?? $mainImageUrl }}"
                         alt="{{ $img1->alt ?? $tour->title }}"
                         class="absolute inset-0 h-full w-full object-cover transition-transform duration-500 group-hover:scale-[1.02]"
                         loading="eager"
                         fetchpriority="high">
                </a>
                {{-- Right: two stacked images + pill CTA --}}
                <div class="flex flex-col gap-4 min-h-0 h-full lg:min-h-0">
                    @if($galleryLightboxLinks)
                        <a href="{{ $img2->url ?? $mainImageUrl }}"
                           class="glightbox group relative block flex-1 min-h-[160px] lg:min-h-0 overflow-hidden rounded-2xl bg-gray-100"
                           data-gallery="tour-gallery-{{ $tour->id }}"
                           role="listitem">
                            <img src="{{ $img2->url ?? $mainImageUrl }}"
                                 alt="{{ $img2->alt ?? $tour->title }}"
                                 class="absolute inset-0 h-full w-full object-cover transition-transform duration-500 group-hover:scale-[1.02]"
                                 loading="lazy">
                        </a>
                    @else
                        <div class="relative flex-1 min-h-[160px] lg:min-h-0 overflow-hidden rounded-2xl bg-gray-100">
                            <img src="{{ $img2->url ?? $mainImageUrl }}"
                                 alt=""
                                 class="absolute inset-0 h-full w-full object-cover"
                                 loading="lazy">
                        </div>
                    @endif
                    <div class="relative flex-1 min-h-[160px] lg:min-h-0 overflow-hidden rounded-2xl bg-gray-100">
                        @if($galleryLightboxLinks)
                            <a href="{{ $img3->url ?? $mainImageUrl }}"
                               class="glightbox group absolute inset-0 block"
                               data-gallery="tour-gallery-{{ $tour->id }}"
                               role="listitem">
                                <img src="{{ $img3->url ?? $mainImageUrl }}"
                                     alt="{{ $img3->alt ?? $tour->title }}"
                                     class="absolute inset-0 h-full w-full object-cover transition-transform duration-500 group-hover:scale-[1.02]"
                                     loading="lazy">
                            </a>
                            <a href="{{ $img1->url ?? $mainImageUrl }}"
                               class="glightbox absolute bottom-3 right-3 z-10 inline-flex items-center gap-2 rounded-full bg-white px-4 py-2 text-sm font-semibold text-[#111827] shadow-md shadow-black/10 ring-1 ring-black/5 transition hover:bg-gray-50"
                               data-gallery="tour-gallery-{{ $tour->id }}"
                               aria-label="{{ __('View all :count photos', ['count' => $totalImages]) }}">
                                <i class="fa-solid fa-camera text-[15px] text-[#111827]/80" aria-hidden="true"></i>
                                <span>{{ __('View') }} {{ $totalImages }} {{ $totalImages === 1 ? __('photo') : __('photos') }}</span>
                            </a>
                        @else
                            <img src="{{ $img3->url ?? $mainImageUrl }}"
                                 alt=""
                                 class="absolute inset-0 h-full w-full object-cover"
                                 loading="lazy">
                        @endif
                    </div>
                </div>
            </div>
            @if($totalImages > 3)
                <div class="hidden" aria-hidden="true">
                    @foreach($galleryImages->skip(3) as $extraImg)
                        <a href="{{ $extraImg->url }}" class="glightbox" data-gallery="tour-gallery-{{ $tour->id }}">
                            <img src="{{ $extraImg->url }}" alt="{{ $extraImg->alt ?? __('Travel package image') }}" loading="lazy">
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</section>

{{-- Quick facts --}}
@php
    $durationLabel = $tour->duration_days
        ? $tour->duration_days . ' ' . ($tour->duration_days === 1 ? __('day') : __('days'))
        : ($tour->duration_hours ? $tour->duration_hours . ' ' . __('hours') : null);
    $facts = collect();
    if ($tour->start_location) $facts->push(['icon' => 'fa-flag', 'label' => __('Starts'), 'value' => $tour->start_location]);
    if ($durationLabel) $facts->push(['icon' => 'fa-sun', 'label' => __('Duration'), 'value' => $durationLabel]);
    if ($tour->end_location ?? $tour->start_location) $facts->push(['icon' => 'fa-suitcase', 'label' => __('Ends'), 'value' => $tour->end_location ?? $tour->start_location]);
    if ($tour->category) $facts->push(['icon' => 'fa-route', 'label' => __('Type'), 'value' => $tour->category->name]);
    if ($tour->difficulty) {
        $dl = ['easy' => __('Easy'), 'moderate' => __('Moderate'), 'challenging' => __('Challenging'), 'strenuous' => __('Strenuous')];
        $facts->push(['icon' => 'fa-mountain', 'label' => __('Difficulty'), 'value' => $dl[$tour->difficulty] ?? $tour->difficulty]);
    }
    if ($tour->season) {
        $sl = ['summer' => __('Summer'), 'winter' => __('Winter'), 'all_season' => __('All Season')];
        $facts->push(['icon' => 'fa-calendar-check', 'label' => __('Season'), 'value' => $sl[$tour->season] ?? $tour->season]);
    }
    if ($tour->max_group_size) $facts->push(['icon' => 'fa-user-group', 'label' => __('Max people'), 'value' => $tour->max_group_size]);
    if ($tour->languages && count($tour->languages) > 0) $facts->push(['icon' => 'fa-language', 'label' => __('Language'), 'value' => implode(', ', (array) $tour->languages)]);
@endphp
@if($facts->isNotEmpty())
<section class="px-4 sm:px-6 md:px-[80px] mt-6 md:mt-8 relative z-10">
    <div class="max-w-[1400px] mx-auto">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 px-6 py-5 flex flex-wrap gap-x-8 gap-y-4">
            @foreach($facts as $fact)
            <div class="flex items-center gap-3 min-w-[140px]">
                <div class="w-9 h-9 rounded-lg bg-gray-100 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid {{ $fact['icon'] }} text-gray-600 text-sm"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-[11px] text-gray-400 leading-none">{{ $fact['label'] }}</p>
                    <p class="text-sm font-medium text-gray-900 truncate">{{ $fact['value'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Main content + sidebar --}}
<div class="px-4 sm:px-6 md:px-[80px] py-10 md:py-14">
    <div class="max-w-[1400px] mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <div class="lg:col-span-2 space-y-10">

                {{-- Summary --}}
                <div class="prose max-w-none prose-headings:font-bold prose-headings:text-gray-900 prose-p:text-gray-600 prose-p:leading-[1.8]">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ __('Summary') }}</h2>
                    {!! $tour->description !!}
                </div>

                {{-- Tour highlights --}}
                @if($tour->tour_highlights && count($tour->tour_highlights) > 0)
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-5">{{ __('Travel package highlights') }}</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach($tour->tour_highlights as $highlight)
                            @php $text = is_array($highlight) ? ($highlight['text'] ?? $highlight['value'] ?? '') : $highlight; @endphp
                            @if($text)
                            <div class="flex items-start gap-3 bg-gray-50 rounded-xl p-4">
                                <span class="flex-shrink-0 w-7 h-7 rounded-lg bg-gray-900 flex items-center justify-center text-white mt-0.5">
                                    <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                </span>
                                <span class="text-[15px] text-gray-700">{{ $text }}</span>
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Important notes --}}
                @if($tour->important_notes)
                <div class="rounded-2xl border border-amber-200 bg-amber-50/60 p-6">
                    <h2 class="text-lg font-bold text-amber-800 mb-3 flex items-center gap-2">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        {{ __('Important notes') }}
                    </h2>
                    <div class="prose prose-sm max-w-none text-amber-900">
                        {!! $tour->important_notes !!}
                    </div>
                </div>
                @endif

                {{-- Itinerary --}}
                @if($tour->itineraries->isNotEmpty())
                    @php $firstId = $tour->itineraries->first()->id; @endphp
                    <div x-data="{ openDay: {{ $firstId }} }">
                        <h2 class="text-2xl font-bold text-gray-900 mb-5">{{ __('Itinerary & Details') }}</h2>
                        <div class="space-y-3">
                            @foreach($tour->itineraries as $day)
                            <div class="rounded-2xl border border-gray-200 overflow-hidden bg-white">
                                <button type="button"
                                    @click="openDay = openDay === {{ $day->id }} ? null : {{ $day->id }}"
                                    :class="openDay === {{ $day->id }} ? 'bg-gray-50' : 'hover:bg-gray-50'"
                                    class="w-full flex items-center justify-between px-5 py-4 text-left font-semibold text-gray-900 transition-colors">
                                    <span class="flex items-center gap-3">
                                        @if($day->day)
                                        <span class="w-8 h-8 rounded-lg bg-gray-900 text-white text-xs font-bold flex items-center justify-center flex-shrink-0">{{ $day->day }}</span>
                                        @endif
                                        <span>{{ $day->title }}</span>
                                    </span>
                                    <i class="fa-solid fa-chevron-down text-gray-400 text-sm transition-transform duration-200"
                                        :class="openDay === {{ $day->id }} ? 'rotate-180' : ''" aria-hidden="true"></i>
                                </button>
                                <div x-show="openDay === {{ $day->id }}" x-collapse>
                                    <div class="px-5 pb-5 pt-1 text-gray-600 text-[15px] leading-relaxed">
                                        @if($day->description)
                                            <div class="prose prose-sm max-w-none text-gray-600">
                                                {!! $day->description !!}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Hotels & resorts --}}
                @if($tour->hotels->isNotEmpty())
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-5">{{ __('Where you\'ll stay') }}</h2>
                    <div class="space-y-8">
                        @foreach($tour->hotels as $hotel)
                            @php
                                $galleryUrls = $hotel->gallery_urls ?? [];
                                $hero = $hotel->featured_image_url ?? ($galleryUrls[0] ?? null) ?? 'https://placehold.co/800x480/e5e7eb/6b7280?text=' . urlencode($hotel->name);
                                $isResort = $hotel->classification === \App\Models\Hotel::CLASSIFICATION_RESORT;
                            @endphp
                            <div class="rounded-2xl border border-gray-200 bg-white overflow-hidden shadow-sm">
                                <div class="grid grid-cols-1 md:grid-cols-5 gap-0">
                                    <div class="md:col-span-2 min-h-[200px] md:min-h-[260px]">
                                        @if(count($galleryUrls) > 0)
                                            <img src="{{ $hero }}" alt="{{ $hotel->name }}" class="w-full h-full object-cover min-h-[200px] md:min-h-[260px]" loading="lazy">
                                        @elseif($hotel->featured_image_url)
                                            <a href="{{ $hero }}" class="glightbox block h-full min-h-[200px] md:min-h-[260px]" data-gallery="hotel-gallery-{{ $hotel->id }}" aria-label="{{ __('View :name photo', ['name' => $hotel->name]) }}">
                                                <img src="{{ $hero }}" alt="{{ $hotel->name }}" class="w-full h-full object-cover min-h-[200px] md:min-h-[260px]" loading="lazy">
                                            </a>
                                        @else
                                            <img src="{{ $hero }}" alt="{{ $hotel->name }}" class="w-full h-full object-cover min-h-[200px] md:min-h-[260px]" loading="lazy">
                                        @endif
                                    </div>
                                    <div class="md:col-span-3 p-6 md:p-8 flex flex-col justify-center">
                                        <div class="flex flex-wrap items-center gap-2 mb-3">
                                            <h3 class="text-xl font-bold text-gray-900">{{ $hotel->name }}</h3>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-semibold {{ $isResort ? 'bg-sky-100 text-sky-800' : 'bg-gray-100 text-gray-700' }}">
                                                {{ $isResort ? __('Resort') : __('Hotel') }}
                                            </span>
                                        </div>
                                        @if($hotel->description)
                                        <div class="prose prose-sm max-w-none text-gray-600">
                                            {!! $hotel->description !!}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @if(count($galleryUrls) > 0)
                                <div class="px-6 pb-6 md:px-8 md:pb-8 pt-0 border-t border-gray-100">
                                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-3 mt-5">{{ __('Gallery') }}</p>
                                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2">
                                        @foreach($galleryUrls as $gUrl)
                                        <a href="{{ $gUrl }}" class="glightbox block aspect-[4/3] rounded-xl overflow-hidden ring-1 ring-black/5" data-gallery="hotel-gallery-{{ $hotel->id }}" role="listitem">
                                            <img src="{{ $gUrl }}" alt="{{ $hotel->name }}" class="w-full h-full object-cover hover:scale-[1.03] transition-transform duration-500" loading="lazy">
                                        </a>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- What to bring --}}
                @if($tour->what_to_bring && count($tour->what_to_bring) > 0)
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ __('What to bring') }}</h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach((array) $tour->what_to_bring as $item)
                        <span class="inline-flex items-center gap-2 rounded-full bg-gray-100 px-4 py-2 text-sm text-gray-700">
                            <i class="fa-solid fa-suitcase text-gray-400 text-xs"></i>
                            {{ $item }}
                        </span>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Included / Not included --}}
                @if($tour->included || $tour->not_included)
                <div class="rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 md:divide-x divide-gray-100">
                        @if($tour->included)
                        <div class="p-6 md:p-8">
                            <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-400 mb-5">{{ __('Included') }}</h2>
                            <ul class="space-y-0 divide-y divide-gray-100">
                                @foreach((array) $tour->included as $item)
                                <li class="flex items-start gap-3 py-3 first:pt-0 text-[15px] text-gray-800 leading-snug">
                                    <span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-emerald-50 text-emerald-600 ring-1 ring-emerald-100">
                                        <i class="fa-solid fa-check text-[10px]" aria-hidden="true"></i>
                                    </span>
                                    <span>{{ $item }}</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        @if($tour->not_included)
                        <div class="p-6 md:p-8 {{ $tour->included ? '' : 'md:col-span-2' }}">
                            <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-400 mb-5">{{ __('Not included') }}</h2>
                            <ul class="space-y-0 divide-y divide-gray-100">
                                @foreach((array) $tour->not_included as $item)
                                <li class="flex items-start gap-3 py-3 first:pt-0 text-[15px] text-gray-600 leading-snug">
                                    <span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-gray-50 text-gray-400 ring-1 ring-gray-100">
                                        <i class="fa-solid fa-minus text-[10px]" aria-hidden="true"></i>
                                    </span>
                                    <span>{{ $item }}</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                {{-- Reviews --}}
                @php
                    $reviews = $tour->approvedReviews;
                    $avgRating = (float) $tour->average_rating;
                    $reviewCount = $tour->approvedReviews->count();
                @endphp
                <div>
                    <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-6 mb-8">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">{{ __('Customer reviews') }}</h2>
                            <p class="mt-1 text-[15px] text-gray-500">
                                {{ __('What real customers say about') }} <strong class="font-semibold text-gray-900">{{ $tour->title }}</strong>.
                            </p>
                        </div>
                        @if($reviewCount > 0)
                        <div class="flex-shrink-0 w-full md:w-auto md:min-w-[180px]">
                            <div class="rounded-2xl bg-gray-900 p-5 text-white">
                                <p class="text-sm text-white/60">{{ __('Overall') }}</p>
                                @php
                                    $fullStars = (int) floor($avgRating);
                                    $halfStar = ($avgRating - $fullStars) >= 0.5;
                                    $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                                @endphp
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-4xl font-bold">{{ number_format($avgRating, 1) }}</span>
                                    <span class="flex items-center -mt-1">
                                        @for($i = 0; $i < $fullStars; $i++)
                                            <svg class="w-5 h-5 text-amber-400 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        @endfor
                                        @if($halfStar)
                                            <svg class="w-5 h-5 text-amber-400 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><defs><linearGradient id="half-overall"><stop offset="50%" stop-color="currentColor"/><stop offset="50%" stop-color="rgba(255,255,255,0.4)"/></linearGradient></defs><path fill="url(#half-overall)" d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        @endif
                                        @for($i = 0; $i < $emptyStars; $i++)
                                            <svg class="w-5 h-5 text-white/20 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        @endfor
                                    </span>
                                </div>
                                <p class="text-sm mt-1 text-white/50">{{ $reviewCount }} {{ $reviewCount === 1 ? __('review') : __('reviews') }}</p>
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="space-y-4 mb-8">
                        @foreach($reviews as $review)
                            @php
                                $name = $review->display_name;
                                $words = explode(' ', trim($name), 2);
                                $initials = count($words) >= 2
                                    ? strtoupper(mb_substr($words[0], 0, 1) . mb_substr($words[1], 0, 1))
                                    : strtoupper(mb_substr($name, 0, 2));
                                if ($initials === '') { $initials = '?'; }
                                $displayDate = $review->display_date;
                            @endphp
                            <div class="rounded-2xl border border-gray-200 p-5 md:p-6 bg-white" x-data="{ expanded: false }">
                                <x-review-platform-logo :platform="$review->platform" :url="$review->platform_tour_url" />
                                <div class="flex gap-4 {{ $review->platform ? 'pr-12' : '' }}">
                                    <div class="w-11 h-11 rounded-full bg-gray-900 flex items-center justify-center text-white text-sm font-semibold flex-shrink-0">
                                        {{ $initials }}
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="font-medium text-gray-900">
                                            {{ $name }}
                                            <span class="text-gray-400 font-normal"> {{ $displayDate->format('d/m/Y') }}</span>
                                        </p>
                                        <div class="mt-1.5 flex items-center gap-0.5">
                                            @for($i = 0; $i < min(5, (int) $review->rating); $i++)
                                                <i class="fa-solid fa-star text-amber-400 text-sm"></i>
                                            @endfor
                                            @for($i = (int) $review->rating; $i < 5; $i++)
                                                <i class="fa-regular fa-star text-gray-300 text-sm"></i>
                                            @endfor
                                        </div>
                                        @if($review->title)
                                            <h3 class="font-bold text-lg text-gray-900 mt-3">{{ $review->title }}</h3>
                                        @endif
                                        <div class="mt-2 text-gray-600 text-[15px] leading-relaxed">
                                            <p :class="expanded ? '' : 'line-clamp-4'">{{ $review->comment }}</p>
                                            @if(strlen($review->comment) > 280)
                                                <button type="button" @click="expanded = !expanded" class="text-gray-900 font-semibold hover:underline mt-1 text-sm" x-text="expanded ? @js(__('Show less')) : @js(__('Show more'))"></button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @auth
                        @if($userHasReviewed ?? false)
                            <div class="rounded-2xl bg-gray-100 p-6 text-center">
                                <p class="text-gray-500">{{ __('You have already reviewed this travel package. Thank you!') }}</p>
                            </div>
                        @else
                            <div class="rounded-2xl border border-gray-200 bg-white p-6 md:p-8">
                                <h3 class="text-xl font-bold text-gray-900 mb-6">{{ __('Leave a review') }}</h3>

                                @if(session('error'))
                                    <div class="mb-6 p-4 rounded-xl bg-red-50 text-red-700 text-sm">{{ session('error') }}</div>
                                @endif
                                @if(session('success'))
                                    <div class="mb-6 p-4 rounded-xl bg-emerald-50 text-emerald-800 text-sm flex items-center gap-2">
                                        <i class="fa-solid fa-circle-check text-emerald-600"></i>
                                        {{ session('success') }}
                                    </div>
                                @endif

                                <form action="{{ route('reviews.store', $tour) }}" method="POST" class="space-y-5" x-data="{ rating: {{ old('rating', 0) }} }" x-init="if(rating) $refs.ratingInput.value = rating">
                                    @csrf
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('Your overall rating') }} <span class="text-red-500">*</span></label>
                                        <div class="flex items-center gap-1">
                                            @for($i = 1; $i <= 5; $i++)
                                                <button type="button" @click="rating = {{ $i }}; $refs.ratingInput.value = {{ $i }}" class="p-1 focus:outline-none transition-colors">
                                                    <i class="text-xl" :class="rating >= {{ $i }} ? 'fa-solid fa-star text-amber-400' : 'fa-regular fa-star text-gray-300'"></i>
                                                </button>
                                            @endfor
                                        </div>
                                        <input type="hidden" name="rating" x-ref="ratingInput" value="{{ old('rating', '') }}" required>
                                        @error('rating')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                    </div>
                                    <div>
                                        <label for="review_title" class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Title') }} <span class="text-red-500">*</span></label>
                                        <input type="text" name="title" id="review_title" value="{{ old('title') }}" required placeholder="{{ __('Summarize your experience') }}"
                                            class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition">
                                        @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                    </div>
                                    <div>
                                        <label for="review_comment" class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Your review') }} <span class="text-red-500">*</span></label>
                                        <textarea name="comment" id="review_comment" rows="5" required placeholder="{{ __('Share your experience...') }}"
                                            class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition resize-y">{{ old('comment') }}</textarea>
                                        @error('comment')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                    </div>
                                    <button type="submit" class="inline-flex items-center rounded-full bg-gray-900 text-white text-sm font-semibold px-7 py-3 hover:bg-gray-800 transition-colors">
                                        {{ __('Submit Review') }}
                                    </button>
                                </form>
                            </div>
                        @endif
                    @else
                        <div class="rounded-2xl bg-gray-100 p-6 md:p-8 text-center">
                            <p class="text-gray-500 mb-5">{{ __('To leave a review you need to log in.') }}</p>
                            <a href="{{ route('login') }}" class="inline-flex items-center rounded-full bg-gray-900 text-white text-sm font-semibold px-7 py-3 hover:bg-gray-800 transition-colors">
                                {{ __('Log in to your account') }}
                            </a>
                        </div>
                    @endauth
                </div>
            </div>

            {{-- Enquiry sidebar --}}
            <div class="lg:col-span-1">
                <div id="enquiry-form" class="lg:sticky lg:top-24 lg:self-start scroll-mt-12">
                    <div class="rounded-2xl border border-gray-200 bg-white overflow-hidden shadow-sm">
                        <div class="bg-gray-900 rounded-t-2xl px-6 py-5">
                            <h3 class="text-lg font-bold text-white">{{ __('Enquire About This Travel Package') }}</h3>
                            @php
                                $basePrice = (float)($tour->base_price ?? $tour->price ?? 0);
                                $currency = ($tour->currency === 'EUR' || !$tour->currency) ? '€' : ($tour->currency === 'USD' ? '$' : $tour->currency . ' ');
                            @endphp
                            @if($basePrice > 0)
                                <p class="text-white/60 text-sm mt-1">{{ __('From') }} <span class="text-white font-semibold text-lg">{{ $currency }}{{ number_format($basePrice, 0) }}</span> / {{ __('person') }}</p>
                            @endif
                        </div>

                        <div class="p-5">
                            @if(session('enquiry_success'))
                                <div class="mb-4 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-start gap-2">
                                    <i class="fa-solid fa-circle-check text-emerald-600 mt-0.5"></i>
                                    <span>{{ session('enquiry_success') }}</span>
                                </div>
                            @endif

                            @php
                                $phoneInitialCountry = strtolower(optional($tour->countries->first())->iso_alpha2 ?? 'gb');
                            @endphp
                            <form id="tour-enquiry-form" action="{{ route('tours.enquiry.store', $tour->slug) }}" method="POST" class="space-y-3.5">
                                @csrf

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Full Name') }} <span class="text-red-500">*</span></label>
                                    <input type="text" name="full_name" value="{{ old('full_name') }}" required
                                        class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition"
                                        placeholder="{{ __('Your full name') }}">
                                    @error('full_name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Email') }} <span class="text-red-500">*</span></label>
                                    <input type="email" name="email" value="{{ old('email') }}" required
                                        class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition"
                                        placeholder="{{ __('your@email.com') }}">
                                    @error('email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Phone') }}</label>
                                    <input type="tel" name="phone" id="enquiry-phone-input" value="{{ old('phone') }}"
                                        data-initial-country="{{ $phoneInitialCountry }}"
                                        autocomplete="tel"
                                        class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition"
                                        placeholder="{{ __('Your phone number') }}">
                                    <p class="mt-1.5 text-xs text-gray-500">{{ __('Choose your country flag for the correct prefix. We store your full international number.') }}</p>
                                    @error('phone')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                </div>

                                @if($tour->homepage_card_date_from || $tour->homepage_card_date_to)
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Departure') }}</label>
                                        <div class="w-full rounded-xl border border-gray-200 bg-gray-100 px-3 py-3 text-sm text-gray-900 tabular-nums select-none" title="{{ __('Set by your travel advisor for this package') }}">
                                            {{ $tour->homepage_card_date_from?->translatedFormat('j M Y') ?? '—' }}
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Return') }}</label>
                                        <div class="w-full rounded-xl border border-gray-200 bg-gray-100 px-3 py-3 text-sm text-gray-900 tabular-nums select-none" title="{{ __('Set by your travel advisor for this package') }}">
                                            {{ $tour->homepage_card_date_to?->translatedFormat('j M Y') ?? '—' }}
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Guests') }} <span class="text-red-500">*</span></label>
                                    <input type="number" name="guests" value="{{ old('guests', 2) }}" min="1" max="100" required
                                        class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition">
                                    @error('guests')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Message') }}</label>
                                    <textarea name="message" rows="3"
                                        class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition resize-y"
                                        placeholder="{{ __('Any special requests...') }}">{{ old('message') }}</textarea>
                                    @error('message')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                </div>

                                <button type="submit" class="w-full rounded-full py-3.5 bg-gray-900 hover:bg-gray-800 text-white text-sm font-semibold transition-colors">
                                    {{ __('Send Enquiry') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Mobile enquiry bar --}}
<div x-data="{ visible: false }"
     x-init="let target = document.getElementById('enquiry-form'); if(target) { let obs = new IntersectionObserver(([e]) => { visible = !e.isIntersecting }, { threshold: 0 }); obs.observe(target); }"
     x-show="visible"
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="translate-y-full opacity-0"
     x-transition:enter-end="translate-y-0 opacity-100"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="translate-y-0 opacity-100"
     x-transition:leave-end="translate-y-full opacity-0"
     class="fixed bottom-0 left-0 right-0 z-40 lg:hidden bg-white border-t border-gray-200 shadow-[0_-4px_12px_rgba(0,0,0,0.06)]"
     style="display: none;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3">
        <div class="flex items-center justify-between gap-4">
            <div class="flex flex-col min-w-0">
                <span class="text-xs text-gray-400">{{ __('From') }}</span>
                @php
                    $mobilePrice = (float)($tour->base_price ?? $tour->price ?? 0);
                    $mobileCurrency = ($tour->currency === 'EUR' || !$tour->currency) ? '€' : $tour->currency;
                @endphp
                <span class="text-lg font-bold text-gray-900">{{ $mobileCurrency }} {{ number_format($mobilePrice, 0) }} <span class="text-xs font-normal text-gray-400">/ {{ __('person') }}</span></span>
            </div>
            <a href="#enquiry-form"
                class="flex-shrink-0 rounded-full py-3 px-6 bg-gray-900 text-white font-semibold text-sm hover:bg-gray-800 transition-colors">
                {{ __('Enquire Now') }}
            </a>
        </div>
    </div>
</div>

@endsection

@push('scripts')
@vite(['resources/js/tour-gallery.js', 'resources/js/enquiry-intl-tel.js'])
@endpush
