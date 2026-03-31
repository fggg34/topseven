<?php $__env->startSection('title', 'Our Packages - ' . config('app.name')); ?>
<?php $__env->startSection('description', 'Browse our tour packages and discover amazing experiences.'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl md:text-4xl font-bold text-lime-900 mb-8">Our Packages</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
        <?php
            $imageUrl = $package->image_url ? asset($package->image_url) : 'https://placehold.co/400x300/e5e7eb/6b7280?text=' . urlencode($package->title);
            $linkUrl = $package->instagram_post_url ?: '#';
        ?>
        <a href="<?php echo e($linkUrl); ?>" target="<?php echo e($package->instagram_post_url ? '_blank' : '_self'); ?>" rel="<?php echo e($package->instagram_post_url ? 'noopener noreferrer' : ''); ?>"
           class="group block rounded-xl overflow-hidden bg-gray-200 border border-gray-200 hover:border-lime-300 hover:shadow-lg transition-all duration-300">
            <img src="<?php echo e($imageUrl); ?>" alt="<?php echo e($package->title); ?>"
                 class="w-full h-auto object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
        </a>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <p class="col-span-full text-gray-500 text-center py-12">No packages yet.</p>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.site', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/kevinhitaj/Desktop/Projects/TOP 7 TRAVEL/resources/views/pages/tour-packages/index.blade.php ENDPATH**/ ?>