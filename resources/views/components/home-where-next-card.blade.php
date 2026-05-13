@props(['country'])

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
            <span class="mt-2.5 inline-flex items-center rounded-full bg-white px-3 py-1 text-xs sm:text-sm font-semibold text-brand-ink tabular-nums shadow-sm">
                {{ $trips }} {{ $trips === 1 ? 'paket turistike' : 'paketa turistike' }}
            </span>
        @endif
    </div>
</a>
