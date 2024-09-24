$(document).ready(function () {

    $("#access-requests").DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        fixedColumns: true,

        ajax: {
            url: getRequestUrl,
            type: "GET",
        },
        columns: [
            {
                data: "type",
                name: "type",
            },
            {
                data: "name",
                name: "name",
            },
            {
                data: "user_name",
                name: "user_name",
            },
            {
                data: "status",
                name: "status",
            },
            {
                data: "created_at",
                name: "created_at",
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

    $(document).on('click', '.approve-request', function() {
        var uuid = $(this).data('uuid');
        Swal.fire({
            text: "Are you sure you want to approve this request?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, approve it!",
            customClass: {
                confirmButton: "btn btn-primary me-2",
                cancelButton: "btn btn-label-secondary",
            },
            buttonsStyling: false,
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    url: approveRequestUrl,
                    type: 'POST',
                    data: {
                        uuid: uuid,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        Swal.fire({
                            icon: "success",
                            title: "Approved!",
                            text: res.message,
                            customClass: {
                                confirmButton: "btn btn-success",
                            },
                        });
                        $('#access-requests').DataTable().ajax.reload();
                    }
                });
            }
        });
    });

    $(document).on('click', '.reject-request', function() {
        var uuid = $(this).data('uuid');
        Swal.fire({
            text: "Are you sure you want to reject this request?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, reject it!",
            customClass: {
                confirmButton: "btn btn-primary me-2",
                cancelButton: "btn btn-label-secondary",
            },
            buttonsStyling: false,
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    url: rejectRequestUrl,
                    type: 'POST',
                    data: {
                        uuid: uuid,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        Swal.fire({
                            icon: "success",
                            title: "Rejected!",
                            text: res.message,
                            customClass: {
                                confirmButton: "btn btn-success",
                            },
                        });
                        $('#access-requests').DataTable().ajax.reload();
                    }
                });
            }
        });
    });
});