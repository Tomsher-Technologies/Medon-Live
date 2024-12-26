

<?php $__env->startSection('content'); ?>
    <div class="aiz-titlebar text-left mt-2 mb-3">
        <h5 class="mb-0 h6">Brand Information</h5>
    </div>

    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-body p-0">

                <form class="p-4" action="<?php echo e(route('brands.update', $brand->id)); ?>" method="POST"
                    enctype="multipart/form-data">
                    <input name="_method" type="hidden" value="PATCH">
                    <?php echo csrf_field(); ?>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="name">Name <i
                                class="las la-language text-danger" title="Translatable"></i></label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="Name" id="name" name="name"
                                value="<?php echo e($brand->name); ?>" class="form-control" required>
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="alert alert-danger"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('slug-check', ['model' => 'App\\Models\\Brand', 'model_id' => $brand->id, 'template' => 2])->html();
} elseif ($_instance->childHasBeenRendered('jkOZINL')) {
    $componentId = $_instance->getRenderedChildComponentId('jkOZINL');
    $componentTag = $_instance->getRenderedChildComponentTagName('jkOZINL');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('jkOZINL');
} else {
    $response = \Livewire\Livewire::mount('slug-check', ['model' => 'App\\Models\\Brand', 'model_id' => $brand->id, 'template' => 2]);
    $html = $response->html();
    $_instance->logRenderedChild('jkOZINL', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

                    <div class="form-group  row">
                        <label class="col-md-3 col-form-label">Is Active</label>
                        <div class="col-md-9">
                            <select class="select2 form-control" name="is_active">
                                <option <?php echo e($brand->is_active == 1 ? 'selected' : ''); ?> value="1">Yes
                                </option>
                                <option <?php echo e($brand->is_active == 0 ? 'selected' : ''); ?> value="0">No
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="signinSrEmail">Logo
                            <small>(150x70)</small></label>
                        <div class="col-md-9">
                            <div class="input-group" data-toggle="aizuploader" data-type="image">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                                        Browse</div>
                                </div>
                                <div class="form-control file-amount">Choose File</div>
                                <input type="hidden" name="logo" value="<?php echo e($brand->logo); ?>" class="selected-files">
                            </div>
                            <div class="file-preview box sm">
                            </div>
                            <?php $__errorArgs = ['logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="alert alert-danger"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="name">Meta Title</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="meta_title"
                                placeholder="Meta Title"
                                value="<?php echo e(old('meta_title', $brand->meta_title)); ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="name">Meta Description</label>
                        <div class="col-md-9">
                            <textarea name="meta_description" rows="5" class="form-control"><?php echo e(old('meta_description', $brand->meta_description)); ?></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="name">Meta Keywords</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="meta_keywords"
                                placeholder="Meta Keywords"
                                value="<?php echo e(old('meta_keywords', $brand->meta_keywords)); ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="name">OG Title</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="og_title"
                                placeholder="OG Title" value="<?php echo e(old('og_title', $brand->og_title)); ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="name">OG Description</label>
                        <div class="col-md-9">
                            <textarea name="og_description" rows="5" class="form-control"><?php echo e(old('og_description', $brand->og_description)); ?></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="name">Twitter Title</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="twitter_title"
                                placeholder="Twitter Title"
                                value="<?php echo e(old('twitter_title', $brand->twitter_title)); ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label"
                            for="name">Twitter Description</label>
                        <div class="col-md-9">
                            <textarea name="twitter_description" rows="5" class="form-control"><?php echo e(old('twitter_description', $brand->twitter_description)); ?></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label"
                            for="name">Footer Title</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="footer_title"
                                placeholder="Footer Title" value="<?php echo e(old('footer_title', $brand->footer_title)); ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label"
                            for="name">Footer Description</label>
                        <div class="col-md-9">
                            <textarea name="footer_description" rows="5" class="form-control aiz-text-editor"><?php echo e(old('footer_description', $brand->footer_content)); ?></textarea>
                        </div>
                    </div>

                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <?php echo \Livewire\Livewire::scripts(); ?>

    <?php echo \Livewire\Livewire::styles(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\jisha\Medon-Laravel\resources\views/backend/product/brands/edit.blade.php ENDPATH**/ ?>