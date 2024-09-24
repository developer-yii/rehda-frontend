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
            url: getSubsidiaryUsers,
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
                data: "d_compname",
                name: "member_comps.d_compname",
            },
            {
                data: "company_status",
                name: "company_status",
            },
            {
                data: "member_type",
                name: "member_type",
            },
            {
                data: "user_type",
                name: "user_type",
            },
            {
                data: "full_name",
                name: "up_fullname",
            },
            {
                data: "up_mykad",
                name: "up_mykad",
            },
            {
                data: "up_designation",
                name: "up_designation",
            },
            {
                data: "gender",
                name: "gender",
            },
            {
                data: "up_profq",
                name: "up_profq",
            },
            {
                data: "up_emailadd",
                name: "up_emailadd",
            },
            {
                data: "up_contactno",
                name: "up_contactno",
            },
            {
                data: "up_address",
                name: "up_address",
            },
            {
                data: "secretary_detail",
                name: "secretary_detail",
            },
            {
                data: "up_sec_name",
                name: "up_sec_name",
                visible: false  // This line hides the column
            },
            {
                data: "up_sec_email",
                name: "up_sec_email",
                visible: false
            },
            {
                data: "up_sec_mobile",
                name: "up_sec_mobile",
                visible: false
            },
            {
                data: "user_status",
                name: "user_status",
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
                    window.location = getSubsidiaryUsers + '?export=csv&' + params;
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

    // Branch filter change event
    $('#company-filter').on('change', function () {
        table.column(1).search($(this).val()).draw();
    });

    $("body").on("click", ".change-password", function (e) {
        e.preventDefault();
        var username = $(this).data('username');

        $('#passwordChangeModal').find('.modal-body #username').val(username);
        $('.dtr-bs-modal').modal('hide');
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