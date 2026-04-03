<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <?php echo $__env->yieldPushContent('meta'); ?>
    <title><?php echo $__env->yieldContent('title', config('app.name')); ?></title>
    <meta name="description" content="<?php echo $__env->yieldContent('description', \App\Models\Setting::get('site_tagline', 'Discover your next adventure')); ?>">
    <link rel="canonical" href="<?php echo e(request()->url()); ?>">
    <?php
        $ogImage = trim((string) view()->yieldContent('og_image'));
        $ogImage = $ogImage ?: \App\Models\Setting::get('seo_og_image', '');
        $ogImageUrl = $ogImage ? asset('storage/' . ltrim($ogImage, '/')) : '';
        $ogTitle = strip_tags(trim((string) view()->yieldContent('title', ''))) ?: \App\Models\Setting::get('seo_default_title', \App\Models\Setting::get('site_name', config('app.name')));
        $ogDescription = strip_tags(trim((string) view()->yieldContent('description', ''))) ?: \App\Models\Setting::get('seo_default_description', \App\Models\Setting::get('site_tagline', 'Discover your next adventure'));
    ?>
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?php echo e($ogTitle); ?>">
    <meta property="og:description" content="<?php echo e($ogDescription); ?>">
    <meta property="og:url" content="<?php echo e(request()->url()); ?>">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($ogImageUrl): ?><meta property="og:image" content="<?php echo e($ogImageUrl); ?>"><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php echo $__env->make('layouts.partials.favicon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link href="https://fonts.bunny.net/css?family=playfair-display:400,500,600,700&display=swap" rel="stylesheet" />
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="font-sans antialiased bg-gray-50 text-[#0f1406]">
    <?php echo $__env->make('layouts.partials.site-nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php echo $__env->yieldContent('hero'); ?>

    <main class="<?php echo \Illuminate\Support\Arr::toCssClasses(['pt-[78px]' => ! request()->routeIs('home')]); ?>">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <?php echo $__env->make('layouts.partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\Administrator\Desktop\Projects\TOP7\topseven\resources\views/layouts/site.blade.php ENDPATH**/ ?>