@props(['tour', 'queryParams' => [], 'wishlisted' => false, 'slider' => false, 'variant' => 'default'])

@php
    $firstImg = $tour->images->first();
    $imageUrl = $firstImg?->url ?? 'https://placehold.co/600x400/e5e7eb/6b7280?text=Travel+Package';
    if ($variant === 'flash' && !$firstImg) {
        $imageUrl = 'https://placehold.co/600x800/e5e7eb/6b7280?text=Travel+Package';
    }
    $tourUrl = route('tours.show', $tour->slug);
    if (!empty($queryParams)) {
        $tourUrl .= '?' . http_build_query($queryParams);
    }
@endphp

@if($variant === 'flash')
@php
    $sale = (float) ($tour->price ?? 0);
    $base = (float) ($tour->base_price ?? 0);
    $hasCompare = $base > $sale && $sale >= 0 && $base > 0;
    $currency = ($tour->currency === 'EUR' || !$tour->currency) ? '€' : ($tour->currency === 'USD' ? '$' : $tour->currency . ' ');
    $decimals = ($sale != floor($sale)) ? 2 : 0;
    $baseDecimals = ($base != floor($base)) ? 2 : 0;
@endphp
<article {{ $attributes->merge(['class' => 'h-full min-w-0 w-full']) }}>
    <a href="{{ $tourUrl }}" class="home-flash-sale-card group relative block w-full max-w-full aspect-[3/4] min-h-[420px] sm:min-h-[480px] max-h-[560px] rounded-[28px] overflow-hidden shadow-md ring-1 ring-black/10 h-full box-border">
        <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 ease-out group-hover:scale-[1.04]" style="background-image: url('{{ e($imageUrl) }}');"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/[0.88] via-black/35 to-transparent pointer-events-none"></div>

        @auth
            @if($wishlisted)
                <form method="POST" action="{{ route('wishlist.destroy', $tour) }}" class="absolute top-4 right-4 z-20" onclick="event.preventDefault(); event.stopPropagation(); this.submit();">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-10 h-10 rounded-full bg-white/20 backdrop-blur-sm border border-white/30 flex items-center justify-center text-rose-400 hover:bg-white/30 transition-colors" aria-label="{{ __('Remove from wishlist') }}">
                        <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M6.25 3.333a4.583 4.583 0 0 0-4.583 4.584c0 4.583 5.416 8.75 8.333 9.716 2.917-.966 8.333-5.133 8.333-9.716A4.583 4.583 0 0 0 10 5.28a4.578 4.578 0 0 0-3.75-1.948Z" fill="currentColor" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                </form>
            @else
                <form method="POST" action="{{ route('wishlist.store', $tour) }}" class="absolute top-4 right-4 z-20" onclick="event.preventDefault(); event.stopPropagation(); this.submit();">
                    @csrf
                    <button type="submit" class="w-10 h-10 rounded-full bg-white/20 backdrop-blur-sm border border-white/30 flex items-center justify-center text-white hover:text-rose-400 hover:bg-white/30 transition-colors" aria-label="{{ __('Add to wishlist') }}">
                        <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M6.25 3.333a4.583 4.583 0 0 0-4.583 4.584c0 4.583 5.416 8.75 8.333 9.716 2.917-.966 8.333-5.133 8.333-9.716A4.583 4.583 0 0 0 10 5.28a4.578 4.578 0 0 0-3.75-1.948Z" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                </form>
            @endif
        @endauth

        <div class="absolute inset-x-0 bottom-0 z-10 p-5 sm:p-6 pt-24 flex flex-col justify-end text-left min-w-0">
            <h3 class="text-xl sm:text-2xl font-bold text-white leading-[1.2] tracking-tight line-clamp-4 drop-shadow-sm font-sans break-words">
                {{ $tour->title }}
            </h3>
            <div class="mt-4 flex flex-wrap items-baseline gap-x-2 gap-y-1">
                <span class="text-[15px] sm:text-base font-bold text-white tabular-nums tracking-tight">
                    {{ __('From') }} {{ $currency }}{{ number_format($sale, $decimals) }}
                </span>
                @if($hasCompare)
                    <span class="text-sm sm:text-[15px] font-normal text-white/75 line-through tabular-nums">
                        {{ $currency }}{{ number_format($base, $baseDecimals) }}
                    </span>
                @endif
            </div>
        </div>
    </a>
