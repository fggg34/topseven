<?php $__env->startSection('title', \App\Models\Setting::get('homepage_seo_title') ?: (\App\Models\Setting::get('site_name', config('app.name')) . ' - ' . \App\Models\Setting::get('site_tagline', 'Discover your next adventure'))); ?>
<?php $__env->startSection('description', \App\Models\Setting::get('homepage_seo_description') ?: \App\Models\Setting::get('hero_subtitle', 'Explore stunning destinations with expert guides.')); ?>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(\App\Models\Setting::get('homepage_seo_og_image')): ?><?php $__env->startSection('og_image', \App\Models\Setting::get('homepage_seo_og_image')); ?><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<?php $__env->startSection('hero'); ?>
<?php
    $heroSlides = isset($heroSlides) && $heroSlides->isNotEmpty()
        ? $heroSlides
        : collect([
            (object) [
                'title' => "Europe's Best Travel Packages & Things to Do",
                'subtitle' => 'Book unforgettable trips with local experts.',
                'banner_type' => 'image',
                'banner_image_url' => 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=1920',
                'banner_video_url' => null,
                'cta_text' => 'Book now',
                'cta_url' => route('tours.index'),
            ],
        ]);
    $resolveUrl = fn ($u) => (str_starts_with($u ?? '', 'http') ? $u : url($u ?? '#'));
?>
<section class="home-hero-section relative isolate h-[650px] bg-black text-white overflow-hidden">
    
    <?php $heroSlideCount = $heroSlides->count(); ?>
    <div class="<?php echo e($heroSlideCount > 1 ? 'swiper home-hero-swiper' : ''); ?> absolute inset-0 z-0">
        <div class="<?php echo e($heroSlideCount > 1 ? 'swiper-wrapper' : ''); ?>" style="height:100%">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $heroSlides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <?php
                    $videoUrl = $slide->banner_video_url ?? null;
                    $imageUrl = $slide->banner_image_url ?? null;
                    $useVideo = (($slide->banner_type ?? '') === 'video') && ! empty($videoUrl);
                    $useImage = ! empty($imageUrl);
                    $fallbackImage = 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=1920';
                    $ctaUrl = ! empty($slide->cta_url) ? $resolveUrl($slide->cta_url) : route('tours.index');
                ?>
                <div class="<?php echo e($heroSlideCount > 1 ? 'swiper-slide' : ''); ?>"
                     style="height:100%;position:relative"
                     data-hero-title="<?php echo e(e($slide->title ?? '')); ?>"
                     data-hero-subtitle="<?php echo e(e($slide->subtitle ?? '')); ?>"
                     data-hero-cta-text="<?php echo e(e($slide->cta_text ?? '')); ?>"
                     data-hero-cta-url="<?php echo e(e($ctaUrl)); ?>">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($useVideo): ?>
                        <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover">
                            <source src="<?php echo e($videoUrl); ?>" type="video/mp4">
                        </video>
                    <?php elseif($useImage): ?>
                        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('<?php echo e($imageUrl); ?>');"></div>
                    <?php else: ?>
                        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('<?php echo e($fallbackImage); ?>');"></div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-black/30"></div>
                </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
    </div>

    
    <div class="relative z-20 flex flex-col h-full w-full min-h-0 px-4 sm:px-6 lg:px-[80px] pt-20 md:pt-24 pointer-events-auto">

        
        <div class="flex-shrink-0 w-full mt-2">
            <?php if (isset($component)) { $__componentOriginal91144834ae340585ab8bc428a53a6d32 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal91144834ae340585ab8bc428a53a6d32 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.hero-search-form','data' => ['action' => route('tours.index'),'countries' => $countries ?? collect()]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('hero-search-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('tours.index')),'countries' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($countries ?? collect())]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal91144834ae340585ab8bc428a53a6d32)): ?>
