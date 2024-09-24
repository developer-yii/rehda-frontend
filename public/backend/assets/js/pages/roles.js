$(document).ready(function () {
    $("#roles").DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        fixedColumns: true,
        bSort: true,
        order : [[0, 'desc']],

        ajax: {
            url: getRoles,
            type: "GET",
        },
        columns: [
            {
                data: "name",
                name: "name",
            },
            // {
            //     data: "permission",
            //     name: "permission",
            // },
            {
                data: "actions",
                name: "actions",
            },
        ],
        columnDefs: [
            { orderable: false, targets: 1 }
         ],
         initComplete: function (settings, json) {
            $('[data-bs-toggle="tooltip"]').tooltip();
        },
        drawCallback: function (settings) {
            $('[data-bs-toggle="tooltip"]').tooltip();
        }
    });

    $("body").on("click", ".delete", function () {
        let id = $(this).attr("id");
        Swal.fire({
            text: "Are you sure you would like to delete this role?",
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
                    url: deleteRole,
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
                            $("#roles").DataTable().ajax.reload();
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
