<?php
    $heroTitle = \App\Models\Setting::get('page_contact_hero_title', __('Get in touch'));
    $heroSubtitle = \App\Models\Setting::get('page_contact_hero_subtitle', __("We'd love to hear from you"));
    $heroImage = \App\Models\Setting::get('page_contact_hero_image', '');
    $heroBg = $heroImage ? \Illuminate\Support\Facades\Storage::disk('public')->url($heroImage) : 'https://images.unsplash.com/photo-1423666639041-f56000c27a9a?w=1920&h=600&fit=crop';
    $formTitle = \App\Models\Setting::get('page_contact_form_title', __('Send us a message'));
    $formDescription = \App\Models\Setting::get('page_contact_form_description', __("Fill out the form below and we'll get back to you as soon as possible."));
    $sidebarTitle = \App\Models\Setting::get('page_contact_sidebar_title', __('Need quick help?'));
    $sidebarDescription = \App\Models\Setting::get('page_contact_sidebar_description', __('Check our frequently asked questions for instant answers.'));
    $sidebarButtonText = \App\Models\Setting::get('page_contact_sidebar_button_text', __('Browse travel packages'));
    $sidebarButtonUrl = \App\Models\Setting::get('page_contact_sidebar_button_url', '') ?: route('tours.index');
    $contactEmail = \App\Models\Setting::get('contact_email');
    $contactPhone = \App\Models\Setting::get('contact_phone');
    $contactAddress = \App\Models\Setting::get('contact_address');
?>


<?php $__env->startSection('title', \App\Models\Setting::get('page_contact_seo_title') ?: ('Contact - ' . config('app.name'))); ?>
<?php $__env->startSection('description', \App\Models\Setting::get('page_contact_seo_description') ?: __('Get in touch with us.')); ?>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(\App\Models\Setting::get('page_contact_seo_og_image')): ?><?php $__env->startSection('og_image', \App\Models\Setting::get('page_contact_seo_og_image')); ?><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<?php $__env->startSection('content'); ?>


<section class="relative w-full overflow-hidden rounded-b-[40px]" style="height: 440px;">
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('<?php echo e($heroBg); ?>');"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/25 to-transparent"></div>
    <div class="absolute inset-0 flex flex-col justify-end">
        <div class="w-full max-w-none px-4 sm:px-6 md:px-[80px] pb-12 md:pb-14">
            <nav class="text-sm mb-5 opacity-70" aria-label="<?php echo e(__('Breadcrumb')); ?>">
                <ol class="flex items-center gap-1.5 text-white/80">
                    <li><a href="<?php echo e(route('home')); ?>" class="hover:text-white transition"><?php echo e(__('Home')); ?></a></li>
                    <li>/</li>
                    <li><?php echo e(__('Contact')); ?></li>
                </ol>
            </nav>
            <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold text-white tracking-tight leading-[1.08]"><?php echo e($heroTitle); ?></h1>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($heroSubtitle): ?>
                <p class="mt-4 text-lg text-white/70 max-w-lg leading-relaxed"><?php echo e($heroSubtitle); ?></p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</section>


<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($contactEmail || $contactPhone || $contactAddress): ?>
<section class="px-4 sm:px-6 md:px-[80px] -mt-8 relative z-10">
    <div class="max-w-[1400px] mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($contactEmail): ?>
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-gray-900 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-envelope text-white text-sm"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-[13px] text-gray-400 mb-0.5"><?php echo e(__('Email')); ?></p>
                    <a href="mailto:<?php echo e($contactEmail); ?>" class="text-[15px] font-medium text-gray-900 hover:underline break-all"><?php echo e($contactEmail); ?></a>
                </div>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($contactPhone): ?>
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-gray-900 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-phone text-white text-sm"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-[13px] text-gray-400 mb-0.5"><?php echo e(__('Phone')); ?></p>
                    <a href="tel:<?php echo e($contactPhone); ?>" class="text-[15px] font-medium text-gray-900 hover:underline"><?php echo e($contactPhone); ?></a>
                </div>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($contactAddress): ?>
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-gray-900 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-location-dot text-white text-sm"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-[13px] text-gray-400 mb-0.5"><?php echo e(__('Address')); ?></p>
                    <p class="text-[15px] font-medium text-gray-900"><?php echo e($contactAddress); ?></p>
                </div>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


