@props([
    'countries',
    'heading' => null,
])

@php
    $countries = $countries ?? collect();
    $heading = $heading ?? \App\Models\Setting::get('homepage_where_next_heading', 'Where to next?');
@endphp

@if($countries->isNotEmpty())
<section class="home-where-next w-full bg-white py-14 md:py-20">
    <div class="w-full max-w-none px-4 sm:px-6 lg:px-[80px]">
        <h2 class="text-4xl sm:text-5xl md:text-[2.75rem] lg:text-6xl font-bold text-brand-heading text-left tracking-tight leading-[1.1] mb-8 md:mb-10">
            {{ $heading }}
        </h2>

        {{-- Mobile: Swiper — 2×2 grid per slide (same nav buttons as homepage flash-sale slider) --}}
        <div class="home-where-next-mobile md:hidden overflow-hidden">
            <div class="swiper home-where-next-swiper">
                <div class="swiper-wrapper">
                    @foreach($countries->chunk(4) as $chunk)
                        <div class="swiper-slide !h-auto">
                            <div class="grid grid-cols-2 gap-3">
                                @foreach($chunk as $country)
                                    <x-home-where-next-card :country="$country" />
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="flex items-center justify-end mt-8 gap-2">
                <button type="button" class="home-where-next-prev w-11 h-11 rounded-full border border-gray-200 bg-gray-100 text-gray-400 flex items-center justify-center transition-colors hover:bg-gray-200 disabled:opacity-40 disabled:pointer-events-none" aria-label="{{ __('Previous') }}">
                    <i class="fa-solid fa-arrow-left text-sm"></i>
                </button>
                <button type="button" class="home-where-next-next w-11 h-11 rounded-full bg-black text-white flex items-center justify-center transition-colors hover:bg-gray-900 disabled:opacity-40 disabled:pointer-events-none" aria-label="{{ __('Next') }}">
                    <i class="fa-solid fa-arrow-right text-sm"></i>
                </button>
            </div>
        </div>

        <div class="hidden md:grid md:grid-cols-3 lg:grid-cols-5 gap-3 sm:gap-4 md:gap-4">
            @foreach($countries as $country)
                <x-home-where-next-card :country="$country" />
            @endforeach
        </div>
    </div>
</section>
@endif
