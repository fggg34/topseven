<?php $__env->startSection('title', 'Blog - ' . config('app.name')); ?>
<?php $__env->startSection('description', 'Travel tips, destination guides and news.'); ?>

<?php $__env->startSection('content'); ?>
<div class="relative w-full overflow-hidden bg-[#111827]" style="height: 380px;">
    <div class="absolute inset-0 bg-cover bg-center opacity-40" style="background-image: url('https://images.unsplash.com/photo-1488085061387-422e29b40080?w=1920&h=600&fit=crop');"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-[#111827]/80 via-transparent to-[#111827]/40"></div>
    <div class="absolute inset-0 flex items-end">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 w-full pb-12">
            <nav class="text-sm mb-4" aria-label="Breadcrumb">
                <ol class="flex items-center gap-1.5">
                    <li><a href="<?php echo e(route('home')); ?>" class="text-white/60 hover:text-white transition">Home</a></li>
                    <li class="text-white/40">/</li>
                    <li class="text-white">Blog</li>
                </ol>
            </nav>
            <h1 class="text-4xl md:text-6xl font-serif text-white tracking-tight">Stories & Guides</h1>
            <p class="mt-3 text-lg text-white/70 max-w-xl">Discover travel inspiration, insider tips, and destination guides curated by our experts.</p>
        </div>
    </div>
</div>

<div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-20">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($categories->isNotEmpty()): ?>
        <div class="flex flex-wrap items-center gap-3 mb-12">
            <a href="<?php echo e(route('blog.index')); ?>"
               class="px-5 py-2.5 text-sm font-semibold tracking-wider uppercase transition-colors <?php echo e(!request('category') ? 'bg-[#111827] text-white' : 'bg-transparent border border-[#d1cdc4] text-[#111827] hover:bg-[#111827] hover:text-white hover:border-[#111827]'); ?>">
                All
            </a>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <a href="<?php echo e(route('blog.index', ['category' => $c->slug])); ?>"
                   class="px-5 py-2.5 text-sm font-semibold tracking-wider uppercase transition-colors <?php echo e(request('category') === $c->slug ? 'bg-[#111827] text-white' : 'bg-transparent border border-[#d1cdc4] text-[#111827] hover:bg-[#111827] hover:text-white hover:border-[#111827]'); ?>">
                    <?php echo e($c->name); ?>

                </a>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <?php
                $imageUrl = $post->featured_image
                    ? \Illuminate\Support\Facades\Storage::disk('public')->url($post->featured_image)
                    : 'https://placehold.co/600x400/e5e7eb/6b7280?text=Blog';
            ?>
            <article class="group">
                <a href="<?php echo e(route('blog.show', $post->slug)); ?>" class="block">
                    <div class="aspect-[16/10] overflow-hidden bg-gray-100">
                        <img src="<?php echo e($imageUrl); ?>" alt="<?php echo e($post->title); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                    </div>
                    <div class="pt-5">
                        <div class="flex items-center gap-3 text-[12px] text-[#111827]/50 uppercase tracking-wider mb-3">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($post->category): ?>
                                <span class="font-semibold text-[#111827]"><?php echo e($post->category->name); ?></span>
                                <span>&bull;</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <span><?php echo e(($post->published_at ?? $post->created_at)?->format('M d, Y')); ?></span>
                        </div>
                        <h3 class="text-xl font-serif text-[#111827] line-clamp-2 leading-snug group-hover:underline decoration-1 underline-offset-4"><?php echo e($post->title); ?></h3>
                        <p class="mt-3 text-[15px] text-[#6a6a6a] line-clamp-3 leading-relaxed"><?php echo e(Str::limit(strip_tags($post->excerpt ?? $post->content ?? ''), 150)); ?></p>
                        <span class="inline-block mt-4 text-[13px] font-semibold uppercase tracking-wider text-[#111827] border-b border-[#111827]">Read article</span>
                    </div>
                </a>
            </article>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <div class="col-span-full text-center py-20">
                <p class="text-lg text-[#6a6a6a] font-serif">No articles yet. Check back soon for travel stories and guides.</p>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <div class="mt-12">
        <?php echo e($posts->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.site', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/kevinhitaj/Desktop/Projects/TOP 7 TRAVEL/resources/views/pages/blog/index.blade.php ENDPATH**/ ?>