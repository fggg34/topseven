@props(['banners'])

@php
    $banners = $banners ?? collect();
    $resolveUrl = fn ($u) => str_starts_with($u ?? '', 'http') ? $u : url($u ?: '/tours');
@endphp

@if($banners->isNotEmpty())
<section class="home-seasonal-banners-section mx-auto px-4 sm:px-6 lg:px-[80px] pt-8 pb-12 overflow-visible">
    <div class="relative">
        <button type="button" class="home-seasonal-next absolute right-2 md:right-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-white text-gray-700 border border-gray-100 shadow-[0_8px_18px_rgba(15,23,42,0.18)] flex items-center justify-center hover:bg-gray-100 transition-colors" aria-label="Next">
            <i class="fa-solid fa-arrow-right text-xs"></i>
        </button>

        <div class="swiper home-seasonal-banners-swiper overflow-visible">
            <div class="swiper-wrapper">
                @foreach($banners as $banner)
                    @php
                        $img = $banner->background_image_url ?? null;
                        $title = trim((string) ($banner->title ?? ''));
                        $buttonText = trim((string) ($banner->button_text ?? '')) ?: 'Learn More';
                        $buttonUrl = $resolveUrl($banner->button_url ?? '/tours');
                    @endphp
                    <div class="swiper-slide">
                        <div class="relative overflow-hidden rounded-md border border-gray-200 min-h-[320px] md:min-h-[400px] lg:min-h-[440px] bg-cover bg-center" style="background-image: url('{{ e($img ?: 'https://images.unsplash.com/photo-1469474968028-56623f02e42e?auto=format&fit=crop&w=1800&q=80') }}');">
                            <div class="absolute inset-0 bg-gradient-to-r from-black/55 via-black/30 to-transparent"></div>
                            <div class="absolute inset-0 z-10 flex items-center px-6 md:px-12">
                                <div class="max-w-[520px]">
                                    <h3 class="text-white text-[30px] md:text-[42px] font-semibold leading-[1.05] drop-shadow-[0_2px_8px_rgba(0,0,0,0.45)]">
                                        {!! nl2br(e($title)) !!}
                                    </h3>
                                    <a href="{{ $buttonUrl }}" class="inline-flex mt-6 items-center rounded-md bg-white text-gray-800 text-sm font-medium px-5 py-2.5 hover:bg-gray-100 transition-colors">
                                        {{ $buttonText }}
                                    </a>
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