<?php $attributes = $__attributesOriginal91144834ae340585ab8bc428a53a6d32; ?>
<?php unset($__attributesOriginal91144834ae340585ab8bc428a53a6d32); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal91144834ae340585ab8bc428a53a6d32)): ?>
<?php $component = $__componentOriginal91144834ae340585ab8bc428a53a6d32; ?>
<?php unset($__componentOriginal91144834ae340585ab8bc428a53a6d32); ?>
<?php endif; ?>
        </div>

        
        <div class="flex-1"></div>

        
        <div class="flex-shrink-0 pb-12 md:pb-16">
            <div class="w-full max-w-none">
                <div class="flex items-end justify-between gap-8">
                    
                    <?php $firstSlide = $heroSlides->first(); ?>
                    <div class="max-w-3xl lg:max-w-4xl hero-slide-content min-w-0">
                        <h1 id="hero-slide-title" class="text-4xl sm:text-5xl md:text-5xl lg:text-6xl xl:text-7xl font-bold leading-[1.08] mb-3 lg:mb-4 tracking-tight"><?php echo e($firstSlide->title); ?></h1>
                        <p id="hero-slide-subtitle" class="text-lg sm:text-xl md:text-xl lg:text-2xl text-white/90 mb-6 lg:mb-8 leading-relaxed <?php if(empty($firstSlide->subtitle)): ?> hidden <?php endif; ?>"><?php echo e($firstSlide->subtitle); ?></p>
                        <a id="hero-slide-cta" href="<?php echo e(!empty($firstSlide->cta_url) ? $resolveUrl($firstSlide->cta_url) : route('tours.index')); ?>"
                           class="inline-flex items-center px-8 py-3.5 lg:px-10 lg:py-4 rounded-full border-2 border-white text-white text-base lg:text-lg font-semibold hover:bg-white hover:text-gray-900 transition-all duration-200 <?php if(empty($firstSlide->cta_text)): ?> hidden <?php endif; ?>"><?php echo e($firstSlide->cta_text); ?></a>
                    </div>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($heroSlideCount > 1): ?>
                        <div class="home-hero-pagination swiper-pagination swiper-pagination-horizontal shrink-0 mb-2"></div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginal88ccf21f1615acf6906bd57b247c4fb5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal88ccf21f1615acf6906bd57b247c4fb5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home-flash-sale-slider','data' => ['rows' => $homepageFlashSaleTours ?? collect()]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home-flash-sale-slider'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['rows' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($homepageFlashSaleTours ?? collect())]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal88ccf21f1615acf6906bd57b247c4fb5)): ?>
<?php $attributes = $__attributesOriginal88ccf21f1615acf6906bd57b247c4fb5; ?>
<?php unset($__attributesOriginal88ccf21f1615acf6906bd57b247c4fb5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal88ccf21f1615acf6906bd57b247c4fb5)): ?>
<?php $component = $__componentOriginal88ccf21f1615acf6906bd57b247c4fb5; ?>
<?php unset($__componentOriginal88ccf21f1615acf6906bd57b247c4fb5); ?>
<?php endif; ?>

<?php if (isset($component)) { $__componentOriginalc5ae5bd5724cd73cf290663fbffdbc17 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc5ae5bd5724cd73cf290663fbffdbc17 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home-why-book','data' => ['heading' => $whyBookHeading,'cards' => $whyBookCards]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home-why-book'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['heading' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($whyBookHeading),'cards' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($whyBookCards)]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc5ae5bd5724cd73cf290663fbffdbc17)): ?>
<?php $attributes = $__attributesOriginalc5ae5bd5724cd73cf290663fbffdbc17; ?>
<?php unset($__attributesOriginalc5ae5bd5724cd73cf290663fbffdbc17); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc5ae5bd5724cd73cf290663fbffdbc17)): ?>
<?php $component = $__componentOriginalc5ae5bd5724cd73cf290663fbffdbc17; ?>
<?php unset($__componentOriginalc5ae5bd5724cd73cf290663fbffdbc17); ?>
<?php endif; ?>

