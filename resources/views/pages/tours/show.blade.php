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
</style>
@endpush

@section('content')
@php
    $images = $tour->images->isEmpty() ? collect([null]) : $tour->images;
    $firstImage = $images->first();
    $mainImageUrl = $firstImage && $firstImage->path ? $firstImage->url : 'https://placehold.co/1200x600?text=Travel+Package';
@endphp

{{-- Hero --}}
<section class="relative w-full overflow-hidden rounded-b-[40px]" style="height: 460px;">
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ e($mainImageUrl) }}');"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/25 to-transparent"></div>
    <div class="absolute inset-0 flex flex-col justify-end">
        <div class="w-full max-w-none px-4 sm:px-6 md:px-[80px] pb-10 md:pb-12">
            <nav class="text-sm mb-4 opacity-70" aria-label="Breadcrumb">
                <ol class="flex items-center gap-1.5 text-white/80">
                    <li><a href="{{ route('home') }}" class="hover:text-white transition">Home</a></li>
                    <li>/</li>
                    <li><a href="{{ route('tours.index') }}" class="hover:text-white transition">Travel Packages</a></li>
                    <li>/</li>
                    <li class="truncate max-w-[250px]">{{ $tour->title }}</li>
                </ol>
            </nav>
            @if($tour->category)
                <span class="inline-flex rounded-full bg-white/20 backdrop-blur-sm px-3.5 py-1 text-[12px] font-medium text-white mb-3">{{ $tour->category->name }}</span>
            @endif
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-white tracking-tight leading-[1.08]">{{ $tour->title }}</h1>
            @if($tour->approvedReviews->count() > 0)
                <div class="mt-3 flex items-center gap-2">
                    <x-review-stars :rating="(float) $tour->average_rating" />
                    <span class="text-sm text-white/70">({{ $tour->approvedReviews->count() }} reviews)</span>
                </div>
            @endif
        </div>
    </div>
</section>

{{-- Quick facts --}}
@php
    $durationLabel = $tour->duration_days
        ? $tour->duration_days . ' day' . ($tour->duration_days > 1 ? 's' : '')
        : ($tour->duration_hours ? $tour->duration_hours . ' hours' : null);
    $facts = collect();
    if ($tour->start_location) $facts->push(['icon' => 'fa-flag', 'label' => 'Starts', 'value' => $tour->start_location]);
    if ($durationLabel) $facts->push(['icon' => 'fa-sun', 'label' => 'Duration', 'value' => $durationLabel]);
    if ($tour->end_location ?? $tour->start_location) $facts->push(['icon' => 'fa-suitcase', 'label' => 'Ends', 'value' => $tour->end_location ?? $tour->start_location]);
    if ($tour->category) $facts->push(['icon' => 'fa-route', 'label' => 'Type', 'value' => $tour->category->name]);
    if ($tour->difficulty) {
        $dl = ['easy' => 'Easy', 'moderate' => 'Moderate', 'challenging' => 'Challenging', 'strenuous' => 'Strenuous'];
        $facts->push(['icon' => 'fa-mountain', 'label' => 'Difficulty', 'value' => $dl[$tour->difficulty] ?? $tour->difficulty]);
    }
    if ($tour->season) {
        $sl = ['summer' => 'Summer', 'winter' => 'Winter', 'all_season' => 'All Season'];
        $facts->push(['icon' => 'fa-calendar-check', 'label' => 'Season', 'value' => $sl[$tour->season] ?? $tour->season]);
    }
    if ($tour->max_group_size) $facts->push(['icon' => 'fa-user-group', 'label' => 'Max people', 'value' => $tour->max_group_size]);
    if ($tour->languages && count($tour->languages) > 0) $facts->push(['icon' => 'fa-language', 'label' => 'Language', 'value' => implode(', ', (array) $tour->languages)]);
