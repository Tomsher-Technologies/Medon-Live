<div class="form-group row">
    <label class="col-md-3 col-form-label">Link<span class="text-danger" style="font-size: 20px;line-height: 1;">*</span></label>
    <div class="col-md-9">
        <select class="form-control aiz-selectpicker" name="link_ref_id[]" id="link_ref_id" data-live-search="true" multiple
        data-actions-box="true" required>
           
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option <?php echo e((in_array($product->id, $oldArray)) ? 'selected' : ''); ?> value="<?php echo e($product->id); ?>"><?php echo e($product->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
</div>
<script>
    $('#link_ref_id').selectpicker({
        size: 5,
        virtualScroll: false
    });
</script>
<?php /**PATH C:\wamp64\www\jisha\Medon-Laravel\resources\views/partials/offers/banner_form_product.blade.php ENDPATH**/ ?>