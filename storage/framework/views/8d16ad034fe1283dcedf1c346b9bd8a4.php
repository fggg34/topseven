<?php $__env->startSection('title', $country->name . ' - ' . config('app.name')); ?>
<?php $__env->startSection('description', Str::limit(strip_tags($country->description ?? ''), 160)); ?>

<?php $__env->startPush('meta'); ?>
<meta property="og:title" content="<?php echo e($country->name); ?>">
<meta property="og:description" content="<?php echo e(Str::limit(strip_tags($country->description ?? ''), 200)); ?>">
<meta property="og:url" content="<?php echo e(request()->url()); ?>">
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($country->city_image_url): ?>
<meta property="og:image" content="<?php echo e(request()->getSchemeAndHttpHost() . $country->city_image_url); ?>">
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-16">

    
    <nav class="text-sm text-gray-500 mb-8" aria-label="Breadcrumb">
        <ol class="flex items-center gap-1.5">
            <li><a href="<?php echo e(route('home')); ?>" class="text-lime-600 hover:text-lime-700 transition">Home</a></li>
            <li>/</li>
            <li><a href="<?php echo e(route('countries.index')); ?>" class="text-lime-600 hover:text-lime-700 transition">Countries</a></li>
            <li>/</li>
            <li class="text-gray-700"><?php echo e($country->name); ?></li>
        </ol>
    </nav>

    <?php
        $allImages = collect();
        if ($country->city_image_url) $allImages->push($country->city_image_url);
        if ($country->gallery_urls) $allImages = $allImages->merge($country->gallery_urls);
        $totalPhotos = $allImages->count();
        $thumbImages = $allImages->slice(1)->values();
    ?>

    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 mb-14">
        
        <div class="city-gallery">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($allImages->isNotEmpty()): ?>
                <div class="relative rounded-2xl overflow-hidden bg-gray-200" style="aspect-ratio: 16/10;">
                    <a href="<?php echo e($allImages[0]); ?>" class="glightbox block w-full h-full" data-gallery="city-gallery">
                        <img src="<?php echo e($allImages[0]); ?>" alt="<?php echo e($country->name); ?>" class="w-full h-full object-cover">
                    </a>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($totalPhotos > 1): ?>
                        <div class="absolute bottom-4 right-4 flex items-center gap-2 px-3.5 py-2 rounded-lg bg-lime-900/80 backdrop-blur-sm text-white text-sm font-medium pointer-events-none">
                            <i class="fa-regular fa-images"></i>
                            <?php echo e($totalPhotos); ?> photos
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($thumbImages->isNotEmpty()): ?>
                    <div class="grid grid-cols-4 gap-2 mt-2">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $thumbImages->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <a href="<?php echo e($url); ?>" class="glightbox group block aspect-[4/3] rounded-xl overflow-hidden bg-gray-200" data-gallery="city-gallery">
                                <img src="<?php echo e($url); ?>" alt="<?php echo e($country->name); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                            </a>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $allImages->slice(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                    <a href="<?php echo e($url); ?>" class="glightbox hidden" data-gallery="city-gallery"></a>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <?php else: ?>
                <div class="rounded-2xl bg-gray-100 h-full flex items-center justify-center text-gray-400" style="min-height: 400px;">
                    No images available
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        
        <div class="flex flex-col justify-center">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($country->country): ?>
                <p class="text-xs font-medium uppercase tracking-wider text-lime-600 mb-2"><?php echo e($country->country); ?></p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-5"><?php echo e($country->name); ?></h1>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($country->description): ?>
                <div class="prose prose-gray max-w-none text-gray-600">
                    <?php echo $country->description; ?>

                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <div class="flex flex-wrap items-center gap-4 mt-6 pt-6 border-t border-gray-100">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($country->tours->count()): ?>
                    <div class="flex items-center gap-2">
                        <span class="w-9 h-9 rounded-lg bg-lime-50 flex items-center justify-center"><i class="fa-solid fa-route text-lime-600 text-sm"></i></span>
                        <div>
                            <span class="text-lg font-bold text-gray-900"><?php echo e($country->tours->where('is_active', true)->count()); ?></span>
                            <span class="text-sm text-gray-500 ml-1">Tours</span>
                        </div>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($country->highlights->count()): ?>
                    <div class="flex items-center gap-2">
                        <span class="w-9 h-9 rounded-lg bg-lime-50 flex items-center justify-center"><i class="fa-solid fa-camera text-lime-600 text-sm"></i></span>
                        <div>
                            <span class="text-lg font-bold text-gray-900"><?php echo e($country->highlights->count()); ?></span>
                            <span class="text-sm text-gray-500 ml-1">Attractions</span>
                        </div>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($country->highlights->isNotEmpty()): ?>
    <section class="mb-14 overflow-hidden">
        <div class="flex items-end justify-between mb-8">
            <div>
                <p class="text-xs font-medium uppercase tracking-wider text-gray-400 mb-1">Explore</p>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Places to visit in <?php echo e($country->name); ?></h2>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" class="city-highlights-prev w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center text-gray-400 hover:text-lime-600 hover:border-lime-300 transition-colors">
                    <i class="fa-solid fa-arrow-left text-sm"></i>
                </button>
                <button type="button" class="city-highlights-next w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center text-gray-400 hover:text-lime-600 hover:border-lime-300 transition-colors">
                    <i class="fa-solid fa-arrow-right text-sm"></i>
                </button>
            </div>
        </div>
        <div class="swiper city-highlights-swiper overflow-visible">
            <div class="swiper-wrapper">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $country->highlights; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $highlight): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <div class="swiper-slide">
                    <a href="<?php echo e(route('countries.highlights.show', [$country->slug, $highlight->slug])); ?>" class="group block relative rounded-xl overflow-hidden bg-gray-200" style="aspect-ratio: 4/3;">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($highlight->image_url): ?>
                            <img src="<?php echo e($highlight->image_url); ?>" alt="<?php echo e($highlight->title); ?>" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent"></div>
                        <div class="absolute bottom-3 left-3 right-3">
                            <h3 class="font-bold text-base drop-shadow line-clamp-2" style="color: #fff !important;"><?php echo e($highlight->title); ?></h3>
                        </div>
                    </a>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </div>
    </section>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($country->tours->isNotEmpty()): ?>
    <section class="mb-14">
        <div class="flex items-end justify-between mb-8">
            <div>
                <p class="text-xs font-medium uppercase tracking-wider text-gray-400 mb-1">Curated experiences</p>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Tours in <?php echo e($country->name); ?></h2>
            </div>
            <div class="flex items-center gap-2">
                <div class="flex items-center gap-2 sm:hidden">
                    <button type="button" class="city-tours-prev w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center text-gray-400 hover:text-lime-600 hover:border-lime-300 transition-colors">
                        <i class="fa-solid fa-arrow-left text-sm"></i>
                    </button>
                    <button type="button" class="city-tours-next w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center text-gray-400 hover:text-lime-600 hover:border-lime-300 transition-colors">
                        <i class="fa-solid fa-arrow-right text-sm"></i>
                    </button>
                </div>
                <a href="<?php echo e(route('tours.index', ['country' => $country->slug])); ?>" class="text-sm font-medium text-lime-600 hover:text-lime-700 transition hidden sm:block">
                    View all tours &rarr;
                </a>
            </div>
        </div>
        
        <div class="hidden sm:grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $country->tours->where('is_active', true)->take(8); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tour): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal82db288ae19d37c54da8bf5b2a908f6d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal82db288ae19d37c54da8bf5b2a908f6d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tour-card','data' => ['tour' => $tour,'queryParams' => []]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tour-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tour' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tour),'queryParams' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([])]); ?>
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
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
        
        <div class="swiper city-tours-swiper overflow-visible block sm:!hidden">
            <div class="swiper-wrapper">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $country->tours->where('is_active', true)->take(8); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tour): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <div class="swiper-slide">
                    <?php if (isset($component)) { $__componentOriginal82db288ae19d37c54da8bf5b2a908f6d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal82db288ae19d37c54da8bf5b2a908f6d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tour-card','data' => ['tour' => $tour,'queryParams' => ['country' => $country->slug],'slider' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tour-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tour' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tour),'queryParams' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['country' => $country->slug]),'slider' => true]); ?>
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
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </div>
        <div class="mt-6 text-center sm:hidden">
            <a href="<?php echo e(route('tours.index', ['country' => $country->slug])); ?>" class="text-sm font-medium text-lime-600 hover:text-lime-700 transition">
                View all tours &rarr;
            </a>
        </div>
    </section>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

</div>
<?php echo app('Illuminate\Foundation\Vite')(['resources/js/tour-gallery.js']); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (window.Swiper && document.querySelector('.city-highlights-swiper')) {
        new window.Swiper('.city-highlights-swiper', {
            modules: [window.SwiperNavigation],
            slidesPerView: 2,
            spaceBetween: 20,
            navigation: {
                prevEl: '.city-highlights-prev',
                nextEl: '.city-highlights-next',
            },
            breakpoints: {
                640: { slidesPerView: 2, spaceBetween: 20 },
                1024: { slidesPerView: 4, spaceBetween: 20 },
            },
        });
    }
    if (window.Swiper && document.querySelector('.city-tours-swiper')) {
        new window.Swiper('.city-tours-swiper', {
            modules: [window.SwiperNavigation],
            slidesPerView: 1.2,
            spaceBetween: 20,
            navigation: {
                prevEl: '.city-tours-prev',
                nextEl: '.city-tours-next',
            },
        });
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.site', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\Projects\TOP7\topseven\resources\views\pages\countries\show.blade.php ENDPATH**/ ?>