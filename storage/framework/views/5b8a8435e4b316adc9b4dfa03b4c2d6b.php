<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['action' => route('tours.index'), 'countries' => collect()]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['action' => route('tours.index'), 'countries' => collect()]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $initialCountry = request('country') ?: request('city');
    $initialDate = request('date');
    if ($initialDate && is_string($initialDate)) {
        try {
            $initialDate = \Carbon\Carbon::parse($initialDate)->startOfMonth()->format('Y-m-d');
        } catch (\Throwable) {
            $initialDate = '';
        }
    }
    $initialAdults = max(1, (int) request('adults', 2));
    $countriesData = $countries->map(fn ($c) => ['slug' => $c->slug, 'name' => $c->name, 'label' => $c->country ?? ''])->values()->toArray();
    $monthOptions = [];
    $monthCursor = now()->startOfMonth();
    $locale = app()->getLocale();
    for ($i = 0; $i < 18; $i++) {
        $d = $monthCursor->copy()->addMonths($i)->locale($locale);
        $monthOptions[] = [
            'value' => $d->format('Y-m-01'),
            'label' => $d->translatedFormat('F Y'),
        ];
    }
    $heroSearchUi = [
        'destination' => __('Destination'),
        'when' => __('When'),
        'anyDestination' => __('Any destination'),
        'anyMonth' => __('Any month'),
        'locale' => str_replace('_', '-', $locale),
    ];
?>

<div class="w-full max-w-[720px] mx-auto" x-data="heroSearchForm({
    action: <?php echo \Illuminate\Support\Js::from($action)->toHtml() ?>,
    countries: <?php echo \Illuminate\Support\Js::from($countriesData)->toHtml() ?>,
    monthOptions: <?php echo \Illuminate\Support\Js::from($monthOptions)->toHtml() ?>,
    initialCountry: <?php echo \Illuminate\Support\Js::from($initialCountry)->toHtml() ?>,
    initialDate: <?php echo \Illuminate\Support\Js::from($initialDate)->toHtml() ?>,
    ui: <?php echo \Illuminate\Support\Js::from($heroSearchUi)->toHtml() ?>,
})" x-init="init()">
    <form :action="action" method="GET" class="w-full" @submit="submitForm">
        <input type="hidden" name="country" :value="selectedCountry">
        <input type="hidden" name="date" :value="selectedDate">
        <input type="hidden" name="adults" value="<?php echo e($initialAdults); ?>">

        <div class="bg-white/95 backdrop-blur-sm rounded-full shadow-lg flex items-stretch min-h-14 md:min-h-16 lg:min-h-[4.25rem] pl-1.5 pr-1.5 relative">

            
            <div class="relative flex-1 min-w-0 flex items-center">
                <div class="flex items-center gap-2.5 lg:gap-3 px-4 lg:px-6 cursor-pointer w-full min-h-[3.5rem] md:min-h-16 lg:min-h-[4.25rem]" @click="countryOpen = !countryOpen; monthOpen = false">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span class="text-base lg:text-lg text-gray-600 truncate font-medium" x-text="selectedCountryName || ui.destination"></span>
                </div>
                <div x-show="countryOpen" x-cloak @click.outside="countryOpen = false"
                    x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
                    class="absolute left-0 right-0 top-full mt-2 z-50 bg-white rounded-xl shadow-xl border border-gray-200" style="display: none;">
                    <div class="max-h-64 overflow-y-auto py-1.5">
                        <button type="button" @click="selectCountry(null); countryOpen = false"
                            class="w-full flex items-center px-4 py-2.5 text-left text-sm hover:bg-gray-50 text-gray-700">
                            <?php echo e(__('Any destination')); ?>

                        </button>
                        <template x-for="c in countries" :key="c.slug">
                            <button type="button" @click="selectCountry(c.slug); countryOpen = false"
                                class="w-full flex items-center justify-between px-4 py-2.5 text-left text-sm hover:bg-gray-50"
                                :class="selectedCountry === c.slug ? 'bg-lime-50 text-lime-600' : 'text-gray-700'">
                                <span x-text="c.name"></span>
                            </button>
                        </template>
                    </div>
                </div>
            </div>

            
            <div class="w-px self-stretch my-2.5 lg:my-3 bg-gray-200 flex-shrink-0"></div>

            
            <div class="relative flex-1 min-w-0 flex items-center">
                <div class="flex items-center gap-2.5 lg:gap-3 px-4 lg:px-6 cursor-pointer w-full min-h-[3.5rem] md:min-h-16 lg:min-h-[4.25rem]" @click="monthOpen = !monthOpen; countryOpen = false">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    <span class="text-base lg:text-lg text-gray-600 truncate font-medium" x-text="selectedMonthLabel || ui.when"></span>
                </div>
                <div x-show="monthOpen" x-cloak @click.outside="monthOpen = false"
                    x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
                    class="absolute left-0 right-0 top-full mt-2 z-50 bg-white rounded-xl shadow-xl border border-gray-200" style="display: none;">
                    <div class="max-h-64 overflow-y-auto py-1.5">
                        <button type="button" @click="selectMonth(''); monthOpen = false"
                            class="w-full flex items-center px-4 py-2.5 text-left text-sm hover:bg-gray-50 text-gray-700">
                            <?php echo e(__('Any month')); ?>

                        </button>
                        <template x-for="m in monthOptions" :key="m.value">
                            <button type="button" @click="selectMonth(m.value); monthOpen = false"
                                class="w-full flex items-center px-4 py-2.5 text-left text-sm hover:bg-gray-50"
                                :class="selectedDate === m.value ? 'bg-lime-50 text-lime-600' : 'text-gray-700'">
                                <span x-text="m.label"></span>
                            </button>
                        </template>
                    </div>
                </div>
            </div>

            
            <button type="submit" class="flex-shrink-0 self-center w-12 h-12 lg:w-14 lg:h-14 rounded-full bg-gray-900 hover:bg-gray-800 text-white flex items-center justify-center transition-colors" aria-label="<?php echo e(__('Search')); ?>">
                <svg class="w-5 h-5 lg:w-6 lg:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </button>

        </div>
    </form>
</div>
<?php /**PATH /Users/kevinhitaj/Desktop/Projects/TOP 7 TRAVEL/resources/views/components/hero-search-form.blade.php ENDPATH**/ ?>