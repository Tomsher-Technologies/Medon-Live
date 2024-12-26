

<?php $__env->startSection('content'); ?>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6"><?php echo e(translate('Product Bulk Upload')); ?></h5>
        </div>
        <div class="card-body">
            <div class="alert" style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                <strong><?php echo e(translate('Step 1')); ?>:</strong>
                <p>1. <?php echo e(translate('Download the skeleton file and fill it with proper data')); ?>.</p>
                <p>2. <?php echo e(translate('You can download the example file to understand how the data must be filled')); ?>.</p>
                <p>3. <?php echo e(translate('Once you have downloaded and filled the skeleton file, upload it in the form below and submit')); ?>.</p>
                <p>4. <?php echo e(translate('After uploading products you need to edit them and set product\'s images and choices')); ?>.</p>
            </div>
            <br>
            <div class="">
                <a href="<?php echo e(static_asset('download/product_bulk_demo.xlsx')); ?>" download><button class="btn btn-info"><?php echo e(translate('Download CSV')); ?></button></a>
            </div>
            
            <br>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6"><strong><?php echo e(translate('Upload Product File')); ?></strong></h5>
        </div>
        <div class="card-body">
            <form class="form-horizontal" action="<?php echo e(route('bulk_product_upload')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="form-group row">
                    <div class="col-sm-9">
                        <div class="custom-file">
    						<label class="custom-file-label">
    							<input type="file" name="bulk_file" class="custom-file-input" required>
    							<span class="custom-file-name"><?php echo e(translate('Choose File')); ?></span>
    						</label>
    					</div>
                    </div>
                </div>
                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-info"><?php echo e(translate('Upload CSV')); ?></button>
                </div>
            </form>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\jisha\Medon-Laravel\resources\views/backend/product/bulk_upload/index.blade.php ENDPATH**/ ?>