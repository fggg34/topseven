@extends('layouts.site')

@push('styles')
<style>
.tours-filter-bar > .relative {
    max-height: 42px;
}
</style>
@endpush

@section('title', __('Travel Packages') . ' - ' . config('app.name'))
@section('description', __('Browse our selection of travel packages and book your next adventure.'))

@section('content')
@php
    $toursFilterSelectedMonth = '';
    if (request()->filled('date')) {
        try {
            $toursFilterSelectedMonth = \Carbon\Carbon::parse(request('date'))->startOfMonth()->format('Y-m-d');
        } catch (\Throwable) {
            $toursFilterSelectedMonth = '';
        }
    }
    $toursFilterMonthOptions = [];
    $monthCursor = now()->startOfMonth();
    $toursFilterLocale = app()->getLocale();
    for ($i = 0; $i < 18; $i++) {
        $d = $monthCursor->copy()->addMonths($i)->locale($toursFilterLocale);
        $toursFilterMonthOptions[] = [
            'value' => $d->format('Y-m-01'),
            'label' => $d->translatedFormat('F Y'),
        ];
    }
    $toursPricePresets = [
        ['id' => '', 'min' => null, 'max' => null, 'label' => __('Any price')],
        ['id' => 'lte_500', 'min' => null, 'max' => 500.0, 'label' => __('Price: up to €500')],
        ['id' => '500_1000', 'min' => 500.0, 'max' => 1000.0, 'label' => __('Price: €500–€1,000')],
        ['id' => '1000_2000', 'min' => 1000.0, 'max' => 2000.0, 'label' => __('Price: €1,000–€2,000')],
        ['id' => 'gte_2000', 'min' => 2000.0, 'max' => null, 'label' => __('Price: over €2,000')],
    ];
    $toursFilterSelectedPricePreset = '';
    $fvMin = request()->filled('min_price') ? (float) request('min_price') : null;
    $fvMax = request()->filled('max_price') ? (float) request('max_price') : null;
    foreach ($toursPricePresets as $preset) {
        if ($preset['id'] === '') {
            continue;
        }
        $pm = $preset['min'];
        $px = $preset['max'];
        $ok = false;
        if ($pm === null && $px !== null) {
            $ok = ($fvMin === null || $fvMin <= 0) && $fvMax !== null && abs($fvMax - $px) < 0.01;
        } elseif ($pm !== null && $px === null) {
            $ok = $fvMin !== null && abs($fvMin - $pm) < 0.01 && $fvMax === null;
        } elseif ($pm !== null && $px !== null) {
            $ok = $fvMin !== null && abs($fvMin - $pm) < 0.01 && $fvMax !== null && abs($fvMax - $px) < 0.01;
        }
        if ($ok) {
            $toursFilterSelectedPricePreset = $preset['id'];
            break;
        }
    }
    $departureDateMin = now()->format('Y-m-d');
    $departureDateMax = now()->addMonths(18)->format('Y-m-d');
    $toursFilterSelectedDeparture = '';
    if (request()->filled('departure')) {
        try {
            $toursFilterSelectedDeparture = \Carbon\Carbon::parse(request('departure'))->format('Y-m-d');
        } catch (\Throwable) {
            $toursFilterSelectedDeparture = '';
        }
    }
    $toursFilterLabels = [
        'destination' => __('Destination'),
        'month' => __('Choose month'),
        'anyMonth' => __('Any month'),
        'chooseDepartureDate' => __('Choose departure date'),
        'anyDeparture' => __('Any departure'),
        'choosePrice' => __('Choose price'),
        'anyPrice' => __('Any price'),
        'sortOptions' => [
            ['value' => 'popular', 'label' => __('Most Popular')],
            ['value' => 'newest', 'label' => __('Newest')],
            ['value' => 'price_low', 'label' => __('Price: Low to High')],
            ['value' => 'price_high', 'label' => __('Price: High to Low')],
        ],
    ];
