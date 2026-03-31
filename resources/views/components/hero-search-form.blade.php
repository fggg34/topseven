@props(['action' => route('tours.index'), 'countries' => collect()])

@php
    $initialCountry = request('country') ?: request('city');
    $initialDate = request('date');
    $initialAdults = max(1, (int) request('adults', 2));
    $countriesData = $countries->map(fn ($c) => ['slug' => $c->slug, 'name' => $c->name, 'label' => $c->country ?? ''])->values()->toArray();
@endphp

<div class="w-full max-w-4xl mx-auto" x-data="heroSearchForm({
    action: @js($action),
    countries: @js($countriesData),
    initialCountry: @js($initialCountry),
    initialDate: @js($initialDate),
    initialAdults: {{ $initialAdults }},
})" x-init="init()">
    <form :action="action" method="GET" class="w-full" @submit="submitForm">
        <input type="hidden" name="country" :value="selectedCountry">
        <input type="hidden" name="date" :value="selectedDate">
        <input type="hidden" name="adults" :value="adults">

        <div class="bg-white rounded-lg shadow-lg border border-gray-100 flex flex-col md:flex-row md:items-stretch md:h-[79px]">

            {{-- Where to? --}}
            <div class="flex-1 min-w-0 relative flex items-center min-h-[75px] max-h-[75px]">
                <div class="px-5 py-2 flex flex-col justify-center min-w-0 cursor-pointer w-full h-full" @click="countryOpen = !countryOpen; dateOpen = false; adultsOpen = false">
                    <div class="text-xs font-semibold text-gray-900 mb-0.5">Where to?</div>
                    <div class="text-sm text-gray-400" x-text="selectedCountryName || 'Country, keywords, or tour code'"></div>
                </div>
                <div x-show="countryOpen" x-cloak @click.outside="countryOpen = false"
                    x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
                    class="absolute left-0 right-0 top-full mt-1 z-50 bg-white rounded-lg shadow-xl border border-gray-200" style="display: none;">
                    <div class="max-h-64 overflow-y-auto py-1.5">
                        <button type="button" @click="selectCountry(null); countryOpen = false"
                            class="w-full flex items-center px-4 py-2.5 text-left text-sm hover:bg-gray-50 text-gray-700">
                            Any destination
                        </button>
                        <template x-for="c in countries" :key="c.slug">
                            <button type="button" @click="selectCountry(c.slug); countryOpen = false"
                                class="w-full flex items-center justify-between px-4 py-2.5 text-left text-sm hover:bg-gray-50"
                                :class="selectedCountry === c.slug ? 'bg-lime-50 text-lime-600' : 'text-gray-700'">
                                <span x-text="c.name"></span>
                                <span class="text-gray-400 text-xs ml-2" x-text="c.label"></span>
                            </button>
                        </template>
                    </div>
                </div>
            </div>

            {{-- Divider --}}
            <div class="hidden md:block w-px bg-gray-200 self-stretch my-2"></div>
            <div class="md:hidden border-t border-gray-100"></div>

            {{-- When --}}
            <div class="flex-1 min-w-0 relative flex items-center min-h-[75px] max-h-[75px]" style="display: block;">
                <div class="px-5 py-2 flex flex-col justify-center min-w-0 cursor-pointer w-full h-full" @click="(dateOpen && fp) ? fp.close() : (fp && fp.open()); countryOpen = false; adultsOpen = false">
                    <div class="text-xs font-semibold text-gray-900 mb-0.5">When</div>
                    <div class="text-sm text-gray-400" x-text="selectedDate ? formatDate(selectedDate) : 'Any day'"></div>
                </div>
                <input type="text" x-ref="dateInput" placeholder="Any day" readonly class="sr-only" aria-label="Select date">
                <div x-show="dateOpen" x-cloak x-ref="dateContainer" class="absolute left-0 top-full mt-1 z-50 min-w-[280px]" style="display: none;"></div>
            </div>

            {{-- Divider --}}
            <div class="hidden md:block w-px bg-gray-200 self-stretch my-2"></div>
            <div class="md:hidden border-t border-gray-100"></div>

            {{-- Guests / Adults --}}
            <div class="flex-1 min-w-0 relative flex items-center min-h-[75px] max-h-[75px]" style="display: block;">
                <div class="px-5 py-2 flex flex-col justify-center min-w-0 cursor-pointer w-full h-full" @click="adultsOpen = !adultsOpen; countryOpen = false; dateOpen = false">
                    <div class="text-xs font-semibold text-gray-900 mb-0.5">Guests</div>
                    <div class="text-sm text-gray-400" x-text="adults + ' Adult' + (adults !== 1 ? 's' : '')"></div>
                </div>
                {{-- Adults popup --}}
                <div x-show="adultsOpen" x-cloak
                    x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
                    class="fixed inset-0 z-50 flex items-center justify-center p-4 md:block md:relative md:inset-auto md:p-0"
                    @click.self="adultsOpen = false" style="display: none;">
                    <div class="absolute inset-0 bg-black/50 md:hidden" @click="adultsOpen = false"></div>
                    <div class="relative bg-white rounded-lg shadow-xl border border-gray-200 max-w-sm w-full p-5 md:absolute md:left-0 md:right-auto md:top-full md:mt-1 md:min-w-[240px]"
                        x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-base font-bold text-gray-900">Adults</h3>
                            <button type="button" @click="adultsOpen = false" class="rounded-full p-1.5 text-gray-400 hover:bg-gray-100 md:hidden">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                        <div class="flex items-center gap-3 rounded-md border border-gray-200 p-2.5">
                            <button type="button" @click="if(adults > 1) adults--"
                                class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-full border border-gray-300 bg-white text-gray-600 hover:bg-gray-50 font-medium text-lg transition">−</button>
                            <span class="flex-1 text-center text-lg font-semibold text-gray-900" x-text="adults"></span>
                            <button type="button" @click="if(adults < 99) adults++"
                                class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-full border border-gray-300 bg-white text-gray-600 hover:bg-gray-50 font-medium text-lg transition">+</button>
                        </div>
                        <button type="button" @click="adultsOpen = false"
                            class="mt-3 w-full py-2 bg-brand-btn text-white text-sm font-medium rounded-md hover:bg-brand-btn-hover md:hidden transition-colors">
                            Done
                        </button>
                    </div>
                </div>
            </div>

            {{-- Show Tours button --}}
            <div class="flex items-center p-2 pr-5 min-h-[75px] max-h-[75px]">
                <button type="submit" class="w-full md:w-auto md:min-w-[140px] px-6 py-3 bg-brand-btn hover:bg-brand-btn-hover text-white font-semibold rounded-md transition-colors flex items-center justify-center gap-2 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Show Tours
                </button>
            </div>

        </div>
    </form>
</div>
