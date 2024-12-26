

<?php $__env->startSection('content'); ?>
    <div class="aiz-titlebar text-left mt-2 mb-3">
        <h1 class="mb-0 h6">Edit Product</h5>
    </div>
    <div class="">
        <form class="form form-horizontal mar-top" action="<?php echo e(route('products.update', $product->id)); ?>" method="POST"
            enctype="multipart/form-data" id="choice_form">
            <div class="row gutters-5">
                <div class="col-12">
                    <div class="card bg-transparent shadow-none border-0">
                        <div class="card-body p-0">
                            <div class="btn-toolbar float-right" role="toolbar"
                                aria-label="Toolbar with button groups">
                                <div class="btn-group" role="group" aria-label="Second group">
                                    <button type="submit" name="button" value="publish"
                                        class="btn btn-info action-btn">Update Product</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <input name="_method" type="hidden" value="POST">
                    <input type="hidden" name="id" value="<?php echo e($product->id); ?>">
                    <input type="hidden" name="lang" value="<?php echo e($lang); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-lg-3 col-from-label">Product Name <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="name" placeholder="Product Name"
                                        value="<?php echo e($product->name); ?>" required>
                                </div>
                            </div>
                            <div class="form-group row" id="category">
                                <label class="col-lg-3 col-from-label">Category<span class="text-danger">*</span></label>
                                <div class="col-lg-8">
                                    <select class="form-control aiz-selectpicker" name="category_id" id="category_id"
                                        data-selected="<?php echo e($product->category_id); ?>" data-live-search="true" required>
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?>

                                            </option>
                                            <?php $__currentLoopData = $category->childrenCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $childCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php echo $__env->make('categories.child_category', [
                                                    'child_category' => $childCategory,
                                                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row" id="brand">
                                <label class="col-lg-3 col-from-label">Brand</label>
                                <div class="col-lg-8">
                                    <select class="form-control aiz-selectpicker" name="brand_id" id="brand_id"
                                        data-live-search="true">
                                        <option value="">Select Brand</option>
                                        <?php $__currentLoopData = \App\Models\Brand::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($brand->id); ?>"
                                                <?php if($product->brand_id == $brand->id): ?> selected <?php endif; ?>>
                                                <?php echo e($brand->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-from-label">
                                    Unit
                                </label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="unit"
                                        placeholder="Unit (e.g. KG, Pc etc)" value="<?php echo e($product->unit); ?>">
                                </div>
                            </div>
                            <div class="form-group row d-none">
                                <label class="col-lg-3 col-from-label">Minimum Purchase Qty</label>
                                <div class="col-lg-8">
                                    <input type="number" lang="en" class="form-control" name="min_qty"
                                        value="<?php echo e($product->min_qty <= 1 ? 1 : $product->min_qty); ?>" min="1"
                                        required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-from-label">Tags</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control aiz-tag-input" name="tags[]" id="tags"
                                        value="<?php echo e($product->tags); ?>" placeholder="Type to add a tag" data-role="tagsinput">
                                    <small class="text-muted">This is used for search. Input those words by which cutomer
                                        can find this product.</small>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Slug<span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" placeholder="Slug" id="slug" name="slug"
                                        value="<?php echo e($product->slug); ?>" required class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">Product Images</h5>
                        </div>
                        <div class="card-body">

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="signinSrEmail">Gallery
                                    Images<small>(1000*1000)</small></label>
                                <div class="col-md-8">
                                    <input type="file" name="gallery_images[]" multiple class="form-control"
                                        accept="image/*">

                                    <?php if($product->photos): ?>
                                        <div class="file-preview box sm">
                                            <?php
                                                $photos = explode(',', $product->photos);
                                            ?>
                                            <?php $__currentLoopData = $photos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div
                                                    class="d-flex justify-content-between align-items-center mt-2 file-preview-item">
                                                    <div
                                                        class="align-items-center align-self-stretch d-flex justify-content-center thumb">
                                                        <img src="<?php echo e($product->image($photo)); ?>" class="img-fit">
                                                    </div>
                                                    <div class="remove">
                                                        <button class="btn btn-sm btn-link remove-galley"
                                                            data-url="<?php echo e($photo); ?>" type="button">
                                                            <i class="la la-close"></i></button>
                                                    </div>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="signinSrEmail">Thumbnail Image
                                    <small>(1000*1000)</small></label>
                                <div class="col-md-8">
                                    <input type="file" name="thumbnail_image" class="form-control" accept="image/*">

                                    <?php if($product->thumbnail_img): ?>
                                        <div class="file-preview box sm">
                                            <div
                                                class="d-flex justify-content-between align-items-center mt-2 file-preview-item">
                                                <div
                                                    class="align-items-center align-self-stretch d-flex justify-content-center thumb">
                                                    <img src="<?php echo e($product->image($product->thumbnail_img)); ?>"
                                                        class="img-fit">
                                                </div>
                                                <div class="remove">
                                                    <button class="btn btn-sm btn-link remove-thumbnail" type="button">
                                                        <i class="la la-close"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>

                            </div>
                        </div>

                    </div>


                    
                    <div class="card d-none">
                        <div class="card-header">
                            <h5 class="mb-0 h6"><?php echo e(translate('Product Variation')); ?></h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group row gutters-5">
                                <div class="col-lg-3">
                                    <input type="text" class="form-control" value="<?php echo e(translate('Attributes')); ?>"
                                        disabled>
                                </div>
                                <div class="col-lg-8">
                                    <select name="choice_attributes[]" id="choice_attributes"
                                        data-selected-text-format="count" data-live-search="true"
                                        class="form-control aiz-selectpicker" multiple
                                        data-placeholder="<?php echo e(translate('Choose Attributes')); ?>">
                                        <?php $__currentLoopData = \App\Models\Attribute::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $attribute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($attribute->id); ?>"
                                                <?php if($product->attributes != null && in_array($attribute->id, json_decode($product->attributes, true))): ?> selected <?php endif; ?>>
                                                <?php echo e($attribute->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="">
                                <p><?php echo e(translate('Choose the attributes of this product and then input values of each attribute')); ?>

                                </p>
                                <br>
                            </div>
                            <div class="customer_choice_options" id="customer_choice_options">

                                <?php if($product->choice_options): ?>
                                    <?php $__currentLoopData = json_decode($product->choice_options); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $choice_option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="form-group row">
                                            <div class="col-lg-3">
                                                <input type="hidden" name="choice_no[]"
                                                    value="<?php echo e($choice_option->attribute_id); ?>">
                                                <input type="text" class="form-control" name="choice[]"
                                                    value="<?php echo e(optional(\App\Models\Attribute::find($choice_option->attribute_id))->name); ?>"
                                                    placeholder="<?php echo e(translate('Choice Title')); ?>" disabled>
                                            </div>
                                            <div class="col-lg-8">
                                                <select class="form-control aiz-selectpicker attribute_choice"
                                                    data-live-search="true"
                                                    name="choice_options_<?php echo e($choice_option->attribute_id); ?>[]" multiple>
                                                    <?php $__currentLoopData = \App\Models\AttributeValue::where('attribute_id', $choice_option->attribute_id)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($row->value); ?>"
                                                            <?php if(in_array($row->value, $choice_option->values)): ?> selected <?php endif; ?>>
                                                            <?php echo e($row->value); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                    


                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">Product price + stock</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-lg-3 col-from-label">Unit price</label>
                                <div class="col-lg-6">
                                    <input type="text" placeholder="Unit price" name="unit_price"
                                        class="form-control" value="<?php echo e($product->unit_price); ?>" required>
                                </div>
                            </div>

                            <?php
                                $start_date = date('d-m-Y H:i:s', $product->discount_start_date);
                                $end_date = date('d-m-Y H:i:s', $product->discount_end_date);
                            ?>

                            <div class="form-group row">
                                <label class="col-sm-3 col-from-label" for="start_date">Discount Date Range</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control aiz-date-range"
                                        <?php if($product->discount_start_date && $product->discount_end_date): ?> value="<?php echo e($start_date . ' to ' . $end_date); ?>" <?php endif; ?>
                                        name="date_range" placeholder="Select Date" data-time-picker="true"
                                        data-format="DD-MM-Y HH:mm:ss" data-separator=" to " autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-from-label">Discount</label>
                                <div class="col-lg-6">
                                    <input type="number" lang="en" min="0" step="0.01"
                                        placeholder="Discount" name="discount" class="form-control"
                                        value="<?php echo e($product->discount); ?>">
                                </div>
                                <div class="col-lg-3">
                                    <select class="form-control aiz-selectpicker" name="discount_type">
                                        <option value="amount" <?php if ($product->discount_type == 'amount') {
                                            echo 'selected';
                                        } ?>>Flat</option>
                                        <option value="percent" <?php if ($product->discount_type == 'percent') {
                                            echo 'selected';
                                        } ?>>Percent</option>
                                    </select>
                                </div>
                            </div>

                            <?php if(addon_is_activated('club_point')): ?>
                                <div class="form-group row">
                                    <label class="col-md-3 col-from-label">
                                        Set Point
                                    </label>
                                    <div class="col-md-6">
                                        <input type="number" lang="en" min="0"
                                            value="<?php echo e($product->earn_point); ?>" step="1" placeholder="1"
                                            name="earn_point" class="form-control">
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div id="show-hide-div">
                                <div class="form-group row" id="quantity">
                                    <label class="col-lg-3 col-from-label">Quantity</label>
                                    <div class="col-lg-6">
                                        <input type="number" lang="en"
                                            value="<?php echo e(optional($product->stocks->first())->qty); ?>" step="1"
                                            placeholder="Quantity" name="current_stock" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-from-label">
                                        SKU
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" placeholder="SKU"
                                            value="<?php echo e(optional($product->stocks->first())->sku); ?>" required name="sku"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">VAT (%) </label>
                                <div class="col-md-6">
                                    <input type="number" lang="en" min="0" value="<?php echo e($product->vat); ?>" step="0.01" placeholder="VAT" name="vat" class="form-control">
                                </div>
                            </div> 

                            <div class="sku_combination" id="sku_combination">

                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">Product Description</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-lg-3 col-from-label">Description </label>
                                <div class="col-lg-9">
                                    <textarea class="aiz-text-editor" name="description"><?php echo e($product->description); ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card repeater">
                        <div class="card-header">
                            <h5 class="mb-0 h6">Product Tabs</h5>
                        </div>
                        <div class="card-body">
                            <div data-repeater-list="tabs">
                                <div data-repeater-item>
                                    <input type="hidden" name="tab_id">
                                    <div class="form-group row">
                                        <label class="col-md-3 col-from-label">Heading</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="tab_heading">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-from-label">Description</label>
                                        <div class="col-md-8">
                                            <textarea class="text-area" name="tab_description"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <input data-repeater-delete type="button" class="btn btn-danger action-btn"
                                            value="Delete" />
                                    </div>
                                </div>
                            </div>
                            <input data-repeater-create type="button" class="btn btn-success action-btn"
                                value="Add" />
                        </div>
                    </div>

                    <div class="card d-none">
                        <div class="card-header">
                            <h5 class="mb-0 h6">Product Dimensions</h5>
                        </div>
                        <div class="card-body">

                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">Length</label>
                                <div class="col-md-6">
                                    <input type="number" step="0.01" placeholder="Length" name="length"
                                        class="form-control" value="<?php echo e($product->length); ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">Height</label>
                                <div class="col-md-6">
                                    <input type="number" step="0.01" placeholder="Height" name="height"
                                        class="form-control" value="<?php echo e($product->height); ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">Width</label>
                                <div class="col-md-6">
                                    <input type="number" step="0.01" placeholder="Width" name="width"
                                        class="form-control" value="<?php echo e($product->width); ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">Weight</label>
                                <div class="col-md-6">
                                    <input type="number" step="0.01" placeholder="Weight" name="weight"
                                        class="form-control" value="<?php echo e($product->weight); ?>">
                                </div>
                            </div>

                        </div>
                    </div>


                    <!--                 <div class="card">
                                                                                                                                                                                                                                        <div class="card-header">
                                                                                                                                                                                                                                            <h5 class="mb-0 h6">Product Shipping Cost</h5>
                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                        <div class="card-body">

                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                    </div>-->

                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">Product Videos</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-lg-3 col-from-label">Video Provider</label>
                                <div class="col-lg-8">
                                    <select class="form-control aiz-selectpicker" name="video_provider"
                                        id="video_provider">
                                        <option value="youtube" <?php if ($product->video_provider == 'youtube') {
                                            echo 'selected';
                                        } ?>>Youtube</option>
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-from-label">Video Link</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="video_link"
                                        value="<?php echo e($product->video_link); ?>" placeholder="Video Link">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card d-none">
                        <div class="card-header">
                            <h5 class="mb-0 h6">PDF Specification</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="signinSrEmail">PDF Specification</label>
                                <div class="col-md-8">
                                    <div class="input-group" data-toggle="aizuploader">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                Browse</div>
                                        </div>
                                        <div class="form-control file-amount">Choose File</div>
                                        <input type="hidden" name="pdf" value="<?php echo e($product->pdf); ?>"
                                            class="selected-files">
                                    </div>
                                    <div class="file-preview box sm">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    


                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">SEO Meta Tags</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-lg-3 col-from-label">Meta Title</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control"
                                        value="<?php echo e(getSeoValues($product->seo, 'meta_title')); ?>" name="meta_title"
                                        placeholder="Meta Title">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-from-label">Description</label>
                                <div class="col-lg-8">
                                    <textarea name="meta_description" rows="8" class="form-control"><?php echo e(getSeoValues($product->seo, 'meta_description')); ?></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">Keywords</label>
                                <div class="col-md-8">
                                    
                                    <input type="text" class="form-control aiz-tag-input" name="meta_keywords[]"
                                        placeholder="Type and hit enter to add a keyword"
                                        value="<?php echo e(getSeoValues($product->seo, 'meta_keywords')); ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-from-label">OG Title</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="og_title" placeholder="OG Title"
                                        value="<?php echo e(getSeoValues($product->seo, 'og_title')); ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-from-label">OG Description</label>
                                <div class="col-lg-8">
                                    <textarea name="og_description" rows="8" class="form-control"><?php echo e(getSeoValues($product->seo, 'og_description')); ?></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-from-label">Twitter Title</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="twitter_title"
                                        placeholder="Twitter Title"
                                        value="<?php echo e(getSeoValues($product->seo, 'twitter_title')); ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-from-label">Twitter Description</label>
                                <div class="col-lg-8">
                                    <textarea name="twitter_description" rows="8" class="form-control"><?php echo e(getSeoValues($product->seo, 'twitter_description')); ?></textarea>
                                </div>
                            </div>

                        </div>
                    </div>


                </div>
                <div class="col-lg-4">

                    <div class="card d-none">
                        <div class="card-header">
                            <h5 class="mb-0 h6">Price visibility</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-md-6 col-from-label">Hide Price</label>
                                <div class="col-md-6">
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input type="checkbox" name="hide_price" value="1"
                                            <?php if($product->hide_price == 1): ?> checked <?php endif; ?>>
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card d-none">
                        <div class="card-header">
                            <h5 class="mb-0 h6">Low Stock Quantity Warning</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label for="name">
                                    Quantity
                                </label>
                                <input type="number" name="low_stock_quantity"
                                    value="<?php echo e($product->low_stock_quantity); ?>" min="0" step="1"
                                    class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="card d-none">
                        <div class="card-header">
                            <h5 class="mb-0 h6">
                                Stock Visibility State
                            </h5>
                        </div>

                        <div class="card-body">

                            <div class="form-group row">
                                <label class="col-md-6 col-from-label">Show Stock Quantity</label>
                                <div class="col-md-6">
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input type="radio" name="stock_visibility_state" value="quantity"
                                            <?php if($product->stock_visibility_state == 'quantity'): ?> checked <?php endif; ?>>
                                        <span></span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-6 col-from-label">Show Stock With Text Only</label>
                                <div class="col-md-6">
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input type="radio" name="stock_visibility_state" value="text"
                                            <?php if($product->stock_visibility_state == 'text'): ?> checked <?php endif; ?>>
                                        <span></span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-6 col-from-label">Hide Stock</label>
                                <div class="col-md-6">
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input type="radio" name="stock_visibility_state" value="hide"
                                            <?php if($product->stock_visibility_state == 'hide'): ?> checked <?php endif; ?>>
                                        <span></span>
                                    </label>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="card d-none">
                        <div class="card-header">
                            <h5 class="mb-0 h6">Featured</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="col-md-6 col-from-label">Status</label>
                                        <div class="col-md-6">
                                            <label class="aiz-switch aiz-switch-success mb-0">
                                                <input type="checkbox" name="featured" value="1"
                                                    <?php if($product->featured == 1): ?> checked <?php endif; ?>>
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card d-none">
                        <div class="card-header">
                            <h5 class="mb-0 h6">Todays Deal</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="col-md-6 col-from-label">Status</label>
                                        <div class="col-md-6">
                                            <label class="aiz-switch aiz-switch-success mb-0">
                                                <input type="checkbox" name="todays_deal" value="1"
                                                    <?php if($product->todays_deal == 1): ?> checked <?php endif; ?>>
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">Return and refund status</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-md-6 col-from-label">Status</label>
                                <div class="col-md-6">
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input type="checkbox" name="return_refund" value="1" <?php if($product->return_refund == 1): ?> checked <?php endif; ?>>
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-12">
                    <div class="mb-3 text-right">
                        <button type="submit" name="button" class="btn btn-info">Update Product</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"
        integrity="sha512-foIijUdV0fR0Zew7vmw98E6mOWd9gkGWQBWaoA1EOFAx+pY+N8FmmtIYAVj64R98KeD2wzZh1aHK0JSpKmRH8w=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $('.remove-thumbnail').on('click', function() {
            thumbnail = $(this)
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: '<?php echo e(route('products.delete_thumbnail')); ?>',
                data: {
                    id: '<?php echo e($product->id); ?>'
                },
                success: function(data) {
                    $(thumbnail).closest('.file-preview-item').remove();
                }
            });

        });
        $('.remove-galley').on('click', function() {
            thumbnail = $(this)
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: '<?php echo e(route('products.delete_gallery')); ?>',
                data: {
                    url: $(thumbnail).data('url'),
                    id: '<?php echo e($product->id); ?>'
                },
                success: function(data) {
                    $(thumbnail).closest('.file-preview-item').remove();
                }
            });
        });
    </script>

    <?php
        $tabs = [];
        foreach ($product->tabs as $key => $tab) {
            $tabs[$key]['tab_id'] = $tab->id;
            $tabs[$key]['tab_heading'] = $tab->heading;
            $tabs[$key]['tab_description'] = $tab->content;
        }
    ?>

    <script>
        var repeater = $('.repeater').repeater({
            initEmpty: true,
            show: function() {

                buttons = [
                    ["font", ["bold", "underline", "italic", "clear"]],
                    ["para", ["ul", "ol", "paragraph"]],
                    ["style", ["style"]],
                    ["color", ["color"]],
                    ["table", ["table"]],
                    ["insert", ["link", "picture", "video"]],
                    ["view", ["fullscreen", "undo", "redo"]],
                ];

                note = $(this).find('.text-area').summernote({
                    toolbar: buttons,
                    height: 200,
                    callbacks: {
                        onImageUpload: function(data) {
                            data.pop();
                        },
                        onPaste: function(e) {
                            if (format) {
                                var bufferText = ((e.originalEvent || e).clipboardData || window
                                    .clipboardData).getData('Text');
                                e.preventDefault();
                                document.execCommand('insertText', false, bufferText);
                            }
                        }
                    }
                });

                var nativeHtmlBuilderFunc = note.summernote('module', 'videoDialog').createVideoNode;

                note.summernote('module', 'videoDialog').createVideoNode = function(url) {
                    var wrap = $('<div class="embed-responsive embed-responsive-16by9"></div>');
                    var html = nativeHtmlBuilderFunc(url);
                    html = $(html).addClass('embed-responsive-item');
                    return wrap.append(html)[0];
                };

                $(this).slideDown();

            },
            hide: function(deleteElement) {
                if (confirm('Are you sure you want to delete this element?')) {
                    $(this).slideUp(deleteElement);
                }
            },
        });

        repeater.setList(<?php echo json_encode($tabs); ?>);
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            show_hide_shipping_div();
        });

        $("[name=shipping_type]").on("change", function() {
            show_hide_shipping_div();
        });

        function show_hide_shipping_div() {
            var shipping_val = $("[name=shipping_type]:checked").val();

            $(".flat_rate_shipping_div").hide();

            if (shipping_val == 'flat_rate') {
                $(".flat_rate_shipping_div").show();
            }
        }

        function add_more_customer_choice_option(i, name) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: '<?php echo e(route('products.add-more-choice-option')); ?>',
                data: {
                    attribute_id: i
                },
                success: function(data) {
                    var obj = JSON.parse(data);
                    name = $.trim(name);
                    $('#customer_choice_options').append(
                        '<div class="form-group row"><div class="col-md-3"><input type="hidden" name="choice_no[]" value="' + i +'"><input type="text" class="form-control" name="choice[]" value="' + name +'" placeholder="Choice Title" readonly></div><div class="col-md-8"><select class="form-control aiz-selectpicker attribute_choice" data-live-search="true" name="choice_options_' + i + '[]" multiple>' + obj + '</select></div></div>'
                    );
                    AIZ.plugins.bootstrapSelect('refresh');
                }
            });


        }

        $('input[name="colors_active"]').on('change', function() {
            if (!$('input[name="colors_active"]').is(':checked')) {
                $('#colors').prop('disabled', true);
                AIZ.plugins.bootstrapSelect('refresh');
            } else {
                $('#colors').prop('disabled', false);
                AIZ.plugins.bootstrapSelect('refresh');
            }
            update_sku();
        });

        $(document).on("change", ".attribute_choice", function() {
            update_sku();
        });

        $('#colors').on('change', function() {
            update_sku();
        });

        function delete_row(em) {
            $(em).closest('.form-group').remove();
            update_sku();
        }

        function delete_variant(em) {
            $(em).closest('.variant').remove();
        }

        function update_sku() {
            $.ajax({
                type: "POST",
                url: '<?php echo e(route('products.sku_combination_edit')); ?>',
                data: $('#choice_form').serialize(),
                success: function(data) {
                    $('#sku_combination').html(data);
                    AIZ.uploader.previewGenerate();
                    AIZ.plugins.fooTable();
                    if (data.length > 1) {
                        $('#show-hide-div').hide();
                    } else {
                        $('#show-hide-div').show();
                    }
                }
            });
        }

        AIZ.plugins.tagify();

        $(document).ready(function() {
            update_sku();

            $('.remove-files').on('click', function() {
                $(this).parents(".col-md-4").remove();
            });
        });

        $('#choice_attributes').on('change', function() {
            $.each($("#choice_attributes option:selected"), function(j, attribute) {
                flag = false;
                $('input[name="choice_no[]"]').each(function(i, choice_no) {
                    if ($(attribute).val() == $(choice_no).val()) {
                        flag = true;
                    }
                });
                if (!flag) {
                    add_more_customer_choice_option($(attribute).val(), $(attribute).text());
                }
            });

            var str = <?php echo $product->attributes ?>;

            $.each(str, function(index, value) {
                flag = false;
                $.each($("#choice_attributes option:selected"), function(j, attribute) {
                    if (value == $(attribute).val()) {
                        flag = true;
                    }
                });
                if (!flag) {
                    $('input[name="choice_no[]"][value="' + value + '"]').parent().parent().remove();
                }
            });

            update_sku();
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\jisha\Medon-Laravel\resources\views/backend/product/products/edit.blade.php ENDPATH**/ ?>