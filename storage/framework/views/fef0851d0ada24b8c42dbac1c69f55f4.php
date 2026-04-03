<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo $__env->yieldContent('title', config('app.name')); ?></title>

        <?php echo $__env->make('layouts.partials.favicon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
        <?php echo $__env->yieldPushContent('styles'); ?>
    </head>
    <body class="font-sans antialiased bg-[#f5f3ef] text-gray-900">
        <?php echo $__env->make('layouts.partials.site-nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <main class="pt-28 pb-16 md:pb-20 px-4 sm:px-6 lg:px-8 min-h-[calc(100vh-8rem)]">
            <div class="max-w-xl mx-auto">
                <?php $siteName = \App\Models\Setting::get('site_name', config('app.name')); ?>
                <a href="<?php echo e(route('home')); ?>" class="block text-center mb-8 group">
                    <span class="text-2xl sm:text-3xl font-serif font-semibold text-[#111827] tracking-tight group-hover:text-lime-800 transition-colors"><?php echo e($siteName); ?></span>
                </a>

                <div class="rounded-[28px] bg-white border border-[#e6e1d8] shadow-xl shadow-black/5 overflow-hidden">
                    <div class="px-8 py-10 sm:px-10 sm:py-12">
                        <?php echo e($slot); ?>

                    </div>
                </div>

                <p class="text-center mt-8 text-sm text-gray-500 flex flex-wrap items-center justify-center gap-x-3 gap-y-1">
                    <a href="<?php echo e(route('dashboard')); ?>" class="text-[#111827] font-medium hover:text-lime-700 transition-colors">← <?php echo e(__('My account')); ?></a>
                    <span class="text-gray-300" aria-hidden="true">·</span>
                    <a href="<?php echo e(route('home')); ?>" class="text-gray-600 hover:text-[#111827] font-medium transition-colors"><?php echo e(__('Site home')); ?></a>
                </p>
            </div>
        </main>

        <?php echo $__env->make('layouts.partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->yieldPushContent('scripts'); ?>
    </body>
</html>
<?php /**PATH C:\Users\Administrator\Desktop\Projects\TOP7\topseven\resources\views/layouts/account.blade.php ENDPATH**/ ?>