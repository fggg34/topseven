<?php $__env->startSection('title', $highlight->title . ' - ' . $country->name . ' - ' . config('app.name')); ?>
<?php $__env->startSection('description', Str::limit(strip_tags($highlight->description), 160)); ?>

<?php $__env->startPush('meta'); ?>
<meta property="og:title" content="<?php echo e($highlight->title); ?> - <?php echo e($country->name); ?>">
<meta property="og:description" content="<?php echo e(Str::limit(strip_tags($highlight->description), 200)); ?>">
<meta property="og:url" content="<?php echo e(request()->url()); ?>">
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($highlight->image_url): ?>
<meta property="og:image" content="<?php echo e(request()->getSchemeAndHttpHost() . $highlight->image_url); ?>">
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-16">

    
    <nav class="text-sm text-gray-500 mb-8" aria-label="Breadcrumb">
        <ol class="flex items-center gap-1.5 flex-wrap">
            <li><a href="<?php echo e(route('home')); ?>" class="text-lime-600 hover:text-lime-700 transition">Home</a></li>
            <li>/</li>
            <li><a href="<?php echo e(route('countries.show', $country->slug)); ?>" class="text-lime-600 hover:text-lime-700 transition"><?php echo e($country->name); ?></a></li>
            <li>/</li>
            <li class="text-gray-700"><?php echo e($highlight->title); ?></li>
        </ol>
    </nav>

    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 mb-14">
        
        <div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($highlight->image_url): ?>
                <div class="rounded-2xl overflow-hidden bg-gray-200 h-full" style="min-height: 400px;">
                    <img src="<?php echo e($highlight->image_url); ?>" alt="<?php echo e($highlight->title); ?>" class="w-full h-full object-cover">
                </div>
            <?php else: ?>
                <div class="rounded-2xl bg-gray-100 h-full flex items-center justify-center text-gray-400" style="min-height: 400px;">
                    No image available
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        
        <div class="flex flex-col justify-center">
            <div class="flex items-center gap-2 mb-3">
                <a href="<?php echo e(route('countries.show', $country->slug)); ?>" class="inline-flex items-center gap-1.5 text-xs font-medium uppercase tracking-wider text-lime-600 hover:text-lime-700 transition">
                    <i class="fa-solid fa-location-dot text-[10px]"></i>
                    <?php echo e($country->name); ?>, <?php echo e($country->country); ?>

                </a>
            </div>
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-5"><?php echo e($highlight->title); ?></h1>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($highlight->description): ?>
                <div class="prose prose-gray max-w-none text-gray-600">
                    <?php echo $highlight->description; ?>

                </div>
            <?php else: ?>
                <p class="text-gray-500">No description available yet.</p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <div class="mt-6 pt-6 border-t border-gray-100">
                <a href="<?php echo e(route('countries.show', $country->slug)); ?>" class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand-btn hover:bg-brand-btn-hover text-white text-sm font-medium rounded-lg transition-colors">
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                    Explore <?php echo e($country->name); ?>

                </a>
            </div>
        </div>
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($otherHighlights->isNotEmpty()): ?>
    <section class="pt-10 border-t border-gray-200 overflow-hidden">
        <div class="flex items-end justify-between mb-8">
            <div>
                <p class="text-xs font-medium uppercase tracking-wider text-gray-400 mb-1">Keep exploring</p>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900">More places to visit in <?php echo e($country->name); ?></h2>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" class="highlight-more-prev w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center text-gray-400 hover:text-lime-600 hover:border-lime-300 transition-colors">
                    <i class="fa-solid fa-arrow-left text-sm"></i>
                </button>
                <button type="button" class="highlight-more-next w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center text-gray-400 hover:text-lime-600 hover:border-lime-300 transition-colors">
                    <i class="fa-solid fa-arrow-right text-sm"></i>
                </button>
            </div>
        </div>
        <div class="swiper highlight-more-swiper overflow-visible">
            <div class="swiper-wrapper">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $otherHighlights; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $other): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <div class="swiper-slide">
                    <a href="<?php echo e(route('countries.highlights.show', [$country->slug, $other->slug])); ?>" class="group block relative rounded-xl overflow-hidden bg-gray-200" style="aspect-ratio: 4/3;">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($other->image_url): ?>
                            <img src="<?php echo e($other->image_url); ?>" alt="<?php echo e($other->title); ?>" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent"></div>
                        <div class="absolute bottom-3 left-3 right-3">
                            <h3 class="font-bold text-base drop-shadow line-clamp-2" style="color: #fff !important;"><?php echo e($other->title); ?></h3>
                        </div>
                    </a>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </div>
    </section>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (window.Swiper && document.querySelector('.highlight-more-swiper')) {
        new window.Swiper('.highlight-more-swiper', {
            modules: [window.SwiperNavigation],
            slidesPerView: 2,
            spaceBetween: 20,
            navigation: {
                prevEl: '.highlight-more-prev',
                nextEl: '.highlight-more-next',
            },
            breakpoints: {
                640: { slidesPerView: 2, spaceBetween: 20 },
                1024: { slidesPerView: 4, spaceBetween: 20 },
            },
        });
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.site', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\Projects\TOP7\topseven\resources\views\pages\highlights\show.blade.php ENDPATH**/ ?>