@endphp
<div class="w-full px-4 sm:px-6 lg:px-[80px]">
    <header class="pt-10 pb-8 md:pt-12 md:pb-10">
        <nav class="text-sm" aria-label="{{ __('Breadcrumb') }}">
            <ol class="flex flex-wrap items-center gap-1.5 text-[#6a6a6a]">
                <li><a href="{{ route('home') }}" class="hover:text-[#111827] transition-colors">{{ __('Home') }}</a></li>
                <li class="text-[#d1cdc4]" aria-hidden="true">/</li>
                <li class="text-[#111827] font-medium">{{ __('Travel Packages') }}</li>
            </ol>
        </nav>
        <div class="mt-6 md:mt-8 max-w-3xl">
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-serif font-semibold text-[#111827] tracking-tight leading-[1.1]">
                {{ __('Explore our travel packages') }}
            </h1>
            <p class="mt-4 text-base md:text-lg text-[#6a6a6a] leading-relaxed">
                {{ __('Handpicked experiences designed to immerse you in culture, nature, and unforgettable moments.') }}
            </p>
            <div class="mt-6 h-1 w-14 rounded-full bg-lime-600" aria-hidden="true"></div>
        </div>
    </header>

    <div class="pb-10 pt-2" x-data="tourFilters(@js($toursFilterLabels))" x-init="init()">

    <div class="tours-filter-bar flex flex-wrap items-center gap-3 pb-7 border-b border-[#e6e1d8]">

        @if($countries->isNotEmpty())
        <div class="relative">
            <button @click="openDestination = !openDestination" type="button"
                class="inline-flex items-center gap-2 px-5 py-3 border text-sm font-semibold uppercase tracking-wider transition-all"
                :class="selectedCountry ? 'bg-[#111827] border-[#111827] text-white' : 'bg-white border-[#d1cdc4] text-[#111827] hover:border-[#111827]'">
                <i class="fa-solid fa-location-dot text-xs"></i>
                <span x-text="selectedCountry ? (destinations.find(c => c.slug === selectedCountry)?.name || labels.destination) : labels.destination"></span>
                <i class="fa-solid fa-chevron-down text-[9px] ml-1"></i>
            </button>
            <div x-show="openDestination" @click.outside="openDestination = false" x-transition
                class="absolute left-0 top-full mt-2 z-50 bg-white shadow-xl border border-[#e6e1d8] py-2 min-w-[220px]">
                <button @click="selectedCountry = ''; openDestination = false; applyFilters()"
                    class="w-full text-left px-5 py-2.5 text-sm transition-colors"
                    :class="!selectedCountry ? 'bg-[#f8f6f2] text-[#111827] font-semibold' : 'hover:bg-[#f8f6f2] text-[#4a4a4a]'">
                    {{ __('All destinations') }}
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

        <div class="relative">
            <button @click="openMonth = !openMonth" type="button"
                class="inline-flex items-center gap-2 px-5 py-3 border text-sm font-semibold uppercase tracking-wider transition-all"
                :class="selectedMonth ? 'bg-[#111827] border-[#111827] text-white' : 'bg-white border-[#d1cdc4] text-[#111827] hover:border-[#111827]'">
                <i class="fa-regular fa-calendar text-xs"></i>
                <span x-text="monthButtonLabel()"></span>
                <i class="fa-solid fa-chevron-down text-[9px] ml-1"></i>
            </button>
            <div x-show="openMonth" @click.outside="openMonth = false" x-transition
                class="absolute left-0 top-full mt-2 z-50 bg-white shadow-xl border border-[#e6e1d8] py-2 min-w-[240px] max-h-72 overflow-y-auto">
                <button type="button" @click="selectMonth('')"
                    class="w-full text-left px-5 py-2.5 text-sm transition-colors"
                    :class="!selectedMonth ? 'bg-[#f8f6f2] text-[#111827] font-semibold' : 'hover:bg-[#f8f6f2] text-[#4a4a4a]'"
                    x-text="labels.anyMonth"></button>
                <template x-for="m in monthOptions" :key="m.value">
                    <button type="button" @click="selectMonth(m.value)"
                        class="w-full text-left px-5 py-2.5 text-sm transition-colors"
                        :class="selectedMonth === m.value ? 'bg-[#f8f6f2] text-[#111827] font-semibold' : 'hover:bg-[#f8f6f2] text-[#4a4a4a]'"
                        x-text="m.label"></button>
                </template>
            </div>
        </div>

        <div class="relative">
            <button @click="openPrice = !openPrice" type="button"
                class="inline-flex items-center gap-2 px-5 py-3 border text-sm font-semibold uppercase tracking-wider transition-all"
                :class="selectedPricePreset ? 'bg-[#111827] border-[#111827] text-white' : 'bg-white border-[#d1cdc4] text-[#111827] hover:border-[#111827]'">
                <i class="fa-solid fa-tag text-xs"></i>
                <span x-text="priceButtonLabel()"></span>
                <i class="fa-solid fa-chevron-down text-[9px] ml-1"></i>
            </button>
            <div x-show="openPrice" @click.outside="openPrice = false" x-transition
                class="absolute left-0 top-full mt-2 z-50 bg-white shadow-xl border border-[#e6e1d8] py-2 min-w-[240px] max-h-72 overflow-y-auto">
                <template x-for="p in pricePresets" :key="p.id || 'any'">
                    <button type="button" @click="selectPricePreset(p.id)"
                        class="w-full text-left px-5 py-2.5 text-sm transition-colors"
                        :class="(selectedPricePreset || '') === (p.id || '') ? 'bg-[#f8f6f2] text-[#111827] font-semibold' : 'hover:bg-[#f8f6f2] text-[#4a4a4a]'"
                        x-text="p.label"></button>
                </template>
            </div>
        </div>

        @if(request('country') || request('date') || request('departure') || request('adults') || request()->filled('min_price') || request()->filled('max_price'))
            <a href="{{ route('tours.index') }}" class="text-sm text-[#111827] hover:underline underline-offset-2 ml-2 font-semibold uppercase tracking-wider">{{ __('Clear') }}</a>
        @endif
    </div>

    <div class="flex items-center justify-between mt-8 mb-8">
        <p class="text-sm text-[#6a6a6a]">
            <span class="font-semibold text-[#111827]">{{ $tours->total() }}</span> {{ __('travel packages available') }}
        </p>

        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" type="button"
                class="inline-flex items-center gap-2 px-4 py-2.5 border border-[#d1cdc4] bg-white text-sm text-[#111827] hover:border-[#111827] transition-colors">
                <span>{{ __('Sort: ') }}<span class="font-semibold" x-text="sortLabel()">{{ __('Most Popular') }}</span></span>
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
            'departure' => request('departure'),
            'adults' => request('adults'),
            'category' => request('category'),
            'min_price' => request('min_price'),
            'max_price' => request('max_price'),
        ], fn ($v) => $v !== null && $v !== '');
    @endphp
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($tours as $tour)
            <x-tour-card variant="flash" :tour="$tour" :queryParams="$searchParams" :wishlisted="in_array($tour->id, $wishlistedIds ?? [])" />
        @empty
            <div class="col-span-full text-center py-20">
                <p class="text-lg text-[#6a6a6a] font-serif">{{ __('No travel packages found. Try adjusting your filters.') }}</p>
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
function tourFilters(labels) {
    labels = labels || {};
    return {
        labels: {
            destination: labels.destination || 'Destination',
            month: labels.month || 'Choose month',
            anyMonth: labels.anyMonth || 'Any month',
            chooseDepartureDate: labels.chooseDepartureDate || 'Choose departure date',
            anyDeparture: labels.anyDeparture || 'Any departure',
            choosePrice: labels.choosePrice || 'Choose price',
            anyPrice: labels.anyPrice || 'Any price',
        },
        locale: @json(str_replace('_', '-', app()->getLocale())),
        departureDateMin: @json($departureDateMin),
        departureDateMax: @json($departureDateMax),
        selectedDeparture: @json($toursFilterSelectedDeparture),
        pricePresets: @json($toursPricePresets),
        selectedPricePreset: @json($toursFilterSelectedPricePreset),
        selectedCountry: '{{ request('country', '') ?: request('city', '') }}',
        openDestination: false,
        openMonth: false,
        openDeparture: false,
        openPrice: false,
        selectedMonth: @json($toursFilterSelectedMonth),
        monthOptions: @json($toursFilterMonthOptions),
        destinations: @json($countries->map(fn($c) => ['slug' => $c->slug, 'name' => $c->name])->values()),
        currentSort: '{{ request('sort', 'popular') }}',
        sortOptions: labels.sortOptions || [
            { value: 'popular', label: 'Most Popular' },
            { value: 'newest', label: 'Newest' },
            { value: 'price_low', label: 'Price: Low to High' },
            { value: 'price_high', label: 'Price: High to Low' },
        ],

        init() {},

        monthButtonLabel() {
            if (!this.selectedMonth) return this.labels.month;
            const row = this.monthOptions.find((m) => m.value === this.selectedMonth);
            return row ? row.label : this.labels.month;
        },

        priceButtonLabel() {
            if (!this.selectedPricePreset) return this.labels.choosePrice;
            const row = this.pricePresets.find((p) => p.id === this.selectedPricePreset);
            return row ? row.label : this.labels.choosePrice;
        },

        selectPricePreset(id) {
            this.selectedPricePreset = id || '';
            this.openPrice = false;
            this.applyFilters();
        },

        selectMonth(value) {
            this.selectedMonth = value || '';
            this.openMonth = false;
            this.applyFilters();
        },

        departureButtonLabel() {
            if (!this.selectedDeparture) return this.labels.chooseDepartureDate;
            try {
                const d = new Date(this.selectedDeparture + 'T12:00:00');
                if (Number.isNaN(d.getTime())) return this.labels.chooseDepartureDate;
                return d.toLocaleDateString(this.locale, { day: 'numeric', month: 'long', year: 'numeric' });
            } catch (e) {
                return this.selectedDeparture;
            }
        },

        selectDeparture(value) {
            this.selectedDeparture = value || '';
            this.openDeparture = false;
            this.applyFilters();
        },

        sortLabel() {
            const found = this.sortOptions.find(o => o.value === this.currentSort);
            return found ? found.label : (this.sortOptions[0]?.label || '');
        },

        applyFilters() {
            const params = new URLSearchParams();
            if (this.selectedCountry) params.set('country', this.selectedCountry);
            if (this.selectedMonth) params.set('date', this.selectedMonth);
            if (this.selectedDeparture) params.set('departure', this.selectedDeparture);
            if (this.currentSort && this.currentSort !== 'popular') params.set('sort', this.currentSort);
            const q = '{{ request('q', '') }}';
            if (q) params.set('q', q);
            const adults = @json(request('adults', ''));
            if (adults !== '' && adults !== null) params.set('adults', String(adults));
            const preset = this.pricePresets.find((p) => p.id === this.selectedPricePreset);
            if (preset && preset.min != null) params.set('min_price', String(preset.min));
            if (preset && preset.max != null) params.set('max_price', String(preset.max));
            window.location.href = '{{ route('tours.index') }}' + '?' + params.toString();
        }
    }
}
</script>
@endpush
