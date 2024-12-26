<div class="form-group row">
    <label class="col-md-3 col-form-label">Category<span class="text-danger" style="font-size: 20px;line-height: 1;">*</span></label>
    <div class="col-md-9">
        <select  onchange="brands_form()" class="form-control aiz-selectpicker" name="main_category" id="main_category" data-live-search="true" required>
            <option value="">Select Category</option>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option <?php echo e(($category->id == $oldArray) ? 'selected' : ''); ?> value="<?php echo e($category->id); ?>">
                    <?php echo e($category->name); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
</div>

<div class="form-group row">
    <label class="col-md-3 col-form-label">Brands<span class="text-danger" style="font-size: 20px;line-height: 1;">*</span></label>
    <div class="col-md-9">
        <select class="form-control aiz-selectpicker" name="link_ref_id[]" id="link_ref_id" data-actions-box="true" data-live-search="true" multiple required>
            <?php if(!empty($brandsData)): ?>
                <?php $__currentLoopData = $brandsData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bd): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option <?php echo e((in_array($bd->id , $selectedBrands)) ? 'selected' : ''); ?> value="<?php echo e($bd->id); ?>">
                        <?php echo e($bd->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </select>
    </div>
</div>
<script>
    $('#main_category').selectpicker({
        size: 5,
        virtualScroll: false
    });
    $('#link_ref_id').selectpicker({
        size: 5,
        virtualScroll: false
    });
</script>
<?php /**PATH C:\wamp64\www\jisha\Medon-Laravel\resources\views/partials/offers/banner_form_category.blade.php ENDPATH**/ ?>