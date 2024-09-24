$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
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
