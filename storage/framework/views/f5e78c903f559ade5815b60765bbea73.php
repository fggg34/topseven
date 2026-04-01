<?php $__env->startSection('title', $tour->meta_title ?: $tour->title . ' - ' . config('app.name')); ?>
<?php $__env->startSection('description', $tour->meta_description ?: Str::limit($tour->short_description, 160)); ?>

<?php $__env->startPush('meta'); ?>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tour->meta_title): ?><meta property="og:title" content="<?php echo e($tour->meta_title); ?>"><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<meta property="og:description" content="<?php echo e($tour->meta_description ?: $tour->short_description); ?>">
<meta property="og:url" content="<?php echo e(request()->url()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.prose ul {
    list-style: disc;
    padding-left: 17px;
}
.prose ul li {
    margin-bottom: 10px;
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <?php
        $images = $tour->images->isEmpty() ? collect([null]) : $tour->images;
        $firstImage = $images->first();
        $mainImageUrl = $firstImage && $firstImage->path ? $firstImage->url : 'https://placehold.co/1200x600?text=Tour';
    ?>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-12">
            <div class="flex flex-col items-left">
                <div class="flex flex-wrap items-center gap-3">
                    <h1 class="text-3xl font-bold text-gray-900"><?php echo e($tour->title); ?></h1>
                    <!-- <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tour->season): ?>
                        <?php
                            $seasonLabels = ['summer' => 'Summer', 'winter' => 'Winter', 'all_season' => 'All Season'];
                            $seasonStyles = ['summer' => 'bg-amber-100 text-amber-800', 'winter' => 'bg-sky-100 text-sky-800', 'all_season' => 'bg-emerald-100 text-emerald-800'];
                        ?>
                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-semibold <?php echo e($seasonStyles[$tour->season] ?? 'bg-gray-100 text-gray-800'); ?>">
                            <?php echo e($seasonLabels[$tour->season] ?? $tour->season); ?> Tour
                        </span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?> -->
                </div>
                <!-- <p class="mt-2 text-gray-600"><?php echo e($tour->short_description); ?></p> -->
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tour->approvedReviews->count() > 0): ?>
                    <p class="mt-2 flex items-center gap-2">
                        <?php if (isset($component)) { $__componentOriginaldd1cac021a1037a3ad586e7a83aa8b85 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldd1cac021a1037a3ad586e7a83aa8b85 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.review-stars','data' => ['rating' => (float) $tour->average_rating]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('review-stars'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['rating' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute((float) $tour->average_rating)]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldd1cac021a1037a3ad586e7a83aa8b85)): ?>
<?php $attributes = $__attributesOriginaldd1cac021a1037a3ad586e7a83aa8b85; ?>
<?php unset($__attributesOriginaldd1cac021a1037a3ad586e7a83aa8b85); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldd1cac021a1037a3ad586e7a83aa8b85)): ?>
<?php $component = $__componentOriginaldd1cac021a1037a3ad586e7a83aa8b85; ?>
<?php unset($__componentOriginaldd1cac021a1037a3ad586e7a83aa8b85); ?>
<?php endif; ?>
                        <span class="text-sm text-gray-500">(<?php echo e($tour->approvedReviews->count()); ?> reviews)</span>
                    </p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            <?php
                $galleryImages = $tour->images->isEmpty() ? collect([(object)['url' => $mainImageUrl, 'alt' => $tour->title]]) : $tour->images;
                $img1 = $galleryImages->get(0);
                $img2 = $galleryImages->get(1);
                $img3 = $galleryImages->get(2);
                $img4 = $galleryImages->get(3);
                $totalImages = $galleryImages->count();
            ?>
            <div class="tour-gallery mt-5" style="margin-top: 20px;">
            
            <div class="tour-gallery-grid grid grid-cols-1 sm:grid-cols-2 gap-4 rounded-xl overflow-hidden">
                
                <a href="<?php echo e($img1->url ?? $mainImageUrl); ?>" class="glightbox block overflow-hidden rounded-lg min-h-[220px] sm:min-h-[200px] lg:row-span-2" data-gallery="tour-gallery-<?php echo e($tour->id); ?>" role="listitem">
                    <img src="<?php echo e($img1->url ?? $mainImageUrl); ?>" alt="<?php echo e($img1->alt ?? $tour->title); ?>" class="w-full h-full min-h-[220px] sm:min-h-[200px] object-cover cursor-pointer hover:opacity-95 transition-opacity" loading="eager" fetchpriority="high">
                </a>
                
                <div class="tour-gallery-right grid grid-cols-2 grid-rows-[130px] sm:grid-cols-2 sm:grid-rows-2 sm:min-h-0 gap-4">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($img2): ?>
                    <a href="<?php echo e($img2->url); ?>" class="glightbox block overflow-hidden rounded-lg h-[130px] sm:h-auto sm:min-h-0" data-gallery="tour-gallery-<?php echo e($tour->id); ?>" role="listitem">
                        <img src="<?php echo e($img2->url); ?>" alt="<?php echo e($img2->alt ?? 'Tour image'); ?>" class="w-full h-full object-cover cursor-pointer hover:opacity-95 transition-opacity" loading="lazy">
                    </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($img3): ?>
                    <div class="relative overflow-hidden rounded-lg h-[130px] sm:h-auto sm:min-h-0">
                        <a href="<?php echo e($img3->url); ?>" class="glightbox block w-full h-full overflow-hidden" data-gallery="tour-gallery-<?php echo e($tour->id); ?>" role="listitem">
                            <img src="<?php echo e($img3->url); ?>" alt="<?php echo e($img3->alt ?? 'Tour image'); ?>" class="w-full h-full object-cover cursor-pointer hover:opacity-95 transition-opacity" loading="lazy">
                        </a>
                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($totalImages > 4): ?>
                            <a href="<?php echo e($img1->url ?? $mainImageUrl); ?>" class="glightbox sm:hidden absolute bottom-2 right-2 flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg bg-black/60 text-white text-xs font-medium hover:bg-black/75 transition cursor-pointer z-10" data-gallery="tour-gallery-<?php echo e($tour->id); ?>" aria-label="View all <?php echo e($totalImages); ?> photos">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                </svg>
                                View all
                            </a>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($img4): ?>
                    <div class="hidden sm:block lg:col-span-2 relative overflow-hidden rounded-lg sm:min-h-0">
                        <a href="<?php echo e($img4->url); ?>" class="glightbox block w-full h-full overflow-hidden" data-gallery="tour-gallery-<?php echo e($tour->id); ?>" role="listitem">
                            <img src="<?php echo e($img4->url); ?>" alt="<?php echo e($img4->alt ?? 'Tour image'); ?>" class="w-full h-full object-cover cursor-pointer hover:opacity-95 transition-opacity" loading="lazy">
                        </a>
                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($totalImages > 4): ?>
                            <a style="z-index: 0;" href="<?php echo e($img1->url ?? $mainImageUrl); ?>" class="glightbox hidden sm:flex absolute bottom-4 right-4 items-center gap-1.5 px-3 py-2 rounded-lg bg-black/60 text-white text-sm font-medium hover:bg-black/75 transition cursor-pointer z-10" data-gallery="tour-gallery-<?php echo e($tour->id); ?>" aria-label="View all <?php echo e($totalImages); ?> photos">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                </svg>
                                View all
                            </a>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($totalImages > 4): ?>
                <div class="hidden">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $galleryImages->skip(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $extraImg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <a href="<?php echo e($extraImg->url); ?>" class="glightbox" data-gallery="tour-gallery-<?php echo e($tour->id); ?>">
                            <img src="<?php echo e($extraImg->url); ?>" alt="<?php echo e($extraImg->alt ?? 'Tour image'); ?>" loading="lazy">
                        </a>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <?php
                $durationLabel = $tour->duration_days
                    ? $tour->duration_days . ' day' . ($tour->duration_days > 1 ? 's' : '')
                    : ($tour->duration_hours ? $tour->duration_hours . ' hours' : null);
            ?>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-2" style="margin-top: 20px;">
                <div class="flex gap-2">
                    <div class="flex-shrink-0 w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center">
                        <i class="fa-solid fa-flag text-slate-600 text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-bold text-gray-600">Tour starts</p>
                        <p class="text-sm text-sky-600 truncate" title="<?php echo e($tour->start_location); ?>"><?php echo e($tour->start_location ?: '—'); ?></p>
                    </div>
                </div>
                <div class="flex gap-2">
                    <div class="flex-shrink-0 w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center">
                        <i class="fa-solid fa-sun text-slate-600 text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-bold text-gray-600">Duration</p>
                        <p class="text-sm text-sky-600"><?php echo e($durationLabel ?: '—'); ?></p>
                    </div>
                </div>
                <div class="flex gap-2">
                    <div class="flex-shrink-0 w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center">
                        <i class="fa-solid fa-suitcase text-slate-600 text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-bold text-gray-600">Ending place</p>
                        <p class="text-sm text-sky-600 truncate" title="<?php echo e($tour->end_location ?? ''); ?>"><?php echo e($tour->end_location ?? ($tour->start_location ?: '—')); ?></p>
                    </div>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tour->category): ?>
                <div class="flex gap-2">
                    <div class="flex-shrink-0 w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center">
                        <i class="fa-solid fa-route text-slate-600 text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-bold text-gray-600">Tour Type</p>
                        <p class="text-sm text-sky-600"><?php echo e($tour->category->name); ?></p>
                    </div>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tour->difficulty): ?>
                <?php
                    $difficultyLabels = ['easy' => 'Easy', 'moderate' => 'Moderate', 'challenging' => 'Challenging', 'strenuous' => 'Strenuous'];
                ?>
                <div class="flex gap-2">
                    <div class="flex-shrink-0 w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center">
                        <i class="fa-solid fa-mountain text-slate-600 text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-bold text-gray-600">Difficulty</p>
                        <p class="text-sm text-sky-600"><?php echo e($difficultyLabels[$tour->difficulty] ?? $tour->difficulty); ?></p>
                    </div>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tour->season): ?>
                <?php
                    $seasonLabels = ['summer' => 'Summer', 'winter' => 'Winter', 'all_season' => 'All Season'];
                ?>
                <div class="flex gap-2">
                    <div class="flex-shrink-0 w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center">
                        <i class="fa-solid fa-calendar-check text-slate-600 text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-bold text-gray-600">Availability</p>
                        <p class="text-sm text-sky-600"><?php echo e($seasonLabels[$tour->season] ?? $tour->season); ?></p>
                    </div>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tour->max_group_size): ?>
                <div class="flex gap-2">
                    <div class="flex-shrink-0 w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center">
                        <i class="fa-solid fa-user-group text-slate-600 text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-bold text-gray-600">Max people</p>
                        <p class="text-sm text-sky-600"><?php echo e($tour->max_group_size); ?></p>
                    </div>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tour->languages && count($tour->languages) > 0): ?>
                <div class="flex gap-2">
                    <div class="flex-shrink-0 w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center">
                        <i class="fa-solid fa-language text-slate-600 text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-bold text-gray-600">Language</p>
                        <p class="text-sm text-sky-600"><?php echo e(implode(', ', (array) $tour->languages)); ?></p>
                    </div>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <div class="prose max-w-none">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Summary</h2>
                <?php echo $tour->description; ?>

            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tour->tour_highlights && count($tour->tour_highlights) > 0): ?>
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Tour highlights</h2>
                    <ul class="space-y-3">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $tour->tour_highlights; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $highlight): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <?php $text = is_array($highlight) ? ($highlight['text'] ?? $highlight['value'] ?? '') : $highlight; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($text): ?>
                                <li class="flex items-start gap-3">
                                    <span class="flex-shrink-0 w-7 h-7 rounded flex items-center justify-center bg-lime-100 text-lime-600">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                    </span>
                                    <span class="text-gray-700"><?php echo e($text); ?></span>
                                </li>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </ul>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tour->important_notes): ?>
                <div class="rounded-xl border border-amber-200 bg-amber-50/50 p-5">
                    <h2 class="text-xl font-bold text-amber-800 mb-3 flex items-center gap-2">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        Important notes
                    </h2>
                    <div class="prose prose-sm max-w-none text-amber-900">
                        <?php echo $tour->important_notes; ?>

                    </div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tour->itineraries->isNotEmpty()): ?>
                <?php $firstId = $tour->itineraries->first()->id; ?>
                <div class="" x-data="{ openDay: <?php echo e($firstId); ?> }">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Itinerary &amp; Details</h2>
                    <div class="border border-gray-200 rounded-lg overflow-hidden divide-y divide-gray-200">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $tour->itineraries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <div class="bg-white">
                                <button type="button"
                                    @click="openDay = openDay === <?php echo e($day->id); ?> ? null : <?php echo e($day->id); ?>"
                                    :class="openDay === <?php echo e($day->id); ?> ? 'bg-gray-100' : 'bg-white hover:bg-gray-50'"
                                    class="w-full flex items-center justify-between px-4 py-4 text-left font-semibold text-gray-900 transition-colors">
                                    <span><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($day->day): ?>Day <?php echo e($day->day); ?>: <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?><?php echo e($day->title); ?></span>
                                    <span class="inline-flex w-7 h-7 flex-shrink-0 ml-2 items-center justify-center">
                                        <i class="fa-solid fa-chevron-down text-gray-500 text-base transition-transform duration-200"
                                            :class="openDay === <?php echo e($day->id); ?> ? 'rotate-180' : ''"
                                            aria-hidden="true"></i>
                                    </span>
                                </button>
                                <div x-show="openDay === <?php echo e($day->id); ?>"
                                    x-collapse
                                    class="border-t border-gray-200">
                                    <div class="px-4 py-4 text-gray-600 text-sm space-y-4">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($day->description): ?>
                                            <div class="prose prose-sm max-w-none text-gray-600">
                                                <?php echo $day->description; ?>

                                            </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                    </div>
                                </div>
                            </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tour->what_to_bring && count($tour->what_to_bring) > 0): ?>
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-3">What to bring</h2>
                    <ul class="space-y-2">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = (array) $tour->what_to_bring; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <li class="flex items-start gap-3">
                                <span class="flex-shrink-0 w-7 h-7 rounded flex items-center justify-center bg-sky-100 text-sky-600">
                                    <i class="fa-solid fa-suitcase text-sm"></i>
                                </span>
                                <span class="text-gray-700"><?php echo e($item); ?></span>
                            </li>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </ul>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tour->included || $tour->not_included): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-12">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tour->included): ?>
                        <div>
                            <h2 class="text-3xl font-bold text-gray-900 mb-3">Included</h2>
                            <ul class="space-y-2">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = (array) $tour->included; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                    <li class="flex items-start gap-3">
                                        <span class="flex-shrink-0 w-7 h-7 rounded flex items-center justify-center bg-lime-100 text-lime-600">
                                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                        </span>
                                        <span class="text-gray-700"><?php echo e($item); ?></span>
                                    </li>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </ul>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tour->not_included): ?>
                        <div>
                            <h2 class="text-3xl font-bold text-gray-900 mb-3">Not included</h2>
                            <ul class="space-y-2">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = (array) $tour->not_included; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                    <li class="flex items-start gap-3">
                                        <span class="flex-shrink-0 w-7 h-7 rounded flex items-center justify-center bg-red-100 text-red-600">
                                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                        </span>
                                        <span class="text-gray-700"><?php echo e($item); ?></span>
                                    </li>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </ul>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            
            <?php
                $reviews = $tour->approvedReviews;
                $avgRating = (float) $tour->average_rating;
                $reviewCount = $tour->approvedReviews->count();
            ?>
            <div>
                <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-6 mb-8">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900">Customer reviews</h2>
                        <p class="mt-1 text-base text-gray-600">
                            Read what real customers had to say about <strong class="font-bold text-gray-900"><?php echo e($tour->title); ?>.</strong>
                        </p>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($reviewCount > 0): ?>
                    <div class="flex-shrink-0 w-full md:w-auto md:min-w-[200px]">
                        <div class="rounded-xl p-5 text-white bg-lime-900">
                            <p class="text-sm">Overall rating for this trip</p>
                            <?php
                                $fullStars = (int) floor($avgRating);
                                $halfStar = ($avgRating - $fullStars) >= 0.5;
                                $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                            ?>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-4xl font-bold"><?php echo e(number_format($avgRating, 1)); ?></span>
                                <span class="flex items-center -mt-1" aria-hidden="true">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($i = 0; $i < $fullStars; $i++): ?>
                                        <svg class="w-7 h-7 text-amber-400 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($halfStar): ?>
                                        <svg class="w-7 h-7 text-amber-400 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><defs><linearGradient id="half-overall"><stop offset="50%" stop-color="currentColor"/><stop offset="50%" stop-color="rgba(255,255,255,0.4)"/></linearGradient></defs><path fill="url(#half-overall)" d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($i = 0; $i < $emptyStars; $i++): ?>
                                        <svg class="w-7 h-7 text-white/40 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </span>
                            </div>
                            <p class="text-sm mt-1 text-white/80">based on <?php echo e($reviewCount); ?> <?php echo e(Str::plural('review', $reviewCount)); ?></p>
                        </div>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                
                <div class="space-y-5 mb-8">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <?php
                            $name = $review->display_name;
                            $words = explode(' ', trim($name), 2);
                            $initials = count($words) >= 2
                                ? strtoupper(mb_substr($words[0], 0, 1) . mb_substr($words[1], 0, 1))
                                : strtoupper(mb_substr($name, 0, 2));
                            if ($initials === '') { $initials = '?'; }
                            $displayDate = $review->display_date;
                        ?>
                        <div class="border border-gray-100 rounded-xl p-5 md:p-6 bg-white shadow-sm relative" x-data="{ expanded: false }">
                            <?php if (isset($component)) { $__componentOriginal1e897b58e787f88086462b791c9c866c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1e897b58e787f88086462b791c9c866c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.review-platform-logo','data' => ['platform' => $review->platform,'url' => $review->platform_tour_url]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('review-platform-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['platform' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($review->platform),'url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($review->platform_tour_url)]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1e897b58e787f88086462b791c9c866c)): ?>
<?php $attributes = $__attributesOriginal1e897b58e787f88086462b791c9c866c; ?>
<?php unset($__attributesOriginal1e897b58e787f88086462b791c9c866c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1e897b58e787f88086462b791c9c866c)): ?>
<?php $component = $__componentOriginal1e897b58e787f88086462b791c9c866c; ?>
<?php unset($__componentOriginal1e897b58e787f88086462b791c9c866c); ?>
<?php endif; ?>
                            <div class="flex gap-4 <?php echo e($review->platform ? 'pr-12' : ''); ?>">
                                <div class="w-12 h-12 rounded-full bg-gray-700 flex items-center justify-center text-white text-sm font-semibold flex-shrink-0">
                                    <?php echo e($initials); ?>

                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="font-medium text-gray-900">
                                        <?php echo e($name); ?>

                                        <span class="text-gray-500 font-normal"> <?php echo e($displayDate->format('d/m/Y')); ?></span>
                                    </p>
                                    <div class="mt-1.5 flex items-center gap-0.5" aria-label="Rating: <?php echo e($review->rating); ?> out of 5">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($i = 0; $i < min(5, (int) $review->rating); $i++): ?>
                                            <i class="fa-solid fa-star text-amber-400 text-sm"></i>
                                        <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($i = (int) $review->rating; $i < 5; $i++): ?>
                                            <i class="fa-regular fa-star text-gray-300 text-sm"></i>
                                        <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($review->title): ?>
                                        <h3 class="font-bold text-lg text-gray-900 mt-3"><?php echo e($review->title); ?></h3>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <div class="mt-2 text-gray-600">
                                        <p :class="expanded ? '' : 'line-clamp-4'"><?php echo e($review->comment); ?></p>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(strlen($review->comment) > 280): ?>
                                            <button type="button" @click="expanded = !expanded" class="text-lime-600 hover:text-lime-700 hover:underline mt-1 text-sm font-medium" x-text="expanded ? 'Show less' : 'Show more'"></button>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($userHasReviewed ?? false): ?>
                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-6 text-center">
                            <p class="text-gray-600">You have already reviewed this tour. Thank you!</p>
                        </div>
                    <?php else: ?>
                        <div class="rounded-xl border border-gray-200 bg-white p-6 md:p-8 shadow-sm">
                            <h3 class="text-xl font-bold text-gray-900 mb-6">Leave a review</h3>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
                                <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-lg text-sm"><?php echo e(session('error')); ?></div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
                                <div class="mb-6 p-4 bg-lime-50 text-lime-800 rounded-lg text-sm flex items-center gap-2">
                                    <i class="fa-solid fa-circle-check text-lime-600"></i>
                                    <?php echo e(session('success')); ?>

                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <form action="<?php echo e(route('reviews.store', $tour)); ?>" method="POST" class="space-y-6" x-data="{ rating: <?php echo e(old('rating', 0)); ?> }" x-init="if(rating) $refs.ratingInput.value = rating">
                                <?php echo csrf_field(); ?>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Your overall rating <span class="text-red-500">*</span></label>
                                    <div class="flex items-center gap-1">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($i = 1; $i <= 5; $i++): ?>
                                            <button type="button" @click="rating = <?php echo e($i); ?>; $refs.ratingInput.value = <?php echo e($i); ?>"
                                                class="p-1 focus:outline-none transition-colors">
                                                <i class="text-xl" :class="rating >= <?php echo e($i); ?> ? 'fa-solid fa-star text-amber-400' : 'fa-regular fa-star text-gray-300'"></i>
                                            </button>
                                        <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                    <input type="hidden" name="rating" x-ref="ratingInput" value="<?php echo e(old('rating', '')); ?>" required>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['rating'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                                <div>
                                    <label for="review_title" class="block text-sm font-medium text-gray-700 mb-1.5">Title of your review <span class="text-red-500">*</span></label>
                                    <input type="text" name="title" id="review_title" value="<?php echo e(old('title')); ?>" required
                                        placeholder="Summarize your review or highlight an interesting detail"
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-lime-500 focus:ring-lime-500">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                                <div>
                                    <label for="review_comment" class="block text-sm font-medium text-gray-700 mb-1.5">Your review <span class="text-red-500">*</span></label>
                                    <textarea name="comment" id="review_comment" rows="5" required
                                        placeholder="Tell people your review"
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-lime-500 focus:ring-lime-500 resize-y"><?php echo e(old('comment')); ?></textarea>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['comment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                                <button type="submit" class="px-6 py-3 bg-brand-btn hover:bg-brand-btn-hover text-white font-medium rounded-lg transition-colors">
                                    Submit Review
                                </button>
                            </form>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php else: ?>
                    <div class="rounded-xl border border-gray-200 bg-white p-6 md:p-8 shadow-sm text-center">
                        <p class="text-gray-600 mb-5">To leave a review you need to log in.</p>
                        <a href="<?php echo e(route('login')); ?>" class="inline-flex items-center px-6 py-3 bg-brand-btn hover:bg-brand-btn-hover text-white font-medium rounded-lg transition-colors">
                            Log in to your account
                        </a>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        <div class="lg:col-span-1 space-y-6 pt-0 lg:pt-[83px]">
            <!-- <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                <?php $inWishlist = auth()->user()->wishlistTours()->where('tour_id', $tour->id)->exists(); ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($inWishlist): ?>
                    <form action="<?php echo e(route('wishlist.destroy', $tour)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="w-full py-2 border border-gray-300 rounded-lg text-gray-700 text-sm font-medium hover:bg-gray-50">Remove from wishlist</button>
                    </form>
                <?php else: ?>
                    <form action="<?php echo e(route('wishlist.store', $tour)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="w-full py-2 border border-brand-btn text-brand-btn rounded-lg text-sm font-medium hover:bg-brand-btn/10">Add to wishlist</button>
                    </form>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?> -->
            <div id="booking-form" class="lg:sticky lg:top-24 lg:self-start scroll-mt-12">
                <?php if (isset($component)) { $__componentOriginalb3878c00709e8b50c0308cf806f1037c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb3878c00709e8b50c0308cf806f1037c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.booking-sidebar','data' => ['tour' => $tour,'defaultDate' => request('date'),'defaultGuests' => request('adults', 2)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('booking-sidebar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tour' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tour),'defaultDate' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request('date')),'defaultGuests' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request('adults', 2))]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb3878c00709e8b50c0308cf806f1037c)): ?>
<?php $attributes = $__attributesOriginalb3878c00709e8b50c0308cf806f1037c; ?>
<?php unset($__attributesOriginalb3878c00709e8b50c0308cf806f1037c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb3878c00709e8b50c0308cf806f1037c)): ?>
<?php $component = $__componentOriginalb3878c00709e8b50c0308cf806f1037c; ?>
<?php unset($__componentOriginalb3878c00709e8b50c0308cf806f1037c); ?>
<?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php if (isset($component)) { $__componentOriginalc039732f1570c441d40b029a31f434e2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc039732f1570c441d40b029a31f434e2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.mobile-booking-bar','data' => ['tour' => $tour]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('mobile-booking-bar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tour' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tour)]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc039732f1570c441d40b029a31f434e2)): ?>
<?php $attributes = $__attributesOriginalc039732f1570c441d40b029a31f434e2; ?>
<?php unset($__attributesOriginalc039732f1570c441d40b029a31f434e2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc039732f1570c441d40b029a31f434e2)): ?>
<?php $component = $__componentOriginalc039732f1570c441d40b029a31f434e2; ?>
<?php unset($__componentOriginalc039732f1570c441d40b029a31f434e2); ?>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<?php echo app('Illuminate\Foundation\Vite')(['resources/js/tour-gallery.js']); ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.site', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\Projects\TOP7\topseven\resources\views\pages\tours\show.blade.php ENDPATH**/ ?>