@endphp
@if($facts->isNotEmpty())
<section class="px-4 sm:px-6 md:px-[80px] -mt-7 relative z-10">
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

                {{-- Gallery --}}
                @php
                    $galleryImages = $tour->images->isEmpty() ? collect([(object)['url' => $mainImageUrl, 'alt' => $tour->title]]) : $tour->images;
                    $img1 = $galleryImages->get(0);
                    $img2 = $galleryImages->get(1);
                    $img3 = $galleryImages->get(2);
                    $img4 = $galleryImages->get(3);
                    $totalImages = $galleryImages->count();
                @endphp
                <div class="tour-gallery">
                <div class="tour-gallery-grid grid grid-cols-1 sm:grid-cols-2 gap-3 overflow-hidden rounded-2xl">
                    <a href="{{ $img1->url ?? $mainImageUrl }}" class="glightbox block overflow-hidden min-h-[220px] sm:min-h-[200px] lg:row-span-2 rounded-xl" data-gallery="tour-gallery-{{ $tour->id }}" role="listitem">
                        <img src="{{ $img1->url ?? $mainImageUrl }}" alt="{{ $img1->alt ?? $tour->title }}" class="w-full h-full min-h-[220px] sm:min-h-[200px] object-cover hover:scale-[1.03] transition-transform duration-500" loading="eager" fetchpriority="high">
                    </a>
                    <div class="tour-gallery-right grid grid-cols-2 grid-rows-[130px] sm:grid-cols-2 sm:grid-rows-2 sm:min-h-0 gap-3">
                    @if($img2)
                        <a href="{{ $img2->url }}" class="glightbox block overflow-hidden h-[130px] sm:h-auto sm:min-h-0 rounded-xl" data-gallery="tour-gallery-{{ $tour->id }}" role="listitem">
                            <img src="{{ $img2->url }}" alt="{{ $img2->alt ?? 'Travel package image' }}" class="w-full h-full object-cover hover:scale-[1.03] transition-transform duration-500" loading="lazy">
                        </a>
                    @endif
                    @if($img3)
                        <div class="relative overflow-hidden h-[130px] sm:h-auto sm:min-h-0 rounded-xl">
                            <a href="{{ $img3->url }}" class="glightbox block w-full h-full overflow-hidden" data-gallery="tour-gallery-{{ $tour->id }}" role="listitem">
                                <img src="{{ $img3->url }}" alt="{{ $img3->alt ?? 'Travel package image' }}" class="w-full h-full object-cover hover:scale-[1.03] transition-transform duration-500" loading="lazy">
                            </a>
                            @if($totalImages > 4)
                                <a href="{{ $img1->url ?? $mainImageUrl }}" class="glightbox sm:hidden absolute bottom-2 right-2 flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-black/60 text-white text-xs font-medium hover:bg-black/75 transition z-10" data-gallery="tour-gallery-{{ $tour->id }}" aria-label="View all {{ $totalImages }} photos">
                                    <i class="fa-solid fa-images text-xs"></i> View all
                                </a>
                            @endif
                        </div>
                    @endif
                    @if($img4)
                        <div class="hidden sm:block lg:col-span-2 relative overflow-hidden sm:min-h-0 rounded-xl">
                            <a href="{{ $img4->url }}" class="glightbox block w-full h-full overflow-hidden" data-gallery="tour-gallery-{{ $tour->id }}" role="listitem">
                                <img src="{{ $img4->url }}" alt="{{ $img4->alt ?? 'Travel package image' }}" class="w-full h-full object-cover hover:scale-[1.03] transition-transform duration-500" loading="lazy">
                            </a>
                            @if($totalImages > 4)
                                <a style="z-index: 0;" href="{{ $img1->url ?? $mainImageUrl }}" class="glightbox hidden sm:flex absolute bottom-3 right-3 items-center gap-1.5 px-4 py-2 rounded-full bg-black/60 text-white text-sm font-medium hover:bg-black/75 transition z-10" data-gallery="tour-gallery-{{ $tour->id }}" aria-label="View all {{ $totalImages }} photos">
                                    <i class="fa-solid fa-images text-sm"></i> View all
                                </a>
                            @endif
                        </div>
                    @endif
                    </div>
                </div>
                @if($totalImages > 4)
                    <div class="hidden">
                        @foreach($galleryImages->skip(4) as $extraImg)
                            <a href="{{ $extraImg->url }}" class="glightbox" data-gallery="tour-gallery-{{ $tour->id }}">
                                <img src="{{ $extraImg->url }}" alt="{{ $extraImg->alt ?? 'Travel package image' }}" loading="lazy">
                            </a>
                        @endforeach
                    </div>
                @endif
                </div>

                {{-- Summary --}}
                <div class="prose max-w-none prose-headings:font-bold prose-headings:text-gray-900 prose-p:text-gray-600 prose-p:leading-[1.8]">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Summary</h2>
                    {!! $tour->description !!}
                </div>

                {{-- Tour highlights --}}
                @if($tour->tour_highlights && count($tour->tour_highlights) > 0)
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-5">Travel package highlights</h2>
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
                        Important notes
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
                        <h2 class="text-2xl font-bold text-gray-900 mb-5">Itinerary &amp; Details</h2>
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
                    <h2 class="text-2xl font-bold text-gray-900 mb-5">Where you&rsquo;ll stay</h2>
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
                                            <a href="{{ $hero }}" class="glightbox block h-full min-h-[200px] md:min-h-[260px]" data-gallery="hotel-gallery-{{ $hotel->id }}" aria-label="View {{ $hotel->name }} photo">
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
                                                {{ $isResort ? 'Resort' : 'Hotel' }}
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
                                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-3 mt-5">Gallery</p>
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
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">What to bring</h2>
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
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    @if($tour->included)
                    <div class="bg-emerald-50/50 rounded-2xl p-6">
                        <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <span class="w-7 h-7 rounded-lg bg-emerald-500 text-white flex items-center justify-center">
                                <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                            </span>
                            Included
                        </h2>
                        <ul class="space-y-2.5">
                            @foreach((array) $tour->included as $item)
                            <li class="flex items-start gap-2.5 text-[15px] text-gray-700">
                                <i class="fa-solid fa-check text-emerald-500 text-xs mt-1.5"></i>
                                {{ $item }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    @if($tour->not_included)
                    <div class="bg-red-50/50 rounded-2xl p-6">
                        <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <span class="w-7 h-7 rounded-lg bg-red-500 text-white flex items-center justify-center">
                                <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                            </span>
                            Not included
                        </h2>
                        <ul class="space-y-2.5">
                            @foreach((array) $tour->not_included as $item)
                            <li class="flex items-start gap-2.5 text-[15px] text-gray-700">
                                <i class="fa-solid fa-xmark text-red-400 text-xs mt-1.5"></i>
                                {{ $item }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
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
                            <h2 class="text-2xl font-bold text-gray-900">Customer reviews</h2>
                            <p class="mt-1 text-[15px] text-gray-500">
                                What real customers say about <strong class="font-semibold text-gray-900">{{ $tour->title }}</strong>.
                            </p>
                        </div>
                        @if($reviewCount > 0)
                        <div class="flex-shrink-0 w-full md:w-auto md:min-w-[180px]">
                            <div class="rounded-2xl bg-gray-900 p-5 text-white">
                                <p class="text-sm text-white/60">Overall</p>
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
                                <p class="text-sm mt-1 text-white/50">{{ $reviewCount }} {{ Str::plural('review', $reviewCount) }}</p>
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
                                                <button type="button" @click="expanded = !expanded" class="text-gray-900 font-semibold hover:underline mt-1 text-sm" x-text="expanded ? 'Show less' : 'Show more'"></button>
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
                                <p class="text-gray-500">You have already reviewed this travel package. Thank you!</p>
                            </div>
                        @else
                            <div class="rounded-2xl border border-gray-200 bg-white p-6 md:p-8">
                                <h3 class="text-xl font-bold text-gray-900 mb-6">Leave a review</h3>

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
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Your overall rating <span class="text-red-500">*</span></label>
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
                                        <label for="review_title" class="block text-sm font-medium text-gray-700 mb-1.5">Title <span class="text-red-500">*</span></label>
                                        <input type="text" name="title" id="review_title" value="{{ old('title') }}" required placeholder="Summarize your experience"
                                            class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition">
                                        @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                    </div>
                                    <div>
                                        <label for="review_comment" class="block text-sm font-medium text-gray-700 mb-1.5">Your review <span class="text-red-500">*</span></label>
                                        <textarea name="comment" id="review_comment" rows="5" required placeholder="Share your experience..."
                                            class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition resize-y">{{ old('comment') }}</textarea>
                                        @error('comment')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                    </div>
                                    <button type="submit" class="inline-flex items-center rounded-full bg-gray-900 text-white text-sm font-semibold px-7 py-3 hover:bg-gray-800 transition-colors">
                                        Submit Review
                                    </button>
                                </form>
                            </div>
                        @endif
                    @else
                        <div class="rounded-2xl bg-gray-100 p-6 md:p-8 text-center">
                            <p class="text-gray-500 mb-5">To leave a review you need to log in.</p>
                            <a href="{{ route('login') }}" class="inline-flex items-center rounded-full bg-gray-900 text-white text-sm font-semibold px-7 py-3 hover:bg-gray-800 transition-colors">
                                Log in to your account
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
                            <h3 class="text-lg font-bold text-white">Enquire About This Travel Package</h3>
                            @php
                                $basePrice = (float)($tour->base_price ?? $tour->price ?? 0);
                                $currency = ($tour->currency === 'EUR' || !$tour->currency) ? '€' : ($tour->currency === 'USD' ? '$' : $tour->currency . ' ');
                            @endphp
                            @if($basePrice > 0)
                                <p class="text-white/60 text-sm mt-1">From <span class="text-white font-semibold text-lg">{{ $currency }}{{ number_format($basePrice, 0) }}</span> / person</p>
                            @endif
                        </div>

                        <div class="p-5">
                            @if(session('enquiry_success'))
                                <div class="mb-4 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-start gap-2">
                                    <i class="fa-solid fa-circle-check text-emerald-600 mt-0.5"></i>
                                    <span>{{ session('enquiry_success') }}</span>
                                </div>
                            @endif

                            <form action="{{ route('tours.enquiry.store', $tour->slug) }}" method="POST" class="space-y-3.5">
                                @csrf

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name <span class="text-red-500">*</span></label>
                                    <input type="text" name="full_name" value="{{ old('full_name') }}" required
                                        class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition"
                                        placeholder="Your full name">
                                    @error('full_name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                                    <input type="email" name="email" value="{{ old('email') }}" required
                                        class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition"
                                        placeholder="your@email.com">
                                    @error('email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                                    <input type="tel" name="phone" value="{{ old('phone') }}"
                                        class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition"
                                        placeholder="+355 ...">
                                    @error('phone')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                </div>

                                @if($tour->homepage_card_date_from || $tour->homepage_card_date_to)
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Departure</label>
                                        <div class="w-full rounded-xl border border-gray-200 bg-gray-100 px-3 py-3 text-sm text-gray-900 tabular-nums select-none" title="Set by your travel advisor for this package">
                                            {{ $tour->homepage_card_date_from?->format('M j, Y') ?? '—' }}
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Return</label>
                                        <div class="w-full rounded-xl border border-gray-200 bg-gray-100 px-3 py-3 text-sm text-gray-900 tabular-nums select-none" title="Set by your travel advisor for this package">
                                            {{ $tour->homepage_card_date_to?->format('M j, Y') ?? '—' }}
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Guests <span class="text-red-500">*</span></label>
                                    <input type="number" name="guests" value="{{ old('guests', 2) }}" min="1" max="100" required
                                        class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition">
                                    @error('guests')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                                    <textarea name="message" rows="3"
                                        class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition resize-y"
                                        placeholder="Any special requests...">{{ old('message') }}</textarea>
                                    @error('message')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                </div>

                                <button type="submit" class="w-full rounded-full py-3.5 bg-gray-900 hover:bg-gray-800 text-white text-sm font-semibold transition-colors">
                                    Send Enquiry
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
                <span class="text-xs text-gray-400">From</span>
                @php
                    $mobilePrice = (float)($tour->base_price ?? $tour->price ?? 0);
                    $mobileCurrency = ($tour->currency === 'EUR' || !$tour->currency) ? '€' : $tour->currency;
                @endphp
                <span class="text-lg font-bold text-gray-900">{{ $mobileCurrency }} {{ number_format($mobilePrice, 0) }} <span class="text-xs font-normal text-gray-400">/ person</span></span>
            </div>
            <a href="#enquiry-form"
                class="flex-shrink-0 rounded-full py-3 px-6 bg-gray-900 text-white font-semibold text-sm hover:bg-gray-800 transition-colors">
                Enquire Now
            </a>
        </div>
    </div>
</div>

@endsection

@push('scripts')
@vite(['resources/js/tour-gallery.js'])
@endpush
