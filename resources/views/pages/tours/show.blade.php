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
    $mainImageUrl = $firstImage && $firstImage->path ? $firstImage->url : 'https://placehold.co/1200x600?text=Tour';
@endphp

{{-- Hero banner with first image --}}
<div class="relative w-full overflow-hidden bg-[#111827]" style="height: 420px;">
    <div class="absolute inset-0 bg-cover bg-center opacity-45" style="background-image: url('{{ e($mainImageUrl) }}');"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-[#111827]/90 via-[#111827]/30 to-[#111827]/50"></div>
    <div class="absolute inset-0 flex items-end">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 w-full pb-10">
            <nav class="text-sm mb-4" aria-label="Breadcrumb">
                <ol class="flex items-center gap-1.5">
                    <li><a href="{{ route('home') }}" class="text-white/60 hover:text-white transition">Home</a></li>
                    <li class="text-white/40">/</li>
                    <li><a href="{{ route('tours.index') }}" class="text-white/60 hover:text-white transition">Tours</a></li>
                    <li class="text-white/40">/</li>
                    <li class="text-white truncate max-w-[250px]">{{ $tour->title }}</li>
                </ol>
            </nav>
            @if($tour->category)
                <span class="inline-block px-3 py-1 text-[11px] font-semibold uppercase tracking-wider bg-white/15 text-white/90 backdrop-blur-sm mb-3">{{ $tour->category->name }}</span>
            @endif
            <h1 class="text-3xl md:text-5xl font-serif text-white tracking-tight leading-[1.1]">{{ $tour->title }}</h1>
            @if($tour->approvedReviews->count() > 0)
                <div class="mt-3 flex items-center gap-2">
                    <x-review-stars :rating="(float) $tour->average_rating" />
                    <span class="text-sm text-white/70">({{ $tour->approvedReviews->count() }} reviews)</span>
                </div>
            @endif
        </div>
    </div>
</div>

<div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <div class="lg:col-span-2 space-y-12">

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
            <div class="tour-gallery-grid grid grid-cols-1 sm:grid-cols-2 gap-3 overflow-hidden">
                <a href="{{ $img1->url ?? $mainImageUrl }}" class="glightbox block overflow-hidden min-h-[220px] sm:min-h-[200px] lg:row-span-2" data-gallery="tour-gallery-{{ $tour->id }}" role="listitem">
                    <img src="{{ $img1->url ?? $mainImageUrl }}" alt="{{ $img1->alt ?? $tour->title }}" class="w-full h-full min-h-[220px] sm:min-h-[200px] object-cover cursor-pointer hover:opacity-95 transition-opacity" loading="eager" fetchpriority="high">
                </a>
                <div class="tour-gallery-right grid grid-cols-2 grid-rows-[130px] sm:grid-cols-2 sm:grid-rows-2 sm:min-h-0 gap-3">
                @if($img2)
                    <a href="{{ $img2->url }}" class="glightbox block overflow-hidden h-[130px] sm:h-auto sm:min-h-0" data-gallery="tour-gallery-{{ $tour->id }}" role="listitem">
                        <img src="{{ $img2->url }}" alt="{{ $img2->alt ?? 'Tour image' }}" class="w-full h-full object-cover cursor-pointer hover:opacity-95 transition-opacity" loading="lazy">
                    </a>
                @endif
                @if($img3)
                    <div class="relative overflow-hidden h-[130px] sm:h-auto sm:min-h-0">
                        <a href="{{ $img3->url }}" class="glightbox block w-full h-full overflow-hidden" data-gallery="tour-gallery-{{ $tour->id }}" role="listitem">
                            <img src="{{ $img3->url }}" alt="{{ $img3->alt ?? 'Tour image' }}" class="w-full h-full object-cover cursor-pointer hover:opacity-95 transition-opacity" loading="lazy">
                        </a>
                        @if($totalImages > 4)
                            <a href="{{ $img1->url ?? $mainImageUrl }}" class="glightbox sm:hidden absolute bottom-2 right-2 flex items-center gap-1.5 px-2.5 py-1.5 bg-black/60 text-white text-xs font-medium hover:bg-black/75 transition cursor-pointer z-10" data-gallery="tour-gallery-{{ $tour->id }}" aria-label="View all {{ $totalImages }} photos">
                                <i class="fa-solid fa-images text-xs"></i> View all
                            </a>
                        @endif
                    </div>
                @endif
                @if($img4)
                    <div class="hidden sm:block lg:col-span-2 relative overflow-hidden sm:min-h-0">
                        <a href="{{ $img4->url }}" class="glightbox block w-full h-full overflow-hidden" data-gallery="tour-gallery-{{ $tour->id }}" role="listitem">
                            <img src="{{ $img4->url }}" alt="{{ $img4->alt ?? 'Tour image' }}" class="w-full h-full object-cover cursor-pointer hover:opacity-95 transition-opacity" loading="lazy">
                        </a>
                        @if($totalImages > 4)
                            <a style="z-index: 0;" href="{{ $img1->url ?? $mainImageUrl }}" class="glightbox hidden sm:flex absolute bottom-4 right-4 items-center gap-1.5 px-3 py-2 bg-black/60 text-white text-sm font-medium hover:bg-black/75 transition cursor-pointer z-10" data-gallery="tour-gallery-{{ $tour->id }}" aria-label="View all {{ $totalImages }} photos">
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
                            <img src="{{ $extraImg->url }}" alt="{{ $extraImg->alt ?? 'Tour image' }}" loading="lazy">
                        </a>
                    @endforeach
                </div>
            @endif
            </div>

            {{-- Tour quick facts --}}
            @php
                $durationLabel = $tour->duration_days
                    ? $tour->duration_days . ' day' . ($tour->duration_days > 1 ? 's' : '')
                    : ($tour->duration_hours ? $tour->duration_hours . ' hours' : null);
            @endphp
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-5 py-7 border-y border-[#e6e1d8]">
                <div class="flex gap-3">
                    <div class="flex-shrink-0 w-10 h-10 bg-[#111827] flex items-center justify-center">
                        <i class="fa-solid fa-flag text-white text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[11px] font-semibold uppercase tracking-wider text-[#111827]/50">Tour starts</p>
                        <p class="text-sm text-[#111827] font-medium truncate" title="{{ $tour->start_location }}">{{ $tour->start_location ?: '—' }}</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <div class="flex-shrink-0 w-10 h-10 bg-[#111827] flex items-center justify-center">
                        <i class="fa-solid fa-sun text-white text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[11px] font-semibold uppercase tracking-wider text-[#111827]/50">Duration</p>
                        <p class="text-sm text-[#111827] font-medium">{{ $durationLabel ?: '—' }}</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <div class="flex-shrink-0 w-10 h-10 bg-[#111827] flex items-center justify-center">
                        <i class="fa-solid fa-suitcase text-white text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[11px] font-semibold uppercase tracking-wider text-[#111827]/50">Ending place</p>
                        <p class="text-sm text-[#111827] font-medium truncate" title="{{ $tour->end_location ?? '' }}">{{ $tour->end_location ?? ($tour->start_location ?: '—') }}</p>
                    </div>
                </div>
                @if($tour->category)
                <div class="flex gap-3">
                    <div class="flex-shrink-0 w-10 h-10 bg-[#111827] flex items-center justify-center">
                        <i class="fa-solid fa-route text-white text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[11px] font-semibold uppercase tracking-wider text-[#111827]/50">Tour Type</p>
                        <p class="text-sm text-[#111827] font-medium">{{ $tour->category->name }}</p>
                    </div>
                </div>
                @endif
                @if($tour->difficulty)
                @php $difficultyLabels = ['easy' => 'Easy', 'moderate' => 'Moderate', 'challenging' => 'Challenging', 'strenuous' => 'Strenuous']; @endphp
                <div class="flex gap-3">
                    <div class="flex-shrink-0 w-10 h-10 bg-[#111827] flex items-center justify-center">
                        <i class="fa-solid fa-mountain text-white text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[11px] font-semibold uppercase tracking-wider text-[#111827]/50">Difficulty</p>
                        <p class="text-sm text-[#111827] font-medium">{{ $difficultyLabels[$tour->difficulty] ?? $tour->difficulty }}</p>
                    </div>
                </div>
                @endif
                @if($tour->season)
                @php $seasonLabels = ['summer' => 'Summer', 'winter' => 'Winter', 'all_season' => 'All Season']; @endphp
                <div class="flex gap-3">
                    <div class="flex-shrink-0 w-10 h-10 bg-[#111827] flex items-center justify-center">
                        <i class="fa-solid fa-calendar-check text-white text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[11px] font-semibold uppercase tracking-wider text-[#111827]/50">Availability</p>
                        <p class="text-sm text-[#111827] font-medium">{{ $seasonLabels[$tour->season] ?? $tour->season }}</p>
                    </div>
                </div>
                @endif
                @if($tour->max_group_size)
                <div class="flex gap-3">
                    <div class="flex-shrink-0 w-10 h-10 bg-[#111827] flex items-center justify-center">
                        <i class="fa-solid fa-user-group text-white text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[11px] font-semibold uppercase tracking-wider text-[#111827]/50">Max people</p>
                        <p class="text-sm text-[#111827] font-medium">{{ $tour->max_group_size }}</p>
                    </div>
                </div>
                @endif
                @if($tour->languages && count($tour->languages) > 0)
                <div class="flex gap-3">
                    <div class="flex-shrink-0 w-10 h-10 bg-[#111827] flex items-center justify-center">
                        <i class="fa-solid fa-language text-white text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[11px] font-semibold uppercase tracking-wider text-[#111827]/50">Language</p>
                        <p class="text-sm text-[#111827] font-medium">{{ implode(', ', (array) $tour->languages) }}</p>
                    </div>
                </div>
                @endif
            </div>

            {{-- Summary --}}
            <div class="prose max-w-none prose-headings:font-serif prose-headings:text-[#111827] prose-p:text-[#4a4a4a] prose-p:leading-[1.8]">
                <h2 class="text-3xl font-serif text-[#111827] mb-4">Summary</h2>
                {!! $tour->description !!}
            </div>

            {{-- Tour highlights --}}
            @if($tour->tour_highlights && count($tour->tour_highlights) > 0)
                <div>
                    <h2 class="text-3xl font-serif text-[#111827] mb-4">Tour highlights</h2>
                    <ul class="space-y-3">
                        @foreach($tour->tour_highlights as $highlight)
                            @php $text = is_array($highlight) ? ($highlight['text'] ?? $highlight['value'] ?? '') : $highlight; @endphp
                            @if($text)
                                <li class="flex items-start gap-3">
                                    <span class="flex-shrink-0 w-7 h-7 bg-[#111827] flex items-center justify-center text-white">
                                        <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                    </span>
                                    <span class="text-[#4a4a4a]">{{ $text }}</span>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Important notes --}}
            @if($tour->important_notes)
                <div class="border border-amber-200 bg-amber-50/50 p-6">
                    <h2 class="text-xl font-serif text-amber-800 mb-3 flex items-center gap-2">
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
                    <h2 class="text-3xl font-serif text-[#111827] mb-4">Itinerary &amp; Details</h2>
                    <div class="border border-[#e6e1d8] overflow-hidden divide-y divide-[#e6e1d8]">
                        @foreach($tour->itineraries as $day)
                            <div class="bg-white">
                                <button type="button"
                                    @click="openDay = openDay === {{ $day->id }} ? null : {{ $day->id }}"
                                    :class="openDay === {{ $day->id }} ? 'bg-[#f8f6f2]' : 'bg-white hover:bg-[#faf9f6]'"
                                    class="w-full flex items-center justify-between px-5 py-5 text-left font-semibold text-[#111827] transition-colors">
                                    <span>@if($day->day)Day {{ $day->day }}: @endif{{ $day->title }}</span>
                                    <span class="inline-flex w-7 h-7 flex-shrink-0 ml-2 items-center justify-center">
                                        <i class="fa-solid fa-chevron-down text-[#111827]/40 text-base transition-transform duration-200"
                                            :class="openDay === {{ $day->id }} ? 'rotate-180' : ''" aria-hidden="true"></i>
                                    </span>
                                </button>
                                <div x-show="openDay === {{ $day->id }}" x-collapse class="border-t border-[#e6e1d8]">
                                    <div class="px-5 py-5 text-[#4a4a4a] text-sm space-y-4">
                                        @if($day->description)
                                            <div class="prose prose-sm max-w-none text-[#4a4a4a]">
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

            {{-- What to bring --}}
            @if($tour->what_to_bring && count($tour->what_to_bring) > 0)
                <div>
                    <h2 class="text-3xl font-serif text-[#111827] mb-3">What to bring</h2>
                    <ul class="space-y-2">
                        @foreach((array) $tour->what_to_bring as $item)
                            <li class="flex items-start gap-3">
                                <span class="flex-shrink-0 w-7 h-7 bg-[#f8f6f2] border border-[#e6e1d8] flex items-center justify-center text-[#111827]">
                                    <i class="fa-solid fa-suitcase text-xs"></i>
                                </span>
                                <span class="text-[#4a4a4a]">{{ $item }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Included & Not included --}}
            @if($tour->included || $tour->not_included)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-12">
                    @if($tour->included)
                        <div>
                            <h2 class="text-3xl font-serif text-[#111827] mb-3">Included</h2>
                            <ul class="space-y-2">
                                @foreach((array) $tour->included as $item)
                                    <li class="flex items-start gap-3">
                                        <span class="flex-shrink-0 w-7 h-7 bg-emerald-50 border border-emerald-200 flex items-center justify-center text-emerald-600">
                                            <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                        </span>
                                        <span class="text-[#4a4a4a]">{{ $item }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if($tour->not_included)
                        <div>
                            <h2 class="text-3xl font-serif text-[#111827] mb-3">Not included</h2>
                            <ul class="space-y-2">
                                @foreach((array) $tour->not_included as $item)
                                    <li class="flex items-start gap-3">
                                        <span class="flex-shrink-0 w-7 h-7 bg-red-50 border border-red-200 flex items-center justify-center text-red-500">
                                            <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                        </span>
                                        <span class="text-[#4a4a4a]">{{ $item }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            @endif

            {{-- Customer reviews --}}
            @php
                $reviews = $tour->approvedReviews;
                $avgRating = (float) $tour->average_rating;
                $reviewCount = $tour->approvedReviews->count();
            @endphp
            <div>
                <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-6 mb-8">
                    <div>
                        <h2 class="text-3xl font-serif text-[#111827]">Customer reviews</h2>
                        <p class="mt-1 text-[15px] text-[#6a6a6a]">
                            Read what real customers had to say about <strong class="font-semibold text-[#111827]">{{ $tour->title }}.</strong>
                        </p>
                    </div>
                    @if($reviewCount > 0)
                    <div class="flex-shrink-0 w-full md:w-auto md:min-w-[200px]">
                        <div class="p-5 text-white bg-[#111827]">
                            <p class="text-sm text-white/70">Overall rating</p>
                            @php
                                $fullStars = (int) floor($avgRating);
                                $halfStar = ($avgRating - $fullStars) >= 0.5;
                                $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                            @endphp
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-4xl font-bold font-serif">{{ number_format($avgRating, 1) }}</span>
                                <span class="flex items-center -mt-1" aria-hidden="true">
                                    @for($i = 0; $i < $fullStars; $i++)
                                        <svg class="w-6 h-6 text-amber-400 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    @endfor
                                    @if($halfStar)
                                        <svg class="w-6 h-6 text-amber-400 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><defs><linearGradient id="half-overall"><stop offset="50%" stop-color="currentColor"/><stop offset="50%" stop-color="rgba(255,255,255,0.4)"/></linearGradient></defs><path fill="url(#half-overall)" d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    @endif
                                    @for($i = 0; $i < $emptyStars; $i++)
                                        <svg class="w-6 h-6 text-white/30 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    @endfor
                                </span>
                            </div>
                            <p class="text-sm mt-1 text-white/60">based on {{ $reviewCount }} {{ Str::plural('review', $reviewCount) }}</p>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="space-y-5 mb-8">
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
                        <div class="border border-[#e6e1d8] p-5 md:p-6 bg-white relative" x-data="{ expanded: false }">
                            <x-review-platform-logo :platform="$review->platform" :url="$review->platform_tour_url" />
                            <div class="flex gap-4 {{ $review->platform ? 'pr-12' : '' }}">
                                <div class="w-12 h-12 rounded-full bg-[#111827] flex items-center justify-center text-white text-sm font-semibold flex-shrink-0">
                                    {{ $initials }}
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="font-medium text-[#111827]">
                                        {{ $name }}
                                        <span class="text-[#999] font-normal"> {{ $displayDate->format('d/m/Y') }}</span>
                                    </p>
                                    <div class="mt-1.5 flex items-center gap-0.5" aria-label="Rating: {{ $review->rating }} out of 5">
                                        @for($i = 0; $i < min(5, (int) $review->rating); $i++)
                                            <i class="fa-solid fa-star text-amber-400 text-sm"></i>
                                        @endfor
                                        @for($i = (int) $review->rating; $i < 5; $i++)
                                            <i class="fa-regular fa-star text-gray-300 text-sm"></i>
                                        @endfor
                                    </div>
                                    @if($review->title)
                                        <h3 class="font-bold text-lg text-[#111827] mt-3">{{ $review->title }}</h3>
                                    @endif
                                    <div class="mt-2 text-[#4a4a4a]">
                                        <p :class="expanded ? '' : 'line-clamp-4'">{{ $review->comment }}</p>
                                        @if(strlen($review->comment) > 280)
                                            <button type="button" @click="expanded = !expanded" class="text-[#111827] font-semibold hover:underline mt-1 text-sm" x-text="expanded ? 'Show less' : 'Show more'"></button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @auth
                    @if($userHasReviewed ?? false)
                        <div class="border border-[#e6e1d8] bg-[#f8f6f2] p-6 text-center">
                            <p class="text-[#6a6a6a]">You have already reviewed this tour. Thank you!</p>
                        </div>
                    @else
                        <div class="border border-[#e6e1d8] bg-white p-6 md:p-8">
                            <h3 class="text-xl font-serif text-[#111827] mb-6">Leave a review</h3>

                            @if(session('error'))
                                <div class="mb-6 p-4 bg-red-50 text-red-700 text-sm">{{ session('error') }}</div>
                            @endif
                            @if(session('success'))
                                <div class="mb-6 p-4 bg-emerald-50 text-emerald-800 text-sm flex items-center gap-2">
                                    <i class="fa-solid fa-circle-check text-emerald-600"></i>
                                    {{ session('success') }}
                                </div>
                            @endif

                            <form action="{{ route('reviews.store', $tour) }}" method="POST" class="space-y-6" x-data="{ rating: {{ old('rating', 0) }} }" x-init="if(rating) $refs.ratingInput.value = rating">
                                @csrf
                                <div>
                                    <label class="block text-[13px] font-semibold uppercase tracking-wider text-[#111827]/60 mb-2">Your overall rating <span class="text-red-500">*</span></label>
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
                                    <label for="review_title" class="block text-[13px] font-semibold uppercase tracking-wider text-[#111827]/60 mb-2">Title <span class="text-red-500">*</span></label>
                                    <input type="text" name="title" id="review_title" value="{{ old('title') }}" required placeholder="Summarize your experience"
                                        class="w-full border border-[#d1cdc4] bg-white px-4 py-3 text-sm text-[#111827] focus:outline-none focus:ring-1 focus:ring-[#111827] focus:border-[#111827] transition">
                                    @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="review_comment" class="block text-[13px] font-semibold uppercase tracking-wider text-[#111827]/60 mb-2">Your review <span class="text-red-500">*</span></label>
                                    <textarea name="comment" id="review_comment" rows="5" required placeholder="Share your experience..."
                                        class="w-full border border-[#d1cdc4] bg-white px-4 py-3 text-sm text-[#111827] focus:outline-none focus:ring-1 focus:ring-[#111827] focus:border-[#111827] transition resize-y">{{ old('comment') }}</textarea>
                                    @error('comment')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>
                                <button type="submit" class="px-8 py-3.5 bg-[#111827] hover:bg-[#1f2937] text-white text-sm font-semibold tracking-wider uppercase transition-colors">
                                    Submit Review
                                </button>
                            </form>
                        </div>
                    @endif
                @else
                    <div class="border border-[#e6e1d8] bg-white p-6 md:p-8 text-center">
                        <p class="text-[#6a6a6a] mb-5">To leave a review you need to log in.</p>
                        <a href="{{ route('login') }}" class="inline-flex items-center px-8 py-3.5 bg-[#111827] hover:bg-[#1f2937] text-white text-sm font-semibold tracking-wider uppercase transition-colors">
                            Log in to your account
                        </a>
                    </div>
                @endauth
            </div>
        </div>

        {{-- ENQUIRY SIDEBAR --}}
        <div class="lg:col-span-1">
            <div id="enquiry-form" class="lg:sticky lg:top-24 lg:self-start scroll-mt-12">
                <div class="bg-[#f8f6f2] border border-[#e6e1d8]">
                    <div class="bg-[#111827] px-6 py-5">
                        <h3 class="text-xl font-serif text-white">Enquire About This Tour</h3>
                        @php
                            $basePrice = (float)($tour->base_price ?? $tour->price ?? 0);
                            $currency = ($tour->currency === 'EUR' || !$tour->currency) ? '€' : ($tour->currency === 'USD' ? '$' : $tour->currency . ' ');
                        @endphp
                        @if($basePrice > 0)
                            <p class="text-white/70 text-sm mt-1">From <span class="text-white font-semibold text-lg">{{ $currency }}{{ number_format($basePrice, 0) }}</span> / person</p>
                        @endif
                    </div>

                    <div class="p-6">
                        @if(session('enquiry_success'))
                            <div class="mb-5 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-start gap-2">
                                <i class="fa-solid fa-circle-check text-emerald-600 mt-0.5"></i>
                                <span>{{ session('enquiry_success') }}</span>
                            </div>
                        @endif

                        <form action="{{ route('tours.enquiry.store', $tour->slug) }}" method="POST" class="space-y-4">
                            @csrf

                            <div>
                                <label class="block text-[12px] font-semibold uppercase tracking-wider text-[#111827]/60 mb-1.5">Full Name <span class="text-red-500">*</span></label>
                                <input type="text" name="full_name" value="{{ old('full_name') }}" required
                                    class="w-full border border-[#d1cdc4] bg-white px-4 py-3 text-sm text-[#111827] focus:outline-none focus:ring-1 focus:ring-[#111827] focus:border-[#111827] transition"
                                    placeholder="Your full name">
                                @error('full_name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block text-[12px] font-semibold uppercase tracking-wider text-[#111827]/60 mb-1.5">Email <span class="text-red-500">*</span></label>
                                <input type="email" name="email" value="{{ old('email') }}" required
                                    class="w-full border border-[#d1cdc4] bg-white px-4 py-3 text-sm text-[#111827] focus:outline-none focus:ring-1 focus:ring-[#111827] focus:border-[#111827] transition"
                                    placeholder="your@email.com">
                                @error('email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block text-[12px] font-semibold uppercase tracking-wider text-[#111827]/60 mb-1.5">Phone</label>
                                <input type="tel" name="phone" value="{{ old('phone') }}"
                                    class="w-full border border-[#d1cdc4] bg-white px-4 py-3 text-sm text-[#111827] focus:outline-none focus:ring-1 focus:ring-[#111827] focus:border-[#111827] transition"
                                    placeholder="+355 ...">
                                @error('phone')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-[12px] font-semibold uppercase tracking-wider text-[#111827]/60 mb-1.5">Departure</label>
                                    <input type="date" name="departure_date"
                                        value="{{ old('departure_date', $tour->homepage_card_date_from?->format('Y-m-d')) }}"
                                        class="w-full border border-[#d1cdc4] bg-white px-3 py-3 text-sm text-[#111827] focus:outline-none focus:ring-1 focus:ring-[#111827] focus:border-[#111827] transition">
                                    @error('departure_date')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-[12px] font-semibold uppercase tracking-wider text-[#111827]/60 mb-1.5">Return</label>
                                    <input type="date" name="return_date"
                                        value="{{ old('return_date', $tour->homepage_card_date_to?->format('Y-m-d')) }}"
                                        class="w-full border border-[#d1cdc4] bg-white px-3 py-3 text-sm text-[#111827] focus:outline-none focus:ring-1 focus:ring-[#111827] focus:border-[#111827] transition">
                                    @error('return_date')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-[12px] font-semibold uppercase tracking-wider text-[#111827]/60 mb-1.5">Guests <span class="text-red-500">*</span></label>
                                <input type="number" name="guests" value="{{ old('guests', 2) }}" min="1" max="100" required
                                    class="w-full border border-[#d1cdc4] bg-white px-4 py-3 text-sm text-[#111827] focus:outline-none focus:ring-1 focus:ring-[#111827] focus:border-[#111827] transition">
                                @error('guests')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block text-[12px] font-semibold uppercase tracking-wider text-[#111827]/60 mb-1.5">Message</label>
                                <textarea name="message" rows="3"
                                    class="w-full border border-[#d1cdc4] bg-white px-4 py-3 text-sm text-[#111827] focus:outline-none focus:ring-1 focus:ring-[#111827] focus:border-[#111827] transition resize-y"
                                    placeholder="Any special requests or questions...">{{ old('message') }}</textarea>
                                @error('message')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <button type="submit" class="w-full py-3.5 bg-[#111827] hover:bg-[#1f2937] text-white text-sm font-semibold tracking-wider uppercase transition-colors">
                                Send Enquiry
                            </button>
                        </form>

                        <div class="mt-5 pt-4 border-t border-[#e6e1d8] space-y-2">
                            <div class="flex items-center gap-2 text-sm text-[#6a6a6a]">
                                <i class="fa-solid fa-shield-halved text-[#111827] text-xs"></i>
                                <span>No commitment required</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-[#6a6a6a]">
                                <i class="fa-solid fa-clock text-[#111827] text-xs"></i>
                                <span>We respond within 24 hours</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-[#6a6a6a]">
                                <i class="fa-solid fa-user-tie text-[#111827] text-xs"></i>
                                <span>Personal travel advisor</span>
                            </div>
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
     class="fixed bottom-0 left-0 right-0 z-40 lg:hidden bg-white border-t border-[#e6e1d8] shadow-[0_-4px_12px_rgba(0,0,0,0.08)]"
     style="display: none;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3">
        <div class="flex items-center justify-between gap-4">
            <div class="flex flex-col min-w-0">
                <span class="text-xs text-[#6a6a6a]">From</span>
                @php
                    $mobilePrice = (float)($tour->base_price ?? $tour->price ?? 0);
                    $mobileCurrency = ($tour->currency === 'EUR' || !$tour->currency) ? '€' : $tour->currency;
                @endphp
                <span class="text-lg font-bold text-[#111827]">{{ $mobileCurrency }} {{ number_format($mobilePrice, 0) }} <span class="text-xs font-normal text-[#6a6a6a]">/ person</span></span>
            </div>
            <a href="#enquiry-form"
                class="flex-shrink-0 py-3 px-5 bg-[#111827] text-white font-semibold text-sm uppercase tracking-wider hover:bg-[#1f2937] transition-colors">
                Enquire Now
            </a>
        </div>
    </div>
</div>

@endsection

@push('scripts')
@vite(['resources/js/tour-gallery.js'])
@endpush
