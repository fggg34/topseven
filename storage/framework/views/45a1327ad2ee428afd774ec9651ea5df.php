<?php
    $headerOverlay = request()->routeIs('home');
    $siteName = \App\Models\Setting::get('site_name', config('app.name'));
    $siteLogo = \App\Models\Setting::get('site_logo', '');
    $bookPhone = \App\Models\Setting::get('contact_phone', '');
    $bookPhoneTel = preg_replace('/[^0-9+]/', '', $bookPhone) ?: '';
    $facebookUrl = trim((string) \App\Models\Setting::get('facebook_url', ''));
    $instagramUrl = trim((string) \App\Models\Setting::get('instagram_url', ''));
    $navItems = \App\Models\Setting::get('nav_menu_items', '');
    $navItems = is_string($navItems) ? (json_decode($navItems, true) ?: []) : $navItems;
    if (empty($navItems)) {
        $navItems = [
            ['type' => 'dropdown', 'label' => 'Destinations', 'children' => [['label' => 'All Destinations', 'url' => '/countries']]],
            ['type' => 'dropdown', 'label' => 'Travel Collections', 'children' => [
                ['label' => 'All Travel Packages', 'url' => '/tours'],
                ['label' => 'Popular Travel Packages', 'url' => '/tours?sort=popular'],
                ['label' => 'Travel Stories', 'url' => '/blog'],
            ]],
            ['type' => 'dropdown', 'label' => 'About', 'children' => [
                ['label' => 'About Us', 'url' => '/about'],
                ['label' => 'Blog', 'url' => '/blog'],
                ['label' => 'Contact', 'url' => '/contact'],
            ]],
            ['type' => 'link', 'label' => 'Create Your Trip', 'url' => '/tours'],
            ['type' => 'link', 'label' => 'My Trips', 'url' => '/dashboard'],
        ];
    }
    $resolveUrl = fn ($u) => (str_starts_with($u ?? '', 'http') ? $u : url($u ?? '#'));
?>
<header
    class="fixed top-0 inset-x-0 z-50 transition-colors duration-300"
    x-data="{
        mobileOpen: false,
        overlay: <?php echo \Illuminate\Support\Js::from($headerOverlay)->toHtml() ?>,
        scrolled: false,
        checkScroll() {
            this.scrolled = (window.scrollY || document.documentElement.scrollTop) > 12;
        },
    }"
    x-init="checkScroll()"
    @scroll.window="checkScroll()"
    :class="overlay && scrolled ? 'bg-[#000] shadow-md shadow-black/30' : (!overlay ? 'bg-white/95 backdrop-blur-sm border-b border-gray-200 shadow-sm' : '')"
