@extends('layouts.site')

@push('styles')
<style>
.tours-filter-bar > .relative:not(.tours-filter-category) {
    max-height: 42px;
}
.tours-date-calendar-wrap .flatpickr-calendar {
    position: relative !important;
    top: auto !important;
    left: auto !important;
}
</style>
@endpush

@section('title', 'Tours - ' . config('app.name'))
@section('description', 'Browse our selection of tours and book your next adventure.')

@section('content')
<div class="relative w-full overflow-hidden bg-[#111827]" style="height: 380px;">
    <div class="absolute inset-0 bg-cover bg-center opacity-40" style="background-image: url('https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?w=1920&h=600&fit=crop');"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-[#111827]/80 via-transparent to-[#111827]/40"></div>
    <div class="absolute inset-0 flex items-end">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 w-full pb-12">
            <nav class="text-sm mb-4" aria-label="Breadcrumb">
                <ol class="flex items-center gap-1.5">
                    <li><a href="{{ route('home') }}" class="text-white/60 hover:text-white transition">Home</a></li>
                    <li class="text-white/40">/</li>
                    <li class="text-white">Tours</li>
                </ol>
            </nav>
            <h1 class="text-4xl md:text-6xl font-serif text-white tracking-tight">Explore Our Tours</h1>
            <p class="mt-3 text-lg text-white/70 max-w-xl">Handpicked experiences designed to immerse you in culture, nature, and unforgettable moments.</p>
        </div>
    </div>
</div>

<div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-10" x-data="tourFilters()" x-init="init()">

    <div class="tours-filter-bar flex flex-wrap items-center gap-3 pb-7 border-b border-[#e6e1d8]">

        @if($categories->isNotEmpty())
        <div class="relative tours-filter-category">
            <button @click="openCategory = !openCategory" type="button"
                class="inline-flex items-center gap-2 px-5 py-3 border text-sm font-semibold uppercase tracking-wider transition-all"
                :class="selectedCategory ? 'bg-[#111827] border-[#111827] text-white' : 'bg-white border-[#d1cdc4] text-[#111827] hover:border-[#111827]'">
                <i class="fa-solid fa-route text-xs"></i>
                <span x-text="selectedCategory ? (categories.find(c => c.slug === selectedCategory)?.name || 'Category') : 'Tour Type'"></span>
                <i class="fa-solid fa-chevron-down text-[9px] ml-1"></i>
            </button>
            <div x-show="openCategory" @click.outside="openCategory = false" x-transition
                class="absolute left-0 top-full mt-2 z-50 bg-white shadow-xl border border-[#e6e1d8] py-2 min-w-[220px]">
                <button @click="selectCategory(''); openCategory = false"
                    class="w-full text-left px-5 py-2.5 text-sm transition-colors"
                    :class="!selectedCategory ? 'bg-[#f8f6f2] text-[#111827] font-semibold' : 'hover:bg-[#f8f6f2] text-[#4a4a4a]'">
                    All categories
                </button>
                @foreach($categories as $cat)
                    <button @click="selectCategory('{{ $cat->slug }}'); openCategory = false"
                        class="w-full text-left px-5 py-2.5 text-sm transition-colors"
                        :class="selectedCategory === '{{ $cat->slug }}' ? 'bg-[#f8f6f2] text-[#111827] font-semibold' : 'hover:bg-[#f8f6f2] text-[#4a4a4a]'">
                        {{ $cat->name }}
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

        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" type="button"
                class="inline-flex items-center gap-2 px-5 py-3 border text-sm font-semibold uppercase tracking-wider transition-all"
                :class="selectedSeasons.length > 0 ? 'bg-[#111827] border-[#111827] text-white' : 'bg-white border-[#d1cdc4] text-[#111827] hover:border-[#111827]'">
                <span x-text="selectedSeasons.length > 0 ? 'Season (' + selectedSeasons.length + ')' : 'Season'"></span>
                <i class="fa-solid fa-chevron-down text-[9px] ml-1"></i>
            </button>
            <div x-show="open" @click.outside="open = false" x-transition
                class="absolute left-0 top-full mt-2 z-50 bg-white shadow-xl border border-[#e6e1d8] py-2 min-w-[200px]">
                @foreach($seasonOptions as $opt)
                    <label class="flex items-center gap-3 px-4 py-2.5 hover:bg-[#f8f6f2] cursor-pointer transition-colors">
                        <input type="checkbox" value="{{ $opt['value'] }}"
                            class="h-4 w-4 border-gray-300 text-[#111827] focus:ring-[#111827]"
                            :checked="selectedSeasons.includes('{{ $opt['value'] }}')"
                            @change="toggleSeason('{{ $opt['value'] }}')">
                        <span class="text-sm text-[#4a4a4a]">{{ $opt['label'] }}</span>
                    </label>
                @endforeach
                @if($seasonOptions->isEmpty())
                    <p class="px-4 py-2.5 text-sm text-[#aaa]">No options available</p>
                @endif
            </div>
        </div>

        <label class="inline-flex items-center gap-2 cursor-pointer select-none ml-1">
            <span class="text-sm font-semibold text-[#111827] uppercase tracking-wider">On Sale</span>
            <button type="button" @click="onSale = !onSale; applyFilters()"
                class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none"
                :class="onSale ? 'bg-[#111827]' : 'bg-gray-200'"
                role="switch" :aria-checked="onSale">
                <span class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                    :class="onSale ? 'translate-x-5' : 'translate-x-0'"></span>
            </button>
        </label>

        @if(request('date') || request()->has('duration') || request()->has('season') || request('category') || request()->boolean('on_sale'))
            <a href="{{ route('tours.index') }}" class="text-sm text-[#111827] hover:underline underline-offset-2 ml-2 font-semibold uppercase tracking-wider">Clear</a>
        @endif
    </div>

    <div class="flex items-center justify-between mt-8 mb-8">
        <p class="text-sm text-[#6a6a6a]">
            <span class="font-semibold text-[#111827]">{{ $tours->total() }}</span> Tours available
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
            <x-tour-card :tour="$tour" :queryParams="$searchParams" :wishlisted="in_array($tour->id, $wishlistedIds ?? [])" />
        @empty
            <div class="col-span-full text-center py-20">
                <p class="text-lg text-[#6a6a6a] font-serif">No tours found. Try adjusting your filters.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-10">
        {{ $tours->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
function tourFilters() {
    return {
        selectedDate: '{{ request('date', '') }}',
        selectedCategory: '{{ request('category', '') }}',
        openCategory: false,
        categories: @json($categories->map(fn($c) => ['slug' => $c->slug, 'name' => $c->name])->values()),
        selectedDurations: @json(array_map('strval', (array) request('duration', []))),
        selectedSeasons: @json(array_map('strval', (array) request('season', []))),
        onSale: {{ request()->boolean('on_sale') ? 'true' : 'false' }},
        currentSort: '{{ request('sort', 'popular') }}',
        sortOptions: [
            { value: 'popular', label: 'Most Popular' },
            { value: 'newest', label: 'Newest' },
            { value: 'price_low', label: 'Price: Low to High' },
            { value: 'price_high', label: 'Price: High to Low' },
        ],

        fp: null,

        init() {
            if (typeof flatpickr !== 'undefined' && this.$refs.filterDateInput && this.$refs.calendarContainer) {
                this.fp = flatpickr(this.$refs.filterDateInput, {
                    dateFormat: 'Y-m-d',
                    defaultDate: this.selectedDate || null,
                    minDate: 'today',
                    appendTo: this.$refs.calendarContainer,
                    static: true,
                    onChange: (selectedDates, dateStr) => {
                        this.selectedDate = dateStr;
                        this.applyFilters();
                    }
                });
            }
        },

        openDatePicker() {
            if (this.fp) this.fp.open();
        },

        toggleDuration(val) {
            const idx = this.selectedDurations.indexOf(val);
            if (idx > -1) {
                this.selectedDurations.splice(idx, 1);
            } else {
                this.selectedDurations.push(val);
            }
            this.applyFilters();
        },

        toggleSeason(val) {
            const idx = this.selectedSeasons.indexOf(val);
            if (idx > -1) {
                this.selectedSeasons.splice(idx, 1);
            } else {
                this.selectedSeasons.push(val);
            }
            this.applyFilters();
        },

        selectCategory(slug) {
            this.selectedCategory = slug;
            this.applyFilters();
        },

        sortLabel() {
            const found = this.sortOptions.find(o => o.value === this.currentSort);
            return found ? found.label : 'Most Popular';
        },

        applyFilters() {
            const params = new URLSearchParams();
            if (this.selectedDate) params.set('date', this.selectedDate);
            if (this.selectedCategory) params.set('category', this.selectedCategory);
            this.selectedDurations.forEach(d => params.append('duration[]', d));
            this.selectedSeasons.forEach(s => params.append('season[]', s));
            if (this.onSale) params.set('on_sale', '1');
            if (this.currentSort && this.currentSort !== 'popular') params.set('sort', this.currentSort);
            const q = '{{ request('q', '') }}';
            if (q) params.set('q', q);
            const country = '{{ request('country', '') ?: request('city', '') }}';
            if (country) params.set('country', country);
            window.location.href = '{{ route('tours.index') }}' + '?' + params.toString();
        }
    }
}
</script>
@endpush
