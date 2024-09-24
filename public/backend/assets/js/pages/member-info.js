$(document).ready(function () {
    var tabler = $('#registrations').DataTable({
        "order": [[ 0, "asc" ]],
        responsive: true,
    });

    $("input[type='checkbox']").click(function() {

        var chckv = $(this).val();
        if($(this).is(':checked')){
            var cc = "Yes";
        } else {
           var cc = "No";
        }

        var passData = {cc:cc,chckv:chckv};
        $.ajax({
            url: changeUserStatusUrl,
            type: "POST",
            data: passData, //pass your required data here
            success: function(response){
                if(response.success){
                    showToastMessage("success", response.message);
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                }
                else {
                    showToastMessage("error", response.message);
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                }
            },
            error: function (error) {
                showToastMessage("error", error.responseJSON.message);
            },
        });
    });

    $("body").on("click", ".change-password", function (e) {
        e.preventDefault();
        var username = $(this).data('username');

        $('#passwordChangeModal').find('.modal-body #username').val(username);
        $('#passwordChangeModal').modal('show');
    });

    $('#passwordChangeForm').on('submit', function(e) {
        e.preventDefault();
        var $this = $(this);
        var form = $('#passwordChangeForm');
        var url = "{{ route('member-users.reset-password') }}";

        $.ajax({
            url: changePasswordUrl,
            type: $(this).attr("method"),
            dataType: "JSON",
            data: $this.serialize(),
            beforeSend: function () {
                $($this).find('button[type="submit"]').prop("disabled", true);
            },
            success: function (res) {
                $($this).find('button[type="submit"]').prop("disabled", false);

                if (res.success === true) {
                    $("#passwordChangeModal").modal("hide");
                    $($this)[0].reset();
                    $this.find('.form-control').removeClass('is-invalid');
                    $this.find('.invalid-feedback').html("");
                    showToastMessage("success", res.message);

                } else if (res.success === false && res.message) {
                    showToastMessage("error", res.message);
                } else {
                    showToastMessage("error", res.message);
                }
            },
            error: function (error) {
                if (error.responseJSON && error.responseJSON.message) {
                    if (error.responseJSON.errors) {
                        // Clear any existing error messages and remove the 'is-invalid' class
                        $('#passwordChangeModal').find('.form-control').removeClass('is-invalid');
                        $('#passwordChangeModal').find('.invalid-feedback').html("");

                        // Display validation errors next to the input fields
                        let first_input = "";
                        $.each(error.responseJSON.errors, function (key, error) {
                            if (first_input === "") first_input = key;

                                // Add 'is-invalid' class to the input with an error
                                let inputField = $("#" + key);

                                inputField.addClass('is-invalid');

                                // Display the error message in the .invalid-feedback div
                                inputField.closest(".mb-3").find(".invalid-feedback").html(error[0]);

                        });

                        // Focus on the first invalid input
                        $('#passwordChangeModal').find("#" + first_input).focus();
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

    $('#passwordChangeModal').on('hidden.bs.modal', function () {
        resetPasswordResetFormFields();
    });

    function resetPasswordResetFormFields()
    {
        $('#passwordChangeForm')[0].reset();
        $('#passwordChangeForm').find('.form-control').removeClass('is-invalid');
        $('#passwordChangeForm').find('.invalid-feedback').html("");
    }

    $("body").on("click", ".del-usr", function () {
        let id = $(this).data("id");
        Swal.fire({
            text: "Are you sure you would like to delete this user?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes",
            customClass: {
                confirmButton: "btn btn-primary me-2",
                cancelButton: "btn btn-label-secondary",
            },
            buttonsStyling: false,
        }).then(function (result) {
            if (result.value) {
                $.ajax({
                    url: delUserUrl,
                    type: "POST",
                    data: {
                        id: id,
                    },
                    success: function (res) {
                        if (res.status == true) {
                            Swal.fire({
                                icon: "success",
                                title: "Deleted!",
                                text: res.message,
                                customClass: {
                                    confirmButton: "btn btn-success",
                                },
                            });
                            setTimeout(function() {
                                location.reload();
                            }, 1500);
                        } else if (res.status == false && res.message) {
                            Swal.fire({
                                icon: "error",
                                title: "Cancelled!",
                                text: res.message,
                                customClass: {
                                    confirmButton: "btn btn-success",
                                },
                            });
                        }
                    },
                    error: function (error) {
                        if (error.responseJSON && error.responseJSON.message) {
                            showToastMessage(
                                "error",
                                error.responseJSON.message
                            );
                        } else {
                            showToastMessage("error", "Something went wrong!");
                        }
                    },
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire({
                    title: "Cancelled",
                    text: "Deletion Cancelled!!",
                    icon: "error",
                    customClass: {
                        confirmButton: "btn btn-success",
                    },
                });
            }
        });
    });
});