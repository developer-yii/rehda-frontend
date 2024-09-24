$(document).ready(function () {
    $('.select2').select2();

    $("body").on("submit", "#addnew", function (e) {
        e.preventDefault();
        var $this = $(this);

        $.ajax({
            url: addAdminMMUserUrl,
            type: $(this).attr("method"),
            data: new FormData(this),
            processData: false,
            contentType: false,
            beforeSend: function () {
                $($this).find('button[type="submit"]').prop("disabled", true);
            },
            success: function (res) {
                $($this).find('button[type="submit"]').prop("disabled", false);

                if (res.original.status === true) {
                    // Success logic
                    $('#addnew').find('.form-control').removeClass('is-invalid');
                    $('#addnew').find('.invalid-feedback').html("");
                    $($this)[0].reset();
                    showToastMessage("success", res.original.message);
                } else {
                    showToastMessage("error", res.original.message);
                }
            },
            error: function (error) {
                if (error.responseJSON && error.responseJSON.message) {
                    if (error.responseJSON.errors) {
                        // Clear any existing error messages and remove the 'is-invalid' class
                        $('#addnew').find('.form-control').removeClass('is-invalid');
                        $('#addnew').find('.invalid-feedback').html("");

                        // Display validation errors next to the input fields
                        let first_input = "";
                        $.each(error.responseJSON.errors, function (key, error) {
                            if (first_input === "") first_input = key;

                            // Add 'is-invalid' class to the input with an error
                            let inputField = $("#" + key);

                            inputField.addClass('is-invalid');

                            // Display the error message in the .invalid-feedback div
                            inputField.closest(".col-sm-10").find(".invalid-feedback").html(error[0]);
                        });

                        // Focus on the first invalid input
                        $('#addnew').find("#" + first_input).focus();
                    } else {
                        showToastMessage("error", error.responseJSON.message);
                    }
                } else {
                    showToastMessage("error", "Something went wrong!");
                }
                $($this).find('button[type="submit"]').prop("disabled", false);
            },
        });
    });
});