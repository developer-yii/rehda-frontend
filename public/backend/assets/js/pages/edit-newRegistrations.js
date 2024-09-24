$(document).ready(function () {
    $('.select2').select2();

    $("body").on("submit", "#addnew", function (e) {
        e.preventDefault();
        var $this = $(this);

        $.ajax({
            url: updateMemberUrl,
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
                    showToastMessage("success", res.original.message);

                    // Update URLs and hidden fields
                    var urls = res.original.urls; // Assuming `urls` is returned in the response

                    // Update Form 9
                    if (urls.d_f9ssm) {
                        var form9Element = $('#f9').closest('.row').find('a');
                        if (form9Element.length) {
                            // form9Element.attr('href', urls.d_f9ssm).html('<i class="tf-icons ti ti-photo"></i>Form 9');
                            form9Element.attr('href', urls.d_f9ssm);
                            $('#f9').closest('.row').find('input[name="ef9"]').val(urls.ef9);
                        }
                    }

                    // Update Form 24
                    if (urls.d_f24) {
                        var form24Element = $('#f24').closest('.row').find('a');
                        if (form24Element.length) {
                            // form24Element.attr('href', urls.d_f24).html('<i class="tf-icons ti ti-photo"></i>Form 24');
                            form24Element.attr('href', urls.d_f24);
                            $('#f24').closest('.row').find('input[name="ef24"]').val(urls.ef24);
                        }
                    }

                    // Update Form 49
                    if (urls.d_f49) {
                        var form49Element = $('#f49').closest('.row').find('a');
                        if (form49Element.length) {
                            // form49Element.attr('href', urls.d_f49).html('<i class="tf-icons ti ti-photo"></i>Form 49');
                            form49Element.attr('href', urls.d_f49);
                            $('#f49').closest('.row').find('input[name="ef49"]').val(urls.ef49);
                        }
                    }

                    // Update Annual Return
                    if (urls.d_anualretuncopy) {
                        var annualReturnElement = $('#annreturn').closest('.row').find('a');
                        if (annualReturnElement.length) {
                            annualReturnElement.attr('href', urls.d_anualretuncopy);
                            $('#annreturn').closest('.row').find('input[name="eannreturn"]').val(urls.eannreturn);
                        }
                    }

                    // Update Housing Developer's License
                    if (urls.d_devlicensecopy) {
                        var devlicElement = $('#devlic').closest('.row').find('a');
                        if (devlicElement.length) {
                            // devlicElement.attr('href', urls.d_devlicensecopy).html('<i class="tf-icons ti ti-photo"></i>Housing Developer\'s License');
                            devlicElement.attr('href', urls.d_devlicensecopy);
                            $('#devlic').closest('.row').find('input[name="edevlic"]').val(urls.edevlic);
                        }
                    }

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