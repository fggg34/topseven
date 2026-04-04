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
        <h2 class="text-4xl sm:text-5xl md:text-[2.75rem] lg:text-6xl font-bold text-gray-900 text-left tracking-tight leading-[1.1] mb-8 md:mb-10">
            {{ $heading }}
        </h2>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 sm:gap-4 md:gap-4">
            @foreach($countries as $country)
                @php
                    $img = $country->city_image_url;
                    $galleryUrls = $country->gallery_urls;
                    if (! $img && is_array($galleryUrls) && ! empty($galleryUrls[0])) {
                        $img = $galleryUrls[0];
                    }
                    if (! $img) {
                        $img = 'https://placehold.co/600x600/e5e7eb/6b7280?text=' . urlencode($country->name);
                    }
                    $trips = (int) ($country->tours_count ?? 0);
                @endphp
                <a
                    href="{{ route('countries.show', $country->slug) }}"
                    class="group relative aspect-square w-full overflow-hidden rounded-2xl md:rounded-3xl bg-gray-200 ring-1 ring-black/5 shadow-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-900 focus-visible:ring-offset-2"
                >
                    <img
                        src="{{ $img }}"
                        alt="{{ $country->name }}"
                        class="absolute inset-0 h-full w-full object-cover transition-transform duration-500 ease-out group-hover:scale-105"
                        loading="lazy"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/35 to-black/20 pointer-events-none"></div>

                    <div class="absolute inset-0 z-10 flex flex-col items-center justify-center px-3 text-center">
                        <span class="text-base sm:text-lg font-medium text-white drop-shadow-md tracking-tight">
                            {{ $country->name }}
                        </span>
                        @if($trips > 0)
                            <span class="mt-2.5 inline-flex items-center rounded-full bg-white px-3 py-1 text-xs sm:text-sm font-semibold text-gray-900 tabular-nums shadow-sm">
                                {{ $trips }} {{ $trips === 1 ? 'travel package' : 'travel packages' }}
                            </span>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif
