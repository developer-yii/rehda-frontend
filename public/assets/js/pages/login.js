$(document).ready(function () {

    $(document).on("submit", "#reset-password-companyadmin", function(e){

        $("#forgotpwdmmno-msg").html('');
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: forgotpwdUrl,
            data: $(this).serialize(),
            success:function(response){
                if (response.status === 'success') {

                    $("#reset-password-companyadmin")[0].reset();
                    $("#forgotpwdmmno-msg").html('<div class="alert alert-success text-center mb-2">' +
                        '<i class="icon_check_alt2"></i> Password reset link have been sent to your email.' +
                        '</div>');
                    setTimeout(() => {
                        $('#basicModal').modal('hide');
                    }, 1000);

                }
            },
            error: function(xhr) {
                if (xhr.status === 400 || xhr.status === 422) {  // Laravel validation error
                    var errors = xhr.responseJSON.errors;
                    // Clear previous error messages
                    $('.text-danger').remove();

                    // Loop through the errors and display them
                    $.each(errors, function(key, value) {
                        // Find the input field by name and display the error message
                        if(key == "email") {
                            var inputField = $("#email1");
                        } else {
                            var inputField = $('input[name="' + key + '"]');
                        }
                        inputField.after('<span class="text-danger">' + value[0] + '</span>');
                    });

                    if(typeof(errors) === "undefined" && xhr.status) {
                        $("#forgotpwdmmno-msg").html('<div class="alert alert-danger text-center mb-2"><i class="icon_error-circle_alt"></i>'+xhr.responseJSON.message+'</div>');
                    }
                }
            }
        });

    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('input[name="csrf-token"]').val()
        }
    });

    $("#reset-password-representative").on("submit", function(e){

        $("#forgotpwdmykad-msg").html('');
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: forgotpwdUrl,
            data: $(this).serialize(),
            success:function(response){
                if (response.status === 'success') {

                    $("#reset-password-representative")[0].reset();
                    $("#forgotpwdmykad-msg").html('<div class="alert alert-success text-center mb-2">' +
                        '<i class="icon_check_alt2"></i> Password reset link have been sent to your email.' +
                        '</div>');
                    setTimeout(() => {
                        $('#basicModal1').modal('hide');
                    }, 1000);

                }
            },
            error: function(xhr) {
                if (xhr.status === 400 || xhr.status === 422) {  // Laravel validation error
                    var errors = xhr.responseJSON.errors;
                    // Clear previous error messages
                    $('.text-danger').remove();

                    // Loop through the errors and display them
                    $.each(errors, function(key, value) {
                        // Find the input field by name and display the error message
                        if(key == "email") {
                            var inputField = $("#email2");
                        } else {
                            var inputField = $('input[name="' + key + '"]');
                        }
                        inputField.after('<span class="text-danger">' + value[0] + '</span>');
                    });

                    if(typeof(errors) === "undefined" && xhr.status) {
                        $("#forgotpwdmykad-msg").html('<div class="alert alert-danger text-center mb-2"><i class="icon_error-circle_alt"></i>'+xhr.responseJSON.message+'</div>');
                    }
                }
            }
        });

    });

});