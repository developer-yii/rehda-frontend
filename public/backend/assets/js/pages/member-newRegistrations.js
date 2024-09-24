$(document).ready(function () {
    $("#registrations").DataTable({
        processing: true,
        serverSide: false,
        scrollX: true,

        ajax: {
            url: getNewRegistrations,
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
                data: "d_created_at",
                name: "d_created_at",
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
                data: "parent_company",
                name: "parent_company",
            },
            {
                data: "d_datecompform",
                name: "d_datecompform",
            },
            {
                data: "details",
                name: "details",
            },
            {
                data: "paid_up_capital",
                name: "paid_up_capital",
            },
            {
                data: "supporting_docs",
                name: "supporting_docs",
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
        destroy: true,
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
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
        order: [[1, 'desc']],
        stateSave: true,
        initComplete: function (settings, json) {
            $('[data-bs-toggle="tooltip"]').tooltip();
        },
        drawCallback: function (settings) {
            $('[data-bs-toggle="tooltip"]').tooltip();
        }
    });

    $("body").on("click", ".approve-member", function () {

        $('.dtr-bs-modal').modal('hide');

        let id = $(this).data("id");
        $('#approveForm').find('#oid').val(id);

        $.ajax({
            url: getMemberBranch,
            type: "post",
            data: {
                id: id,
            },
            success: function (res) {
                if (res) {
                    $('#branch').val(res);
                    $("#approveModal").modal("show");
                }
            },
            error: function (error) {
                console.error('error');
            },
        });
    });

    $('body').on('submit', '#approveForm', function (e) {
        e.preventDefault();
        var $this = $(this);

        $.ajax({
            url: approveBranchUrl,
            type: $(this).attr("method"),
            dataType: "JSON",
            data: $this.serialize(),
            beforeSend: function () {
                $($this).find('button[type="submit"]').prop("disabled", true);
            },
            success: function (res) {
                $($this).find('button[type="submit"]').prop("disabled", false);

                if (res.status === true) {
                    $("#approveModal").modal("hide");
                    $($this)[0].reset();
                    $this.find('.form-control').removeClass('is-invalid');
                    $this.find('.invalid-feedback').html("");
                    showToastMessage("success", res.message);

                } else if (res.status === false && res.message) {
                    showToastMessage("error", res.message);
                } else {
                    showToastMessage("error", res.message);
                }
            },
            error: function (error) {
                if (error.responseJSON && error.responseJSON.message) {
                    if (error.responseJSON.errors) {
                        // Clear any existing error messages and remove the 'is-invalid' class
                        $('#approveForm').find('.form-control').removeClass('is-invalid');
                        $('#approveForm').find('.invalid-feedback').html("");

                        // Display validation errors next to the input fields
                        let first_input = "";
                        $.each(error.responseJSON.errors, function (key, error) {
                            if (first_input === "") first_input = key;
                            if (key == 'branchid') {
                                // Add 'is-invalid' class to the input with an error
                                let inputField = $("#" + key);

                                inputField.addClass('is-invalid');

                                // Display the error message in the .invalid-feedback div
                                inputField.closest(".col-sm-10").find(".invalid-feedback").html(error[0]);
                            } else {
                                showToastMessage("error", error[0]);
                            }

                        });

                        // Focus on the first invalid input
                        $('#approveForm').find("#" + first_input).focus();
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

    $(document).on('click','.reject-member', function(e){
        e.preventDefault();
        var oid = $(this).data('id');

        Swal.fire({
            text: "Are you sure to reject!!?",
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
                    url: memberReject,
                    type: "POST",
                    data: {
                        oid: oid,
                    },
                    success: function (res) {
                        if (res.status == true) {
                            showToastMessage(
                                "success",
                                res.message
                            );
                            $("#registrations").DataTable().ajax.reload();
                        } else if (res.status == false && res.message) {
                            showToastMessage(
                                "error",
                                res.message
                            );
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
                    text: "Member reject Cancelled!!",
                    icon: "error",
                    customClass: {
                        confirmButton: "btn btn-success",
                    },
                });
            }
        });
    });

    $('body').on('hidden.bs.modal', '#approveModal', function () {
        resetApproveFormInputFields();
    });

    function resetApproveFormInputFields() {
        $("#approveForm").find(".invalid-feedback").html("");
        $("#approveForm")[0].reset();
        $("#oid").val("");
    }
});