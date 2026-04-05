@props(['posts'])

@php
    $posts = $posts ?? collect();
@endphp

@if($posts->isNotEmpty())
<section class="home-blog-stories-section w-full px-4 sm:px-6 lg:px-[80px] py-14">
    <p class="text-[15px] text-gray-700 mb-2">Get Inspired</p>
    <h2 class="text-[36px] md:text-[48px] font-serif font-semibold text-[#1f1f1f] leading-[1.05] mb-7">
        Travel stories to inspire you.
    </h2>

    {{-- Mobile: same Swiper behaviour + arrows as homepage flash-sale tour slider --}}
    <div class="home-blog-stories-mobile md:hidden overflow-hidden">
        <div class="swiper home-blog-stories-swiper">
            <div class="swiper-wrapper">
                @foreach($posts as $post)
                    <div class="swiper-slide !h-auto">
                        <x-home-blog-story-card :post="$post" />
                    </div>
                @endforeach
            </div>
        </div>
        <div class="flex items-center justify-end mt-8 gap-2">
            <button type="button" class="home-blog-stories-prev w-11 h-11 rounded-full border border-gray-200 bg-gray-100 text-gray-400 flex items-center justify-center transition-colors hover:bg-gray-200 disabled:opacity-40 disabled:pointer-events-none" aria-label="{{ __('Previous') }}">
                <i class="fa-solid fa-arrow-left text-sm"></i>
            </button>
            <button type="button" class="home-blog-stories-next w-11 h-11 rounded-full bg-black text-white flex items-center justify-center transition-colors hover:bg-gray-900 disabled:opacity-40 disabled:pointer-events-none" aria-label="{{ __('Next') }}">
                <i class="fa-solid fa-arrow-right text-sm"></i>
            </button>
        </div>
    </div>

    <div class="hidden md:grid grid-cols-2 xl:grid-cols-4 gap-6">
        @foreach($posts as $post)
            <x-home-blog-story-card :post="$post" />
        @endforeach
    </div>
</section>
@endif
