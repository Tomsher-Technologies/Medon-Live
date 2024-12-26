<?php
    $value = null;
    for ($i = 0; $i < $category->level; $i++) {
        $value .= '-';
    }
?>
<option <?php echo e(isset($old_data) ? ( $old_data == $category->id ? 'selected' : '' ) : ''); ?> value="<?php echo e($category->id); ?>"><?php echo e($value . ' ' . $category->name); ?></option>
<?php if($category->child): ?>
    <?php $__currentLoopData = $category->child; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $childCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo $__env->make('backend.product.categories.menu_child_category', [
            'category' => $childCategory,
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?><?php /**PATH C:\wamp64\www\jisha\Medon-Laravel\resources\views/backend/product/categories/menu_child_category.blade.php ENDPATH**/ ?>