<?php if (isset($component)) { $__componentOriginal8e7956dae19015fe0584c4754c890ebc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8e7956dae19015fe0584c4754c890ebc = $attributes; } ?>
<?php $component = App\View\Components\AccountLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('account-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AccountLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

    <h1 class="text-[28px] sm:text-[32px] font-serif font-semibold text-[#111827] tracking-tight leading-tight mb-2"><?php echo e(__('Account settings')); ?></h1>
    <p class="text-[15px] text-gray-500 mb-10 leading-relaxed"><?php echo e(__('Update your profile, password, or delete your account.')); ?></p>

    <div class="space-y-0">
        <div class="pb-10 mb-10 border-b border-[#e6e1d8]">
            <?php echo $__env->make('profile.partials.update-profile-information-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>

        <div class="pb-10 mb-10 border-b border-[#e6e1d8]">
            <?php echo $__env->make('profile.partials.update-password-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>

        <div>
            <?php echo $__env->make('profile.partials.delete-user-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8e7956dae19015fe0584c4754c890ebc)): ?>
<?php $attributes = $__attributesOriginal8e7956dae19015fe0584c4754c890ebc; ?>
<?php unset($__attributesOriginal8e7956dae19015fe0584c4754c890ebc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e7956dae19015fe0584c4754c890ebc)): ?>
<?php $component = $__componentOriginal8e7956dae19015fe0584c4754c890ebc; ?>
<?php unset($__componentOriginal8e7956dae19015fe0584c4754c890ebc); ?>
<?php endif; ?>
<?php /**PATH C:\Users\Administrator\Desktop\Projects\TOP7\topseven\resources\views/profile/edit.blade.php ENDPATH**/ ?>