<?php if (isset($component)) { $__componentOriginal9e8a687138a9adb8d668371f7e8cc613 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9e8a687138a9adb8d668371f7e8cc613 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home-where-next','data' => ['countries' => $whereNextCountries ?? collect()]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home-where-next'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['countries' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($whereNextCountries ?? collect())]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9e8a687138a9adb8d668371f7e8cc613)): ?>
<?php $attributes = $__attributesOriginal9e8a687138a9adb8d668371f7e8cc613; ?>
<?php unset($__attributesOriginal9e8a687138a9adb8d668371f7e8cc613); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9e8a687138a9adb8d668371f7e8cc613)): ?>
<?php $component = $__componentOriginal9e8a687138a9adb8d668371f7e8cc613; ?>
<?php unset($__componentOriginal9e8a687138a9adb8d668371f7e8cc613); ?>
<?php endif; ?>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($homepageReviews ?? collect())->isNotEmpty()): ?>
<section class="home-testimonials-section px-4 sm:px-6 lg:px-[80px] pt-16 pb-16">
    <div class="mx-auto w-full max-w-[1400px]">
        <h2 class="text-center text-3xl md:text-[40px] font-semibold text-[#2f2419] tracking-tight mb-7">
            What do Top 7 Agency travellers say
        </h2>

        <div class="relative overflow-visible">

            <button type="button" class="home-testimonials-prev absolute left-0 top-1/2 -translate-y-1/2 -translate-x-1/2 z-20 w-12 h-12 rounded-full bg-white text-gray-500 border border-gray-100 shadow-[0_10px_22px_rgba(15,23,42,0.12)] flex items-center justify-center hover:text-gray-700 transition-colors" aria-label="Previous review">
                <i class="fa-solid fa-arrow-left text-sm"></i>
            </button>
            <button type="button" class="home-testimonials-next absolute right-0 top-1/2 -translate-y-1/2 translate-x-1/2 z-20 w-12 h-12 rounded-full bg-white text-gray-500 border border-gray-100 shadow-[0_10px_22px_rgba(15,23,42,0.12)] flex items-center justify-center hover:text-gray-700 transition-colors" aria-label="Next review">
                <i class="fa-solid fa-arrow-right text-sm"></i>
            </button>

            <div class="relative rounded-md overflow-hidden bg-cover bg-center" style="background-image: linear-gradient(rgba(0,0,0,0.05), rgba(0,0,0,0.05)), url('https://images.unsplash.com/photo-1530789253388-582c481c54b0?auto=format&fit=crop&w=1800&q=80');">
                <div class="absolute inset-0 bg-gradient-to-r from-[#ab6f2e]/20 via-transparent to-[#f0ca79]/25 pointer-events-none"></div>
                <div class="swiper home-testimonials-swiper">
                    <div class="swiper-wrapper">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $homepageReviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                    <?php
                        $name = $review->display_name;
                        $safeComment = trim((string) $review->comment);
                        $comment = $safeComment !== '' ? $safeComment : 'Great service, smooth planning, and an unforgettable trip from start to finish.';
                        $title = trim((string) ($review->title ?? '')) ?: $comment;
                    ?>
                    <div class="swiper-slide">
                        <div class="home-testimonial-slide relative min-h-[230px] md:min-h-[250px]">
                            <div class="relative z-10 px-6 md:px-10 py-6 md:py-8 flex items-center justify-center min-h-[230px] md:min-h-[250px]">
                                <article class="w-full max-w-4xl bg-white/95 border border-[#efe7dc] shadow-[0_18px_40px_rgba(15,23,42,0.13)] px-5 md:px-10 py-5 md:py-6">
                                    <h3 class="text-[22px] md:text-[34px] leading-tight font-medium text-[#3f2f23] mb-3">
                                        &ldquo;<?php echo e(\Illuminate\Support\Str::limit($title, 90)); ?>&rdquo;
                                    </h3>
                                    <p class="text-[15px] md:text-[17px] leading-relaxed text-[#4d3f33] mb-4">
                                        <?php echo e(\Illuminate\Support\Str::limit($comment, 220)); ?>

                                    </p>
                                    <div class="flex items-center justify-between gap-3 flex-wrap">
                                        <p class="text-[15px] font-semibold text-[#2f2419]"><?php echo e($name); ?></p>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($review->platform): ?>
                                            <span class="inline-flex items-center gap-2 rounded bg-white px-2 py-1 border border-gray-200 text-[12px] text-gray-700">
                                                <span class="inline-block w-2 h-2 rounded-full bg-green-500"></span>
                                                <?php echo e($review->platform); ?>

                                            </span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </article>
                            </div>
                        </div>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<?php if (isset($component)) { $__componentOriginal88ccf21f1615acf6906bd57b247c4fb5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal88ccf21f1615acf6906bd57b247c4fb5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home-flash-sale-slider','data' => ['rows' => $homepageFlashSaleToursSecondary ?? collect()]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home-flash-sale-slider'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['rows' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($homepageFlashSaleToursSecondary ?? collect())]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal88ccf21f1615acf6906bd57b247c4fb5)): ?>
