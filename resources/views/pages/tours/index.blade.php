@extends('layouts.site')

@push('styles')
<style>
.tours-filter-bar > .relative {
    max-height: 42px;
}
</style>
@endpush

@section('title', 'Travel Packages - ' . config('app.name'))
@section('description', 'Browse our selection of travel packages and book your next adventure.')

@section('content')
<div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
    <header class="pt-10 pb-8 md:pt-12 md:pb-10">
        <nav class="text-sm" aria-label="Breadcrumb">
            <ol class="flex flex-wrap items-center gap-1.5 text-[#6a6a6a]">
                <li><a href="{{ route('home') }}" class="hover:text-[#111827] transition-colors">Home</a></li>
                <li class="text-[#d1cdc4]" aria-hidden="true">/</li>
                <li class="text-[#111827] font-medium">Travel Packages</li>
            </ol>
        </nav>
        <div class="mt-6 md:mt-8 max-w-3xl">
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-serif font-semibold text-[#111827] tracking-tight leading-[1.1]">
                Explore our travel packages
            </h1>
            <p class="mt-4 text-base md:text-lg text-[#6a6a6a] leading-relaxed">
                Handpicked experiences designed to immerse you in culture, nature, and unforgettable moments.
            </p>
            <div class="mt-6 h-1 w-14 rounded-full bg-lime-600" aria-hidden="true"></div>
        </div>
    </header>

    <div class="pb-10 pt-2" x-data="tourFilters()" x-init="init()">

    <div class="tours-filter-bar flex flex-wrap items-center gap-3 pb-7 border-b border-[#e6e1d8]">

        @if($countries->isNotEmpty())
        <div class="relative">
            <button @click="openDestination = !openDestination" type="button"
                class="inline-flex items-center gap-2 px-5 py-3 border text-sm font-semibold uppercase tracking-wider transition-all"
                :class="selectedCountry ? 'bg-[#111827] border-[#111827] text-white' : 'bg-white border-[#d1cdc4] text-[#111827] hover:border-[#111827]'">
                <i class="fa-solid fa-location-dot text-xs"></i>
                <span x-text="selectedCountry ? (destinations.find(c => c.slug === selectedCountry)?.name || 'Destination') : 'Destination'"></span>
                <i class="fa-solid fa-chevron-down text-[9px] ml-1"></i>
            </button>
            <div x-show="openDestination" @click.outside="openDestination = false" x-transition
                class="absolute left-0 top-full mt-2 z-50 bg-white shadow-xl border border-[#e6e1d8] py-2 min-w-[220px]">
                <button @click="selectedCountry = ''; openDestination = false; applyFilters()"
                    class="w-full text-left px-5 py-2.5 text-sm transition-colors"
                    :class="!selectedCountry ? 'bg-[#f8f6f2] text-[#111827] font-semibold' : 'hover:bg-[#f8f6f2] text-[#4a4a4a]'">
                    All destinations
                </button>
                @foreach($countries as $c)
                    <button @click="selectedCountry = '{{ $c->slug }}'; openDestination = false; applyFilters()"
                        class="w-full text-left px-5 py-2.5 text-sm transition-colors"
                        :class="selectedCountry === '{{ $c->slug }}' ? 'bg-[#f8f6f2] text-[#111827] font-semibold' : 'hover:bg-[#f8f6f2] text-[#4a4a4a]'">
                        {{ $c->name }}
                    </button>
                @endforeach
            </div>
        </div>
        @endif

        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" type="button"
                class="inline-flex items-center gap-2 px-5 py-3 border text-sm font-semibold uppercase tracking-wider transition-all"
                :class="selectedDurations.length > 0 ? 'bg-[#111827] border-[#111827] text-white' : 'bg-white border-[#d1cdc4] text-[#111827] hover:border-[#111827]'">
                <span x-text="selectedDurations.length > 0 ? 'Duration (' + selectedDurations.length + ')' : 'Duration'"></span>
                <i class="fa-solid fa-chevron-down text-[9px] ml-1"></i>
            </button>
            <div x-show="open" @click.outside="open = false" x-transition
                class="absolute left-0 top-full mt-2 z-50 bg-white shadow-xl border border-[#e6e1d8] py-2 min-w-[200px]">
                @foreach($durationOptions as $opt)
                    <label class="flex items-center gap-3 px-4 py-2.5 hover:bg-[#f8f6f2] cursor-pointer transition-colors">
                        <input type="checkbox" value="{{ $opt['value'] }}"
                            class="h-4 w-4 border-gray-300 text-[#111827] focus:ring-[#111827]"
                            :checked="selectedDurations.includes('{{ $opt['value'] }}')"
                            @change="toggleDuration('{{ $opt['value'] }}')">
                        <span class="text-sm text-[#4a4a4a]">{{ $opt['label'] }}</span>
                    </label>
                @endforeach
                @if($durationOptions->isEmpty())
                    <p class="px-4 py-2.5 text-sm text-[#aaa]">No options available</p>
                @endif
            </div>
        </div>

        @if(request('country') || request()->has('duration'))
            <a href="{{ route('tours.index') }}" class="text-sm text-[#111827] hover:underline underline-offset-2 ml-2 font-semibold uppercase tracking-wider">Clear</a>
        @endif
    </div>

    <div class="flex items-center justify-between mt-8 mb-8">
        <p class="text-sm text-[#6a6a6a]">
            <span class="font-semibold text-[#111827]">{{ $tours->total() }}</span> travel packages available
        </p>

        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" type="button"
                class="inline-flex items-center gap-2 px-4 py-2.5 border border-[#d1cdc4] bg-white text-sm text-[#111827] hover:border-[#111827] transition-colors">
                <span>Sort: <span class="font-semibold" x-text="sortLabel()">Most Popular</span></span>
                <i class="fa-solid fa-chevron-down text-[9px] text-[#111827]/50"></i>
            </button>
            <div x-show="open" @click.outside="open = false" x-transition
                class="absolute right-0 top-full mt-1 z-50 bg-white shadow-xl border border-[#e6e1d8] py-1 min-w-[180px]">
                <template x-for="opt in sortOptions" :key="opt.value">
                    <button @click="currentSort = opt.value; open = false; applyFilters()"
                        class="w-full text-left px-5 py-2.5 text-sm hover:bg-[#f8f6f2] transition-colors"
                        :class="currentSort === opt.value ? 'text-[#111827] font-semibold' : 'text-[#4a4a4a]'"
                        x-text="opt.label"></button>
                </template>
            </div>
        </div>
    </div>

    @php
        $searchParams = array_filter([
            'country' => request('country') ?: request('city'),
            'date' => request('date'),
            'adults' => request('adults'),
            'category' => request('category'),
        ]);
    @endphp
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($tours as $tour)
            <x-tour-card variant="flash" :tour="$tour" :queryParams="$searchParams" :wishlisted="in_array($tour->id, $wishlistedIds ?? [])" />
        @empty
            <div class="col-span-full text-center py-20">
                <p class="text-lg text-[#6a6a6a] font-serif">No travel packages found. Try adjusting your filters.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-10">
        {{ $tours->links() }}
    </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function tourFilters() {
    return {
        selectedCountry: '{{ request('country', '') ?: request('city', '') }}',
        openDestination: false,
        destinations: @json($countries->map(fn($c) => ['slug' => $c->slug, 'name' => $c->name])->values()),
        selectedDurations: @json(array_map('strval', (array) request('duration', []))),
        currentSort: '{{ request('sort', 'popular') }}',
        sortOptions: [
            { value: 'popular', label: 'Most Popular' },
            { value: 'newest', label: 'Newest' },
            { value: 'price_low', label: 'Price: Low to High' },
            { value: 'price_high', label: 'Price: High to Low' },
        ],

        init() {},

        toggleDuration(val) {
            const idx = this.selectedDurations.indexOf(val);
            if (idx > -1) {
                this.selectedDurations.splice(idx, 1);
            } else {
                this.selectedDurations.push(val);
            }
            this.applyFilters();
        },

        sortLabel() {
            const found = this.sortOptions.find(o => o.value === this.currentSort);
            return found ? found.label : 'Most Popular';
        },

        applyFilters() {
            const params = new URLSearchParams();
            if (this.selectedCountry) params.set('country', this.selectedCountry);
            this.selectedDurations.forEach(d => params.append('duration[]', d));
            if (this.currentSort && this.currentSort !== 'popular') params.set('sort', this.currentSort);
            const q = '{{ request('q', '') }}';
            if (q) params.set('q', q);
            window.location.href = '{{ route('tours.index') }}' + '?' + params.toString();
        }
    }
}
</script>
@endpush
