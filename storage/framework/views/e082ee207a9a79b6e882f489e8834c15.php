<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['rows']));

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

foreach (array_filter((['rows']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $rows = $rows ?? collect();
?>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($rows->isNotEmpty()): ?>
<?php
    $headline = \App\Models\Setting::get('homepage_flash_sale_headline', 'Hand-picked tours for your next trip.');
    $highlight = \App\Models\Setting::get('homepage_flash_sale_highlight', '');
    $ctaLabel = \App\Models\Setting::get('homepage_flash_sale_cta_label', 'View All');
    $ctaUrlRaw = \App\Models\Setting::get('homepage_flash_sale_cta_url', '/tours');
    $ctaUrl = str_starts_with($ctaUrlRaw ?? '', 'http') ? $ctaUrlRaw : url($ctaUrlRaw ?: '/tours');
?>

<section class="home-flash-sale-section max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-10 pt-14 pb-14">
    <div class="mb-6 md:mb-8">
        <h2 class="text-3xl sm:text-4xl md:text-[2.125rem] lg:text-[2.5rem] font-semibold text-gray-700 tracking-tight leading-tight">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($highlight !== '' && $highlight !== null && str_contains($headline, (string) $highlight)): ?>
                <?php
                    $pos = strpos($headline, (string) $highlight);
                    $before = substr($headline, 0, $pos);
                    $after = substr($headline, $pos + strlen((string) $highlight));
                ?>
                <?php echo e($before); ?><span class="home-flash-sale-highlight inline-block px-1.5 py-0.5 rounded bg-gray-200/90 text-gray-800 font-semibold"><?php echo e($highlight); ?></span><?php echo e($after); ?>

            <?php else: ?>
                <?php echo e($headline); ?>

            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </h2>
    </div>

    <div class="swiper home-flash-sale-swiper overflow-visible">
        <div class="swiper-wrapper">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $spotlight): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <?php
                    $tour = $spotlight->tour;
                ?>
                <?php if(!$tour) continue; ?>
                <?php
                    $img = $tour->images->first();
                    $imageUrl = $img?->url ?? 'https://placehold.co/600x800/e5e7eb/6b7280?text=Tour';
                    $tourUrl = route('tours.show', $tour->slug);
                    $sale = (float) ($tour->price ?? 0);
                    $base = (float) ($tour->base_price ?? 0);
                    $hasCompare = $base > $sale && $sale >= 0 && $base > 0;
                    $currency = ($tour->currency === 'EUR' || !$tour->currency) ? '€' : ($tour->currency === 'USD' ? '$' : $tour->currency . ' ');
                    $decimals = ($sale != floor($sale)) ? 2 : 0;
                    $baseDecimals = ($base != floor($base)) ? 2 : 0;
                ?>
                <div class="swiper-slide !h-auto">
                    <a href="<?php echo e($tourUrl); ?>" class="home-flash-sale-card group relative block aspect-[3/4] min-h-[420px] sm:min-h-[480px] max-h-[560px] rounded-[28px] overflow-hidden shadow-md ring-1 ring-black/10">
                        <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 ease-out group-hover:scale-[1.04]" style="background-image: url('<?php echo e(e($imageUrl)); ?>');"></div>
                        
                        <div class="absolute inset-0 bg-gradient-to-t from-black/[0.88] via-black/35 to-transparent pointer-events-none"></div>

                        <div class="absolute inset-x-0 bottom-0 z-10 p-5 sm:p-6 pt-24 flex flex-col justify-end text-left">
                            <h3 class="text-xl sm:text-2xl font-bold text-white leading-[1.2] tracking-tight line-clamp-4 drop-shadow-sm font-sans">
                                <?php echo e($tour->title); ?>

                            </h3>
                            <div class="mt-4 flex flex-wrap items-baseline gap-x-2 gap-y-1">
                                <span class="text-[15px] sm:text-base font-bold text-white tabular-nums tracking-tight">
                                    From <?php echo e($currency); ?><?php echo e(number_format($sale, $decimals)); ?>

                                </span>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasCompare): ?>
                                    <span class="text-sm sm:text-[15px] font-normal text-white/75 line-through tabular-nums">
                                        <?php echo e($currency); ?><?php echo e(number_format($base, $baseDecimals)); ?>

                                    </span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    </a>
                </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
    </div>

    <div class="flex items-center justify-between mt-8 gap-4">
        <a href="<?php echo e($ctaUrl); ?>" class="inline-flex items-center rounded-full bg-black text-white text-sm font-semibold px-6 py-2.5 hover:bg-gray-900 transition-colors">
            <?php echo e($ctaLabel); ?>

        </a>
        <div class="flex items-center gap-2">
            <button type="button" class="home-flash-sale-prev w-11 h-11 rounded-full border border-gray-200 bg-gray-100 text-gray-400 flex items-center justify-center transition-colors hover:bg-gray-200 disabled:opacity-40 disabled:pointer-events-none" aria-label="Previous">
                <i class="fa-solid fa-arrow-left text-sm"></i>
            </button>
            <button type="button" class="home-flash-sale-next w-11 h-11 rounded-full bg-black text-white flex items-center justify-center transition-colors hover:bg-gray-900 disabled:opacity-40 disabled:pointer-events-none" aria-label="Next">
                <i class="fa-solid fa-arrow-right text-sm"></i>
            </button>
        </div>
    </div>
</section>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php /**PATH /Users/kevinhitaj/Desktop/Projects/TOP 7 TRAVEL/resources/views/components/home-flash-sale-slider.blade.php ENDPATH**/ ?>