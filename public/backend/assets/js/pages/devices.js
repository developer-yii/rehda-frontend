$(document).ready(function () {
    $("#devices").DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        fixedColumns: true,

        ajax: {
            url: getDevice,
            type: "GET",
        },
        columns: [
            {
                data: "name",
                name: "name",
            },
            {
                data: "brand",
                name: "brand",
            },
            {
                data: "model",
                name: "model",
            },
            {
                data: "device_id",
                name: "device_id",
            },
            {
                data: "status",
                name: "status",
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

    $("body").on("click", ".add-device", function () {
        resetAllInputFields();
        $("#deviceCreate").modal("show");
    });

    $("body").on("submit", "#saveDevice", function (e) {
        e.preventDefault();
        var $this = $(this);
        $.ajax({
            url: createDevice,
            type: $(this).attr("method"),
            dataType: "JSON",
            data: new FormData(this),
            processData: false,
            contentType: false,
            beforeSend: function () {
                $($this).find('button[type="submit"]').prop("disabled", true);
            },
            success: function (res) {
                $($this).find('button[type="submit"]').prop("disabled", false);

                if (res.status === true) {
                    // Success logic
                    $($this)[0].reset();
                    $("#deviceCreate").modal("hide");
                    Swal.fire({
                        icon: "success",
                        title: res.is_update,
                        text: res.message,
                        customClass: {
                            confirmButton: "btn btn-success",
                        },
                    });
                    $("#devices").DataTable().ajax.reload();
                    $(".error").html("");
                } else if (res.status === false && res.message) {
                    // Display general error in a toast
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
                    showToastMessage("error", res.message);
                }
            },
            error: function (error) {
                if (error.responseJSON && error.responseJSON.message) {
                    if (error.responseJSON.errors) {
                        $(".error").html("");

                        // Display validation errors next to the input fields
                        let first_input = "";
                        $.each(error.responseJSON.errors, function (key, error) {
                            if (first_input === "") first_input = key;
                            $("#" + key).closest(".col-6").find(".error").html(error[0]);
                        });

                        // Focus on the first invalid input
                        $('#saveDevice').find("#" + first_input).focus();
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


    $("body").on("click", ".edit", function () {
        resetAllInputFields();
        let id = $(this).attr("id");

        $.ajax({
            url: getSingleDevice,
            type: "GET",
            data: {
                id: id,
            },
            success: function (res) {
                if (res.status == true) {
                    $(".modal-title").html("Edit Device");
                    $("#name").val(res.data.name);
                    $("#model").val(res.data.model);
                    $("#brand").val(res.data.brand);
                    $("#device_id").val(res.data.device_id);
                    $("#deviceId").val(res.data.uuid);

                    if (res.data.status == 1) {
                        $("#status").prop("checked", true);
                        $("#status").val(1);
                    } else {
                        $("#status").prop("checked", false);
                        $("#status").val(0);
                    }

                    $("#deviceCreate").modal("show");
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
            text: "Are you sure you would like to delete this device?",
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
                    url: deleteDevice,
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
                            $("#devices").DataTable().ajax.reload();
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

    $(document).on('click', '.request-access', function() {
        var uuid = $(this).attr('id');

        Swal.fire({
            text: "Are you sure you want to request access to this device?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, request access",
            customClass: {
                confirmButton: "btn btn-primary me-2",
                cancelButton: "btn btn-label-secondary",
            },
            buttonsStyling: false,
        }).then(function(result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: deviceAccessRequestUrl,
                    type: 'POST',
                    data: {
                        uuid: uuid,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        if(res.success)
                        {
                            Swal.fire({
                                icon: "success",
                                title: "Requested!",
                                text: res.message,
                                customClass: {
                                    confirmButton: "btn btn-success",
                                },
                            });
                        }else{
                            Swal.fire({
                                icon: "error",
                                title: "Failed!",
                                text: res.message,
                                customClass: {
                                    confirmButton: "btn btn-danger",
                                },
                            });
                        }
                    },
                    error: function(err) {
                        Swal.fire({
                            icon: "error",
                            title: "Error!",
                            text: "There was an issue processing your request.",
                            customClass: {
                                confirmButton: "btn btn-danger",
                            },
                        });
                    }
                });
            }
        });
    });

    $("body").on("click", ".view-users", function() {
        let requestUuid = $(this).attr("id");

        // Destroy the DataTable if it already exists
        if ($.fn.DataTable.isDataTable('#usersTable')) {
            $('#usersTable').DataTable().destroy();
        }

        // Initialize the DataTable
        $('#usersTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: getDeviceUsersUrl, // Update with your actual route
                type: 'GET',
                data: {
                    request_uuid: requestUuid,
                }
            },
            columns: [
                { data: 'user_name', name: 'user_name' },
                { data: 'email', name: 'users.email' },
                { data: 'status', name: 'access_requests.status' },
                { data: 'actioned_at', name: 'access_requests.actioned_at' },
            ],
            destroy: true // Ensure DataTables is recreated on each button click
        });

        // Show the modal
        $("#viewUsersModal").modal("show");
    });

    function resetAllInputFields() {
        $(".modal-title").html("Add Device");
        $("#saveDevice").find(".error").html("");
        $("#saveDevice")[0].reset();
        $("#modal-preview").addClass("d-none");
        $("#deviceId").val("");
    }
});
