$(document).ready(function () {

    $("body").on("submit", "#addcircular", function (e) {
        e.preventDefault();
        var $this = $(this);
        var formData = new FormData(this);

        $.ajax({
            url: storeUrl,
            type: $(this).attr("method"),
            dataType: "JSON",
            data: formData,
            contentType: false,
            beforeSend: function () {
                $($this).find('button[type="submit"]').prop("disabled", true);
            },
            success: function (res) {
                $($this).find('button[type="submit"]').prop("disabled", false);
                if (res.status == true) {
                    $('#addcircular').find('.form-control').removeClass('is-invalid');
                    $('#addcircular').find('.invalid-feedback').html("");
                    showToastMessage("success", res.message);
                    $this[0].reset();
                    quill.setContents([]);
                    const dateInput = document.getElementById('datepicker');
                    const currentDate = new Date().toISOString().split('T')[0]; // Format: YYYY-MM-DD
                    dateInput.value = currentDate;
                }
            },
            error: function (xhr) {
                $($this).find('button[type="submit"]').prop("disabled", false);
                var errors = xhr.responseJSON.errors;
                $('#addcircular').find('.form-control').removeClass('is-invalid');
                $('#addcircular').find('.invalid-feedback').html("");

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
