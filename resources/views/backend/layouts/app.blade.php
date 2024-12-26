<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app-url" content="{{ getBaseURL() }}">
    <meta name="admin-url" content="{{ getBaseURL() . env('ADMIN_PREFIX') }}">
    <meta name="file-base-url" content="{{ getFileBaseURL() }}">
    <meta name="robots" content="noindex">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('admin_assets/assets/img/favicon.ico') }}">
    <title>{{ env('APP_NAME') }} | Admin Panel</title>

    <!-- google font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700">

    <!-- aiz core css -->
    <link rel="stylesheet" href="{{ static_asset('assets/css/vendors.css') }}">
    <link rel="stylesheet" href="{{ static_asset('assets/css/aiz-core.css') }}">

    <style>
        body {
            font-size: 12px;
        }
    </style>
    <script>
        var AIZ = AIZ || {};
        AIZ.local = {
            nothing_selected: '{!! translate('Nothing selected', null, true) !!}',
            nothing_found: '{!! translate('Nothing found', null, true) !!}',
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

    @yield('styles')

</head>

<body class="">

    <div class="aiz-main-wrapper">
        @include('backend.inc.admin_sidenav')
        <div class="aiz-content-wrapper">
            @include('backend.inc.admin_nav')
            <div class="aiz-main-content">
                <div class="px-15px px-lg-25px">
                    @yield('content')
                </div>
                <div class="bg-white text-center py-3 px-15px px-lg-25px mt-auto">
                    <p class="mb-0">&copy; {{ env('APP_NAME') }} - Developed By <a href="https://www.tomsher.com/">Tomsher</a></p>
                </div>
            </div><!-- .aiz-main-content -->
        </div><!-- .aiz-content-wrapper -->
    </div><!-- .aiz-main-wrapper -->
    
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
            {{-- data-dismiss="modal" --}}
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" onClick="closeModal()">Close</button>
            </div>
          </div>
        </div>
    </div>

    @yield('modal')


    <script src="{{ static_asset('assets/js/vendors.js') }}"></script>
    <script src="{{ static_asset('assets/js/aiz-core.js') }}"></script>

    @yield('script')

    <script type="text/javascript">
        @foreach (session('flash_notification', collect())->toArray() as $message)
            AIZ.plugins.notify('{{ $message['level'] }}', '{{ $message['message'] }}');
        @endforeach


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
                            if (notification.data && notification.data.message) {
                                notHtml += `<li>${notification.data.message}</li>`;
                            }
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
                data: { _token: '{{ csrf_token() }}' },
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
