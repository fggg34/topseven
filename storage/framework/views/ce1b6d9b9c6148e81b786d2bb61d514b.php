<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'countries',
    'heading' => null,
]));

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

foreach (array_filter(([
    'countries',
    'heading' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $countries = $countries ?? collect();
    $heading = $heading ?? \App\Models\Setting::get('homepage_where_next_heading', 'Where to next?');
?>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($countries->isNotEmpty()): ?>
<section class="home-where-next w-full bg-white py-14 md:py-20">
    <div class="w-full max-w-none px-4 sm:px-6 md:px-[80px]">
        <h2 class="text-4xl sm:text-5xl md:text-[2.75rem] lg:text-6xl font-bold text-gray-900 text-left tracking-tight leading-[1.1] mb-8 md:mb-10">
            <?php echo e($heading); ?>

        </h2>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 sm:gap-4 md:gap-4">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <?php
                    $img = $country->city_image_url;
                    $galleryUrls = $country->gallery_urls;
                    if (! $img && is_array($galleryUrls) && ! empty($galleryUrls[0])) {
                        $img = $galleryUrls[0];
                    }
                    if (! $img) {
                        $img = 'https://placehold.co/600x600/e5e7eb/6b7280?text=' . urlencode($country->name);
                    }
                    $trips = (int) ($country->tours_count ?? 0);
                ?>
                <a
                    href="<?php echo e(route('countries.show', $country->slug)); ?>"
                    class="group relative aspect-square w-full overflow-hidden rounded-2xl md:rounded-3xl bg-gray-200 ring-1 ring-black/5 shadow-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-900 focus-visible:ring-offset-2"
                >
                    <img
                        src="<?php echo e($img); ?>"
                        alt="<?php echo e($country->name); ?>"
                        class="absolute inset-0 h-full w-full object-cover transition-transform duration-500 ease-out group-hover:scale-105"
                        loading="lazy"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/35 to-black/20 pointer-events-none"></div>

                    <div class="absolute inset-0 z-10 flex flex-col items-center justify-center px-3 text-center">
                        <span class="text-base sm:text-lg font-medium text-white drop-shadow-md tracking-tight">
                            <?php echo e($country->name); ?>

                        </span>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($trips > 0): ?>
                            <span class="mt-2.5 inline-flex items-center rounded-full bg-white px-3 py-1 text-xs sm:text-sm font-semibold text-gray-900 tabular-nums shadow-sm">
                                <?php echo e($trips); ?> <?php echo e(\Illuminate\Support\Str::plural('Trip', $trips)); ?>

                            </span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </a>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php /**PATH C:\Users\Administrator\Desktop\Projects\TOP7\topseven\resources\views/components/home-where-next.blade.php ENDPATH**/ ?>