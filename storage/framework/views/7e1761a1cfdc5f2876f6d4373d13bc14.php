<?php
    $heroTitle = \App\Models\Setting::get('page_faq_hero_title', 'Frequently Asked Questions');
    $heroSubtitle = \App\Models\Setting::get('page_faq_hero_subtitle', 'Everything you need to know');
    $heroImage = \App\Models\Setting::get('page_faq_hero_image', '');
    $heroBg = $heroImage ? \Illuminate\Support\Facades\Storage::disk('public')->url($heroImage) : 'https://images.unsplash.com/photo-1488085061387-422e29b40080?w=1920&h=600&fit=crop';
    $sections = \App\Models\Setting::get('page_faq_sections', '');
    $sections = is_string($sections) ? (json_decode($sections, true) ?: []) : $sections;
    if (empty($sections)) {
        $sections = [
            ['category_label' => 'Enquiries & payments', 'category_title' => 'How enquiries work', 'items' => [
                ['q' => 'How do I enquire about a travel package?', 'a' => 'Browse our travel packages, open the one you like, and submit the enquiry form with your dates, guest count, and message. Our team will contact you with availability and next steps.'],
                ['q' => 'What payment methods do you accept?', 'a' => 'We accept all major credit and debit cards, as well as bank transfers. Payment is arranged after we confirm your trip details.'],
            ]],
            ['category_label' => 'Cancellations & changes', 'category_title' => 'Flexibility when you need it', 'items' => [
                ['q' => 'What is your cancellation policy?', 'a' => 'Most travel packages offer free cancellation up to 7 days before the departure date.'],
            ]],
            ['category_label' => 'Tours & experiences', 'category_title' => 'About our tours', 'items' => [
                ['q' => 'Are your tours guided?', 'a' => 'Most tours include professional local guides.'],
            ]],
        ];
    }
    $ctaTitle = \App\Models\Setting::get('page_faq_cta_title', 'Still have questions?');
    $ctaDescription = \App\Models\Setting::get('page_faq_cta_description', "Can't find what you're looking for? Our team is happy to help.");
    $ctaButtonText = \App\Models\Setting::get('page_faq_cta_button_text', 'Contact us');
    $ctaButtonUrl = \App\Models\Setting::get('page_faq_cta_button_url', '') ?: route('contact');
?>


<?php $__env->startSection('title', \App\Models\Setting::get('page_faq_seo_title') ?: ('FAQ - ' . config('app.name'))); ?>
<?php $__env->startSection('description', \App\Models\Setting::get('page_faq_seo_description') ?: 'Frequently asked questions about our travel packages, enquiries and services.'); ?>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(\App\Models\Setting::get('page_faq_seo_og_image')): ?><?php $__env->startSection('og_image', \App\Models\Setting::get('page_faq_seo_og_image')); ?><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<?php $__env->startSection('content'); ?>

<div class="relative w-full overflow-hidden bg-brand-footer" style="height: 320px;">
    <div class="absolute inset-0 bg-cover bg-center opacity-50" style="background-image: url('<?php echo e($heroBg); ?>');"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
    <div class="absolute inset-0 flex items-end">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full pb-10">
            <nav class="text-sm mb-4" aria-label="Breadcrumb">
                <ol class="flex items-center gap-1.5">
                    <li><a href="<?php echo e(route('home')); ?>" class="text-white/70 hover:text-white transition">Home</a></li>
                    <li class="text-white/50">/</li>
                    <li class="text-white">FAQ</li>
                </ol>
            </nav>
            <h1 class="text-4xl md:text-5xl font-bold text-white" style="color: #fff !important;"><?php echo e($heroTitle); ?></h1>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($heroSubtitle): ?>
                <p class="mt-2 text-lg text-white/80"><?php echo e($heroSubtitle); ?></p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sIdx => $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
    <section class="mb-12">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($section['category_label'])): ?>
            <p class="text-xs font-medium uppercase tracking-wider text-gray-400 mb-2"><?php echo e($section['category_label']); ?></p>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($section['category_title'])): ?>
            <h2 class="text-2xl font-bold text-gray-900 mb-6"><?php echo e($section['category_title']); ?></h2>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($section['items'])): ?>
        <div class="space-y-3" x-data="{ open: null }">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $section['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <div class="rounded-xl border border-gray-100 bg-white overflow-hidden">
                    <button @click="open === 's<?php echo e($sIdx); ?>_<?php echo e($i); ?>' ? open = null : open = 's<?php echo e($sIdx); ?>_<?php echo e($i); ?>'"
                        class="w-full flex items-center justify-between gap-4 px-6 py-4 text-left">
                        <span class="font-medium text-gray-900"><?php echo e($faq['q'] ?? ''); ?></span>
                        <i class="fa-solid fa-chevron-down text-xs text-gray-400 transition-transform duration-200" :class="open === 's<?php echo e($sIdx); ?>_<?php echo e($i); ?>' && 'rotate-180'"></i>
                    </button>
                    <div x-show="open === 's<?php echo e($sIdx); ?>_<?php echo e($i); ?>'" x-collapse>
                        <div class="px-6 pb-4 text-sm text-gray-600 leading-relaxed"><?php echo e($faq['a'] ?? ''); ?></div>
                    </div>
                </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </section>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

    
    <section class="mt-16 rounded-2xl bg-white border border-gray-100 p-8 md:p-12 text-center">
        <i class="fa-solid fa-comment-dots text-3xl text-brand-btn mb-4"></i>
        <h2 class="text-xl font-bold text-gray-900 mb-2"><?php echo e($ctaTitle); ?></h2>
        <p class="text-gray-500 mb-6 max-w-md mx-auto"><?php echo e($ctaDescription); ?></p>
        <a href="<?php echo e($ctaButtonUrl); ?>" class="inline-flex px-8 py-3.5 bg-brand-btn hover:bg-brand-btn-hover text-white font-medium rounded-xl transition-colors">
            <?php echo e($ctaButtonText); ?>

        </a>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.site', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/kevinhitaj/Desktop/Projects/TOP 7 TRAVEL/resources/views/pages/faq.blade.php ENDPATH**/ ?>