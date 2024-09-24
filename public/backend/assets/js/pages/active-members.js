$(document).ready(function () {

    function generateTimestamp() {
        var now = new Date();
        var timestamp = now.getFullYear().toString() +
            ('0' + (now.getMonth() + 1)).slice(-2) +
            ('0' + now.getDate()).slice(-2) +
            ('0' + now.getHours()).slice(-2) +
            ('0' + now.getMinutes()).slice(-2) +
            ('0' + now.getSeconds()).slice(-2);
    }

    var table = $("#registrations").DataTable({
        processing: true,
        serverSide: false,
        scrollX: true,
        ajax: {
            url: getActiveMembers,
            type: "GET",
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
                data: "member.m_approval_at",
                name: "member.m_approval_at",
            },
            {
                data: "member_type",
                name: "member_type",
            },
            {
                data: "d_compname",
                name: "d_compname",
            },
            {
                data: "branch_name",
                name: "branch_name",
            },
            {
                data: "membership_no",
                name: "membership_no",
            },
            {
                data: "parent_company",
                name: "parent_company",
            },
            {
                data: "details",
                name: "details",
            },
            {
                data: "d_remarks",
                name: "d_remarks",
            },
            {
                data: "actions",
                name: "actions",
            },
        ],
        buttons: [

            {
                extend: 'csv',
                filename: 'ListingCustomers' + generateTimestamp() + 'Export',
                exportOptions: {
                    columns: 'th:not(:last-child)'
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

    $(document).on('click', '.upload-cert', function (e) {
        e.preventDefault();
        var pid = $(this).data('id');
        $('#pid').val(pid);

        $.ajax({
            url: getMemberCertificates,
            type: "GET",
            data: {
                pid: pid,
            },
            success: function (res) {
                if (res.status == true) {
                    if (res.html != '') {
                        $('#certificates').html(res.html);
                    }else{
                        $('#certificates').html("");
                    }
                    $('.dtr-bs-modal').modal('hide');
                    $('#uploadCertModal').modal('show');
                } else if (res.status == false && res.message) {
                    console.error(res.message);
                }
            },
            error: function (error) {
                if (error.responseJSON && error.responseJSON.message) {
                    console.error(error.responseJSON.message);
                } else {
                    console.error("Something went wrong!");
                }
            },
        });
    });

    $("body").on("click", ".del-cert", function () {
        let eid = $(this).data("id");
        var $listItem = $(this).closest('li');

        Swal.fire({
            text: "Are you sure you would like to delete this certificate?",
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
                    url: deleteCert,
                    type: "POST",
                    data: {
                        eid: eid,
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
                            $listItem.remove();
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
                    error: function (xhr) {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: xhr.responseJSON?.message || "Something went wrong!",
                            customClass: {
                                confirmButton: "btn btn-danger",
                            },
                        });
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

    $("body").on("submit", "#uploadCertForm", function (e) {
        e.preventDefault();
        var $this = $(this);

        $.ajax({
            url: uploadCertificate,
            type: $(this).attr("method"),
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

                    // update certificate listing with uploaded certificate
                    $('#certificates').html("");

                    if (res.html != '') {
                        $('#certificates').html(res.html);
                    }

                    $('#uploadCertForm').find('.form-control').removeClass('is-invalid');
                    $('#uploadCertForm').find('.invalid-feedback').html("");
                    showToastMessage("success", res.message);

                } else {
                    showToastMessage("error", res.message);
                }
            },
            error: function (error) {
                if (error.responseJSON && error.responseJSON.message) {
                    if (error.responseJSON.errors) {
                        // Clear any existing error messages and remove the 'is-invalid' class
                        $('#uploadCertForm').find('.form-control').removeClass('is-invalid');
                        $('#uploadCertForm').find('.invalid-feedback').html("");

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
                        $('#uploadCertForm').find("#" + first_input).focus();
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

    $('#uploadCertModal').on('hidden.bs.modal', function () {
        resetUploadCertFormInputFields();
    });

    function resetUploadCertFormInputFields()
    {
        // uploadCertForm is form id
        $('#uploadCertForm')[0].reset();
        $('#uploadCertForm').find('.form-control').removeClass('is-invalid');
        $('#uploadCertForm').find('.invalid-feedback').html("");
    }

    // Branch filter change event
    $('#branch-filter').on('change', function () {
        table.column(4).search($(this).val()).draw();
    });

    $(document).on('click', '.acc-statement', function (e) {
        e.preventDefault();
        var pid = $(this).data('id');
        $('#pid').val(pid);

        $.ajax({
            url: getStatementOfAccUrl,
            type: "GET",
            data: {
                pid: pid,
            },
            success: function (res) {
                console.log(res);
                if (res.status == true) {
                    if (res.html != '') {
                        $('#modal-body-content').html(res.html);
                        $('#statementModal').modal('show');
                        $('.dtr-bs-modal').modal('hide');
                    }else{
                        $('#modal-body-content').html("");
                    }

                } else if (res.status == false && res.message) {
                    showToastMessage("error", res.message);
                }
            },
            error: function (error) {
                if (error.responseJSON && error.responseJSON.message) {
                    showToastMessage("error", error.responseJSON.message);
                } else {
                    console.error("Something went wrong!");
                }
            },
        });
    });

    $('#changeMembershipModal').on('hidden.bs.modal', function () {
        clearMembershipChangeForm();
    });

    function clearMembershipChangeForm()
    {
        $('#curr').val("");
        $('#m_no_p2').val("");
        $('#m_no_p3').html("");
        $('#m_no_p4').val("");
        $('#m_no_p5').val("");
        $('#changeMembershipForm')[0].reset();
        $('#changeMembershipForm').find('.form-control').removeClass('is-invalid');
        $('#changeMembershipForm').find('.invalid-feedback').html("");
    }

    $(document).on('click', '.change-mno', function (e) {
        e.preventDefault();
        var pid = $(this).data('id');
        $('#memberId').val(pid);

        $.ajax({
            url: getMemberShipDetails,
            type: "GET",
            data: {
                pid: pid,
            },
            success: function (res) {
                console.log(res);
                if (res.status == true && res.member) {
                        clearMembershipChangeForm();

                        $('#curr').val(res.mno);
                        $('#m_no_p2').val(res.member.m_no_p2);
                        $('#m_no_p3').html(res.member.m_no_p3);
                        $('#m_no_p4').val(res.member.m_no_p4);
                        $('#m_no_p5').val(res.member.m_no_p5);

                        $('.dtr-bs-modal').modal('hide');
                        $('#changeMembershipModal').modal('show');

                } else if (res.status == false && res.message) {
                    showToastMessage("error", res.message);
                }
            },
            error: function (error) {
                if (error.responseJSON && error.responseJSON.message) {
                    showToastMessage("error", error.responseJSON.message);
                } else {
                    console.error("Something went wrong!");
                }
            },
        });
    });

    $("body").on("submit", "#changeMembershipForm", function (e) {
        e.preventDefault();
        var $this = $(this);

        $.ajax({
            url: updateMemberShipNoUrl,
            type: $(this).attr("method"),
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
                    $('#changeMembershipModal').modal('hide');
                    $('#changeMembershipForm').find('.form-control').removeClass('is-invalid');
                    $('#changeMembershipForm').find('.invalid-feedback').html("");
                    $($this)[0].reset();
                    showToastMessage("success", res.message);
                } else {
                    showToastMessage("error", res.message);
                }
            },
            error: function (error) {
                if (error.responseJSON && error.responseJSON.message) {
                    if (error.responseJSON.errors) {
                        // Clear any existing error messages and remove the 'is-invalid' class
                        $('#changeMembershipForm').find('.form-control').removeClass('is-invalid');
                        $('#changeMembershipForm').find('.invalid-feedback').html("");
                        $('#changeMembershipForm').find('.invalid-feedback').show();

                        // Display validation errors next to the input fields
                        let first_input = "";
                        $.each(error.responseJSON.errors, function (key, error) {
                            if (first_input === "") first_input = key;

                            // Add 'is-invalid' class to the input with an error
                            let inputField = $("#" + key);

                            inputField.addClass('is-invalid');

                            // Display the error message in the .invalid-feedback div
                            inputField.closest(".row").find(".invalid-feedback").html(error[0]);
                        });

                        // Focus on the first invalid input
                        $('#changeMembershipForm').find("#" + first_input).focus();
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

});