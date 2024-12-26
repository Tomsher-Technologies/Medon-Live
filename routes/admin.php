<?php

/*
  |--------------------------------------------------------------------------
  | Admin Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register admin routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

use App\Http\Controllers\Admin\AbandonedCartController;
use App\Http\Controllers\Admin\App\AppBannerController;
use App\Http\Controllers\Admin\App\AppHomeController;
use App\Http\Controllers\Admin\App\SplashScreenController;
use App\Http\Controllers\Admin\Auth\LoginController as AuthLoginController;
use App\Http\Controllers\Admin\Delivery\DeliveryBoyController;
use App\Http\Controllers\Admin\Frontend\Bannercontroller;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AizUploadController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\BusinessSettingsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\CustomerBulkUploadController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerPackageController;
use App\Http\Controllers\CustomerProductController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductBulkUploadController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\UpdateController;
use App\Http\Controllers\WebsiteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Frontend\HomeSliderController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\TempImageController;
use App\Http\Controllers\CareersController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RequestQuoteController;
use App\Http\Controllers\ShopsController;
use App\Models\Notification;

Route::get('/admin/notifications', function () {
    $admin = auth()->user();
    return $admin->unreadNotifications;
})->middleware('auth');

Route::post('/admin/notifications/mark-as-read', function () {
    $admin = auth()->user();
    $admin->unreadNotifications->markAsRead();
    return response()->json(['success' => true]);
})->middleware('auth');

Route::post('/update', [UpdateController::class, 'step0'])->name('update');
Route::get('/update/step1', [UpdateController::class, 'step1'])->name('update.step1');
Route::get('/update/step2', [UpdateController::class, 'step2'])->name('update.step2');

Route::get('/' . env('ADMIN_PREFIX'), [AdminController::class, 'admin_dashboard'])
    ->name('admin.dashboard')
    ->middleware(['auth', 'admin']);

Route::get('/', [AuthLoginController::class, 'adminLoginView'])->name('home');

Route::group(['prefix' => env('ADMIN_PREFIX'), 'middleware' => ['guest']], function () {
    Route::get('login', [AuthLoginController::class, 'adminLoginView'])->name('admin.login');
    Route::post('login', [AuthLoginController::class, 'login']);
});

Route::group(['prefix' => env('ADMIN_PREFIX'), 'middleware' => ['auth', 'admin']], function () {

    // Logout
    Route::get('/logout', [AuthLoginController::class, 'logout'])->name('admin.logout');

    //Update Routes
    Route::resource('categories', CategoryController::class);
    Route::get('/categories/edit/{id}', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::get('/categories/destroy/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::post('/categories/featured', [CategoryController::class, 'updateFeatured'])->name('categories.featured');
    Route::post('/categories/status', [CategoryController::class, 'updateStatus'])->name('categories.status');

    Route::resource('brands', BrandController::class);
    // Route::get('/brands/edit/{id}', [BrandController::class, 'edit'])->name('brands.edit');
    Route::get('/brands/destroy/{id}', [BrandController::class, 'destroy'])->name('brands.destroy');
    Route::post('/brands/status', [BrandController::class, 'updateStatus'])->name('brands.status');

    // Route::get('/products/admin', [ProductController::class, 'admin_products'])->name('products.admin');
    // Route::get('/products/seller', [ProductController::class, 'seller_products'])->name('products.seller');
    Route::get('/products/all', [ProductController::class, 'all_products'])->name('products.all');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::get('/products/admin/{id}/edit', [ProductController::class, 'admin_product_edit'])->name('products.edit');
    // Route::get('/products/seller/{id}/edit', [ProductController::class, 'seller_product_edit'])->name('products.seller.edit');
    Route::post('/products/todays_deal', [ProductController::class, 'updateTodaysDeal'])->name('products.todays_deal');
    Route::post('/products/featured', [ProductController::class, 'updateFeatured'])->name('products.featured');
    Route::post('/products/approved', [ProductController::class, 'updateProductApproval'])->name('products.approved');
    Route::post('/products/get_products_by_subcategory', [ProductController::class, 'get_products_by_subcategory'])->name('products.get_products_by_subcategory');
    Route::post('/bulk-product-delete', [ProductController::class, 'bulk_product_delete'])->name('bulk-product-delete');

    Route::post('/products/store/', [ProductController::class, 'store'])->name('products.store');
    Route::post('/products/update/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::get('/products/destroy/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/products/duplicate/{id}', [ProductController::class, 'duplicate'])->name('products.duplicate');
    Route::post('/products/delete-thumbnail', [ProductController::class, 'delete_thumbnail'])->name('products.delete_thumbnail');
    Route::post('/products/delete_gallery', [ProductController::class, 'delete_gallery'])->name('products.delete_gallery');

    Route::post('/products/slug_check', [ProductController::class, 'slug_check'])->name('products.slug_check');

    Route::post('/products/sku_combination', [ProductController::class, 'sku_combination'])->name('products.sku_combination');
    Route::post('/products/sku_combination_edit', [ProductController::class, 'sku_combination_edit'])->name('products.sku_combination_edit');
    Route::post('/products/seller/featured', [ProductController::class, 'updateSellerFeatured'])->name('products.seller.featured');
    Route::post('/products/published', [ProductController::class, 'updatePublished'])->name('products.published');
    Route::post('/products/add-more-choice-option', [ProductController::class, 'add_more_choice_option'])->name('products.add-more-choice-option');


    //Product Bulk Upload
    Route::get('/product-bulk-upload/index', [ProductBulkUploadController::class, 'index'])->name('product_bulk_upload.index');
    Route::post('/bulk-product-upload', [ProductBulkUploadController::class, 'bulk_upload'])->name('bulk_product_upload');
    Route::get('/product-csv-download/{type}', [ProductBulkUploadController::class, 'import_product'])->name('product_csv.download');
    Route::get('/vendor-product-csv-download/{id}', [ProductBulkUploadController::class, 'import_vendor_product'])->name('import_vendor_product.download');
    Route::group(['prefix' => 'bulk-upload/download'], function () {
        Route::get('/category', [ProductBulkUploadController::class, 'pdf_download_category'])->name('pdf.download_category');
        Route::get('/brand', [ProductBulkUploadController::class, 'pdf_download_brand'])->name('pdf.download_brand');
        Route::get('/seller', [ProductBulkUploadController::class, 'pdf_download_seller'])->name('pdf.download_seller');
    });

    //Product Export
    Route::get('/product-bulk-export', [ProductBulkUploadController::class, 'export'])->name('product_bulk_export.index');

    Route::resource('customers', CustomerController::class);
    Route::get('customers_ban/{customer}', [CustomerController::class, 'ban'])->name('customers.ban');
    Route::get('/customers/login/{id}', [CustomerController::class, 'login'])->name('customers.login');
    Route::get('/customers/destroy/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');
    Route::post('/bulk-customer-delete', [CustomerController::class, 'bulk_customer_delete'])->name('bulk-customer-delete');

    Route::post('/addresses/add/{customer}', [CustomerController::class, 'create_address'])->name('admin.addresses.create');
    Route::post('/addresses/update/{customer}/{id}', [CustomerController::class, 'update_address'])->name('admin.addresses.update');
    Route::get('/addresses/destroy/{customer}/{id}', [CustomerController::class, 'delete_address'])->name('admin.addresses.destroy');
    Route::get('/addresses/set_default/{customer}/{id}', [CustomerController::class, 'address_set_default'])->name('admin.addresses.set_default');

    Route::get('/newsletter', [NewsletterController::class, 'index'])->name('newsletters.index');
    Route::post('/newsletter/send', [NewsletterController::class, 'send'])->name('newsletters.send');
    Route::post('/newsletter/test/smtp', [NewsletterController::class, 'testEmail'])->name('test.smtp');

    Route::resource('profile', ProfileController::class);

    Route::post('/business-settings/update', [BusinessSettingsController::class, 'update'])->name('business_settings.update');
    Route::post('/business-settings/update/activation', [BusinessSettingsController::class, 'updateActivationSettings'])->name('business_settings.update.activation');
    Route::get('/general-setting', [BusinessSettingsController::class, 'general_setting'])->name('general_setting.index');
    Route::get('/activation', [BusinessSettingsController::class, 'activation'])->name('activation.index');
    Route::get('/payment-method', [BusinessSettingsController::class, 'payment_method'])->name('payment_method.index');
    Route::get('/file_system', [BusinessSettingsController::class, 'file_system'])->name('file_system.index');
    Route::get('/social-login', [BusinessSettingsController::class, 'social_login'])->name('social_login.index');
    Route::get('/smtp-settings', [BusinessSettingsController::class, 'smtp_settings'])->name('smtp_settings.index');
    Route::get('/google-analytics', [BusinessSettingsController::class, 'google_analytics'])->name('google_analytics.index');
    Route::get('/google-recaptcha', [BusinessSettingsController::class, 'google_recaptcha'])->name('google_recaptcha.index');
    Route::get('/google-map', [BusinessSettingsController::class, 'google_map'])->name('google-map.index');
    Route::get('/google-firebase', [BusinessSettingsController::class, 'google_firebase'])->name('google-firebase.index');

    //Facebook Settings
    Route::get('/facebook-chat', [BusinessSettingsController::class, 'facebook_chat'])->name('facebook_chat.index');
    Route::post('/facebook_chat', [BusinessSettingsController::class, 'facebook_chat_update'])->name('facebook_chat.update');
    Route::get('/facebook-comment', [BusinessSettingsController::class, 'facebook_comment'])->name('facebook-comment');
    Route::post('/facebook-comment', [BusinessSettingsController::class, 'facebook_comment_update'])->name('facebook-comment.update');
    Route::post('/facebook_pixel', [BusinessSettingsController::class, 'facebook_pixel_update'])->name('facebook_pixel.update');

    Route::post('/env_key_update', [BusinessSettingsController::class, 'env_key_update'])->name('env_key_update.update');
    Route::post('/payment_method_update', [BusinessSettingsController::class, 'payment_method_update'])->name('payment_method.update');
    Route::post('/google_analytics', [BusinessSettingsController::class, 'google_analytics_update'])->name('google_analytics.update');
    Route::post('/google_recaptcha', [BusinessSettingsController::class, 'google_recaptcha_update'])->name('google_recaptcha.update');
    Route::post('/google-map', [BusinessSettingsController::class, 'google_map_update'])->name('google-map.update');
    Route::post('/google-firebase', [BusinessSettingsController::class, 'google_firebase_update'])->name('google-firebase.update');
    //Currency
    Route::get('/currency', [CurrencyController::class, 'currency'])->name('currency.index');
    Route::post('/currency/update', [CurrencyController::class, 'updateCurrency'])->name('currency.update');
    Route::post('/your-currency/update', [CurrencyController::class, 'updateYourCurrency'])->name('your_currency.update');
    Route::get('/currency/create', [CurrencyController::class, 'create'])->name('currency.create');
    Route::post('/currency/store', [CurrencyController::class, 'store'])->name('currency.store');
    Route::post('/currency/currency_edit', [CurrencyController::class, 'edit'])->name('currency.edit');
    Route::post('/currency/update_status', [CurrencyController::class, 'update_status'])->name('currency.update_status');

    //Tax
    Route::resource('tax', TaxController::class);
    Route::get('/tax/edit/{id}', [TaxController::class, 'edit'])->name('tax.edit');
    Route::get('/tax/destroy/{id}', [TaxController::class, 'destroy'])->name('tax.destroy');
    Route::post('tax-status', [TaxController::class, 'change_tax_status'])->name('taxes.tax-status');


    Route::get('/verification/form', [BusinessSettingsController::class, 'seller_verification_form'])->name('seller_verification_form.index');
    Route::post('/verification/form', [BusinessSettingsController::class, 'seller_verification_form_update'])->name('seller_verification_form.update');
    Route::get('/vendor_commission', [BusinessSettingsController::class, 'vendor_commission'])->name('business_settings.vendor_commission');
    Route::post('/vendor_commission_update', [BusinessSettingsController::class, 'vendor_commission_update'])->name('business_settings.vendor_commission.update');

    Route::resource('/languages', LanguageController::class);
    Route::post('/languages/{id}/update', [LanguageController::class, 'update'])->name('languages.update');
    Route::get('/languages/destroy/{id}', [LanguageController::class, 'destroy'])->name('languages.destroy');
    Route::post('/languages/update_rtl_status', [LanguageController::class, 'update_rtl_status'])->name('languages.update_rtl_status');
    Route::post('/languages/update-status', [LanguageController::class, 'update_status'])->name('languages.update-status');
    Route::post('/languages/key_value_store', [LanguageController::class, 'key_value_store'])->name('languages.key_value_store');

    //App Trasnlation
    Route::post('/languages/app-translations/import', [LanguageController::class, 'importEnglishFile'])->name('app-translations.import');
    Route::get('/languages/app-translations/show/{id}', [LanguageController::class, 'showAppTranlsationView'])->name('app-translations.show');
    Route::post('/languages/app-translations/key_value_store', [LanguageController::class, 'storeAppTranlsation'])->name('app-translations.store');
    Route::get('/languages/app-translations/export/{id}', [LanguageController::class, 'exportARBFile'])->name('app-translations.export');

    // App setting
    Route::group(['prefix' => 'app'], function () {
        Route::post('/app-banner/update-status', [AppBannerController::class, 'updateStatus'])->name('app-banner.update-status');
        Route::get('/app-banner/delete/{id}', [AppBannerController::class, 'destroy'])->name('app-banner.delete');
        Route::resource('app-banner', AppBannerController::class);

        Route::post('/app-banners', [AppHomeController::class, 'updateBanners'])->name('app-banners.update');
        Route::get('/app-home', [AppHomeController::class, 'index'])->name('app.home');
    });
    
    Route::resource('offers', OfferController::class);
    Route::post('/offers/get-form', [OfferController::class, 'get_form'])->name('offers.get_form');
    Route::post('/offers/get_brands', [OfferController::class, 'get_brands'])->name('offers.get_brands');
    Route::get('/offers/destroy/{id}', [OfferController::class, 'destroy'])->name('offers.destroy');
    // website setting

    Route::get('/enquiries-contact', [PageController::class, 'enquiries'])->name('enquiries.contact');
    Route::group(['prefix' => 'website'], function () {
        Route::get('/footer', [WebsiteController::class, 'footer'])->name('website.footer');

        Route::get('/menu', [WebsiteController::class, 'menu'])->name('website.menu');
        Route::post('/menu', [WebsiteController::class, 'menuUpdate']);

        Route::get('/header', [WebsiteController::class, 'header'])->name('website.header');
        Route::post('/store-header', [WebsiteController::class, 'storeHeader'])->name('store.header');
        Route::get('/appearance', [WebsiteController::class, 'appearance'])->name('website.appearance');
        Route::get('/pages', [WebsiteController::class, 'pages'])->name('website.pages');

        Route::post('/home-slider/update-status', [HomeSliderController::class, 'updateStatus'])->name('home-slider.update-status');
        Route::get('/home-slider/delete/{id}', [HomeSliderController::class, 'destroy'])->name('home-slider.delete');
        Route::resource('home-slider', HomeSliderController::class);

        Route::post('/splash_screen/update-status', [SplashScreenController::class, 'updateStatus'])->name('splash-screen.update-status');
        Route::get('/splash_screen/delete/{id}', [SplashScreenController::class, 'destroy'])->name('splash-screen.delete');
        Route::resource('splash_screen', SplashScreenController::class)->except('show');

        Route::resource('custom-pages', PageController::class);
        Route::get('/custom-pages/edit/{id}', [PageController::class, 'edit'])->name('custom-pages.edit');
        Route::get('/custom-pages/destroy/{id}', [PageController::class, 'destroy'])->name('custom-pages.destroy');
    });

    Route::resource('roles', RoleController::class);
    Route::get('/roles/edit/{id}', [RoleController::class, 'edit'])->name('roles.edit');
    Route::get('/roles/destroy/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');

    Route::resource('staffs', StaffController::class);
    Route::get('/staffs/destroy/{id}', [StaffController::class, 'destroy'])->name('staffs.destroy');

    //Subscribers
    Route::get('/subscribers', [SubscriberController::class, 'index'])->name('subscribers.index');
    Route::get('/subscribers/destroy/{id}', [SubscriberController::class, 'destroy'])->name('subscriber.destroy');

    Route::get('/all_orders', [OrderController::class, 'all_orders'])->name('all_orders.index');
    Route::get('/all_orders/{id}/show', [OrderController::class, 'all_orders_show'])->name('all_orders.show');

    Route::get('/prescriptions', [WebsiteController::class, 'prescriptions'])->name('prescriptions');
    Route::get('/delivery-agents/{id}', [OrderController::class, 'getNearByDeliveryAgents'])->name('delivery-agents');

    Route::resource('shops', ShopsController::class, ['as' => 'admin']);
    Route::post('/shops/delete/', [ShopsController::class, 'delete'])->name('admin.shops.delete');
    Route::get('/shops/edit/{id}', [ShopsController::class, 'edit'])->name('admin.shops.edit');
    Route::post('/shops/update/{id}', [ShopsController::class, 'update'])->name('admin.shops.update');

    Route::get('/cancel_requests', [OrderController::class, 'allCancelRequests'])->name('cancel_requests.index');
    Route::post('/cancel-request-status', [OrderController::class, 'cancelRequestStatus'])->name('cancel-request-status');
    Route::post('/cancel-payment-type', [OrderController::class, 'cancelPaymentType'])->name('cancel-payment-type');
    Route::get('/cancel_orders/{id}/show', [OrderController::class, 'cancel_orders_show'])->name('cancel_orders.show');

    Route::get('/return_requests', [OrderController::class, 'allReturnRequests'])->name('return_requests.index');
    Route::get('/return_orders/{id}/show', [OrderController::class, 'return_orders_show'])->name('return_orders.show');
    Route::post('/return-request-status', [OrderController::class, 'returnRequestStatus'])->name('return-request-status');
    Route::post('/return-payment-type', [OrderController::class, 'returnPaymentType'])->name('return-payment-type');

    Route::get('/return-delivery/{id}', [OrderController::class, 'getNearByReturnDeliveryAgents'])->name('return-delivery');

    Route::get('invoice/{order_id}', [InvoiceController::class, 'invoice_download'])->name('invoice.download');

    Route::post('/bulk-order-status', [OrderController::class, 'bulk_order_status'])->name('bulk-order-status');

    Route::get('/orders/destroy/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
    Route::post('/bulk-order-delete', [OrderController::class, 'bulk_order_delete'])->name('bulk-order-delete');

    Route::post('/assign-shop-order', [OrderController::class, 'assign_shop_order'])->name('assign-shop-order');

    Route::post('/assign-shop-refund', [OrderController::class, 'assign_shop_refund'])->name('assign-shop-refund');
    
    Route::get('/test', [OrderController::class, 'test'])->name('test');
    //Reports
    Route::get('/stock_report', [ReportController::class, 'stock_report'])->name('stock_report.index');
    Route::get('/in_house_sa le_report', [ReportController::class, 'in_house_sale_report'])->name('in_house_sale_report.index');
    Route::get('/wish_report', [ReportController::class, 'wish_report'])->name('wish_report.index');
    Route::get('/user_search_report', [ReportController::class, 'user_search_report'])->name('user_search_report.index');
    Route::get('/abandoned-cart', [AbandonedCartController::class, 'index'])->name('abandoned-cart.index');
    Route::get('/{cart}/abandoned-cart', [AbandonedCartController::class, 'view'])->name('abandoned-cart.view');
    Route::get('/sales_report', [ReportController::class, 'sales_report'])->name('sales_report.index');
    Route::get('/sales_orders/{id}/show', [ReportController::class, 'sales_orders_show'])->name('sales_orders.show');
    Route::get('/export-sales-report', [ReportController::class, 'exportSalesReport'])->name('export.sales_report');

    //Coupons
    Route::resource('coupon', CouponController::class);
    Route::get('/coupon/destroy/{id}', [CouponController::class, 'destroy'])->name('coupon.destroy');
    Route::post('/coupon/get_form', [CouponController::class, 'get_coupon_form'])->name('coupon.get_coupon_form');
    Route::post('/coupon/get_form_edit', [CouponController::class, 'get_coupon_form_edit'])->name('coupon.get_coupon_form_edit');

    //Reviews
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::post('/reviews/published', [ReviewController::class, 'updatePublished'])->name('reviews.published');

    Route::resource('attributes', AttributeController::class);
    Route::get('/attributes/edit/{id}', [AttributeController::class, 'edit'])->name('attributes.edit');
    Route::get('/attributes/destroy/{id}', [AttributeController::class, 'destroy'])->name('attributes.destroy');

    //Attribute Value
    Route::post('/store-attribute-value', [AttributeController::class, 'store_attribute_value'])->name('store-attribute-value');
    Route::get('/edit-attribute-value/{id}', [AttributeController::class, 'edit_attribute_value'])->name('edit-attribute-value');
    Route::post('/update-attribute-value/{id}', [AttributeController::class, 'update_attribute_value'])->name('update-attribute-value');
    Route::get('/destroy-attribute-value/{id}', [AttributeController::class, 'destroy_attribute_value'])->name('destroy-attribute-value');

    Route::get('/customer-bulk-upload/index', [CustomerBulkUploadController::class, 'index'])->name('customer_bulk_upload.index');
    Route::post('/bulk-user-upload', [CustomerBulkUploadController::class, 'user_bulk_upload'])->name('bulk_user_upload');
    Route::post('/bulk-customer-upload', [CustomerBulkUploadController::class, 'customer_bulk_file'])->name('bulk_customer_upload');
    Route::get('/user', [CustomerBulkUploadController::class, 'pdf_download_user'])->name('pdf.download_user');
    //Customer Package

    Route::resource('customer_packages', CustomerPackageController::class);
    Route::get('/customer_packages/edit/{id}', [CustomerPackageController::class, 'edit'])->name('customer_packages.edit');
    Route::get('/customer_packages/destroy/{id}', [CustomerPackageController::class, 'destroy'])->name('customer_packages.destroy');

    //Classified Products
    Route::get('/classified_products', [CustomerProductController::class, 'customer_product_index'])->name('classified_products');
    Route::post('/classified_products/published', [CustomerProductController::class, 'updatePublished'])->name('classified_products.published');

    //Shipping Configuration
    Route::get('/configuration', [BusinessSettingsController::class, 'shipping_configuration'])->name('shipping_configuration.index');
    Route::post('/configuration/update', [BusinessSettingsController::class, 'shipping_configuration_update'])->name('shipping_configuration.update');
    Route::post('/shipping_configuration/free_shipping', [BusinessSettingsController::class, 'freeshipping_settings'])->name('shipping_configuration.free_shipping');
    Route::post('/configuration/return', [BusinessSettingsController::class, 'return_settings'])->name('configuration.return_settings');

    Route::resource('countries', CountryController::class);
    Route::post('/countries/status', [CountryController::class, 'updateStatus'])->name('countries.status');
    Route::post('/countries/rate', [CountryController::class, 'updateRate'])->name('countries.rate');

    Route::resource('states', StateController::class);
    Route::post('/states/status', [StateController::class, 'updateStatus'])->name('states.status');

    Route::resource('cities', CityController::class);
    Route::get('/cities/edit/{id}', [CityController::class, 'edit'])->name('cities.edit');
    Route::get('/cities/destroy/{id}', [CityController::class, 'destroy'])->name('cities.destroy');
    Route::post('/cities/status', [CityController::class, 'updateStatus'])->name('cities.status');

    Route::view('/system/update', 'backend.system.update')->name('system_update');
    Route::view('/system/server-status', 'backend.system.server_status')->name('system_server');

    // uploaded files
    Route::any('/uploaded-files/file-info', [AizUploadController::class, 'file_info'])->name('uploaded-files.info');
    Route::resource('/uploaded-files', AizUploadController::class);
    Route::get('/uploaded-files/destroy/{id}', [AizUploadController::class, 'destroy'])->name('uploaded-files.destroy');

    Route::get('/all-notification', [NotificationController::class, 'index'])->name('admin.all-notification');

    Route::post('/banners/get_form', [Bannercontroller::class, 'get_form'])->name('banners.get_form');
    Route::get('/banners/destroy/{banner}', [Bannercontroller::class, 'destroy'])->name('banners.destroy');
    Route::resource('banners', Bannercontroller::class)->except(['show', 'destroy']);

    Route::post('/aiz-uploader', [AizUploadController::class, 'show_uploader']);
    Route::post('/aiz-uploader/upload', [AizUploadController::class, 'upload']);
    Route::get('/aiz-uploader/get_uploaded_files', [AizUploadController::class, 'get_uploaded_files']);
    Route::post('/aiz-uploader/get_file_by_ids', [AizUploadController::class, 'get_preview_files']);
    Route::get('/aiz-uploader/download/{id}', [AizUploadController::class, 'attachment_download'])->name('download_attachment');


    Route::get('/temp-images', [TempImageController::class, 'index'])->name('temp_image');
    Route::post('/temp-images', [TempImageController::class, 'upload']);
    Route::get('/temp-images/list', [TempImageController::class, 'listAll'])->name('temp_image.all');
    Route::post('/temp-images/delete', [TempImageController::class, 'deleteAll'])->name('temp_image.delete');


    Route::resource('career', CareersController::class)->only('index', 'show', 'delete');
    Route::resource('rfq', RequestQuoteController::class)->only('index', 'show', 'delete');

    // Cache
    Route::get('/cache-cache/{type?}', [AdminController::class, 'clearCache'])->name('cache.clear');


    // Delivery Boy
    Route::resource('delivery_boy', DeliveryBoyController::class)->except('show');


    Route::resource('orders', OrderController::class);
    Route::get('/orders/destroy/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
    Route::post('/orders/details', [OrderController::class, 'order_details'])->name('orders.details');
    Route::post('/orders/update_delivery_status', [OrderController::class, 'update_delivery_status'])->name('orders.update_delivery_status');
    Route::post('/orders/update_payment_status', [OrderController::class, 'update_payment_status'])->name('orders.update_payment_status');
    Route::post('/orders/update_tracking_code', [OrderController::class, 'update_tracking_code'])->name('orders.update_tracking_code');

    Route::post('/orders/update_estimated_date', [OrderController::class, 'update_estimated_date'])->name('orders.update_estimated_date');

    Route::get('get-order-delivery-boys', [OrderController::class, 'getOrderDeliveryBoys'])->name('get-order-delivery-boys');
    Route::post('assign-delivery-boy', [OrderController::class, 'assignDeliveryAgent'])->name('assign-delivery-boy');

    Route::get('get-order-return-delivery-boys', [OrderController::class, 'getOrderReturnDeliveryBoys'])->name('get-order-return-delivery-boys');
    Route::post('assign-return-delivery-boy', [OrderController::class, 'assignReturnDeliveryAgent'])->name('assign-return-delivery-boy');
});
