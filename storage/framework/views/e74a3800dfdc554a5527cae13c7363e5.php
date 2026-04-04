<?php $__env->startSection('title', $post->meta_title ?: $post->title . ' - ' . config('app.name')); ?>
<?php $__env->startSection('description', $post->meta_description ?: Str::limit(strip_tags($post->excerpt ?? ''), 160)); ?>

<?php $__env->startSection('content'); ?>
<div class="relative w-full overflow-hidden bg-[#111827]" style="height: 340px;">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($post->featured_image): ?>
        <div class="absolute inset-0 bg-cover bg-center opacity-35" style="background-image: url('<?php echo e(\Illuminate\Support\Facades\Storage::disk('public')->url($post->featured_image)); ?>');"></div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <div class="absolute inset-0 bg-gradient-to-t from-[#111827]/80 via-transparent to-[#111827]/40"></div>
    <div class="absolute inset-0 flex items-end">
        <div class="max-w-[900px] mx-auto px-4 sm:px-6 lg:px-8 w-full pb-12">
            <nav class="text-sm mb-4" aria-label="Breadcrumb">
                <ol class="flex items-center gap-1.5">
                    <li><a href="<?php echo e(route('home')); ?>" class="text-white/60 hover:text-white transition">Home</a></li>
                    <li class="text-white/40">/</li>
                    <li><a href="<?php echo e(route('blog.index')); ?>" class="text-white/60 hover:text-white transition">Blog</a></li>
                    <li class="text-white/40">/</li>
                    <li class="text-white truncate max-w-[200px]"><?php echo e($post->title); ?></li>
                </ol>
            </nav>
            <div class="flex items-center gap-3 text-[12px] text-white/50 uppercase tracking-wider mb-3">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($post->category): ?>
                    <span class="font-semibold text-white/80"><?php echo e($post->category->name); ?></span>
                    <span>&bull;</span>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <span><?php echo e($post->published_at?->format('F j, Y')); ?></span>
            </div>
            <h1 class="text-3xl md:text-5xl font-serif text-white tracking-tight leading-[1.1]"><?php echo e($post->title); ?></h1>
        </div>
    </div>
</div>

<article class="max-w-[900px] mx-auto px-4 sm:px-6 lg:px-8 py-14">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($post->featured_image): ?>
        <img src="<?php echo e(\Illuminate\Support\Facades\Storage::disk('public')->url($post->featured_image)); ?>" alt="<?php echo e($post->title); ?>" class="w-full mb-10" style="aspect-ratio: 16/9; object-fit: cover;">
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <div class="blog-content prose prose-lg max-w-none prose-headings:font-serif prose-headings:text-[#111827] prose-p:text-[#4a4a4a] prose-p:leading-[1.8] prose-a:text-[#111827] prose-a:underline prose-a:underline-offset-4">
        <?php echo $post->content; ?>

    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($post->category || $post->tags->isNotEmpty()): ?>
    <div class="mt-14 pt-8 border-t border-[#e6e1d8]">
        <div class="flex flex-wrap flex-col items-left gap-4 text-sm">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($post->category): ?>
                <div class="flex items-center gap-3">
                    <span class="text-[11px] font-semibold uppercase tracking-wider text-[#111827]/50">Category</span>
                    <a href="<?php echo e(route('blog.index', ['category' => $post->category->slug])); ?>" class="inline-flex items-center px-4 py-1.5 bg-[#f8f6f2] text-[#111827] text-sm font-semibold hover:bg-[#eee9df] transition-colors"><?php echo e($post->category->name); ?></a>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($post->tags->isNotEmpty()): ?>
                <div class="flex items-center gap-3 flex-wrap">
                    <span class="text-[11px] font-semibold uppercase tracking-wider text-[#111827]/50">Tags</span>
                    <div class="flex flex-wrap gap-2">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $post->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <a href="<?php echo e(route('blog.index', ['tag' => $tag->slug])); ?>" class="inline-flex items-center px-4 py-1.5 bg-[#f8f6f2] text-[#111827] text-sm font-medium hover:bg-[#eee9df] transition-colors"><?php echo e($tag->name); ?></a>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</article>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($related->isNotEmpty()): ?>
<section class="border-t border-[#e6e1d8] bg-[#f8f6f2]">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <h2 class="text-3xl font-serif text-[#111827] mb-8">Related articles</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $related; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <?php
                    $relImageUrl = $p->featured_image
                        ? \Illuminate\Support\Facades\Storage::disk('public')->url($p->featured_image)
                        : 'https://placehold.co/600x400/e5e7eb/6b7280?text=Blog';
                ?>
                <article class="group">
                    <a href="<?php echo e(route('blog.show', $p->slug)); ?>" class="block">
                        <div class="aspect-[16/10] overflow-hidden bg-gray-100">
                            <img src="<?php echo e($relImageUrl); ?>" alt="<?php echo e($p->title); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                        </div>
                        <div class="pt-5">
                            <p class="text-[12px] text-[#111827]/50 uppercase tracking-wider mb-2"><?php echo e(($p->published_at ?? $p->created_at)?->format('M d, Y')); ?></p>
                            <h3 class="text-xl font-serif text-[#111827] line-clamp-2 leading-snug group-hover:underline decoration-1 underline-offset-4"><?php echo e($p->title); ?></h3>
                        </div>
                    </a>
                </article>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.site', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/kevinhitaj/Desktop/Projects/TOP 7 TRAVEL/resources/views/pages/blog/show.blade.php ENDPATH**/ ?>