<?php $attributes = $__attributesOriginal88ccf21f1615acf6906bd57b247c4fb5; ?>
<?php unset($__attributesOriginal88ccf21f1615acf6906bd57b247c4fb5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal88ccf21f1615acf6906bd57b247c4fb5)): ?>
<?php $component = $__componentOriginal88ccf21f1615acf6906bd57b247c4fb5; ?>
<?php unset($__componentOriginal88ccf21f1615acf6906bd57b247c4fb5); ?>
<?php endif; ?>
<?php if (isset($component)) { $__componentOriginal2940c6a791a522214710f918f68cf93f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2940c6a791a522214710f918f68cf93f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home-seasonal-banners-slider','data' => ['banners' => $homepageSeasonalBanners ?? collect()]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home-seasonal-banners-slider'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['banners' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($homepageSeasonalBanners ?? collect())]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2940c6a791a522214710f918f68cf93f)): ?>
<?php $attributes = $__attributesOriginal2940c6a791a522214710f918f68cf93f; ?>
<?php unset($__attributesOriginal2940c6a791a522214710f918f68cf93f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2940c6a791a522214710f918f68cf93f)): ?>
<?php $component = $__componentOriginal2940c6a791a522214710f918f68cf93f; ?>
<?php unset($__componentOriginal2940c6a791a522214710f918f68cf93f); ?>
<?php endif; ?>
<?php if (isset($component)) { $__componentOriginal3d6ffdb528a96963d18dfce7ddca7bec = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3d6ffdb528a96963d18dfce7ddca7bec = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home-blog-stories','data' => ['posts' => $homepageBlogPosts ?? collect()]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home-blog-stories'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['posts' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($homepageBlogPosts ?? collect())]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3d6ffdb528a96963d18dfce7ddca7bec)): ?>
<?php $attributes = $__attributesOriginal3d6ffdb528a96963d18dfce7ddca7bec; ?>
<?php unset($__attributesOriginal3d6ffdb528a96963d18dfce7ddca7bec); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3d6ffdb528a96963d18dfce7ddca7bec)): ?>
<?php $component = $__componentOriginal3d6ffdb528a96963d18dfce7ddca7bec; ?>
<?php unset($__componentOriginal3d6ffdb528a96963d18dfce7ddca7bec); ?>
<?php endif; ?>

