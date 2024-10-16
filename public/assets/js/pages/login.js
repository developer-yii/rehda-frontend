$(document).ready(function () {

    function updateLabelUsername(username) {

        var firstChar = username.charAt(0);

        if (firstChar.match(/[a-zA-Z]/)) {
            $('#label-username').text('Membership No.');
            $("#form_type").val('membership');
        } else if (firstChar.match(/[0-9]/)) {
            $('#label-username').text('MyKad No.');
            $("#form_type").val('representative');
        } else {
            $('#label-username').text('Membership No. / MyKad No.');
            $("#form_type").val('membership');
        }
    }

    var oldUsername = $('#username').val();
    if (oldUsername) {
        updateLabelUsername(oldUsername);
    }

    $('#username').on('input', function() {
        var username = $(this).val();
        updateLabelUsername(username);
    });

    function updateForgotpassLabelUsername(username) {

        var firstChar = username.charAt(0);

        if (firstChar.match(/[a-zA-Z]/)) {
            $('#label-username-forgotpass').html('Membership Number: <small>(Company Admin)</small>');
            $("#form_type_reset").val('membership');
        } else if (firstChar.match(/[0-9]/)) {
            $('#label-username-forgotpass').html('MyKad No.: <small>(Official Representative)');
            $("#form_type_reset").val('representative');
        } else {
            $('#label-username-forgotpass').html('Membership Number / MyKad No.');
            $("#form_type_reset").val('membership');
        }
    }

    var oldUsernameForgotpass = $('#membershipno').val();
    if (oldUsernameForgotpass) {
        updateForgotpassLabelUsername(oldUsernameForgotpass);
    }

    $('#membershipno').on('input', function() {
        var username = $(this).val();
        updateForgotpassLabelUsername(username);
    });


    $(document).on("submit", "#reset-password-companyadmin", function(e){

        $("#forgotpwdmmno-msg").html('');
        e.preventDefault();
        $("#btn-resetpass").prop('disabled', true);

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
                        $('.text-danger').remove();
                        $("#forgotpwdmmno-msg").html('');
                        $("#btn-resetpass").prop('disabled', false);
                    }, 1000);

                }
            },
            error: function(xhr) {
                if (xhr.status === 400 || xhr.status === 422) {  // Laravel validation error

                    $("#btn-resetpass").prop('disabled', false);

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

function disableSubmitButton(form) {
    // Disable the submit button
    const submitButton = form.querySelector("#submitBtn");
    submitButton.disabled = true;
}