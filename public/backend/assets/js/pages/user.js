let phone_number = '';

$(document).ready(function () {
    $("#users").DataTable({
        processing: true,
        serverSide: false,
        scrollX: true,
        fixedColumns: true,
        processData: false,
        language: {
            loadingRecords: '<div class="sk-wave sk-primary"><div class="sk-wave-rect"></div><div class="sk-wave-rect"></div><div class="sk-wave-rect"></div><div class="sk-wave-rect"></div><div class="sk-wave-rect"></div></div>',
        },
        ajax: {
            url: getUser,
            type: "GET",
        },
        columns: [
            {
                data: "username",
                name: "username",
            },
            {
                data: "role",
                name: "role",
            },
            {
                data: "email",
                name: "email",
            },
            {
                data: "branch",
                name: "branch",
            },
            {
                data: "is_active",
                name: "is_active",
            },
            {
                data: "actions",
                name: "actions",
            },
        ],
        columnDefs: [
            { orderable: false, targets: 4 }
         ],
        initComplete: function (settings, json) {
            $('[data-bs-toggle="tooltip"]').tooltip();
        },
        drawCallback: function (settings) {
            $('[data-bs-toggle="tooltip"]').tooltip();
        }
    });

    $("body").on("click", ".add-customer", function () {
        resetAllInputFields();
        $('#saveUser #password').prop('disabled', false);
        $('#saveUser #password').siblings('.form-label').addClass('required_label');
        $("#userCreate").modal("show");
    });

    $("body").on("submit", "#saveUser", function (e) {
        e.preventDefault();
        var $this = $(this);
        $.ajax({
            url: createUser,
            type: $(this).attr("method"),
            typeData: "JSON",
            data: new FormData(this),
            processData: false,
            contentType: false,
            beforeSend: function () {
                $($this).find('button[type="submit"]').prop("disabled", true);
            },
            success: function (res) {
                $($this).find('button[type="submit"]').prop("disabled", false);
                if (res.status == true) {
                    $($this)[0].reset();
                    $("#userCreate").modal("hide");
                    Swal.fire({
                        icon: "success",
                        title: res.is_update,
                        text: res.message,
                        customClass: {
                            confirmButton: "btn btn-success",
                        },
                    });
                    $("#users").DataTable().ajax.reload();
                    $(".error").html("");
                } else if (res.status == false && res.message) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: res.message,
                        customClass: {
                            confirmButton: "btn btn-danger",
                        },
                    });
                    showToastMessage("error", res.message);
                } else {
                    first_input = "";
                    $(".error").html("");
                    $.each(res.errors, function (key) {
                        if (first_input == "") first_input = key;
                        $("#" + key)
                            .closest(".col-6")
                            .find(".error")
                            .html(res.errors[key]);
                    });
                    $($this)
                        .find("#" + first_input)
                        .focus();
                }
            },
            error: function (error) {
                if (error.responseJSON && error.responseJSON.message) {
                    showToastMessage("error", error.responseJSON.message);
                } else {
                    showToastMessage("error", "Something went wrong!");
                }
                $($this).find('button[type="submit"]').prop("disabled", false);
            },
        });
    });

    $(".select2").select2({
        placeholder: "Select role",
        dropdownParent: $(".select2").parent(),
    });

    $("body").on("click", ".edit", function () {
        resetAllInputFields();
        let id = $(this).attr("id");
        $('#saveUser #password').val('********');
        $('#saveUser #password').prop('disabled', true);
        $('#saveUser #password').siblings('.form-label').removeClass('required_label');
        $.ajax({
            url: getSingleUser,
            type: "GET",
            data: {
                id: id,
            },
            success: function (res) {
                if (res.status == true) {
                    $(".modal-title").html("Edit User");
                    $("#first_name").val(res.data.first_name);
                    $("#last_name").val(res.data.last_name);
                    $("#user_id").val(res.data.id);
                    $("#email").val(res.data.email);
                    $("#phone_number").val(res.data.phone_number);
                    if (res.data.profile_image) {
                        $("#modal-preview").attr(
                            "src",
                            basepath + res.data.profile_image
                        );
                        $("#modal-preview").removeClass("d-none");
                        $(".hidden_image").val(res.data.profile_image);
                    }
                    if (res.data.is_active == 1) {
                        $("#active").prop("checked", true);
                        $("#active").val(1);
                    } else {
                        $("#active").prop("checked", false);
                        $("#active").val(0);
                    }
                    if (res.data.roles[0]){
                         $("#role").val(res.data.roles[0].name).trigger("change");
                    }

                    $("#userCreate").modal("show");
                } else if (res.status == false && res.message) {
                    showToastMessage("error", res.message);
                }
            },
            error: function (error) {
                if (error.responseJSON && error.responseJSON.message) {
                    showToastMessage("error", error.responseJSON.message);
                } else {
                    showToastMessage("error", "Something went wrong!");
                }
            },
        });
    });

    $("body").on("click", ".delete", function () {
        let id = $(this).attr("id");
        Swal.fire({
            text: "Are you sure you would like to delete this account?",
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
                    url: deleteUser,
                    type: "GET",
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
                            $("#users").DataTable().ajax.reload();
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

    $("body").on("change", "#active", function () {
        var value = $(this).val();
        if (value == 1) {
            $(this).val(0);
        } else {
            $(this).val(1);
        }
    });

    function readURL(input, id) {
        id = id || "#modal-preview";
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $(id).attr("src", e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
            $("#modal-preview").removeClass("d-none");
        }
        else{
            $("#modal-preview").addClass("d-none");
            $("#modal-preview").attr("src", '');
        }
    }

    function fileInputSet(name = "") {
        if (name) {
            $("#user_image").text(name);
        } else {
            $("#user_image").text(choosefile);
        }
    }

    $(".user_image").change(function () {
        readURL(this);
        var fileName = $(this).val().split("\\").pop();
        fileInputSet(fileName);
    });
});

function resetAllInputFields() {
    $(".modal-title").html("Add User");
    $("#saveUser").find(".error").html("");
    $("#saveUser")[0].reset();
    // $("#modal-preview").attr("src", defaultimg);
    $("#modal-preview").addClass("d-none");
    $("#user_image").text("Choose File");
    $(".manual-matching").prop("checked", true);
    $(".select2").trigger("change", true);
    $("#user_id").val("");
}


// Get Country code
document.addEventListener("DOMContentLoaded", function() {
    const input = document.querySelector("#phone_number");
    const iti = window.intlTelInput(input, {
        initialCountry: "auto", // Automatically detect user's country
        geoIpLookup: function(success, failure) {
            fetch('https://ipinfo.io/json')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    var countryCode = data.country;
                    success(countryCode);
                })
        },
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        nationalMode: false
    });

    window.iti = iti; // Store instance for console access
});
