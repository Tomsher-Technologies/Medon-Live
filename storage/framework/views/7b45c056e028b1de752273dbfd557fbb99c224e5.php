<?php
    $value = null;
    for ($i = 0; $i < $child_category->level; $i++) {
        $value .= '--';
    }
?>
<option <?php echo e(isset($old_data) ? ( $old_data == $child_category->id ? 'selected' : '' ) : ''); ?> value="<?php echo e($child_category->id); ?>"><?php echo e($value . ' ' . $child_category->name); ?></option>
<?php if($child_category->categories): ?>
    <?php $__currentLoopData = $child_category->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $childCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo $__env->make('categories.child_category', [
            'child_category' => $childCategory,
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
Z<?php /**PATH C:\wamp64\www\jisha\Medon-Laravel\resources\views/categories/child_category.blade.php ENDPATH**/ ?>