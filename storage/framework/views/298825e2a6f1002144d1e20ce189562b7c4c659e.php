

<?php $__env->startSection('content'); ?>
    <div class="aiz-titlebar text-left mt-2 mb-3">

        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">All Brands</h1>
            </div>
            <div class="col-md-6 text-md-right">
                <a href="<?php echo e(route('brands.create')); ?>" class="btn btn-primary">
                    <span>Add new brand</span>
                </a>
            </div>
        </div>
    </div>

    

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header row gutters-5">
                    <div class="col text-center text-md-left">
                        <h5 class="mb-md-0 h6">Brands</h5>
                    </div>
                    <div class="col-md-4">
                        <form class="" id="sort_brands" action="" method="GET">
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" id="search"
                                    name="search"<?php if(isset($sort_search)): ?> value="<?php echo e($sort_search); ?>" <?php endif; ?>
                                    placeholder="Type name & Enter">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table aiz-table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Logo</th>
                                <th class="text-center">Is Active</th>
                                <th class="text-right">Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($key + 1 + ($brands->currentPage() - 1) * $brands->perPage()); ?></td>
                                    <td><?php echo e($brand->name); ?></td>
                                    <td>
                                        <img src="<?php echo e(api_upload_asset($brand->logo)); ?>" alt="Brand"
                                            class="h-50px">
                                    </td>
                                    <td class="text-center">
                                        <label class="aiz-switch aiz-switch-success mb-0">
                                            <input type="checkbox" onchange="update_status(this)" value="<?php echo e($brand->id); ?>"
                                                <?php if ($brand->is_active == 1) {
                                                    echo 'checked';
                                                } ?>>
                                            <span></span>
                                        </label>
                                    </td>
                                    <td class="text-right">
                                        <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                            href="<?php echo e(route('brands.edit', $brand)); ?>" title="Edit">
                                            <i class="las la-edit"></i>
                                        </a>
                                        
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <div class="aiz-pagination">
                        <?php echo e($brands->appends(request()->input())->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('modal'); ?>
    <?php echo $__env->make('modals.delete_modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script type="text/javascript">
        function sort_brands(el) {
            $('#sort_brands').submit();
        }
        function update_status(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('<?php echo e(route('brands.status')); ?>', {
                _token: '<?php echo e(csrf_token()); ?>',
                id: el.value,
                status: status
            }, function(data) {
                if (data == 1) {
                    AIZ.plugins.notify('success', 'Brand status updated successfully');
                } else {
                    AIZ.plugins.notify('danger', 'Something went wrong');
                }
            });
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\jisha\Medon-Laravel\resources\views/backend/product/brands/index.blade.php ENDPATH**/ ?>