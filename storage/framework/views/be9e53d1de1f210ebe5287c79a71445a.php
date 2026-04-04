<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['action' => route('tours.index'), 'placeholder' => 'Search travel packages...']));

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

foreach (array_filter((['action' => route('tours.index'), 'placeholder' => 'Search travel packages...']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<form action="<?php echo e($action); ?>" method="GET" class="flex flex-col sm:flex-row gap-2 max-w-2xl mx-auto">
    <input type="search" name="q" value="<?php echo e(request('q')); ?>" placeholder="<?php echo e($placeholder); ?>" class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-lime-500 focus:ring-lime-500 px-4 py-3">
    <button type="submit" class="px-6 py-3 bg-brand-btn text-white font-medium rounded-lg hover:bg-brand-btn-hover transition">
        Search
    </button>
</form>
<?php /**PATH /Users/kevinhitaj/Desktop/Projects/TOP 7 TRAVEL/resources/views/components/search-bar.blade.php ENDPATH**/ ?>