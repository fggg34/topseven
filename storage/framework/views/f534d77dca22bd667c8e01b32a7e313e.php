<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['country']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['country']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $imageUrl = $country->city_image_url ?? 'https://placehold.co/400x400/e5e7eb/6b7280?text=' . urlencode($country->name);
    $countryUrl = route('countries.show', $country->slug);
?>
<a href="<?php echo e($countryUrl); ?>" class="flex-shrink-0 w-[185px] block group" data-slider-card>
    <div class="aspect-square rounded-lg overflow-hidden bg-gray-200 shadow-sm group-hover:shadow-md transition-shadow duration-300">
        <img src="<?php echo e($imageUrl); ?>" alt="<?php echo e($country->name); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
    </div>
    <h3 class="mt-2 text-center font-medium text-gray-900 group-hover:text-lime-600 transition-colors"><?php echo e($country->name); ?></h3>
</a>
<?php /**PATH /Users/kevinhitaj/Desktop/Projects/TOP 7 TRAVEL/resources/views/components/destination-card.blade.php ENDPATH**/ ?>