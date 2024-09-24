$(document).ready(function () {

    function passwordToggle() {
        var toggler = document.querySelectorAll('.form-password-toggle i');
        toggler.forEach(function(icon) {
            var formPasswordToggle = icon.closest('.form-password-toggle');
            var formPasswordToggleInput = formPasswordToggle.querySelector('input');

            // Always set the input type to 'password' to mask it
            formPasswordToggleInput.setAttribute('type', 'password');
            icon.classList.replace('ti-eye', 'ti-eye-off');
        });
    }


    $('#viewPasswordModal').on('hidden.bs.modal', function () {
        passwordToggle();
    });

    $("#access-list").DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        fixedColumns: true,

        ajax: {
            url: getAccessListUrl,
            type: "GET",
        },
        columns: [
            {
                data: "type",
                name: "type",
            },
            {
                data: "device_app_name",
                name: "device_app_name",
            },
            {
                data: "requester_name",
                name: "requester_name",
            },
            {
                data: "approver_name",
                name: "approver_name",
            },
            {
                data: "status",
                name: "status",
            },
            {
                data: "actioned_at",
                name: "actioned_at",
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

    // Handle the click event for "View Details" button
    $("body").on("click", ".view-details", function() {
        let requestUuid = $(this).data("id");

        $.ajax({
            url: getAccessDetailsUrl, // Update with your actual route
            type: 'GET',
            data: {
                request_uuid: requestUuid,
            },
            success: function(res) {
                if (res.status === true) {
                    if (res.data.requestable_type === 'App\\Models\\Device') {
                        // Populate and show the device modal
                        $("#name").val(res.data.requestable.name);
                        $("#brand").val(res.data.requestable.brand);
                        $("#model").val(res.data.requestable.model);
                        $("#device_id").val(res.data.requestable.device_id);
                        $("#status").prop("checked", res.data.requestable.status == 1);
                        $("#deviceView").modal("show");
                    } else if (res.data.requestable_type === 'App\\Models\\Application') {
                        // Populate and show the application modal
                        $("#app_name").val(res.data.requestable.name);
                        $("#os").val(res.data.requestable.os);
                        $("#server").val(res.data.requestable.server);
                        $("#status").prop("checked", res.data.requestable.status == 1);
                        $("#applicationView").modal("show");
                    }
                } else if (res.status === false && res.message) {
                    showToastMessage("error", res.message);
                }
            },
            error: function(error) {
                showToastMessage("error", "Something went wrong!");
            },
        });
    });

    // Handle the click event for "View Password" button
    $("body").on("click", ".view-password", function() {
        let requestUuid = $(this).data("id");

        $.ajax({
            url: showPassUrl, // Update with your actual route
            type: 'GET',
            data: {
                request_uuid: requestUuid,
            },
            success: function(res) {
                if (res.status === true) {
                    // Populate the password field with a masked password
                    $("#basic-default-password12").val(res.data.password_id);
                    $("#viewPasswordModal").modal("show");
                } else if (res.status === false && res.message) {
                    showToastMessage("error", res.message);
                }
            },
            error: function(error) {
                showToastMessage("error", "Something went wrong!");
            },
        });
    });

    // Handle the "View" button in the password modal to unmask the password
    $("body").on("click", ".toggle-password", function() {
        let passwordField = $("#password");
        if (passwordField.attr("type") === "password") {
            passwordField.attr("type", "text");
        } else {
            passwordField.attr("type", "password");
        }
    });

});