<?php $__env->startPush('styles'); ?>
<style>
    .home-hero-swiper,
    .home-hero-swiper .swiper-wrapper,
    .home-hero-swiper .swiper-slide {
        height: 100% !important;
    }
    .home-hero-pagination .swiper-pagination-bullet {
        display: inline-block;
        width: 12px;
        height: 12px;
        background: transparent;
        border: 2px solid rgba(255, 255, 255, 0.6);
        opacity: 1;
        border-radius: 50%;
        cursor: pointer;
    }
    .home-hero-pagination .swiper-pagination-bullet-active {
        background: #ffffff;
        border-color: #ffffff;
    }
    /* Keep bullets in the bottom-right flex row (Swiper defaults to full-width absolute) */
    .home-hero-section .home-hero-pagination.swiper-pagination {
        position: relative !important;
        left: auto !important;
        right: auto !important;
        bottom: auto !important;
        top: auto !important;
        width: auto !important;
        transform: none !important;
        text-align: left;
    }
    .home-flash-sale-prev.swiper-button-disabled,
    .home-flash-sale-next.swiper-button-disabled {
        opacity: 0.35 !important;
        cursor: not-allowed;
    }
    .home-flash-sale-next.swiper-button-disabled {
        background-color: #e5e7eb !important;
        color: #9ca3af !important;
    }
    .home-testimonials-prev.swiper-button-disabled,
    .home-testimonials-next.swiper-button-disabled {
        opacity: 0.35;
        pointer-events: none;
    }
    .home-testimonial-slide article {
        backdrop-filter: blur(1px);
    }
    .home-testimonials-swiper .swiper-slide {
        display: flex;
        justify-content: center;
    }
    .home-seasonal-next.swiper-button-disabled {
        opacity: 0.35;
        pointer-events: none;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var heroSwiperEl = document.querySelector('.home-hero-swiper');
    if (window.Swiper && heroSwiperEl) {
        var heroSlideCount = heroSwiperEl.querySelectorAll('.swiper-slide').length;
        var heroSection = document.querySelector('.home-hero-section');
        var pagEl = heroSection ? heroSection.querySelector('.home-hero-pagination') : null;
        var titleEl = document.getElementById('hero-slide-title');
        var subtitleEl = document.getElementById('hero-slide-subtitle');
        var ctaEl = document.getElementById('hero-slide-cta');

        function syncHeroCopy(swiper) {
            var slide = swiper.slides[swiper.activeIndex];
            if (!slide || !titleEl) return;
            titleEl.textContent = slide.getAttribute('data-hero-title') || '';
            var sub = slide.getAttribute('data-hero-subtitle') || '';
            if (subtitleEl) {
                if (sub) {
                    subtitleEl.textContent = sub;
                    subtitleEl.classList.remove('hidden');
                } else {
                    subtitleEl.textContent = '';
                    subtitleEl.classList.add('hidden');
                }
            }
            var ctaText = slide.getAttribute('data-hero-cta-text') || '';
            var ctaUrl = slide.getAttribute('data-hero-cta-url') || '#';
            if (ctaEl) {
                if (ctaText) {
                    ctaEl.textContent = ctaText;
                    ctaEl.setAttribute('href', ctaUrl);
                    ctaEl.classList.remove('hidden');
                } else {
                    ctaEl.classList.add('hidden');
                }
            }
        }

        new window.Swiper(heroSwiperEl, {
            modules: [window.SwiperAutoplay, window.SwiperPagination],
            slidesPerView: 1,
            speed: 600,
            loop: false,
            rewind: heroSlideCount > 1,
            autoplay: heroSlideCount > 1 ? { delay: 6000, disableOnInteraction: false } : false,
            pagination: pagEl ? {
                el: pagEl,
                clickable: true,
            } : undefined,
            on: {
                init: function (swiper) {
                    syncHeroCopy(swiper);
                },
                slideChange: function (swiper) {
                    syncHeroCopy(swiper);
                },
            },
        });
    }
    if (window.Swiper && document.querySelector('.home-flash-sale-swiper')) {
        new window.Swiper('.home-flash-sale-swiper', {
            modules: [window.SwiperNavigation],
            slidesPerView: 1.15,
            spaceBetween: 16,
            watchOverflow: true,
            navigation: {
                prevEl: '.home-flash-sale-prev',
                nextEl: '.home-flash-sale-next',
            },
            breakpoints: {
                480: { slidesPerView: 1.35, spaceBetween: 16 },
                640: { slidesPerView: 2.15, spaceBetween: 16 },
                1024: { slidesPerView: 3.15, spaceBetween: 16 },
                1280: { slidesPerView: 4.15, spaceBetween: 16 },
            },
        });
    }
    if (window.Swiper && document.querySelector('.featured-tours-swiper')) {
        new window.Swiper('.featured-tours-swiper', {
            modules: [window.SwiperNavigation],
            slidesPerView: 1.2,
            spaceBetween: 20,
            navigation: {
                prevEl: '.featured-prev',
                nextEl: '.featured-next',
            },
            breakpoints: {
                640: { slidesPerView: 2.2, spaceBetween: 20 },
                1024: { slidesPerView: 3.2, spaceBetween: 20 },
                1280: { slidesPerView: 4, spaceBetween: 20 },
            },
        });
    }
    if (window.Swiper && document.querySelector('.home-testimonials-swiper')) {
        new window.Swiper('.home-testimonials-swiper', {
            modules: [window.SwiperNavigation, window.SwiperAutoplay],
            slidesPerView: 1,
            centeredSlides: true,
            speed: 650,
            loop: true,
            autoplay: { delay: 7000, disableOnInteraction: false },
            navigation: {
                prevEl: '.home-testimonials-prev',
                nextEl: '.home-testimonials-next',
            },
        });
    }
    if (window.Swiper && document.querySelector('.home-seasonal-banners-swiper')) {
        new window.Swiper('.home-seasonal-banners-swiper', {
            modules: [window.SwiperNavigation, window.SwiperAutoplay],
            slidesPerView: 2.3,
            spaceBetween: 14,
            speed: 700,
            watchOverflow: true,
            autoplay: { delay: 5500, disableOnInteraction: false },
            navigation: {
                nextEl: '.home-seasonal-next',
            },
            breakpoints: {
                640: { slidesPerView: 1.2, spaceBetween: 12 },
                1024: { slidesPerView: 2.2, spaceBetween: 14 },
                1280: { slidesPerView: 2.3, spaceBetween: 14 },
            },
        });
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.site', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\Projects\TOP7\topseven\resources\views/pages/home.blade.php ENDPATH**/ ?>