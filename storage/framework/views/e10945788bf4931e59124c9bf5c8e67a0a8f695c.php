<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="app-url" content="<?php echo e(getBaseURL()); ?>">
    <meta name="admin-url" content="<?php echo e(getBaseURL() . env('ADMIN_PREFIX')); ?>">
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
    <link rel="stylesheet" href="<?php echo e(static_asset('assets/css/aiz-core.css')); ?>">

    <style>
        body {
            font-size: 12px;
        }
    </style>
    <script>
        var AIZ = AIZ || {};
        AIZ.local = {
            nothing_selected: '<?php echo translate('Nothing selected', null, true); ?>',
            nothing_found: '<?php echo translate('Nothing found', null, true); ?>',
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

    <?php echo $__env->yieldContent('styles'); ?>

</head>

<body class="">

    <div class="aiz-main-wrapper">
        <?php echo $__env->make('backend.inc.admin_sidenav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="aiz-content-wrapper">
            <?php echo $__env->make('backend.inc.admin_nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="aiz-main-content">
                <div class="px-15px px-lg-25px">
                    <?php echo $__env->yieldContent('content'); ?>
                </div>
                <div class="bg-white text-center py-3 px-15px px-lg-25px mt-auto">
                    <p class="mb-0">&copy; <?php echo e(env('APP_NAME')); ?> - Developed By <a href="https://www.tomsher.com/">Tomsher</a></p>
                </div>
            </div><!-- .aiz-main-content -->
        </div><!-- .aiz-content-wrapper -->
    </div><!-- .aiz-main-wrapper -->
    <button id="fakeButton">Click Me!</button>

    <!-- Modal -->
<div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="notificationModalLabel">New Notifications</h5>
          <button type="button" class="close"  onClick="closeModal()" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="notificationContent">
          <!-- Dynamic notification content will be injected here -->
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" onClick="closeModal()">Close</button>
        </div>
      </div>
    </div>
  </div>

    <?php echo $__env->yieldContent('modal'); ?>


    <script src="<?php echo e(static_asset('assets/js/vendors.js')); ?>"></script>
    <script src="<?php echo e(static_asset('assets/js/aiz-core.js')); ?>"></script>

    <?php echo $__env->yieldContent('script'); ?>

    <script type="text/javascript">
        <?php $__currentLoopData = session('flash_notification', collect())->toArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            AIZ.plugins.notify('<?php echo e($message['level']); ?>', '<?php echo e($message['message']); ?>');
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


        function menuSearch() {
            var filter, item;
            filter = $("#menu-search").val().toUpperCase();
            items = $("#main-menu").find("a");
            items = items.filter(function(i, item) {
                if ($(item).find(".aiz-side-nav-text")[0].innerText.toUpperCase().indexOf(filter) > -1 && $(item)
                    .attr('href') !== '#') {
                    return item;
                }
            });

            if (filter !== '') {
                $("#main-menu").addClass('d-none');
                $("#search-menu").html('')
                if (items.length > 0) {
                    for (i = 0; i < items.length; i++) {
                        const text = $(items[i]).find(".aiz-side-nav-text")[0].innerText;
                        const link = $(items[i]).attr('href');
                        $("#search-menu").append(
                            `<li class="aiz-side-nav-item"><a href="${link}" class="aiz-side-nav-link"><i class="las la-ellipsis-h aiz-side-nav-icon"></i><span>${text}</span></a></li`
                        );
                    }
                } else {
                    $("#search-menu").html(
                        `<li class="aiz-side-nav-item"><span	class="text-center text-muted d-block">Nothing Found</span></li>`
                    );
                }
            } else {
                $("#main-menu").removeClass('d-none');
                $("#search-menu").html('')
            }
        }
    </script>
    <script>

        // window.addEventListener('load', () => {
        //     setInterval(autoClickButton, 10000);
        //     // autoClickButton(); // Call the function to click the button
        // });

        // function autoClickButton() {
        //     const button = document.getElementById('fakeButton');
        //     if (button) {
        //         button.click(); // Simulates a click on the button
        //     }
        //     alert('button');
        // }

        function closeModal(){
            $('#notificationContent').html('');
            $('#notificationModal').modal('hide');
        }

        // Play sound when a new notification is received
        const notificationSound = new Audio('/sounds/notification.wav');
        var modalBody = document.getElementById('notificationContent');
    
        function checkNotifications() {
            // fakeClick();
            $.ajax({
                url: '/admin/notifications',
                type: 'GET',
                success: function (data) {
                    if (data.length > 0) {
                       
                        notificationSound.play();

                        notHtml = '<ul>';
                        data.forEach(function (notification) {
                            // alert('New Order: ' + notification.data.message);
                            notHtml += `<li>${notification.data.message}</li>`;
                        });
                        notHtml += '</ul>';
                        
                        // Mark notifications as read after playing sound
                        modalBody.innerHTML += notHtml;
                        // $('#notificationContent').html(notHtml);
                        $('#notificationModal').modal('show');
                        
                        markNotificationsAsRead();
                    }
                }
            });
        }
    
        function markNotificationsAsRead() {
            $.ajax({
                url: '/admin/notifications/mark-as-read', // Define this route to mark notifications as read
                type: 'POST',
                data: { _token: '<?php echo e(csrf_token()); ?>' },
                success: function () {
                    console.log('Notifications marked as read');
                }
            });
        }
    
        // Poll for new notifications every 10 seconds
        setInterval(checkNotifications, 20000);
    </script>

</body>

</html>
<?php /**PATH C:\wamp64\www\jisha\Medon-Laravel\resources\views/backend/layouts/app.blade.php ENDPATH**/ ?>