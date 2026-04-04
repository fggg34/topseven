<?php $__env->startPush('styles'); ?>
<style>
.tours-filter-bar > .relative {
    max-height: 42px;
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('title', __('Travel Packages') . ' - ' . config('app.name')); ?>
<?php $__env->startSection('description', __('Browse our selection of travel packages and book your next adventure.')); ?>

<?php $__env->startSection('content'); ?>
<?php
    $toursFilterLabels = [
        'destination' => __('Destination'),
        'duration' => __('Duration'),
        'sortOptions' => [
            ['value' => 'popular', 'label' => __('Most Popular')],
            ['value' => 'newest', 'label' => __('Newest')],
            ['value' => 'price_low', 'label' => __('Price: Low to High')],
            ['value' => 'price_high', 'label' => __('Price: High to Low')],
        ],
    ];
?>
<div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
    <header class="pt-10 pb-8 md:pt-12 md:pb-10">
        <nav class="text-sm" aria-label="<?php echo e(__('Breadcrumb')); ?>">
            <ol class="flex flex-wrap items-center gap-1.5 text-[#6a6a6a]">
                <li><a href="<?php echo e(route('home')); ?>" class="hover:text-[#111827] transition-colors"><?php echo e(__('Home')); ?></a></li>
                <li class="text-[#d1cdc4]" aria-hidden="true">/</li>
                <li class="text-[#111827] font-medium"><?php echo e(__('Travel Packages')); ?></li>
            </ol>
        </nav>
        <div class="mt-6 md:mt-8 max-w-3xl">
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-serif font-semibold text-[#111827] tracking-tight leading-[1.1]">
                <?php echo e(__('Explore our travel packages')); ?>

            </h1>
            <p class="mt-4 text-base md:text-lg text-[#6a6a6a] leading-relaxed">
                <?php echo e(__('Handpicked experiences designed to immerse you in culture, nature, and unforgettable moments.')); ?>

            </p>
            <div class="mt-6 h-1 w-14 rounded-full bg-lime-600" aria-hidden="true"></div>
        </div>
    </header>

    <div class="pb-10 pt-2" x-data="tourFilters(<?php echo \Illuminate\Support\Js::from($toursFilterLabels)->toHtml() ?>)" x-init="init()">

    <div class="tours-filter-bar flex flex-wrap items-center gap-3 pb-7 border-b border-[#e6e1d8]">

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($countries->isNotEmpty()): ?>
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
                    <?php echo e(__('All destinations')); ?>

                </button>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                    <button @click="selectedCountry = '<?php echo e($c->slug); ?>'; openDestination = false; applyFilters()"
                        class="w-full text-left px-5 py-2.5 text-sm transition-colors"
                        :class="selectedCountry === '<?php echo e($c->slug); ?>' ? 'bg-[#f8f6f2] text-[#111827] font-semibold' : 'hover:bg-[#f8f6f2] text-[#4a4a4a]'">
                        <?php echo e($c->name); ?>

                    </button>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" type="button"
                class="inline-flex items-center gap-2 px-5 py-3 border text-sm font-semibold uppercase tracking-wider transition-all"
                :class="selectedDurations.length > 0 ? 'bg-[#111827] border-[#111827] text-white' : 'bg-white border-[#d1cdc4] text-[#111827] hover:border-[#111827]'">
                <span x-text="selectedDurations.length > 0 ? (labels.duration + ' (' + selectedDurations.length + ')') : labels.duration"></span>
                <i class="fa-solid fa-chevron-down text-[9px] ml-1"></i>
            </button>
            <div x-show="open" @click.outside="open = false" x-transition
                class="absolute left-0 top-full mt-2 z-50 bg-white shadow-xl border border-[#e6e1d8] py-2 min-w-[200px]">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $durationOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                    <label class="flex items-center gap-3 px-4 py-2.5 hover:bg-[#f8f6f2] cursor-pointer transition-colors">
                        <input type="checkbox" value="<?php echo e($opt['value']); ?>"
                            class="h-4 w-4 border-gray-300 text-[#111827] focus:ring-[#111827]"
                            :checked="selectedDurations.includes('<?php echo e($opt['value']); ?>')"
                            @change="toggleDuration('<?php echo e($opt['value']); ?>')">
                        <span class="text-sm text-[#4a4a4a]"><?php echo e($opt['label']); ?></span>
                    </label>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($durationOptions->isEmpty()): ?>
                    <p class="px-4 py-2.5 text-sm text-[#aaa]"><?php echo e(__('No options available')); ?></p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(request('country') || request()->has('duration')): ?>
            <a href="<?php echo e(route('tours.index')); ?>" class="text-sm text-[#111827] hover:underline underline-offset-2 ml-2 font-semibold uppercase tracking-wider"><?php echo e(__('Clear')); ?></a>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <div class="flex items-center justify-between mt-8 mb-8">
        <p class="text-sm text-[#6a6a6a]">
            <span class="font-semibold text-[#111827]"><?php echo e($tours->total()); ?></span> <?php echo e(__('travel packages available')); ?>

        </p>

        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" type="button"
                class="inline-flex items-center gap-2 px-4 py-2.5 border border-[#d1cdc4] bg-white text-sm text-[#111827] hover:border-[#111827] transition-colors">
                <span><?php echo e(__('Sort: ')); ?><span class="font-semibold" x-text="sortLabel()"><?php echo e(__('Most Popular')); ?></span></span>
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

    <?php
        $searchParams = array_filter([
            'country' => request('country') ?: request('city'),
            'date' => request('date'),
            'adults' => request('adults'),
            'category' => request('category'),
        ]);
    ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $tours; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tour): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal82db288ae19d37c54da8bf5b2a908f6d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal82db288ae19d37c54da8bf5b2a908f6d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tour-card','data' => ['variant' => 'flash','tour' => $tour,'queryParams' => $searchParams,'wishlisted' => in_array($tour->id, $wishlistedIds ?? [])]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tour-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'flash','tour' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tour),'queryParams' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($searchParams),'wishlisted' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(in_array($tour->id, $wishlistedIds ?? []))]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal82db288ae19d37c54da8bf5b2a908f6d)): ?>
<?php $attributes = $__attributesOriginal82db288ae19d37c54da8bf5b2a908f6d; ?>
<?php unset($__attributesOriginal82db288ae19d37c54da8bf5b2a908f6d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal82db288ae19d37c54da8bf5b2a908f6d)): ?>
<?php $component = $__componentOriginal82db288ae19d37c54da8bf5b2a908f6d; ?>
<?php unset($__componentOriginal82db288ae19d37c54da8bf5b2a908f6d); ?>
<?php endif; ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <div class="col-span-full text-center py-20">
                <p class="text-lg text-[#6a6a6a] font-serif"><?php echo e(__('No travel packages found. Try adjusting your filters.')); ?></p>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <div class="mt-10">
        <?php echo e($tours->links()); ?>

    </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function tourFilters(labels) {
    labels = labels || {};
    return {
        labels: {
            destination: labels.destination || 'Destination',
            duration: labels.duration || 'Duration',
        },
        selectedCountry: '<?php echo e(request('country', '') ?: request('city', '')); ?>',
        openDestination: false,
        destinations: <?php echo json_encode($countries->map(fn($c) => ['slug' => $c->slug, 'name' => $c->name])->values(), 512) ?>,
        selectedDurations: <?php echo json_encode(array_map('strval', (array) request('duration', []))) ?>,
        currentSort: '<?php echo e(request('sort', 'popular')); ?>',
        sortOptions: labels.sortOptions || [
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
            return found ? found.label : (this.sortOptions[0]?.label || '');
        },

        applyFilters() {
            const params = new URLSearchParams();
            if (this.selectedCountry) params.set('country', this.selectedCountry);
            this.selectedDurations.forEach(d => params.append('duration[]', d));
            if (this.currentSort && this.currentSort !== 'popular') params.set('sort', this.currentSort);
            const q = '<?php echo e(request('q', '')); ?>';
            if (q) params.set('q', q);
            window.location.href = '<?php echo e(route('tours.index')); ?>' + '?' + params.toString();
        }
    }
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.site', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/kevinhitaj/Desktop/Projects/TOP 7 TRAVEL/resources/views/pages/tours/index.blade.php ENDPATH**/ ?>