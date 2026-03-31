<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

    <div class="bg-gray-50 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">

            
            <div class="mb-8 lg:mb-10">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl lg:text-3xl font-bold text-lime-900">My Trips</h1>
                        <p class="mt-1 text-gray-600">Manage your bookings and saved tours</p>
                    </div>
                    <a href="<?php echo e(route('profile.edit')); ?>" class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 hover:text-lime-700 transition-colors">
                        <span class="w-9 h-9 rounded-full bg-white border border-gray-200 flex items-center justify-center">
                            <i class="fa-solid fa-user text-gray-500 text-sm"></i>
                        </span>
                        Account settings
                    </a>
                </div>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
                <div class="mb-8 flex items-center gap-3 px-4 py-3 bg-lime-50 border border-lime-200 text-lime-800 rounded-xl">
                    <i class="fa-solid fa-circle-check text-lime-600 text-lg"></i>
                    <span><?php echo e(session('success')); ?></span>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            
            <div class="grid grid-cols-2 gap-4 mb-8 lg:mb-10">
                <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-lime-50 flex items-center justify-center">
                            <i class="fa-solid fa-calendar-check text-lime-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-lime-900"><?php echo e($activeBookingsCount ?? 0); ?></p>
                            <p class="text-sm text-gray-500">Bookings</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center">
                            <i class="fa-solid fa-heart text-amber-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-lime-900"><?php echo e($wishlistTours->count()); ?></p>
                            <p class="text-sm text-gray-500">Saved tours</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-8 lg:space-y-10">
                
                <section>
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-lg font-semibold text-lime-900">My bookings</h2>
                            <p class="text-sm text-gray-500 mt-0.5">Your upcoming and past reservations</p>
                        </div>
                        <a href="<?php echo e(route('tours.index')); ?>" class="text-sm font-medium text-lime-600 hover:text-lime-700 transition-colors hidden sm:inline-flex items-center gap-1">
                            Browse tours
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                    </div>

                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bookings->isEmpty()): ?>
                            <div class="p-12 text-center">
                                <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mx-auto mb-4">
                                    <i class="fa-solid fa-calendar-xmark text-gray-400 text-2xl"></i>
                                </div>
                                <p class="text-gray-600 font-medium">No bookings yet</p>
                                <p class="text-sm text-gray-500 mt-1 mb-6">Discover amazing tours and start planning your next adventure.</p>
                                <a href="<?php echo e(route('tours.index')); ?>" class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand-btn hover:bg-brand-btn-hover text-white text-sm font-medium rounded-lg transition-colors">
                                    <i class="fa-solid fa-compass"></i>
                                    Browse tours
                                </a>
                            </div>
                        <?php else: ?>
                            <ul class="divide-y divide-gray-100">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                    <?php
                                        $bookingDate = $booking->tourDate?->date ?? $booking->booking_date;
                                        $isPast = $bookingDate && $bookingDate->isPast();
                                        $currency = $booking->currency ?: '€';
                                    ?>
                                    <li class="group">
                                        <div class="flex flex-col sm:flex-row sm:items-center gap-4 p-6 hover:bg-gray-50/50 transition-colors">
                                            <div class="flex-1 min-w-0">
                                                <a href="<?php echo e(route('bookings.confirmation', ['token' => $booking->confirmation_token])); ?>" class="font-semibold text-lime-900 hover:text-lime-700 transition line-clamp-2">
                                                    <?php echo e($booking->tour->title); ?>

                                                </a>
                                                <div class="mt-2 flex flex-wrap items-center gap-x-4 gap-y-1 text-sm text-gray-500">
                                                    <span class="flex items-center gap-1.5">
                                                        <i class="fa-regular fa-calendar text-gray-400 text-xs"></i>
                                                        <?php echo e($bookingDate?->format('M j, Y') ?? '—'); ?>

                                                    </span>
                                                    <span class="flex items-center gap-1.5">
                                                        <i class="fa-solid fa-users text-gray-400 text-xs"></i>
                                                        <?php echo e($booking->guest_count); ?> <?php echo e(Str::plural('guest', $booking->guest_count)); ?>

                                                    </span>
                                                    <span class="font-medium text-gray-700"><?php echo e($currency); ?><?php echo e(number_format($booking->total_amount, 2)); ?></span>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-3 flex-shrink-0">
                                                <span class="inline-flex items-center px-3 py-1.5 text-xs font-semibold rounded-lg
                                                    <?php if($booking->status === 'confirmed'): ?> bg-emerald-50 text-emerald-700
                                                    <?php elseif($booking->status === 'cancelled'): ?> bg-gray-100 text-gray-500
                                                    <?php else: ?> bg-lime-50 text-lime-700 <?php endif; ?>">
                                                    <?php echo e(ucfirst($booking->status)); ?>

                                                </span>
                                                <a href="<?php echo e(route('bookings.confirmation', ['token' => $booking->confirmation_token])); ?>" class="text-sm font-medium text-lime-600 hover:text-lime-700 transition">
                                                    View details
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </ul>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bookings->hasPages()): ?>
                                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50"><?php echo e($bookings->links()); ?></div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$bookings->isEmpty()): ?>
                        <div class="mt-4 text-center sm:hidden">
                            <a href="<?php echo e(route('tours.index')); ?>" class="text-sm font-medium text-lime-600 hover:text-lime-700">Browse more tours</a>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </section>

                
                <section>
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-lg font-semibold text-lime-900">Saved tours</h2>
                            <p class="text-sm text-gray-500 mt-0.5">Tours you've added to your wishlist</p>
                        </div>
                        <a href="<?php echo e(route('tours.index')); ?>" class="text-sm font-medium text-lime-600 hover:text-lime-700 transition-colors hidden sm:inline-flex items-center gap-1">
                            Explore tours
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                    </div>

                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($wishlistTours->isEmpty()): ?>
                            <div class="p-12 text-center">
                                <div class="w-16 h-16 rounded-2xl bg-amber-50 flex items-center justify-center mx-auto mb-4">
                                    <i class="fa-regular fa-heart text-amber-500 text-2xl"></i>
                                </div>
                                <p class="text-gray-600 font-medium">No saved tours yet</p>
                                <p class="text-sm text-gray-500 mt-1 mb-6">Save tours you love and they'll appear here for easy access.</p>
                                <a href="<?php echo e(route('tours.index')); ?>" class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand-btn hover:bg-brand-btn-hover text-white text-sm font-medium rounded-lg transition-colors">
                                    <i class="fa-solid fa-compass"></i>
                                    Explore tours
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="p-6">
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $wishlistTours; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tour): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                        <div class="group relative p-4 rounded-xl border border-gray-100 hover:border-lime-200 hover:bg-lime-50/30 transition-all">
                                            <form action="<?php echo e(route('wishlist.destroy', $tour)); ?>" method="POST" class="absolute top-4 right-4 z-10">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="w-9 h-9 rounded-full bg-white/95 shadow-sm flex items-center justify-center text-rose-500 hover:bg-rose-50 transition-colors" title="Remove from wishlist">
                                                    <i class="fa-solid fa-heart text-sm"></i>
                                                </button>
                                            </form>
                                            <a href="<?php echo e(route('tours.show', $tour->slug)); ?>" class="block">
                                                <?php
                                                    $firstImg = $tour->images->first();
                                                    $imageUrl = $firstImg?->url ?? 'https://placehold.co/400x300/e5e7eb/6b7280?text=Tour';
                                                ?>
                                                <div class="aspect-[4/3] rounded-lg overflow-hidden bg-gray-100 mb-3">
                                                    <img src="<?php echo e($imageUrl); ?>" alt="<?php echo e($tour->title); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                                                </div>
                                                <h3 class="font-semibold text-lime-900 group-hover:text-lime-700 transition line-clamp-2 pr-10"><?php echo e($tour->title); ?></h3>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tour->price): ?>
                                                    <p class="mt-1 text-sm font-medium text-gray-600">From €<?php echo e(number_format($tour->price, 0)); ?></p>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </a>
                                        </div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$wishlistTours->isEmpty()): ?>
                        <div class="mt-4 text-center sm:hidden">
                            <a href="<?php echo e(route('tours.index')); ?>" class="text-sm font-medium text-lime-600 hover:text-lime-700">Explore more tours</a>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </section>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH /Users/kevinhitaj/Desktop/Projects/TOP 7 TRAVEL/resources/views/dashboard.blade.php ENDPATH**/ ?>