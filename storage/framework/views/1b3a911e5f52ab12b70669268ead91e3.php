<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['banners']));

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

foreach (array_filter((['banners']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $banners = $banners ?? collect();
    $resolveUrl = fn ($u) => str_starts_with($u ?? '', 'http') ? $u : url($u ?: '/tours');
?>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($banners->isNotEmpty()): ?>
<section class="home-seasonal-banners-section mx-auto px-4 sm:px-6 lg:px-[80px] pt-8 pb-12" style="overflow: hidden;">
    <div class="relative">
        <button type="button" class="home-seasonal-next absolute right-2 md:right-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-white text-gray-700 border border-gray-100 shadow-[0_8px_18px_rgba(15,23,42,0.18)] flex items-center justify-center hover:bg-gray-100 transition-colors" aria-label="Next">
            <i class="fa-solid fa-arrow-right text-xs"></i>
        </button>

        <div style="overflow: visible;" class="swiper home-seasonal-banners-swiper overflow-visible">
            <div class="swiper-wrapper">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                    <?php
                        $img = $banner->background_image_url ?? null;
                        $title = trim((string) ($banner->title ?? ''));
                        $buttonText = trim((string) ($banner->button_text ?? '')) ?: 'Learn More';
                        $buttonUrl = $resolveUrl($banner->button_url ?? '/tours');
                    ?>
                    <div class="swiper-slide">
                        <div class="relative overflow-hidden rounded-md border border-gray-200 min-h-[320px] md:min-h-[400px] lg:min-h-[440px] bg-cover bg-center" style="background-image: url('<?php echo e(e($img ?: 'https://images.unsplash.com/photo-1469474968028-56623f02e42e?auto=format&fit=crop&w=1800&q=80')); ?>');">
                            <div class="absolute inset-0 bg-gradient-to-r from-black/55 via-black/30 to-transparent"></div>
                            <div class="absolute inset-0 z-10 flex items-center px-6 md:px-12">
                                <div class="max-w-[520px]">
                                    <h3 class="text-white text-[30px] md:text-[42px] font-semibold leading-[1.05] drop-shadow-[0_2px_8px_rgba(0,0,0,0.45)]">
                                        <?php echo nl2br(e($title)); ?>

                                    </h3>
                                    <a href="<?php echo e($buttonUrl); ?>" class="inline-flex mt-6 items-center rounded-md bg-white text-gray-800 text-sm font-medium px-5 py-2.5 hover:bg-gray-100 transition-colors">
                                        <?php echo e($buttonText); ?>

                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php /**PATH /Users/kevinhitaj/Desktop/Projects/TOP 7 TRAVEL/resources/views/components/home-seasonal-banners-slider.blade.php ENDPATH**/ ?>