>
    <nav class="w-full px-4 sm:px-6 lg:px-[80px] pt-5 pb-4">
        <div class="flex items-center justify-between">
            
            <nav class="hidden md:flex items-center gap-8 text-sm lg:text-base font-medium tracking-wide">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $navItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                    <a href="<?php echo e($resolveUrl(($item['type'] ?? 'link') === 'dropdown' ? (($item['children'][0]['url'] ?? '#')) : ($item['url'] ?? '#'))); ?>"
                       class="<?php echo e($headerOverlay ? 'text-white/85 hover:text-white' : 'text-gray-700 hover:text-lime-700'); ?> transition-colors">
                        <?php echo e($item['label'] ?? ''); ?>

                    </a>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </nav>

            
            <a href="<?php echo e(route('home')); ?>" class="absolute left-1/2 -translate-x-1/2 md:static md:translate-x-0 md:mx-auto">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($siteLogo): ?>
                    <img src="<?php echo e(\Illuminate\Support\Facades\Storage::disk('public')->url($siteLogo)); ?>" alt="<?php echo e($siteName); ?>"
                         class="h-9 md:h-10 lg:h-12 w-auto object-contain <?php echo e($headerOverlay ? 'brightness-0 invert' : ''); ?>" />
                <?php else: ?>
                    <span class="text-2xl md:text-3xl lg:text-4xl font-black tracking-wider uppercase <?php echo e($headerOverlay ? 'text-white' : 'text-gray-900'); ?>"><?php echo e($siteName); ?></span>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </a>

            
            <div class="hidden md:flex items-center gap-6 lg:gap-8 text-sm lg:text-base font-medium">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bookPhone): ?>
                    <a href="tel:<?php echo e($bookPhoneTel); ?>" class="<?php echo e($headerOverlay ? 'text-white/85 hover:text-white' : 'text-gray-700 hover:text-lime-700'); ?> transition-colors">
                        Book now: <?php echo e($bookPhone); ?>

                    </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($facebookUrl || $instagramUrl): ?>
                    <div class="flex items-center gap-4 lg:gap-5">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($facebookUrl): ?>
                            <a href="<?php echo e($facebookUrl); ?>" target="_blank" rel="noopener noreferrer"
                               class="<?php echo e($headerOverlay ? 'text-white/90 hover:text-white' : 'text-gray-700 hover:text-lime-700'); ?> transition-colors"
                               aria-label="Facebook">
                                <i class="fa-brands fa-facebook-f text-lg lg:text-xl"></i>
                            </a>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($instagramUrl): ?>
                            <a href="<?php echo e($instagramUrl); ?>" target="_blank" rel="noopener noreferrer"
                               class="<?php echo e($headerOverlay ? 'text-white/90 hover:text-white' : 'text-gray-700 hover:text-lime-700'); ?> transition-colors"
                               aria-label="Instagram">
                                <i class="fa-brands fa-instagram text-xl lg:text-2xl"></i>
                            </a>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('dashboard')); ?>"
                       class="<?php echo e($headerOverlay ? 'text-white/90 hover:text-white' : 'text-gray-700 hover:text-lime-700'); ?> transition-colors inline-flex"
                       title="My account" aria-label="My account">
                        <?php if (isset($component)) { $__componentOriginal97cd70b27ebbfc72f0446b75665d1c91 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal97cd70b27ebbfc72f0446b75665d1c91 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.user-circled','data' => ['class' => 'w-6 h-6 lg:w-[26px] lg:h-[26px] shrink-0']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.user-circled'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-6 h-6 lg:w-[26px] lg:h-[26px] shrink-0']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal97cd70b27ebbfc72f0446b75665d1c91)): ?>
<?php $attributes = $__attributesOriginal97cd70b27ebbfc72f0446b75665d1c91; ?>
<?php unset($__attributesOriginal97cd70b27ebbfc72f0446b75665d1c91); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal97cd70b27ebbfc72f0446b75665d1c91)): ?>
<?php $component = $__componentOriginal97cd70b27ebbfc72f0446b75665d1c91; ?>
<?php unset($__componentOriginal97cd70b27ebbfc72f0446b75665d1c91); ?>
<?php endif; ?>
                    </a>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>"
                       class="<?php echo e($headerOverlay ? 'text-white/90 hover:text-white' : 'text-gray-700 hover:text-lime-700'); ?> transition-colors"
                       title="Log in" aria-label="Log in">
                        <i class="fa-regular fa-circle-user text-2xl lg:text-[26px] leading-none"></i>
                    </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            
            <button @click="mobileOpen = !mobileOpen" type="button"
                    class="md:hidden p-2 -mr-2 <?php echo e($headerOverlay ? 'text-white/80 hover:text-white' : 'text-gray-600 hover:text-gray-900'); ?>">
                <svg x-show="!mobileOpen" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                <svg x-show="mobileOpen" x-cloak class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </nav>

    
    <div x-show="mobileOpen" x-cloak x-transition @click="mobileOpen = false"
         class="md:hidden fixed inset-0 z-[9998] bg-black/40"></div>
    <div x-show="mobileOpen" x-cloak
         x-transition:enter="transition ease-out duration-200" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in duration-150" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
         class="md:hidden fixed top-0 right-0 bottom-0 z-[9999] w-72 max-w-[85vw] bg-white shadow-xl flex flex-col text-gray-800">
        <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100">
            <span class="text-sm font-medium text-gray-500">Menu</span>
            <button @click="mobileOpen = false" type="button" class="p-2 -mr-2 text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="flex-1 overflow-y-auto py-4">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $navItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($item['type'] ?? 'link') === 'dropdown' && !empty($item['children'] ?? [])): ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $item['children']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <a href="<?php echo e($resolveUrl($child['url'] ?? '')); ?>" @click="mobileOpen = false" class="block px-5 py-2.5 text-sm text-gray-700 hover:bg-gray-50"><?php echo e($child['label'] ?? ''); ?></a>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <?php else: ?>
                    <a href="<?php echo e($resolveUrl($item['url'] ?? '')); ?>" @click="mobileOpen = false" class="block px-5 py-2.5 text-sm text-gray-700 hover:bg-gray-50"><?php echo e($item['label'] ?? ''); ?></a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
        <div class="flex-shrink-0 border-t border-gray-100 py-4">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($facebookUrl || $instagramUrl): ?>
                <div class="flex items-center gap-5 px-5 pb-3">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($facebookUrl): ?>
                        <a href="<?php echo e($facebookUrl); ?>" target="_blank" rel="noopener noreferrer" @click="mobileOpen = false" class="text-gray-700 hover:text-lime-700 transition-colors" aria-label="Facebook">
                            <i class="fa-brands fa-facebook-f text-xl"></i>
                        </a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($instagramUrl): ?>
                        <a href="<?php echo e($instagramUrl); ?>" target="_blank" rel="noopener noreferrer" @click="mobileOpen = false" class="text-gray-700 hover:text-lime-700 transition-colors" aria-label="Instagram">
                            <i class="fa-brands fa-instagram text-2xl"></i>
                        </a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <div class="px-5 pb-3 flex items-center gap-4 border-b border-gray-100">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('dashboard')); ?>" @click="mobileOpen = false" class="text-sm font-medium text-gray-800 hover:text-lime-700 transition-colors flex items-center gap-2">
                        <?php if (isset($component)) { $__componentOriginal97cd70b27ebbfc72f0446b75665d1c91 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal97cd70b27ebbfc72f0446b75665d1c91 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.user-circled','data' => ['class' => 'w-[1.125rem] h-[1.125rem] shrink-0 text-gray-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.user-circled'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-[1.125rem] h-[1.125rem] shrink-0 text-gray-500']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal97cd70b27ebbfc72f0446b75665d1c91)): ?>
