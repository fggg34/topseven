@props(['country'])

@php
    $imageUrl = $country->city_image_url ?? 'https://placehold.co/400x400/e5e7eb/6b7280?text=' . urlencode($country->name);
    $countryUrl = route('countries.show', $country->slug);
@endphp
<a href="{{ $countryUrl }}" class="flex-shrink-0 w-[185px] block group" data-slider-card>
    <div class="aspect-square rounded-lg overflow-hidden bg-gray-200 shadow-sm group-hover:shadow-md transition-shadow duration-300">
        <img src="{{ $imageUrl }}" alt="{{ $country->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
    </div>
    <h3 class="mt-2 text-center font-medium text-gray-900 group-hover:text-lime-600 transition-colors">{{ $country->name }}</h3>
</a>
