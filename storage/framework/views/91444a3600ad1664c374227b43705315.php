<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['post']));

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

foreach (array_filter((['post']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $imageUrl = $post->featured_image
        ? \Illuminate\Support\Facades\Storage::disk('public')->url($post->featured_image)
        : 'https://placehold.co/600x400/e5e7eb/6b7280?text=Blog';
?>
<article class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
    <a href="<?php echo e(route('blog.show', $post->slug)); ?>" class="block">
        <div class="aspect-[16/10] overflow-hidden rounded-t-lg bg-gray-200">
            <img src="<?php echo e($imageUrl); ?>" alt="<?php echo e($post->title); ?>" class="w-full h-full object-cover" loading="lazy">
        </div>
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 line-clamp-2 leading-snug"><?php echo e($post->title); ?></h3>
            <p class="mt-3 text-sm text-gray-600 line-clamp-3 leading-relaxed"><?php echo e(Str::limit(strip_tags($post->excerpt ?? $post->content ?? ''), 150)); ?></p>
            <p class="mt-4 text-xs text-gray-500"><?php echo e($post->published_at?->format('M d Y')); ?></p>
        </div>
    </a>
</article>
<?php /**PATH /Users/kevinhitaj/Desktop/Projects/TOP 7 TRAVEL/resources/views/components/blog-card.blade.php ENDPATH**/ ?>