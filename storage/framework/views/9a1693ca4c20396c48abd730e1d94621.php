<?php
    $heroTitle = \App\Models\Setting::get('page_contact_hero_title', 'Get in touch');
    $heroSubtitle = \App\Models\Setting::get('page_contact_hero_subtitle', "We'd love to hear from you");
    $heroImage = \App\Models\Setting::get('page_contact_hero_image', '');
    $heroBg = $heroImage ? \Illuminate\Support\Facades\Storage::disk('public')->url($heroImage) : 'https://images.unsplash.com/photo-1423666639041-f56000c27a9a?w=1920&h=600&fit=crop';
    $formTitle = \App\Models\Setting::get('page_contact_form_title', 'Send us a message');
    $formDescription = \App\Models\Setting::get('page_contact_form_description', "Fill out the form below and we'll get back to you as soon as possible.");
    $sidebarTitle = \App\Models\Setting::get('page_contact_sidebar_title', 'Need quick help?');
    $sidebarDescription = \App\Models\Setting::get('page_contact_sidebar_description', 'Check our frequently asked questions for instant answers.');
    $sidebarButtonText = \App\Models\Setting::get('page_contact_sidebar_button_text', 'Browse tours');
    $sidebarButtonUrl = \App\Models\Setting::get('page_contact_sidebar_button_url', '') ?: route('tours.index');
?>


<?php $__env->startSection('title', \App\Models\Setting::get('page_contact_seo_title') ?: ('Contact - ' . config('app.name'))); ?>
<?php $__env->startSection('description', \App\Models\Setting::get('page_contact_seo_description') ?: 'Get in touch with us.'); ?>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(\App\Models\Setting::get('page_contact_seo_og_image')): ?><?php $__env->startSection('og_image', \App\Models\Setting::get('page_contact_seo_og_image')); ?><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<?php $__env->startSection('content'); ?>

<div class="relative w-full overflow-hidden bg-brand-footer" style="height: 320px;">
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('<?php echo e($heroBg); ?>');"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
    <div class="absolute inset-0 flex items-end">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full pb-10">
            <nav class="text-sm mb-4" aria-label="Breadcrumb">
                <ol class="flex items-center gap-1.5">
                    <li><a href="<?php echo e(route('home')); ?>" class="text-white/70 hover:text-white transition">Home</a></li>
                    <li class="text-white/50">/</li>
                    <li class="text-white">Contact</li>
                </ol>
            </nav>
            <h1 class="text-4xl md:text-5xl font-bold text-white" style="color: #fff !important;"><?php echo e($heroTitle); ?></h1>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($heroSubtitle): ?>
                <p class="mt-2 text-lg text-white/80"><?php echo e($heroSubtitle); ?></p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-12">

        
        <div class="lg:col-span-3">
            <h2 class="text-2xl font-bold text-gray-900 mb-2"><?php echo e($formTitle); ?></h2>
            <p class="text-gray-500 mb-8"><?php echo e($formDescription); ?></p>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
                <div class="mb-6 p-4 bg-green-50 text-green-800 rounded-xl border border-green-100 flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-green-500"></i>
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <form action="<?php echo e(route('contact.store')); ?>" method="POST" class="space-y-5">
                <?php echo csrf_field(); ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Name</label>
                        <input type="text" name="name" id="name" value="<?php echo e(old('name')); ?>" required
                            class="w-full rounded-xl border-gray-300 shadow-sm focus:border-lime-500 focus:ring-lime-500 py-3"
                            placeholder="Your name">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                        <input type="email" name="email" id="email" value="<?php echo e(old('email')); ?>" required
                            class="w-full rounded-xl border-gray-300 shadow-sm focus:border-lime-500 focus:ring-lime-500 py-3"
                            placeholder="your@email.com">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700 mb-1.5">Subject</label>
                    <input type="text" name="subject" id="subject" value="<?php echo e(old('subject')); ?>" required
                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-lime-500 focus:ring-lime-500 py-3"
                        placeholder="How can we help?">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['subject'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-1.5">Message</label>
                    <textarea name="message" id="message" rows="5" required
                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-lime-500 focus:ring-lime-500"
                        placeholder="Tell us more about your inquiry..."><?php echo e(old('message')); ?></textarea>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <button type="submit" class="px-8 py-3.5 bg-brand-btn hover:bg-brand-btn-hover text-white font-medium rounded-xl transition-colors">
                    Send message
                </button>
            </form>
        </div>

        
        <div class="lg:col-span-2">
            <div class="sticky top-24 space-y-6">
                <div class="rounded-2xl bg-white border border-gray-100 p-8">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">Contact details</h3>
                    <div class="space-y-5">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(\App\Models\Setting::get('contact_email')): ?>
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-white border border-gray-100 flex items-center justify-center flex-shrink-0 shadow-sm">
                                <i class="fa-solid fa-envelope text-brand-btn"></i>
                            </div>
                            <div>
                                <p class="text-xs font-medium uppercase tracking-wider text-gray-400 mb-0.5">Email</p>
                                <a href="mailto:<?php echo e(\App\Models\Setting::get('contact_email')); ?>" class="text-sm text-gray-700 hover:text-brand-btn transition break-all"><?php echo e(\App\Models\Setting::get('contact_email')); ?></a>
                            </div>
                        </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(\App\Models\Setting::get('contact_phone')): ?>
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-white border border-gray-100 flex items-center justify-center flex-shrink-0 shadow-sm">
                                <i class="fa-solid fa-phone text-brand-btn"></i>
                            </div>
                            <div>
                                <p class="text-xs font-medium uppercase tracking-wider text-gray-400 mb-0.5">Phone</p>
                                <a href="tel:<?php echo e(\App\Models\Setting::get('contact_phone')); ?>" class="text-sm text-gray-700 hover:text-brand-btn transition"><?php echo e(\App\Models\Setting::get('contact_phone')); ?></a>
                            </div>
                        </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(\App\Models\Setting::get('contact_address')): ?>
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-white border border-gray-100 flex items-center justify-center flex-shrink-0 shadow-sm">
                                <i class="fa-solid fa-location-dot text-brand-btn"></i>
                            </div>
                            <div>
                                <p class="text-xs font-medium uppercase tracking-wider text-gray-400 mb-0.5">Address</p>
                                <p class="text-sm text-gray-700"><?php echo e(\App\Models\Setting::get('contact_address')); ?></p>
                            </div>
                        </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                
                <div class="rounded-2xl bg-white border border-gray-100 p-8 text-center">
                    <i class="fa-solid fa-headset text-3xl text-brand-btn mb-4"></i>
                    <h3 class="text-lg font-bold text-gray-900 mb-2"><?php echo e($sidebarTitle); ?></h3>
                    <p class="text-sm text-gray-500 mb-5"><?php echo e($sidebarDescription); ?></p>
                    <a href="<?php echo e($sidebarButtonUrl); ?>" class="inline-flex px-6 py-2.5 bg-brand-btn hover:bg-brand-btn-hover text-white text-sm font-medium rounded-lg transition-colors">
                        <?php echo e($sidebarButtonText); ?>

                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.site', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\Projects\TOP7\topseven\resources\views\pages\contact.blade.php ENDPATH**/ ?>