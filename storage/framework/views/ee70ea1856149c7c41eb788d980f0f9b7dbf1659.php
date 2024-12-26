

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-lg-12 mx-auto">

            <div class="aiz-titlebar text-left mt-2 mb-3">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h1 class="h3">All Offers</h1>
                    </div>
                    <div class="col-md-6 text-md-right">
                        <a href="<?php echo e(route('offers.create')); ?>" class="btn btn-primary">
                            <span><?php echo e(translate('Add New offers')); ?></span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="card">
                <form class="" id="sort_customers" action="" method="GET">

                    <div class="card-body">
                        <table class="table aiz-table mb-0">
                            <thead>
                                <tr>
                                    <th >Name</th>
                                    <th >Link Type</th>
                                    <th >Offer Type</th>
                                    <th >Start Date</th>
                                    <th >End Date</th>
                                    
                                    <th class="text-center">Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $offers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $offer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <?php echo e($offer->name); ?>

                                        </td>
                                        <td>
                                            <?php echo e(ucfirst($offer->link_type)); ?>

                                        </td>
                                        <td>
                                            <span class="text-capitalize"><?php echo e(str_replace('_', ' ', $offer->offer_type)); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <span
                                                class="text-capitalize"><?php echo e($offer->start_date ? $offer->start_date->format('d/m/Y H:i:s') : '-'); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <span
                                                class="text-capitalize"><?php echo e($offer->end_date ? $offer->end_date->format('d/m/Y H:i:s') : '-'); ?>

                                            </span>
                                        </td>

                                        
                                        <td class="text-center">
                                            <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                                href="<?php echo e(route('offers.edit', $offer->id)); ?>" title="Edit">
                                                <i class="las la-edit"></i>
                                            </a>
                                            <a href="#"
                                                class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                                data-href="<?php echo e(route('offers.destroy', $offer->id)); ?>" title="Delete">
                                                <i class="las la-trash"></i>
                                            </a>
                                            
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <div class="aiz-pagination">
                            <?php echo e($offers->appends(request()->input())->links()); ?>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('modal'); ?>
    <?php echo $__env->make('modals.delete_modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\jisha\Medon-Laravel\resources\views/backend/offers/index.blade.php ENDPATH**/ ?>