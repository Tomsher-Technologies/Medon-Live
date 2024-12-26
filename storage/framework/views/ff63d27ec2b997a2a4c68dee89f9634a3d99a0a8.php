

<?php $__env->startSection('content'); ?>
    <style>
        .bread .breadcrumb {
            all: unset;
        }

        .bread .breadcrumb li {
            display: inline-block;
        }

        .bread nav {
            display: inline-block;
            max-width: 250px;
        }

        .bread .breadcrumb-item+.breadcrumb-item::before {
            content: ">";
        }

        .breadcrumb-item+.breadcrumb-item {
            padding-left: 0;
        }

        .bread a {
            pointer-events: none;
            cursor: sw-resize;
        }
    </style>
    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col-auto">
                <h1 class="h3">All products</h1>
            </div>
            <?php if($type != 'Seller'): ?>
                <div class="col text-right">
                    <a href="<?php echo e(route('products.create')); ?>" class="btn btn-circle btn-info">
                        <span>Add New Product</span>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <br>

    <div class="card">
        <form class="" id="sort_products" action="" method="GET">
            <div class="card-header row gutters-5">
                <div class="col">
                    <h5 class="mb-md-0 h6">All Product</h5>
                </div>

                
                <div class="col-md-3 ml-auto bootstrap-select">
                    
                    <select class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0" data-live-search="true"
                    name="category" id="" data-selected=<?php echo e($category); ?>>
                        <option value="0">All</option>
                        <?php $__currentLoopData = getAllCategories()->where('parent_id', 0); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($item->id); ?>" <?php if( $category == $item->id): ?>  <?php echo e('selected'); ?> <?php endif; ?> )><?php echo e($item->name); ?></option>
                            <?php if($item->child): ?>
                                <?php $__currentLoopData = $item->child; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php echo $__env->make('backend.product.categories.menu_child_category', [
                                        'category' => $cat,
                                        'old_data' => $category,
                                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-3 ml-auto bootstrap-select">
                    <select class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0" name="type"
                        id="type">
                        <option value="">Sort By</option>
                        <option value="rating,desc"
                            <?php if(isset($col_name, $query)): ?> <?php if($col_name == 'rating' && $query == 'desc'): ?> selected <?php endif; ?> <?php endif; ?>>
                            Rating (High > Low)</option>
                        <option value="rating,asc"
                            <?php if(isset($col_name, $query)): ?> <?php if($col_name == 'rating' && $query == 'asc'): ?> selected <?php endif; ?> <?php endif; ?>>
                            Rating (Low > High)</option>
                        <option
                            value="num_of_sale,desc"<?php if(isset($col_name, $query)): ?> <?php if($col_name == 'num_of_sale' && $query == 'desc'): ?> selected <?php endif; ?> <?php endif; ?>>
                            Num of Sale (High > Low)</option>
                        <option
                            value="num_of_sale,asc"<?php if(isset($col_name, $query)): ?> <?php if($col_name == 'num_of_sale' && $query == 'asc'): ?> selected <?php endif; ?> <?php endif; ?>>
                            Num of Sale (Low > High)</option>
                        <option
                            value="unit_price,desc"<?php if(isset($col_name, $query)): ?> <?php if($col_name == 'unit_price' && $query == 'desc'): ?> selected <?php endif; ?> <?php endif; ?>>
                            Base Price (High > Low)</option>
                        <option
                            value="unit_price,asc"<?php if(isset($col_name, $query)): ?> <?php if($col_name == 'unit_price' && $query == 'asc'): ?> selected <?php endif; ?> <?php endif; ?>>
                            Base Price (Low > High)</option>
                        <option
                            value="status,1"<?php if(isset($col_name, $query)): ?> <?php if($col_name == 'status' && $query == '1'): ?> selected <?php endif; ?> <?php endif; ?>>
                            Published</option>
                        <option
                            value="status,0"<?php if(isset($col_name, $query)): ?> <?php if($col_name == 'status' && $query == '0'): ?> selected <?php endif; ?> <?php endif; ?>>
                            Unpublished</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <div class="form-group mb-0">
                        <input type="text" class="form-control form-control-sm" id="search"
                            name="search"<?php if(isset($sort_search)): ?> value="<?php echo e($sort_search); ?>" <?php endif; ?>
                            placeholder="Type & Enter">
                    </div>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-warning w-100" type="submit">Filter</button>
                </div>
            </div>

            <div class="card-body">
                <table class="table aiz-table mb-0">
                    <thead>
                        <tr>
                            
                            <th  width="10%">#</th>
                            <th><?php echo e(translate('Name')); ?></th>
                            <th>Category</th>
                            <th><?php echo e(translate('Info')); ?></th>
                            <th ><?php echo e(translate('Total Stock')); ?></th>
                            
                            <th ><?php echo e(translate('Published')); ?></th>
                            
                           
                            <th  class="text-right"><?php echo e(translate('Options')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $shops = getActiveShops();
                        ?>
                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($key + 1 + ($products->currentPage() - 1) * $products->perPage()); ?></td>
                                
                                <td>
                                    <div class="row gutters-5 w-200px w-md-300px mw-100">

                                        <?php if($product->thumbnail_img): ?>
                                            <div class="col-auto">
                                                <img src="<?php echo e(get_product_image($product->thumbnail_img, '300')); ?>"
                                                    alt="Image" class="size-50px img-fit">
                                            </div>
                                        <?php endif; ?>


                                        <div class="col">
                                            <span class="text-muted text-truncate-2"><?php echo e($product->name); ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="bread">
                                    <?php echo e(Breadcrumbs::render('product_admin', $product)); ?>

                                </td>
                                <td style="word-break: break-word;">
                                    <strong><?php echo e(translate('Num of Sale')); ?>:</strong> <?php echo e($product->num_of_sale); ?>

                                    <?php echo e(translate('times')); ?> </br>
                                    <strong><?php echo e(translate('Base Price')); ?>:</strong>
                                    <?php echo e(single_price($product->unit_price)); ?> </br>
                                    <strong><?php echo e(translate('Rating')); ?>:</strong> <?php echo e($product->rating); ?> </br>
                                    <strong><?php echo e(translate('SKU')); ?>:</strong> <?php echo e($product->sku); ?> </br>
                                    <strong><?php echo e(translate('VAT')); ?>:</strong> <?php echo e($product->vat); ?> </br>
                                </td>
                                <td>
                                    <?php
                                        $qty = 0;
                                        if ($product->variant_product) {
                                            foreach ($product->stocks as $key => $stock) {
                                                $qty += $stock->qty;
                                                echo $stock->variant . ' - ' . $stock->qty . '<br>';
                                            }
                                        } else {
                                            //$qty = $product->current_stock;
                                            $qty = optional($product->stocks->first())->qty;
                                            echo $qty;
                                        }
                                    ?>
                                    <?php if($qty <= $product->low_stock_quantity): ?>
                                        <span class="badge badge-inline badge-danger">Low</span>
                                    <?php endif; ?>
                                </td>
                                
                                <td>
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input onchange="update_published(this)" value="<?php echo e($product->id); ?>"
                                            type="checkbox" <?php if ($product->published == 1) {
                                                echo 'checked';
                                            } ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                

                                
                                <td class="text-right">
                                  
                                    <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                        href="<?php echo e(route('products.edit', ['id' => $product->id, 'lang' => env('DEFAULT_LANGUAGE')])); ?>"
                                        title="Edit">
                                        <i class="las la-edit"></i>
                                    </a>
                                    
                                    
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <div class="aiz-pagination">
                    <?php echo e($products->appends(request()->input())->links()); ?>

                </div>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('modal'); ?>
    <?php echo $__env->make('modals.delete_modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('script'); ?>
    <script type="text/javascript">
        $(document).on("change", ".check-all", function() {
            if (this.checked) {
                // Iterate each checkbox
                $('.check-one:checkbox').each(function() {
                    this.checked = true;
                });
            } else {
                $('.check-one:checkbox').each(function() {
                    this.checked = false;
                });
            }

        });

        $(document).ready(function() {
            //$('#container').removeClass('mainnav-lg').addClass('mainnav-sm');
        });

        function update_todays_deal(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('<?php echo e(route('products.todays_deal')); ?>', {
                _token: '<?php echo e(csrf_token()); ?>',
                id: el.value,
                status: status
            }, function(data) {
                if (data == 1) {
                    AIZ.plugins.notify('success', 'Todays Deal updated successfully');
                } else {
                    AIZ.plugins.notify('danger', 'Something went wrong');
                }
            });
        }

        function update_published(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('<?php echo e(route('products.published')); ?>', {
                _token: '<?php echo e(csrf_token()); ?>',
                id: el.value,
                status: status
            }, function(data) {
                if (data == 1) {
                    AIZ.plugins.notify('success', 'Published products updated successfully');
                } else {
                    AIZ.plugins.notify('danger', 'Something went wrong');
                }
            });
        }

        function update_approved(el) {
            if (el.checked) {
                var approved = 1;
            } else {
                var approved = 0;
            }
            $.post('<?php echo e(route('products.approved')); ?>', {
                _token: '<?php echo e(csrf_token()); ?>',
                id: el.value,
                approved: approved
            }, function(data) {
                if (data == 1) {
                    AIZ.plugins.notify('success', 'Product approval update successfully');
                } else {
                    AIZ.plugins.notify('danger', 'Something went wrong');
                }
            });
        }

        function update_featured(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('<?php echo e(route('products.featured')); ?>', {
                _token: '<?php echo e(csrf_token()); ?>',
                id: el.value,
                status: status
            }, function(data) {
                if (data == 1) {
                    AIZ.plugins.notify('success', 'Featured products updated successfully');
                } else {
                    AIZ.plugins.notify('danger', 'Something went wrong');
                }
            });
        }

        function sort_products(el) {
            $('#sort_products').submit();
        }

        function bulk_delete() {
            var data = new FormData($('#sort_products')[0]);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "<?php echo e(route('bulk-product-delete')); ?>",
                type: 'POST',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response == 1) {
                        location.reload();
                    }
                }
            });
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\jisha\Medon-Laravel\resources\views/backend/product/products/index.blade.php ENDPATH**/ ?>