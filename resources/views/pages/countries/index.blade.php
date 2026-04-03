@extends('layouts.site')

@section('title', 'All Countries - ' . config('app.name'))
@section('description', 'Explore countries and find travel packages.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Breadcrumb --}}
    <nav class="text-sm text-gray-500 mb-6" aria-label="Breadcrumb">
        <ol class="flex items-center gap-1.5">
            <li>
                <a href="{{ route('home') }}" class="text-lime-600 hover:text-lime-700 transition">Home</a>
            </li>
            <li class="flex items-center gap-1.5" aria-hidden="true">
                <span>&gt;</span>
            </li>
            <li class="text-gray-700" aria-current="page">All Countries</li>
        </ol>
    </nav>

    <h1 class="text-2xl font-bold text-gray-900 mb-6">All Countries</h1>

    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach($countries as $country)
            <a href="{{ route('countries.show', $country->slug) }}" class="group block rounded-xl overflow-hidden bg-gray-200 shadow-sm hover:shadow-md transition-shadow focus:outline-none focus:ring-2 focus:ring-lime-500 focus:ring-offset-2">
                <div class="aspect-[4/3] relative overflow-hidden">
                    @if($country->city_image_url)
                        <img src="{{ $country->city_image_url }}" alt="{{ $country->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="w-full h-full bg-gray-300 flex items-center justify-center">
                            <span class="text-gray-500 text-lg font-medium">{{ $country->name }}</span>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-4 text-white">
                        <h2 class="text-xl font-bold" style="color: #fff !important;">{{ $country->name }}</h2>
                        <p class="text-sm text-white/90 mt-1">
                            @if($country->tours_count > 0)
                                {{ $country->tours_count }} {{ $country->tours_count === 1 ? 'travel package' : 'travel packages' }}
                            @else
                                Travel packages coming soon
                            @endif
                        </p>
                    </div>
                </div>
            </a>
        @endforeach
    </div>

    @if($countries->isEmpty())
        <p class="text-gray-600">No countries yet. Add countries in the admin panel.</p>
    @endif
</div>
@endsection