</article>
@else
@php
    $rating = $tour->average_rating ?? $tour->approvedReviews->avg('rating');
    $reviewCount = $tour->approvedReviews->count();

    $durationLabel = $tour->duration_days
        ? $tour->duration_days . ' ' . ($tour->duration_days === 1 ? __('day') : __('days'))
        : ($tour->duration_hours
            ? ($tour->duration_hours >= 1 ? floor($tour->duration_hours) . ' ' . __('h') : '') .
              ($tour->duration_hours != floor($tour->duration_hours) ? ' ' . round(($tour->duration_hours - floor($tour->duration_hours)) * 60) . ' ' . __('min') : '')
            : null);

    $hasDiscount = $tour->base_price && $tour->price && $tour->base_price > $tour->price;
    $discountPercent = $hasDiscount ? round((1 - $tour->price / $tour->base_price) * 100) : 0;
    $categoryName = $tour->category?->name;
    $currency = ($tour->currency === 'EUR' || !$tour->currency) ? '€' : $tour->currency;
@endphp

<article {{ $attributes->merge(['class' => 'group bg-white rounded-xl overflow-hidden border border-gray-200 transition-shadow min-w-0 w-full ' . ($slider ? 'flex-shrink-0 hover:shadow-md' : 'hover:shadow-lg')]) }}
    @if($slider) data-slider-card @endif>
    <a href="{{ $tourUrl }}" class="flex flex-col h-full w-full min-w-0">
        {{-- Image --}}
        <div class="relative overflow-hidden flex-shrink-0 aspect-[4/3] rounded-xl px-2 mt-2" style="max-width: 100% !important;">
            <img style="width: 100% !important;" src="{{ $imageUrl }}" alt="{{ $tour->title }}"
                 class="w-full rounded-xl h-full object-cover" loading="lazy">

            {{-- Season badge --}}
            @if($tour->season)
                <div class="absolute bottom-3 left-3 flex flex-wrap gap-1.5">
                    @if($tour->is_featured)
                        <span class="inline-flex items-center px-2.5 py-1 text-xs font-bold bg-brand-btn text-white rounded-md backdrop-blur-sm">{{ __('Best Seller') }}</span>
                    @endif
                    @php
                        $seasonLabels = ['summer' => __('Summer'), 'winter' => __('Winter'), 'all_season' => __('All Season')];
                        $seasonColors = ['summer' => 'bg-amber-500/90', 'winter' => 'bg-sky-500/90', 'all_season' => 'bg-emerald-600/90'];
                    @endphp
                    <span class="inline-flex items-center px-2.5 py-1 text-xs font-bold {{ $seasonColors[$tour->season] ?? 'bg-gray-700/90' }} text-white rounded-md backdrop-blur-sm">{{ $seasonLabels[$tour->season] ?? $tour->season }}</span>
                </div>
            @elseif($tour->is_featured)
                <div class="absolute bottom-3 left-3">
                    <span class="inline-flex items-center px-2.5 py-1 text-xs font-bold bg-brand-btn text-white rounded-md backdrop-blur-sm">{{ __('Best Seller') }}</span>
                </div>
            @endif

            {{-- Discount badge --}}
            @if($hasDiscount && $discountPercent >= 5)
                <div class="absolute top-3 left-3">
                    <span class="inline-flex items-center px-2 py-0.5 text-[11px] font-bold bg-red-500 text-white rounded">{{ $discountPercent }}% {{ __('Off') }}</span>
                </div>
            @endif

            {{-- Wishlist --}}
            @auth
                @if($wishlisted)
                    <form method="POST" action="{{ route('wishlist.destroy', $tour) }}" class="absolute top-3 right-3 z-10" onclick="event.preventDefault(); event.stopPropagation(); this.submit();">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-9 h-9 rounded-xl bg-white/20 backdrop-blur-sm border border-white/30 flex items-center justify-center text-rose-500 hover:bg-white/30 transition-colors" aria-label="{{ __('Remove from wishlist') }}">
                            <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M6.25 3.333a4.583 4.583 0 0 0-4.583 4.584c0 4.583 5.416 8.75 8.333 9.716 2.917-.966 8.333-5.133 8.333-9.716A4.583 4.583 0 0 0 10 5.28a4.578 4.578 0 0 0-3.75-1.948Z" fill="currentColor" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                    </form>
                @else
                    <form method="POST" action="{{ route('wishlist.store', $tour) }}" class="absolute top-3 right-3 z-10" onclick="event.preventDefault(); event.stopPropagation(); this.submit();">
                        @csrf
                        <button type="submit" class="w-9 h-9 rounded-xl bg-white/20 backdrop-blur-sm border border-white/30 flex items-center justify-center text-white hover:text-rose-500 hover:bg-white/30 transition-colors" aria-label="{{ __('Add to wishlist') }}">
                            <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M6.25 3.333a4.583 4.583 0 0 0-4.583 4.584c0 4.583 5.416 8.75 8.333 9.716 2.917-.966 8.333-5.133 8.333-9.716A4.583 4.583 0 0 0 10 5.28a4.578 4.578 0 0 0-3.75-1.948Z" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                    </form>
                @endif
            @endauth
        </div>

        {{-- Content --}}
        <div class="flex flex-col flex-1 min-w-0 px-3 pt-3 pb-4">
            {{-- Category tags --}}
            @if($categoryName)
                <div class="flex flex-wrap gap-1.5 mb-2">
                    <span class="inline-flex items-center px-2 py-0.5 text-[11px] font-medium text-sky-700 border border-sky-200 bg-sky-50 rounded">{{ $categoryName }}</span>
                </div>
            @endif

            {{-- Title --}}
            <h3 class="text-[15px] font-semibold text-gray-900 leading-snug line-clamp-2 group-hover:text-gray-700 transition-colors min-h-[41px]">{{ $tour->title }}</h3>

            {{-- Duration --}}
            @if($durationLabel)
                <div class="mt-2">
                    <span class="text-sm text-gray-500 flex items-center gap-1">
                        <i class="fa-regular fa-clock text-xs"></i>
                        {{ $durationLabel }}
                    </span>
                </div>
            @endif

            {{-- Rating + Price --}}
            <div class="mt-auto pt-2.5 flex items-center justify-between gap-2">
                <div class="flex items-center gap-1.5">
                    @if($rating)
                        <span class="inline-flex items-center gap-0.5 text-sm font-bold text-gray-900">
                            <i class="fa-solid fa-star text-amber-400 text-xs"></i>
                            {{ number_format($rating, 1) }}
                        </span>
                    @endif
                    @if($reviewCount)
                        <span class="text-sm text-gray-400">({{ number_format($reviewCount) }})</span>
                    @endif
                </div>

                <div class="flex items-baseline gap-1.5 text-right">
                    <span class="text-xs text-gray-400">{{ __('From') }}</span>
                    @if($hasDiscount)
                        <span class="text-xs text-gray-400 line-through">{{ $currency }}{{ number_format($tour->base_price, 0) }}</span>
                    @endif
                    <span class="text-base font-bold text-gray-900">{{ $currency }}{{ number_format($tour->price ?? 0, 0) }}</span>
                </div>
            </div>
        </div>
    </a>
</article>
@endif
