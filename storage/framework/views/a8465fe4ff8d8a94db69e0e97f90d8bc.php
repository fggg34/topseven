<div
    <?php echo e($attributes
            ->merge([
                'id' => $getId(),
            ], escape: false)
            ->merge($getExtraAttributes(), escape: false)); ?>

>
    <?php echo e($getChildSchema()); ?>

</div>
<?php /**PATH /Users/kevinhitaj/Desktop/Projects/TOP 7 TRAVEL/vendor/filament/schemas/resources/views/components/grid.blade.php ENDPATH**/ ?>