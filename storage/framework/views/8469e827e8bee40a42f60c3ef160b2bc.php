<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo $__env->yieldContent('title', config('app.name')); ?></title>

        <?php echo $__env->make('layouts.partials.favicon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-900">
        <?php echo $__env->make('layouts.partials.site-nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <main class="py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-sm mx-auto">
                <a href="<?php echo e(route('home')); ?>" class="block text-center mb-8">
                    <span class="text-2xl font-bold text-lime-600"><?php echo e(\App\Models\Setting::get('site_name', config('app.name'))); ?></span>
                </a>

                <div class="bg-white shadow-lg rounded-md overflow-hidden border border-gray-200">
                    <div class="px-10 py-12">
                        <?php echo e($slot); ?>

                    </div>
                </div>
            </div>
        </main>

        <?php echo $__env->make('layouts.partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </body>
</html>
<?php /**PATH /Users/kevinhitaj/Desktop/Projects/TOP 7 TRAVEL/resources/views/layouts/guest.blade.php ENDPATH**/ ?>