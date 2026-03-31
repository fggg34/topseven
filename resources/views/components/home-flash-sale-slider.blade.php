@props(['rows'])

@php
    $rows = $rows ?? collect();
@endphp

@if($rows->isNotEmpty())
@php
    $headline = \App\Models\Setting::get('homepage_flash_sale_headline', 'Hand-picked tours for your next trip.');
    $highlight = \App\Models\Setting::get('homepage_flash_sale_highlight', '');
    $ctaLabel = \App\Models\Setting::get('homepage_flash_sale_cta_label', 'View All');
    $ctaUrlRaw = \App\Models\Setting::get('homepage_flash_sale_cta_url', '/tours');
    $ctaUrl = str_starts_with($ctaUrlRaw ?? '', 'http') ? $ctaUrlRaw : url($ctaUrlRaw ?: '/tours');
@endphp

<section class="home-flash-sale-section max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-10 pt-14 pb-14">
    <div class="mb-6 md:mb-8">
        <h2 class="text-3xl sm:text-4xl md:text-[2.125rem] lg:text-[2.5rem] font-semibold text-gray-700 tracking-tight leading-tight">
            @if($highlight !== '' && $highlight !== null && str_contains($headline, (string) $highlight))
                @php
                    $pos = strpos($headline, (string) $highlight);
                    $before = substr($headline, 0, $pos);
                    $after = substr($headline, $pos + strlen((string) $highlight));
                @endphp
                {{ $before }}<span class="home-flash-sale-highlight inline-block px-1.5 py-0.5 rounded bg-gray-200/90 text-gray-800 font-semibold">{{ $highlight }}</span>{{ $after }}
            @else
                {{ $headline }}
            @endif
        </h2>
    </div>

    <div class="swiper home-flash-sale-swiper overflow-visible">
        <div class="swiper-wrapper">
            @foreach($rows as $spotlight)
                @php
                    $tour = $spotlight->tour;
                @endphp
                @continue(!$tour)
                @php
                    $img = $tour->images->first();
                    $imageUrl = $img?->url ?? 'https://placehold.co/600x800/e5e7eb/6b7280?text=Tour';
                    $tourUrl = route('tours.show', $tour->slug);
                    $sale = (float) ($tour->price ?? 0);
                    $base = (float) ($tour->base_price ?? 0);
                    $hasCompare = $base > $sale && $sale >= 0 && $base > 0;
                    $currency = ($tour->currency === 'EUR' || !$tour->currency) ? '€' : ($tour->currency === 'USD' ? '$' : $tour->currency . ' ');
                    $decimals = ($sale != floor($sale)) ? 2 : 0;
                    $baseDecimals = ($base != floor($base)) ? 2 : 0;
                @endphp
                <div class="swiper-slide !h-auto">
                    <a href="{{ $tourUrl }}" class="home-flash-sale-card group relative block aspect-[3/4] min-h-[420px] sm:min-h-[480px] max-h-[560px] rounded-[28px] overflow-hidden shadow-md ring-1 ring-black/10">
                        <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 ease-out group-hover:scale-[1.04]" style="background-image: url('{{ e($imageUrl) }}');"></div>
                        {{-- Readability gradient: strong at bottom, fades by ~mid card --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-black/[0.88] via-black/35 to-transparent pointer-events-none"></div>

                        <div class="absolute inset-x-0 bottom-0 z-10 p-5 sm:p-6 pt-24 flex flex-col justify-end text-left">
                            <h3 class="text-xl sm:text-2xl font-bold text-white leading-[1.2] tracking-tight line-clamp-4 drop-shadow-sm font-sans">
                                {{ $tour->title }}
                            </h3>
                            <div class="mt-4 flex flex-wrap items-baseline gap-x-2 gap-y-1">
                                <span class="text-[15px] sm:text-base font-bold text-white tabular-nums tracking-tight">
                                    From {{ $currency }}{{ number_format($sale, $decimals) }}
                                </span>
                                @if($hasCompare)
                                    <span class="text-sm sm:text-[15px] font-normal text-white/75 line-through tabular-nums">
                                        {{ $currency }}{{ number_format($base, $baseDecimals) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <div class="flex items-center justify-between mt-8 gap-4">
        <a href="{{ $ctaUrl }}" class="inline-flex items-center rounded-full bg-black text-white text-sm font-semibold px-6 py-2.5 hover:bg-gray-900 transition-colors">
            {{ $ctaLabel }}
        </a>
        <div class="flex items-center gap-2">
            <button type="button" class="home-flash-sale-prev w-11 h-11 rounded-full border border-gray-200 bg-gray-100 text-gray-400 flex items-center justify-center transition-colors hover:bg-gray-200 disabled:opacity-40 disabled:pointer-events-none" aria-label="Previous">
                <i class="fa-solid fa-arrow-left text-sm"></i>
            </button>
            <button type="button" class="home-flash-sale-next w-11 h-11 rounded-full bg-black text-white flex items-center justify-center transition-colors hover:bg-gray-900 disabled:opacity-40 disabled:pointer-events-none" aria-label="Next">
                <i class="fa-solid fa-arrow-right text-sm"></i>
            </button>
        </div>
    </div>
</section>
@endif