<?php $attributes = $__attributesOriginal97cd70b27ebbfc72f0446b75665d1c91; ?>
<?php unset($__attributesOriginal97cd70b27ebbfc72f0446b75665d1c91); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal97cd70b27ebbfc72f0446b75665d1c91)): ?>
<?php $component = $__componentOriginal97cd70b27ebbfc72f0446b75665d1c91; ?>
<?php unset($__componentOriginal97cd70b27ebbfc72f0446b75665d1c91); ?>
<?php endif; ?> My account
                    </a>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" @click="mobileOpen = false" class="text-sm font-medium text-gray-800 hover:text-lime-700 transition-colors">Log in</a>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Route::has('register')): ?>
                        <a href="<?php echo e(route('register')); ?>" @click="mobileOpen = false" class="text-sm font-medium text-lime-600 hover:text-lime-700 transition-colors">Register</a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                <form method="POST" action="<?php echo e(route('logout')); ?>" class="px-5 pb-2"><?php echo csrf_field(); ?>
                    <button type="submit" class="text-sm text-gray-500 hover:text-red-600 transition-colors">Log out</button>
                </form>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <a href="<?php echo e(route('contact')); ?>" @click="mobileOpen = false" class="flex items-center gap-2 px-5 py-2.5 text-sm text-gray-700 hover:bg-gray-50"><i class="fa-solid fa-envelope text-gray-400 w-5"></i>Contact</a>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bookPhone): ?>
                <a href="tel:<?php echo e($bookPhoneTel); ?>" @click="mobileOpen = false" class="flex items-center gap-2 px-5 py-2.5 text-sm text-gray-700 hover:bg-gray-50"><i class="fa-solid fa-phone text-gray-400 w-5"></i><?php echo e($bookPhone); ?></a>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($contactEmail = \App\Models\Setting::get('contact_email')): ?>
                <a href="mailto:<?php echo e($contactEmail); ?>" @click="mobileOpen = false" class="flex items-center gap-2 px-5 py-2.5 text-sm text-gray-700 hover:bg-gray-50 break-all"><i class="fa-solid fa-envelope text-gray-400 w-5 flex-shrink-0"></i><?php echo e($contactEmail); ?></a>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</header>
<?php /**PATH /Users/kevinhitaj/Desktop/Projects/TOP 7 TRAVEL/resources/views/layouts/partials/site-nav.blade.php ENDPATH**/ ?>