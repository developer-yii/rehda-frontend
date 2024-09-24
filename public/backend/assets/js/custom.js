$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.mark-all-read').click(function () {
        var markallread = 1;
        getNotification(markallread);
    });

    setInterval(function () {
        getNotification();
    }, 15 * 1000);

    getNotification();
});

// Toaster Setting and function ref: https://codeseven.github.io/toastr/demo.html
toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": true,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}

function showToastMessage(toast_type = "success", message = "") {

    var toast_type = toast_type.toLowerCase();
    if (toast_type == "warning") {
        toastr.warning(message, 'Warning');
    } else if (toast_type == "info") {
        toastr.info(message, 'Info');
    } else if (toast_type == "error") {
        toastr.error(message, 'Error');
    } else {
        toastr.success(message, 'Success');
    }
}
var count =0;

function getNotification(markallread=null) {
    if ($('#app-notification').length > 0) {
        $.ajax({
            url: getNotificationUrl,
            type: "POST",
            data : {
                markallread : markallread
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                $('#sidebar-menu').find('.badge').addClass('d-none');
                $('.notification-listing').html('');
                $('#app-notification').find('.notification-main-icon.bx-tada').removeClass(
                    'bx-tada');
                $('#app-notification').find('.notification-count').text('0');
                var html = '';
                if (response.status && response.data.length > 0) {
                    $('#app-notification').find('.notification-count').text(response.data.length);
                    if(response.data.length>count){
                        var audio = document.getElementById('audio');
                        count=response.data.length;
                        audio.play();
                    }
                    $.each(response.data, function (key, value) {
                        html += `<ul class="list-group list-group-flush">
                                    <li
                                        class="list-group-item list-group-item-action dropdown-notifications-item">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar">
                                                    <span class="avatar-initial rounded-circle bg-label-success"><i class="ti ti-shopping-cart"></i></span>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                            <a href="${value.url}">
                                                <h6 class="mb-1">${value.title}</h6>
                                                <p class="mb-0">${value.body}</p>
                                                <small class="text-muted">${value.time}</small>
                                            </a>
                                            </div>
                                        </div>
                                    </li>
                                </ul>`;
                    });
                } else {
                    html += `<ul class="list-group list-group-flush">
                                    <li class="list-group-item list-group-item-action dropdown-notifications-item">
                                        <div class="d-flex"><div class="flex-grow-1">
                                            <a href="javascript:void(0);">
                                                <h6 class="mb-1 text-center">No Notification Found!</h6>
                                            </a>
                                            </div>
                                        </div>
                                    </li>
                                </ul>`;
                }
                $('.notification-listing').html(html);

            },
            error: function (error) {
                showToastMessage("error", 'Something went wrong');
            }
        });
    } else {
        $('#sidebar-menu').find('.badge').remove();
    }
}