<section class="px-4 sm:px-6 md:px-[80px] py-16 md:py-24">
    <div class="max-w-[1400px] mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-10 lg:gap-16">

            
            <div class="lg:col-span-3">
                <p class="text-[15px] text-gray-500 mb-2"><?php echo e(__('Send a message')); ?></p>
                <h2 class="text-[34px] md:text-[44px] font-serif font-semibold text-gray-900 leading-[1.08] mb-3"><?php echo e($formTitle); ?></h2>
                <p class="text-[17px] text-gray-500 mb-10 max-w-lg leading-relaxed"><?php echo e($formDescription); ?></p>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
                    <div class="mb-8 p-5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-start gap-3">
                        <i class="fa-solid fa-circle-check text-emerald-600 mt-0.5"></i>
                        <span><?php echo e(session('success')); ?></span>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <form action="<?php echo e(route('contact.store')); ?>" method="POST" class="space-y-5">
                    <?php echo csrf_field(); ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5"><?php echo e(__('Name')); ?> <span class="text-red-400">*</span></label>
                            <input type="text" name="name" id="name" value="<?php echo e(old('name')); ?>" required
                                class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3.5 text-[15px] text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition"
                                placeholder="<?php echo e(__('Your name')); ?>">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1.5 text-xs text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5"><?php echo e(__('Email')); ?> <span class="text-red-400">*</span></label>
                            <input type="email" name="email" id="email" value="<?php echo e(old('email')); ?>" required
                                class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3.5 text-[15px] text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition"
                                placeholder="<?php echo e(__('your@email.com')); ?>">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1.5 text-xs text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1.5"><?php echo e(__('Phone')); ?> <span class="text-red-400">*</span></label>
                            <input type="tel" name="phone" id="phone" value="<?php echo e(old('phone')); ?>" required autocomplete="tel"
                                class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3.5 text-[15px] text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition"
                                placeholder="<?php echo e(__('Your phone number')); ?>">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1.5 text-xs text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-1.5">Subject <span class="text-red-400">*</span></label>
                            <input type="text" name="subject" id="subject" value="<?php echo e(old('subject')); ?>" required
                                class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3.5 text-[15px] text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition"
                                placeholder="How can we help?">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['subject'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1.5 text-xs text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-1.5"><?php echo e(__('Message')); ?> <span class="text-red-400">*</span></label>
                        <textarea name="message" id="message" rows="5" required
                            class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3.5 text-[15px] text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition resize-y"
                            placeholder="<?php echo e(__('Tell us more about your inquiry...')); ?>"><?php echo e(old('message')); ?></textarea>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1.5 text-xs text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <button type="submit" class="inline-flex items-center rounded-full bg-gray-900 text-white text-sm font-semibold px-8 py-3.5 hover:bg-gray-800 transition-colors">
                        <?php echo e(__('Send message')); ?>

                        <i class="fa-solid fa-arrow-right text-xs ml-2.5"></i>
                    </button>
                </form>
            </div>

            
            <div class="lg:col-span-2">
                <div class="sticky top-28 space-y-5">
                    
                    <div class="bg-gray-100 rounded-2xl p-7">
                        <h3 class="text-xl font-bold text-gray-900 mb-5"><?php echo e(__('How can we help?')); ?></h3>
                        <div class="space-y-4">
                            <div class="flex items-start gap-3.5">
                                <div class="w-10 h-10 rounded-xl bg-gray-900 flex items-center justify-center flex-shrink-0">
                                    <i class="fa-solid fa-plane-departure text-white text-sm"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-900"><?php echo e(__('Custom travel package requests')); ?></h4>
                                    <p class="text-[13px] text-gray-500 mt-0.5"><?php echo e(__("Tell us your dream itinerary and we'll make it happen.")); ?></p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3.5">
                                <div class="w-10 h-10 rounded-xl bg-gray-900 flex items-center justify-center flex-shrink-0">
                                    <i class="fa-solid fa-users text-white text-sm"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-900"><?php echo e(__('Group travel')); ?></h4>
                                    <p class="text-[13px] text-gray-500 mt-0.5"><?php echo e(__('Special rates and tailored experiences for groups.')); ?></p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3.5">
                                <div class="w-10 h-10 rounded-xl bg-gray-900 flex items-center justify-center flex-shrink-0">
                                    <i class="fa-solid fa-circle-question text-white text-sm"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-900"><?php echo e(__('General Enquiries')); ?></h4>
                                    <p class="text-[13px] text-gray-500 mt-0.5"><?php echo e(__('Questions about destinations, availability, or anything else.')); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="relative rounded-[28px] overflow-hidden" style="min-height: 240px;">
                        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1530789253388-582c481c54b0?w=800&h=600&fit=crop');"></div>
                        <div class="absolute inset-0 bg-black/60"></div>
                        <div class="relative flex flex-col items-center justify-center text-center p-8" style="min-height: 240px;">
                            <i class="fa-solid fa-headset text-3xl text-white/50 mb-4"></i>
                            <h3 class="text-xl font-bold text-white mb-2"><?php echo e($sidebarTitle); ?></h3>
                            <p class="text-sm text-white/60 mb-5"><?php echo e($sidebarDescription); ?></p>
                            <a href="<?php echo e($sidebarButtonUrl); ?>" class="inline-flex items-center rounded-full border border-white/40 text-white text-sm font-semibold px-6 py-2.5 hover:bg-white hover:text-gray-900 transition-colors">
                                <?php echo e($sidebarButtonText); ?>

                            </a>
                        </div>
                    </div>

                    
                    <div class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white p-5">
                        <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-clock text-emerald-600 text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900"><?php echo e(__('Average response time')); ?></p>
                            <p class="text-[13px] text-gray-500"><?php echo e(__('We typically reply within 2-4 hours.')); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.site', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/kevinhitaj/Desktop/Projects/TOP 7 TRAVEL/resources/views/pages/contact.blade.php ENDPATH**/ ?>