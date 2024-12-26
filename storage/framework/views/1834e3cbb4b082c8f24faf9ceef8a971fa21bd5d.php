<div class="aiz-sidebar-wrap">
    <div class="aiz-sidebar left c-scrollbar">
        <div class="aiz-side-nav-logo-wrap">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="d-block text-center">
                <?php if(get_setting('system_logo_white') != null): ?>
                    <img class="mw-100" src="<?php echo e(uploaded_asset(get_setting('system_logo_white'))); ?>" class="brand-icon"
                        alt="<?php echo e(get_setting('site_name')); ?>">
                <?php else: ?>
                    <img class="mw-100" src="<?php echo e(static_asset('assets/img/logo.png')); ?>" class="brand-icon"
                        alt="<?php echo e(get_setting('site_name')); ?>">
                <?php endif; ?>
            </a>
        </div>
        <div class="aiz-side-nav-wrap">
            <div class="px-20px mb-3">
                <input class="form-control bg-soft-secondary border-0 form-control-sm text-white" type="text"
                    name="" placeholder="Search in menu" id="menu-search" onkeyup="menuSearch()">
            </div>
            <ul class="aiz-side-nav-list" id="search-menu">
            </ul>
            <ul class="aiz-side-nav-list" id="main-menu" data-toggle="aiz-side-menu">
                <li class="aiz-side-nav-item">
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="aiz-side-nav-link">
                        <i class="las la-home aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">Dashboard</span>
                    </a>
                </li>

                <!-- Product -->
                <?php if(userHasPermision(2)): ?>
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-shopping-cart aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">Products</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <!--Submenu-->
                        <ul class="aiz-side-nav-list level-2">
                            <?php if(userHasPermision(25)): ?>
                                <li class="aiz-side-nav-item">
                                    <a class="aiz-side-nav-link" href="<?php echo e(route('products.create')); ?>">
                                        <span class="aiz-side-nav-text">Add New product</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(userHasPermision(2)): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('products.all')); ?>" class="aiz-side-nav-link <?php echo e(areActiveRoutes(['products.all', 'products.edit'])); ?>">
                                        <span class="aiz-side-nav-text">All Products</span>
                                    </a>
                                </li>

                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('categories.index')); ?>"
                                        class="aiz-side-nav-link <?php echo e(areActiveRoutes(['categories.index', 'categories.create', 'categories.edit'])); ?>">
                                        <span class="aiz-side-nav-text">Category</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('brands.index')); ?>"
                                        class="aiz-side-nav-link <?php echo e(areActiveRoutes(['brands.index', 'brands.create', 'brands.edit'])); ?>">
                                        <span class="aiz-side-nav-text">Brand</span>
                                    </a>
                                </li>
                                
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('reviews.index')); ?>" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">Product Reviews</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(userHasPermision(30)): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('product_bulk_upload.index')); ?>" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">Bulk Import</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(userHasPermision(31)): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('product_bulk_export.index')); ?>" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">Bulk Export</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if(userHasPermision(3) || userHasPermision(28)): ?>
                    <!-- Sale -->
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-money-bill aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">Sales</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <!--Submenu-->
                        <ul class="aiz-side-nav-list level-2">
                            <?php if(userHasPermision(3)): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('all_orders.index')); ?>"
                                        class="aiz-side-nav-link <?php echo e(areActiveRoutes(['all_orders.index', 'all_orders.show','delivery-agents'])); ?>">
                                        <span class="aiz-side-nav-text">All Orders</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(userHasPermision(4)): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('return_requests.index')); ?>"
                                        class="aiz-side-nav-link <?php echo e(areActiveRoutes(['return_requests.index', 'return_orders.show'])); ?>">
                                        <span class="aiz-side-nav-text">Return Requests</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(userHasPermision(5)): ?>
                                <li class="aiz-side-nav-item">
                                    <a href="<?php echo e(route('cancel_requests.index')); ?>"
                                        class="aiz-side-nav-link <?php echo e(areActiveRoutes(['cancel_requests.index', 'cancel_orders.show'])); ?>">
                                        <span class="aiz-side-nav-text">Cancel Requests</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>



                <!-- Customers -->
                <?php if(userHasPermision(8)): ?>
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-user-friends aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">Customers</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            <li class="aiz-side-nav-item">
                                <a href="<?php echo e(route('customers.index')); ?>" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">Customer list</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if(userHasPermision(22)): ?>
                    <li class="aiz-side-nav-item">
                        <a href="<?php echo e(route('uploaded-files.index')); ?>"
                            class="aiz-side-nav-link <?php echo e(areActiveRoutes(['uploaded-files.create'])); ?>">
                            <i class="las la-folder-open aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">Uploaded Files</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if(userHasPermision(23)): ?>
                    <li class="aiz-side-nav-item">
                        <a href="<?php echo e(route('prescriptions')); ?>"
                            class="aiz-side-nav-link <?php echo e(areActiveRoutes(['prescriptions'])); ?>">
                            <i class="las la-folder-open aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">Prescriptions</span>
                        </a>
                    </li>
                <?php endif; ?>
                <!-- Reports -->
                <?php if(userHasPermision(10)): ?>
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-file-alt aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">Reports</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            <!--<li class="aiz-side-nav-item">-->
                            <!--    <a href="<?php echo e(route('in_house_sale_report.index')); ?>"-->
                            <!--        class="aiz-side-nav-link <?php echo e(areActiveRoutes(['in_house_sale_report.index'])); ?>">-->
                            <!--        <span class="aiz-side-nav-text">Product Sale</span>-->
                            <!--    </a>-->
                            <!--</li>-->
                            
                            <li class="aiz-side-nav-item">
                                <a href="<?php echo e(route('stock_report.index')); ?>"
                                    class="aiz-side-nav-link <?php echo e(areActiveRoutes(['stock_report.index'])); ?>">
                                    <span class="aiz-side-nav-text">Products Stock</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="<?php echo e(route('wish_report.index')); ?>"
                                    class="aiz-side-nav-link <?php echo e(areActiveRoutes(['wish_report.index'])); ?>">
                                    <span class="aiz-side-nav-text">Products wishlist</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="<?php echo e(route('user_search_report.index')); ?>"
                                    class="aiz-side-nav-link <?php echo e(areActiveRoutes(['user_search_report.index'])); ?>">
                                    <span class="aiz-side-nav-text">User Searches</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="<?php echo e(route('abandoned-cart.index')); ?>"
                                    class="aiz-side-nav-link <?php echo e(areActiveRoutes(['abandoned-cart.index','abandoned-cart.view'])); ?>">
                                    <span class="aiz-side-nav-text">Abandoned Cart</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if(userHasPermision(26)): ?>
                    <li class="aiz-side-nav-item">
                        <a href="<?php echo e(route('delivery_boy.index')); ?>"
                            class="aiz-side-nav-link <?php echo e(areActiveRoutes(['delivery_boy.index', 'delivery_boy.create', 'delivery_boy.edit'])); ?>">
                            <i class="las la-motorcycle aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">Delivery Boys</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if(userHasPermision(29)): ?>
                    <li class="aiz-side-nav-item">
                        <a href="<?php echo e(route('enquiries.contact')); ?>"
                            class="aiz-side-nav-link <?php echo e(areActiveRoutes(['enquiries.contact'])); ?>">
                            <i class="las la-mail-bulk aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">Contact Enquiries</span>
                        </a>
                    </li>
                <?php endif; ?>

                <!-- marketing -->
                <?php if(userHasPermision(11)): ?>
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-bullhorn aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">Marketing</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            
                            <li class="aiz-side-nav-item">
                                <a href="<?php echo e(route('subscribers.index')); ?>" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">Subscribers</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="<?php echo e(route('coupon.index')); ?>"
                                    class="aiz-side-nav-link <?php echo e(areActiveRoutes(['coupon.index', 'coupon.create', 'coupon.edit'])); ?>">
                                    <span class="aiz-side-nav-text">Coupon</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="<?php echo e(route('offers.index')); ?>"
                                    class="aiz-side-nav-link <?php echo e(areActiveRoutes(['offers.index', 'offers.create', 'offers.edit'])); ?>">
                                    <span class="aiz-side-nav-text">Offers</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>


                <!-- Website Setup -->
                <?php if(userHasPermision(13)): ?>
                    <li class="aiz-side-nav-item">
                        <a href="#"
                            class="aiz-side-nav-link <?php echo e(areActiveRoutes(['website.footer', 'website.header', 'banners.*'])); ?>">
                            <i class="las la-desktop aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">Website Setup</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            <li class="aiz-side-nav-item">
                                <a href="<?php echo e(route('website.header')); ?>" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">Header</span>
                                </a>
                            </li>
                            
                            <li class="aiz-side-nav-item">
                                <a href="<?php echo e(route('website.footer', ['lang' => App::getLocale()])); ?>"
                                    class="aiz-side-nav-link <?php echo e(areActiveRoutes(['website.footer'])); ?>">
                                    <span class="aiz-side-nav-text">Footer</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="<?php echo e(route('website.pages')); ?>"
                                    class="aiz-side-nav-link <?php echo e(areActiveRoutes(['website.pages', 'custom-pages.create', 'custom-pages.edit'])); ?>">
                                    <span class="aiz-side-nav-text">Pages</span>
                                </a>
                            </li>
                            
                            <li class="aiz-side-nav-item">
                                <a href="<?php echo e(route('home-slider.index')); ?>"
                                    class="aiz-side-nav-link <?php echo e(areActiveRoutes(['home-slider.index', 'home-slider.create', 'home-slider.edit'])); ?>">
                                    <span class="aiz-side-nav-text">Home Page Sliders</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="<?php echo e(route('banners.index')); ?>"
                                    class="aiz-side-nav-link <?php echo e(areActiveRoutes(['banners.index', 'banners.create', 'banners.edit'])); ?>">
                                    <span class="aiz-side-nav-text">Banners</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if(userHasPermision(27)): ?>
                    <li class="aiz-side-nav-item">
                        <a href="#"
                            class="aiz-side-nav-link <?php echo e(areActiveRoutes(['website.footer', 'website.header', 'banners.*'])); ?>">
                            <i class="las la-mobile aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">App Setup</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            <li class="aiz-side-nav-item">
                                <a href="<?php echo e(route('splash_screen.index')); ?>"
                                    class="aiz-side-nav-link <?php echo e(areActiveRoutes(['splash_screen.index'])); ?>">
                                    <span class="aiz-side-nav-text">Splash Sliders</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="<?php echo e(route('app-banner.index')); ?>"
                                    class="aiz-side-nav-link <?php echo e(areActiveRoutes(['app-banner.index', 'app-banner.create', 'app-banner.edit'])); ?>">
                                    <span class="aiz-side-nav-text">Home Sliders</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="<?php echo e(route('app.home')); ?>"
                                    class="aiz-side-nav-link <?php echo e(areActiveRoutes(['app.home'])); ?>">
                                    <span class="aiz-side-nav-text">Home Page</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

                <!-- Setup & Configurations -->
                <?php if(userHasPermision(14)): ?>
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-dharmachakra aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">Setup & Configurations</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                             <li class="aiz-side-nav-item">
                                <a href="<?php echo e(route('shipping_configuration.index')); ?>" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">Shipping and Return</span>
                                </a>
                            </li>
                            


                            
                            

                            <!--<li class="aiz-side-nav-item">-->
                            <!--    <a href="javascript:void(0);" class="aiz-side-nav-link">-->
                            <!--        <span class="aiz-side-nav-text">Facebook</span>-->
                            <!--        <span class="aiz-side-nav-arrow"></span>-->
                            <!--    </a>-->
                            <!--    <ul class="aiz-side-nav-list level-3">-->
                            <!--        <li class="aiz-side-nav-item">-->
                            <!--            <a href="<?php echo e(route('facebook_chat.index')); ?>" class="aiz-side-nav-link">-->
                            <!--                <span class="aiz-side-nav-text">Facebook Chat</span>-->
                            <!--            </a>-->
                            <!--        </li>-->
                            <!--        <li class="aiz-side-nav-item">-->
                            <!--            <a href="<?php echo e(route('facebook-comment')); ?>" class="aiz-side-nav-link">-->
                            <!--                <span class="aiz-side-nav-text">Facebook Comment</span>-->
                            <!--            </a>-->
                            <!--        </li>-->
                            <!--    </ul>-->
                            <!--</li>-->

                            <!--<li class="aiz-side-nav-item">-->
                            <!--    <a href="javascript:void(0);" class="aiz-side-nav-link">-->
                            <!--        <span class="aiz-side-nav-text">Google</span>-->
                            <!--        <span class="aiz-side-nav-arrow"></span>-->
                            <!--    </a>-->
                            <!--    <ul class="aiz-side-nav-list level-3">-->
                            <!--        <li class="aiz-side-nav-item">-->
                            <!--            <a href="<?php echo e(route('google_analytics.index')); ?>" class="aiz-side-nav-link">-->
                            <!--                <span class="aiz-side-nav-text">Analytics Tools</span>-->
                            <!--            </a>-->
                            <!--        </li>-->
                            <!--        <li class="aiz-side-nav-item">-->
                            <!--            <a href="<?php echo e(route('google_recaptcha.index')); ?>" class="aiz-side-nav-link">-->
                            <!--                <span class="aiz-side-nav-text">Google reCAPTCHA</span>-->
                            <!--            </a>-->
                            <!--        </li>-->
                            <!--        <li class="aiz-side-nav-item">-->
                            <!--            <a href="<?php echo e(route('google-map.index')); ?>" class="aiz-side-nav-link">-->
                            <!--                <span class="aiz-side-nav-text">Google Map</span>-->
                            <!--            </a>-->
                            <!--        </li>-->
                            <!--        <li class="aiz-side-nav-item">-->
                            <!--            <a href="<?php echo e(route('google-firebase.index')); ?>" class="aiz-side-nav-link">-->
                            <!--                <span class="aiz-side-nav-text">Google Firebase</span>-->
                            <!--            </a>-->
                            <!--        </li>-->
                            <!--    </ul>-->
                            <!--</li>-->




                            

                        </ul>
                    </li>
                <?php endif; ?>

                <?php if(userHasPermision(21)): ?>
                    <li class="aiz-side-nav-item">
                        <a href="<?php echo e(route('admin.shops.index')); ?>"
                            class="aiz-side-nav-link <?php echo e(areActiveRoutes(['admin.shops.index','admin.shops.create','admin.shops.edit'])); ?>">
                            <i class="las la-store aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">Shops</span>
                        </a>
                    </li>
                <?php endif; ?>

                <!-- Staffs -->
                <?php if(userHasPermision(20)): ?>
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-user-tie aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">Staffs</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            <li class="aiz-side-nav-item">
                                <a href="<?php echo e(route('staffs.index')); ?>"
                                    class="aiz-side-nav-link <?php echo e(areActiveRoutes(['staffs.index', 'staffs.create', 'staffs.edit'])); ?>">
                                    <span class="aiz-side-nav-text">All staffs</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="<?php echo e(route('roles.index')); ?>"
                                    class="aiz-side-nav-link <?php echo e(areActiveRoutes(['roles.index', 'roles.create', 'roles.edit'])); ?>">
                                    <span class="aiz-side-nav-text">Staff permissions</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

            </ul><!-- .aiz-side-nav -->
        </div><!-- .aiz-side-nav-wrap -->
    </div><!-- .aiz-sidebar -->
    <div class="aiz-sidebar-overlay"></div>
</div><!-- .aiz-sidebar -->
<?php /**PATH C:\wamp64\www\jisha\Medon-Laravel\resources\views/backend/inc/admin_sidenav.blade.php ENDPATH**/ ?>