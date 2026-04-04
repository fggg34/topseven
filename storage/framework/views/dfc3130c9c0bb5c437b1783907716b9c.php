<?php $__env->startSection('title', 'New Account Created - ' . config('app.name')); ?>

<?php $__env->startSection('header'); ?>
<div style="background: linear-gradient(135deg, #1f2937 0%, #374151 100%); color: #ffffff; padding: 24px; text-align: center;">
    <h1 style="margin: 0; font-size: 20px; font-weight: 700;">New account created</h1>
    <p style="margin: 8px 0 0; font-size: 14px; opacity: 0.9;"><?php echo e($user->name); ?> · <?php echo e($user->email); ?></p>
    <p style="margin: 4px 0 0; font-size: 12px; opacity: 0.8;"><?php echo e($user->created_at->format('l, F j, Y \a\t g:i A')); ?></p>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<p style="margin: 0 0 20px; font-size: 14px;">A new user has registered on your site. Details below:</p>

<table class="email-table">
    <tr><td colspan="2" style="padding: 8px 16px; background: #f9fafb; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #6b7280;">Account information</td></tr>
    <tr class="detail-row">
        <td class="detail-label">Name</td>
        <td class="detail-value"><?php echo e($user->name); ?></td>
    </tr>
    <tr class="detail-row">
        <td class="detail-label">Email</td>
        <td class="detail-value"><a href="mailto:<?php echo e($user->email); ?>" style="color: #65a30d;"><?php echo e($user->email); ?></a></td>
    </tr>
    <tr class="detail-row">
        <td class="detail-label">Registered at</td>
        <td class="detail-value"><?php echo e($user->created_at->format('l, F j, Y \a\t g:i A')); ?></td>
    </tr>
</table>

<div style="margin-top: 24px; text-align: center;">
    <a href="<?php echo e(url(config('app.filament_admin_path', '_panel') . '/users')); ?>" class="btn">View in admin panel</a>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
<div class="footer">
    Automated notification from <strong><?php echo e(config('app.name')); ?></strong>.
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('emails.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/kevinhitaj/Desktop/Projects/TOP 7 TRAVEL/resources/views/emails/admin-new-account.blade.php ENDPATH**/ ?>