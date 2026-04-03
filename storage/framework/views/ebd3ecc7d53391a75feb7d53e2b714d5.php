<?php
    $inputClass = 'w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3.5 text-[15px] text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#111827] focus:border-transparent transition';
?>

<section>
    <header class="mb-6">
        <h2 class="text-lg font-semibold text-[#111827]">
            <?php echo e(__('Delete account')); ?>

        </h2>
        <p class="mt-1 text-sm text-gray-500 leading-relaxed">
            <?php echo e(__('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.')); ?>

        </p>
    </header>

    <button
        type="button"
        class="inline-flex items-center justify-center rounded-full border border-red-200 bg-white text-red-700 text-sm font-semibold px-8 py-3.5 hover:bg-red-50 transition-colors"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    ><?php echo e(__('Delete account')); ?></button>

    <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['name' => 'confirm-user-deletion','show' => $errors->userDeletion->isNotEmpty(),'focusable' => true,'maxWidth' => 'md']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'confirm-user-deletion','show' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->userDeletion->isNotEmpty()),'focusable' => true,'maxWidth' => 'md']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

        <form method="post" action="<?php echo e(route('profile.destroy')); ?>" class="p-6 sm:p-8">
            <?php echo csrf_field(); ?>
            <?php echo method_field('delete'); ?>

            <h2 class="text-lg font-semibold text-[#111827]">
                <?php echo e(__('Are you sure you want to delete your account?')); ?>

            </h2>

            <p class="mt-2 text-sm text-gray-500 leading-relaxed">
                <?php echo e(__('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.')); ?>

            </p>

            <div class="mt-6">
                <label for="password" class="sr-only"><?php echo e(__('Password')); ?></label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    class="<?php echo e($inputClass); ?>"
                    placeholder="<?php echo e(__('Password')); ?>"
                    autocomplete="current-password"
                />
                <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->userDeletion->get('password'),'class' => 'mt-1.5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->userDeletion->get('password')),'class' => 'mt-1.5']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
            </div>

            <div class="mt-8 flex flex-col-reverse sm:flex-row sm:justify-end gap-3">
                <button
                    type="button"
                    class="inline-flex items-center justify-center rounded-full border border-gray-200 bg-white text-[#111827] text-sm font-semibold px-6 py-3 hover:bg-gray-50 transition-colors w-full sm:w-auto"
                    x-on:click="$dispatch('close')"
                ><?php echo e(__('Cancel')); ?></button>

                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-full bg-red-600 text-white text-sm font-semibold px-6 py-3 hover:bg-red-700 transition-colors w-full sm:w-auto"
                ><?php echo e(__('Delete account')); ?></button>
            </div>
        </form>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $attributes = $__attributesOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__attributesOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $component = $__componentOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__componentOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
</section>
<?php /**PATH C:\Users\Administrator\Desktop\Projects\TOP7\topseven\resources\views/profile/partials/delete-user-form.blade.php ENDPATH**/ ?>