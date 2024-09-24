function generateTimestamp() {
    var now = new Date();
    var timestamp = now.getFullYear().toString() +
        ('0' + (now.getMonth() + 1)).slice(-2) +
        ('0' + now.getDate()).slice(-2) +
        ('0' + now.getHours()).slice(-2) +
        ('0' + now.getMinutes()).slice(-2) +
        ('0' + now.getSeconds()).slice(-2);
}

$(document).ready(function () {
    var table = $("#registrations").DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        ajax: {
            url: getChangeRequest,
            type: "GET",
        },
        'language': {
            'loadingRecords': '<div class="sk-wave sk-primary"><div class="sk-wave-rect"></div><div class="sk-wave-rect"></div><div class="sk-wave-rect"></div><div class="sk-wave-rect"></div><div class="sk-wave-rect"></div></div>',
        },
        columns: [
            {
                className: 'control',
                orderable: false,
                targets: 0,
                searchable: false,
                render: function (data, type, full, meta) {
                    return '';
                }
            },
            {
                data: "rc_created_at",
                name: "rc_created_at",
            },
            {
                data: "company_name",
                name: "company_name",
            },
            {
                data: "membership_no",
                name: "membership_no",
            },
            {
                data: "membership_type",
                name: "membership_type",
            },
            {
                data: "rc_name",
                name: "rc_name",
            },
            {
                data: "rc_mykad",
                name: "rc_mykad",
            },
            {
                data: "rc_oldname",
                name: "rc_oldname",
            },
            {
                data: "rc_oldmykad",
                name: "rc_oldmykad",
            },
            {
                data: "rc_status",
                name: "rc_status",
            },
            {
                data: "actions",
                name: "actions",
            },
        ],
        buttons: [

            {
                extend: 'csv',
                action: function (e, dt, node, config) {
                    var params = $.param(table.ajax.params());
                    window.location = getChangeRequest + '?export=csv&' + params;
                },
                className: "btn btn-outline-secondary",
            }
        ],
        destroy: true,
        dom: '<"row"<"col-sm-12 col-md-3"l><"col-sm-12 col-md-3 d-flex justify-content-center justify-content-md-start dataTables_length"B><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal({
                    header: function (row) {
                        var data = row.data();
                        return 'Details';
                    }
                }),
                type: 'column',
                renderer: function (api, rowIdx, columns) {
                    var data = $.map(columns, function (col, i) {
                        return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                            ? '<tr data-dt-row="' +
                            col.rowIndex +
                            '" data-dt-column="' +
                            col.columnIndex +
                            '">' +
                            '<td>' +
                            col.title +
                            ':' +
                            '</td> ' +
                            '<td>' +
                            col.data +
                            '</td>' +
                            '</tr>'
                            : '';
                    }).join('');

                    return data ? $('<table class="table"/><tbody />').append(data) : false;
                }
            }
        },
        order: [[1, 'asc']],
        initComplete: function (settings, json) {
            $('[data-bs-toggle="tooltip"]').tooltip();
        },
        drawCallback: function (settings) {
            $('[data-bs-toggle="tooltip"]').tooltip();
        },

    });

    $("body").on("click", ".approve-req", function () {
        let id = $(this).data("id");

        Swal.fire({
            text: "Are you sure you would like to Approve this request?",
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
                    url: approveChangeRequest,
                    type: "POST",
                    data: {
                        id: id,
                    },
                    success: function (res) {
                        if (res.status == true) {
                            Swal.fire({
                                icon: "success",
                                title: "Approved!",
                                text: res.message,
                                customClass: {
                                    confirmButton: "btn btn-success",
                                },
                            });
                            $('.dtr-bs-modal').modal('hide');
                            $('#registrations').DataTable().ajax.reload();
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
                    text: "Approve Cancelled!!",
                    icon: "error",
                    customClass: {
                        confirmButton: "btn btn-success",
                    },
                });
            }
        });
    });

    $("body").on("click", ".reject-req", function () {
        let id = $(this).data("id");

        Swal.fire({
            text: "Are you sure you would like to Reject this request?",
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
                    url: rejectChangeRequest,
                    type: "POST",
                    data: {
                        id: id,
                    },
                    success: function (res) {
                        if (res.status == true) {
                            Swal.fire({
                                icon: "success",
                                title: "Rejected!",
                                text: res.message,
                                customClass: {
                                    confirmButton: "btn btn-success",
                                },
                            });
                            $('.dtr-bs-modal').modal('hide');
                            $('#registrations').DataTable().ajax.reload();
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
                    text: "Reject Cancelled!!",
                    icon: "error",
                    customClass: {
                        confirmButton: "btn btn-success",
                    },
                });
            }
        });
    });
});