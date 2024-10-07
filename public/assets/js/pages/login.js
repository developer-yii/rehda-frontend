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
                    alert(response);
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
                        var inputField = $('input[name="' + key + '"]');
                        inputField.after('<span class="text-danger">' + value[0] + '</span>');
                    });

                    if(typeof(errors) === "undefined" && xhr.status) {
                        $("#forgotpwdmmno-msg").html('<div class="alert-danger text-center mb-2"><i class="icon_error-circle_alt"></i>'+xhr.responseJSON.message+'</div>');
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

    // $('#reset-password-representative').submit(function(e) {
    $("#reset-password-representative").on("submit", function(e){

        $("#forgotpwdmykad-msg").html('');
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: forgotpwdUrl,
            data: $(this).serialize(),
            success:function(response){
                if (response.status === 'success') {
                    alert(response);
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
                        var inputField = $('input[name="' + key + '"]');
                        inputField.after('<span class="text-danger">' + value[0] + '</span>');
                    });

                    if(typeof(errors) === "undefined" && xhr.status) {
                        $("#forgotpwdmykad-msg").html('<div class="alert-danger text-center mb-2"><i class="icon_error-circle_alt"></i>'+xhr.responseJSON.message+'</div>');
                    }
                }
            }
        });

    });

});