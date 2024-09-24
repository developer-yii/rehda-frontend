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

    $("#newsletters").DataTable({
        processing: true,
        serverSide: false,
        scrollX: true,
        fixedColumns: true,
        bSort: true,
        language: {
            loadingRecords: '<div class="sk-wave sk-primary"><div class="sk-wave-rect"></div><div class="sk-wave-rect"></div><div class="sk-wave-rect"></div><div class="sk-wave-rect"></div><div class="sk-wave-rect"></div></div>',
        },
        order : [[0, 'desc']],

        ajax: {
            url: getNewSletters,
            type: "GET",
        },
        columns: [
            {
                data: "newsletter",
                name: "newsletter",
            },
            {
                data: "level",
                name: "level",
            },
            {
                data: "branch",
                name: "branch",
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
            { orderable: false, targets: 1 }
         ],
         buttons: [
            {
                extend: 'csv',
                title: 'Newsletter' + generateTimestamp() + 'Export',
                exportOptions: {
                    columns: [0, 1, 2, 3], // Export only the first 4 column
                    modifer: {
                        page: 'all',
                        search: 'none'}
                },
                className: "btn btn-outline-secondary",
            }
        ],
        destroy: true,
        dom: '<"row"<"col-sm-12 col-md-3"l><"col-sm-12 col-md-3 d-flex justify-content-center justify-content-md-start dataTables_length"B><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
         initComplete: function (settings, json) {
            $('[data-bs-toggle="tooltip"]').tooltip();
        },
        drawCallback: function (settings) {
            $('[data-bs-toggle="tooltip"]').tooltip();
        }
    });

    $("body").on("click", ".newsletterdelete", function () {
        let id = $(this).attr("id");
        Swal.fire({
            text: "Are you sure you would like to delete this Newsletter?",
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
                    url: deleteNewSletter, // This should be the URL where the delete request is sent
                    type: "DELETE", // Change to DELETE method
                    data: {
                        id: id,
                        _token: $('meta[name="csrf-token"]').attr('content') // Include CSRF token
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
                            $("#newsletters").DataTable().ajax.reload();
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
                            showToastMessage("error", error.responseJSON.message);
                        } else {
                            showToastMessage("error", "Something went wrong!");
                        }
                    },
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire({
                    title: "Cancelled",
                    text: "Deletion Cancelled!",
                    icon: "error",
                    customClass: {
                        confirmButton: "btn btn-success",
                    },
                });
            }
        });
    });

    $("body").on("click",".membership-permission", function() {
        var id= $(this).attr('data-id');
        var title = $(this).attr('data-title');
        $.ajax({
            url: membership,
            type: "GET",
            data: {
                id: id,
                title: title
            },
            success: function (res) {
                $('#membershipPermissionModal .membership-permission-body').empty();
                $('#membershipPermissionModal').modal('show');
                $('.membership-permission-body').append(res.data);
                $('#cm_membertype').select2({
                    dropdownParent: $('#membershipPermissionModal'), // Ensure dropdown stays within modal
                    placeholder: 'Select member types',
                    allowClear: true
                });

                if ($('#cm_membertype option').length > 0) { // Excluding default option
                    $('#saveMembershipPermission').prop('disabled', false);
                } else {
                    $('#saveMembershipPermission').prop('disabled', true);

                }

            },
            error: function(error) {

            }
        })
    });

    $("body").on("click", ".del-permission", function () {
        let id = $(this).attr("data-id");
        let cmId = $(this).attr("data-cmid");
        let cmTitle = $(this).attr("data-cmTitle");
        Swal.fire({
            text: "Are you sure you would like to delete this Membership Permission?",
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
                    url: membershipPermissionDelete, // This should be the URL where the delete request is sent
                    type: "DELETE", // Change to DELETE method
                    data: {
                        id: id,
                        _token: $('meta[name="csrf-token"]').attr('content') // Include CSRF token
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
                            }).then(function () {
                                // After deletion, reload permissions
                                $(`.membership-permission[data-id="${cmId}"][data-title="${cmTitle}"]`).trigger('click');
                            });

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
                            showToastMessage("error", error.responseJSON.message);
                        } else {
                            showToastMessage("error", "Something went wrong!");
                        }
                    },
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire({
                    title: "Cancelled",
                    text: "Deletion Cancelled!",
                    icon: "error",
                    customClass: {
                        confirmButton: "btn btn-success",
                    },
                });
            }
        });
    });

    $("body").on("click","#saveMembershipPermission", function () {
        let selectedValues = $("#cm_membertype").val();
        let cm_id = $('#cm_id').val();
        let cm_title = $('#cm_title').val();

        if (selectedValues.length === 0) {
            alert("Please select at least one membership type.");
            return;
        }

        $.ajax({
            url: membershipPermissionStore, // Replace with your endpoint URL
            type: "POST",
            data: {
                selectedValues: selectedValues,
                cm_id: cm_id,
                cm_title: cm_title,
                _token: $('meta[name="csrf-token"]').attr('content') // Include CSRF token
            },
            success: function(res) {
                $('#membershipPermissionModal').modal('hide');
                showToastMessage("success", res.message);
            }
            });
    });

    $("body").on("click",".newsletter-branch-permission", function() {
        var id= $(this).attr('data-id');
        var title = $(this).attr('data-title');
        $.ajax({
            url: branch,
            type: "GET",
            data: {
                id: id,
                title: title
            },
            success: function (res) {
                $('#newsletterBranchPermissionModal .newsletter-branch-permission-body').empty();
                $('#newsletterBranchPermissionModal').modal('show');
                $('.newsletter-branch-permission-body').append(res.data);
                $('#cp_branch').select2({
                    dropdownParent: $('#newsletterBranchPermissionModal'), // Ensure dropdown stays within modal
                    placeholder: 'Select branch types',
                    allowClear: true
                });

                if ($('#cp_branch option').length > 0) { // Excluding default option
                    $('#savenewsletterBranchPermission').prop('disabled', false);
                } else {
                    $('#savenewsletterBranchPermission').prop('disabled', true);

                }

            },
            error: function(error) {

            }
        })
    });

    $("body").on("click", ".del-branch-permission", function () {
        let id = $(this).attr("data-id");
        let cpId = $(this).attr("data-cpid");
        let cpTitle = $(this).attr("data-cpTitle");
        Swal.fire({
            text: "Are you sure you would like to delete this Branch Permission?",
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
                    url: branchPermissionDelete, // This should be the URL where the delete request is sent
                    type: "DELETE", // Change to DELETE method
                    data: {
                        id: id,
                        _token: $('meta[name="csrf-token"]').attr('content') // Include CSRF token
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
                            }).then(function () {
                                // After deletion, reload permissions
                                $(`.newsletter-branch-permission[data-id="${cpId}"][data-title="${cpTitle}"]`).trigger('click');
                            });

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
                            showToastMessage("error", error.responseJSON.message);
                        } else {
                            showToastMessage("error", "Something went wrong!");
                        }
                    },
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire({
                    title: "Cancelled",
                    text: "Deletion Cancelled!",
                    icon: "error",
                    customClass: {
                        confirmButton: "btn btn-success",
                    },
                });
            }
        });
    });

    $("body").on("click","#savenewsletterBranchPermission", function () {
        let selectedValues = $("#cp_branch").val();
        let cp_id = $('#cp_id').val();
        let cp_title = $('#cp_title').val();

        if (selectedValues.length === 0) {
            alert("Please select at least one branch.");
            return;
        }

        $.ajax({
            url: branchPermissionStore, // Replace with your endpoint URL
            type: "POST",
            data: {
                selectedValues: selectedValues,
                cp_id: cp_id,
                cp_title: cp_title,
                _token: $('meta[name="csrf-token"]').attr('content') // Include CSRF token
            },
            success: function(res) {
                $('#newsletterBranchPermissionModal').modal('hide');
                showToastMessage("success", res.message);
            }
            });
    });

});
