<!doctype html>
<?php if(\App\Models\Language::where('code', Session::get('locale', Config::get('app.locale')))->first()->rtl == 1): ?>
    <html dir="rtl" lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<?php else: ?>
    <html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<?php endif; ?>

<head>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="app-url" content="<?php echo e(getBaseURL()); ?>">
    <meta name="file-base-url" content="<?php echo e(getFileBaseURL()); ?>">
    <meta name="robots" content="noindex">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicon -->
    <link rel="icon" href="<?php echo e(asset('admin_assets/assets/img/favicon.ico')); ?>">
    <title><?php echo e(env('APP_NAME')); ?> | Admin Panel</title>

    <!-- google font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700">

    <!-- aiz core css -->
    <link rel="stylesheet" href="<?php echo e(static_asset('assets/css/vendors.css')); ?>">
    <?php if(\App\Models\Language::where('code', Session::get('locale', Config::get('app.locale')))->first()->rtl == 1): ?>
        <link rel="stylesheet" href="<?php echo e(static_asset('assets/css/bootstrap-rtl.min.css')); ?>">
    <?php endif; ?>
    <link rel="stylesheet" href="<?php echo e(static_asset('assets/css/aiz-core.css')); ?>">

    <style>
        body {
            font-size: 12px;
        }
    </style>
    <script>
        var AIZ = AIZ || {};
        AIZ.local = {
            nothing_selected: 'Nothing selected',
            nothing_found: 'Nothing found',
            choose_file: 'Choose file',
            file_selected: 'File selected',
            files_selected: 'Files selected',
            add_more_files: 'Add more files',
            adding_more_files: 'Adding more files',
            drop_files_here_paste_or: 'Drop files here, paste or',
            browse: 'Browse',
            upload_complete: 'Upload complete',
            upload_paused: 'Upload paused',
            resume_upload: 'Resume upload',
            pause_upload: 'Pause upload',
            retry_upload: 'Retry upload',
            cancel_upload: 'Cancel upload',
            uploading: 'Uploading',
            processing: 'Processing',
            complete: 'Complete',
            file: 'File',
            files: 'Files',
        }
    </script>
    <?php echo $__env->yieldContent('header'); ?>
</head>

<body class="">

    <div class="aiz-main-wrapper d-flex">
        <div class="flex-grow-1">
            <?php echo $__env->yieldContent('content'); ?>
            <div class="bg-white text-center py-3 px-15px px-lg-25px mt-auto">
                <p class="mb-0">&copy; <?php echo e(env('APP_NAME')); ?> - Developed By <a href="https://www.tomsher.com/">Tomsher</a></p>
            </div>
        </div>
       
    </div><!-- .aiz-main-wrapper -->

    <?php echo $__env->yieldContent('modal'); ?>


    <script src="<?php echo e(static_asset('assets/js/vendors.js')); ?>"></script>
    <script src="<?php echo e(static_asset('assets/js/aiz-core.js')); ?>"></script>

    <?php echo $__env->yieldContent('script'); ?>

    <script type="text/javascript">
        <?php $__currentLoopData = session('flash_notification', collect())->toArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            AIZ.plugins.notify('<?php echo e($message['level']); ?>', '<?php echo e($message['message']); ?>');
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </script>

</body>

</html>
<?php /**PATH C:\wamp64\www\jisha\Medon-Laravel\resources\views/backend/layouts/layout.blade.php ENDPATH**/ ?>