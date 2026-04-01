<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['tour', 'queryParams' => [], 'wishlisted' => false, 'slider' => false]));

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

foreach (array_filter((['tour', 'queryParams' => [], 'wishlisted' => false, 'slider' => false]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $firstImg = $tour->images->first();
    $imageUrl = $firstImg?->url ?? 'https://placehold.co/600x400/e5e7eb/6b7280?text=Tour';
    $rating = $tour->average_rating ?? $tour->approvedReviews->avg('rating');
    $reviewCount = $tour->approvedReviews->count();
    $tourUrl = route('tours.show', $tour->slug);
    if (!empty($queryParams)) {
        $tourUrl .= '?' . http_build_query($queryParams);
    }

    $durationLabel = $tour->duration_days
        ? $tour->duration_days . ' day' . ($tour->duration_days > 1 ? 's' : '')
        : ($tour->duration_hours
            ? ($tour->duration_hours >= 1 ? floor($tour->duration_hours) . ' h' : '') .
              ($tour->duration_hours != floor($tour->duration_hours) ? ' ' . round(($tour->duration_hours - floor($tour->duration_hours)) * 60) . ' min' : '')
            : null);

    $hasDiscount = $tour->base_price && $tour->price && $tour->base_price > $tour->price;
    $discountPercent = $hasDiscount ? round((1 - $tour->price / $tour->base_price) * 100) : 0;
    $categoryName = $tour->category?->name;
    $currency = ($tour->currency === 'EUR' || !$tour->currency) ? '€' : $tour->currency;
?>

<article <?php echo e($attributes->merge(['class' => 'group bg-white rounded-xl overflow-hidden border border-gray-200 transition-shadow ' . ($slider ? 'flex-shrink-0 hover:shadow-md' : 'hover:shadow-lg')])); ?>

    <?php if($slider): ?> data-slider-card <?php endif; ?>>
    <a href="<?php echo e($tourUrl); ?>" class="flex flex-col h-full">
        
        <div class="relative overflow-hidden flex-shrink-0 aspect-[4/3] rounded-xl px-2 mt-2" style="max-width: 100% !important;">
            <img style="width: 100% !important;" src="<?php echo e($imageUrl); ?>" alt="<?php echo e($tour->title); ?>"
                 class="w-full rounded-xl h-full object-cover" loading="lazy">

            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tour->season): ?>
                <div class="absolute bottom-3 left-3 flex flex-wrap gap-1.5">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tour->is_featured): ?>
                        <span class="inline-flex items-center px-2.5 py-1 text-xs font-bold bg-brand-btn text-white rounded-md backdrop-blur-sm">Best Seller</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php
                        $seasonLabels = ['summer' => 'Summer', 'winter' => 'Winter', 'all_season' => 'All Season'];
                        $seasonColors = ['summer' => 'bg-amber-500/90', 'winter' => 'bg-sky-500/90', 'all_season' => 'bg-emerald-600/90'];
                    ?>
                    <span class="inline-flex items-center px-2.5 py-1 text-xs font-bold <?php echo e($seasonColors[$tour->season] ?? 'bg-gray-700/90'); ?> text-white rounded-md backdrop-blur-sm"><?php echo e($seasonLabels[$tour->season] ?? $tour->season); ?></span>
                </div>
            <?php elseif($tour->is_featured): ?>
                <div class="absolute bottom-3 left-3">
                    <span class="inline-flex items-center px-2.5 py-1 text-xs font-bold bg-brand-btn text-white rounded-md backdrop-blur-sm">Best Seller</span>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasDiscount && $discountPercent >= 5): ?>
                <div class="absolute top-3 left-3">
                    <span class="inline-flex items-center px-2 py-0.5 text-[11px] font-bold bg-red-500 text-white rounded"><?php echo e($discountPercent); ?>% Off</span>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($wishlisted): ?>
                    <form method="POST" action="<?php echo e(route('wishlist.destroy', $tour)); ?>" class="absolute top-3 right-3 z-10" onclick="event.preventDefault(); event.stopPropagation(); this.submit();">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="w-9 h-9 rounded-xl bg-white/20 backdrop-blur-sm border border-white/30 flex items-center justify-center text-rose-500 hover:bg-white/30 transition-colors" aria-label="Remove from wishlist">
                            <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M6.25 3.333a4.583 4.583 0 0 0-4.583 4.584c0 4.583 5.416 8.75 8.333 9.716 2.917-.966 8.333-5.133 8.333-9.716A4.583 4.583 0 0 0 10 5.28a4.578 4.578 0 0 0-3.75-1.948Z" fill="currentColor" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                    </form>
                <?php else: ?>
                    <form method="POST" action="<?php echo e(route('wishlist.store', $tour)); ?>" class="absolute top-3 right-3 z-10" onclick="event.preventDefault(); event.stopPropagation(); this.submit();">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="w-9 h-9 rounded-xl bg-white/20 backdrop-blur-sm border border-white/30 flex items-center justify-center text-white hover:text-rose-500 hover:bg-white/30 transition-colors" aria-label="Add to wishlist">
                            <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M6.25 3.333a4.583 4.583 0 0 0-4.583 4.584c0 4.583 5.416 8.75 8.333 9.716 2.917-.966 8.333-5.133 8.333-9.716A4.583 4.583 0 0 0 10 5.28a4.578 4.578 0 0 0-3.75-1.948Z" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                    </form>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        
        <div class="flex flex-col flex-1 min-w-0 px-3 pt-3 pb-4">
            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($categoryName): ?>
                <div class="flex flex-wrap gap-1.5 mb-2">
                    <span class="inline-flex items-center px-2 py-0.5 text-[11px] font-medium text-sky-700 border border-sky-200 bg-sky-50 rounded"><?php echo e($categoryName); ?></span>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            
            <h3 class="text-[15px] font-semibold text-gray-900 leading-snug line-clamp-2 group-hover:text-gray-700 transition-colors min-h-[41px]"><?php echo e($tour->title); ?></h3>

            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($durationLabel): ?>
                <div class="mt-2">
                    <span class="text-sm text-gray-500 flex items-center gap-1">
                        <i class="fa-regular fa-clock text-xs"></i>
                        <?php echo e($durationLabel); ?>

                    </span>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            
            <div class="mt-auto pt-2.5 flex items-center justify-between gap-2">
                <div class="flex items-center gap-1.5">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($rating): ?>
                        <span class="inline-flex items-center gap-0.5 text-sm font-bold text-gray-900">
                            <i class="fa-solid fa-star text-amber-400 text-xs"></i>
                            <?php echo e(number_format($rating, 1)); ?>

                        </span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($reviewCount): ?>
                        <span class="text-sm text-gray-400">(<?php echo e(number_format($reviewCount)); ?>)</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <div class="flex items-baseline gap-1.5 text-right">
                    <span class="text-xs text-gray-400">From</span>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasDiscount): ?>
                        <span class="text-xs text-gray-400 line-through"><?php echo e($currency); ?><?php echo e(number_format($tour->base_price, 0)); ?></span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <span class="text-base font-bold text-gray-900"><?php echo e($currency); ?><?php echo e(number_format($tour->price ?? 0, 0)); ?></span>
                </div>
            </div>
        </div>
    </a>
</article>
<?php /**PATH C:\Users\Administrator\Desktop\Projects\TOP7\topseven\resources\views\components\tour-card.blade.php ENDPATH**/ ?>