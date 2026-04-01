<?php $__env->startSection('title', 'Booking confirmed - ' . config('app.name')); ?>

<?php $__env->startSection('content'); ?>
<?php
    $bookingDate = $booking->booking_date ?? $booking->tourDate?->date;
    $firstImage = $booking->tour->images->first();
    $tourImageUrl = $firstImage && $firstImage->path ? $firstImage->url : 'https://placehold.co/1200x600?text=Tour';
    $durationDays = (int) ($booking->tour->duration_days ?? 0);
    $durationLabel = $durationDays ? $durationDays . ' Day' . ($durationDays > 1 ? 's' : '') . ' Tour' : ($booking->tour->duration_hours ? (int) $booking->tour->duration_hours . ' hours' : 'Tour');
?>
<div class="min-h-screen bg-gray-50 py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 text-green-600 mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Booking confirmed</h1>
            <p class="mt-2 text-gray-600">Thank you! A confirmation has been sent to <strong class="text-gray-900"><?php echo e($booking->guest_email); ?></strong>.</p>
        </div>

        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-0">
                
                <div class="lg:col-span-3 p-6 sm:p-8">
                    <h2 class="text-base font-semibold text-gray-900 mb-5 pb-3 border-b border-gray-100">Booking details</h2>
                    <dl class="space-y-4">
                        <div>
                            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">Booking reference</dt>
                            <dd class="mt-1 font-mono font-semibold text-gray-900"><?php echo e($booking->reference); ?></dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">Traveler</dt>
                            <dd class="mt-1 text-gray-900"><?php echo e($booking->guest_name); ?></dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">Email</dt>
                            <dd class="mt-1 text-gray-900"><?php echo e($booking->guest_email); ?></dd>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($booking->guest_phone): ?>
                        <div>
                            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">Phone</dt>
                            <dd class="mt-1 text-gray-900"><?php echo e($booking->guest_phone); ?></dd>
                        </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <div>
                            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">Tour</dt>
                            <dd class="mt-1 font-medium text-gray-900"><?php echo e($booking->tour->title); ?></dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">Date</dt>
                            <dd class="mt-1 text-gray-900"><?php echo e($bookingDate?->format('l, F j, Y')); ?></dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">Travelers</dt>
                            <dd class="mt-1 text-gray-900"><?php echo e($booking->guest_count); ?></dd>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($booking->pickup_location): ?>
                        <div>
                            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">Pickup</dt>
                            <dd class="mt-1 text-gray-900"><?php echo e($booking->pickup_location); ?></dd>
                        </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($booking->billing_address || $booking->billing_city || $booking->billing_country): ?>
                        <div>
                            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">Billing address</dt>
                            <dd class="mt-1 text-gray-600 text-sm">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($booking->billing_address): ?><?php echo e($booking->billing_address); ?><br><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($booking->billing_city || $booking->billing_region): ?><?php echo e(trim(($booking->billing_city ?? '') . ', ' . ($booking->billing_region ?? ''))); ?><br><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($booking->billing_country): ?><?php echo e($booking->billing_country); ?><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </dd>
                        </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($booking->special_requests): ?>
                        <div>
                            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">Special requests</dt>
                            <dd class="mt-1 text-gray-900"><?php echo e($booking->special_requests); ?></dd>
                        </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </dl>
                    <div class="flex flex-wrap gap-3 mt-6 pt-5 border-t border-gray-100">
                        <a href="<?php echo e(route('tours.show', $booking->tour->slug)); ?>" class="inline-flex items-center justify-center px-5 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition">View tour</a>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                            <a href="<?php echo e(route('dashboard')); ?>" class="inline-flex items-center justify-center px-5 py-2.5 rounded-lg text-sm font-medium text-white bg-brand-btn hover:bg-brand-btn-hover transition">My bookings</a>
                        <?php else: ?>
                            <a href="<?php echo e(route('tours.index')); ?>" class="inline-flex items-center justify-center px-5 py-2.5 rounded-lg text-sm font-medium text-white bg-brand-btn hover:bg-brand-btn-hover transition">Browse more tours</a>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                
                <div class="lg:col-span-2 bg-gray-50 p-6 sm:p-8 border-t lg:border-t-0 lg:border-l border-gray-200">
                    <div class="aspect-[4/3] rounded-xl overflow-hidden bg-gray-200 mb-4">
                        <img src="<?php echo e($tourImageUrl); ?>" alt="<?php echo e($booking->tour->title); ?>" class="w-full h-full object-cover">
                    </div>
                    <h3 class="font-semibold text-gray-900"><?php echo e($booking->tour->title); ?></h3>
                    <p class="text-sm text-gray-600 mt-1"><?php echo e($durationLabel); ?></p>
                    <div class="mt-5 pt-4 border-t border-gray-200 flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-600">Total paid</span>
                        <span class="text-lg font-bold text-gray-900"><?php echo e((strtoupper($booking->currency ?? '') === 'EUR' ? '€' : ($booking->currency ?? ''))); ?><?php echo e(number_format($booking->total_amount, 2)); ?></span>
                    </div>
                    <p class="mt-4 flex items-center gap-2 text-sm text-green-600 font-medium">
                        <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        Instant confirmation
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.site', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\Projects\TOP7\topseven\resources\views\pages\bookings\confirmation.blade.php ENDPATH**/ ?>