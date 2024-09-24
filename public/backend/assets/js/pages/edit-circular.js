$(document).ready(function () {

    $("body").on("submit", "#editcircular", function (e) {
        e.preventDefault();
        var $this = $(this);
        var formData = new FormData(this);

        $.ajax({
            url: updateUrl,
            type: $(this).attr("method"),
            dataType: "JSON",
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $($this).find('button[type="submit"]').prop("disabled", true);
            },
            success: function (res) {
                $($this).find('button[type="submit"]').prop("disabled", false);
                if (res.status == true) {
                    $('#editcircular').find('.form-control').removeClass('is-invalid');
                    $('#editcircular').find('.invalid-feedback').html("");
                    showToastMessage("success", res.message);
                    setTimeout(function () {
                        window.location.reload();
                    }, 5000);
                }
            },
            error: function (xhr) {
                $($this).find('button[type="submit"]').prop("disabled", false);
                var errors = xhr.responseJSON.errors;
                $('#editcircular').find('.form-control').removeClass('is-invalid');
                $('#editcircular').find('.invalid-feedback').html("");

                $.each(errors, function (key, value) {
                    var input = $('#' + key);
                    input.addClass('is-invalid');
                    input.siblings('.invalid-feedback').html(value[0]);
                });
            }
        });
    });

    const currentDate = new Date().toISOString().split('T')[0]; // Format: YYYY-MM-DD
    $('#datepicker').val(currentDate);

    // Initialize Flatpickr
    $('#datepicker').flatpickr({
        dateFormat: "Y-m-d",
        enableTime: false,
    });
});
