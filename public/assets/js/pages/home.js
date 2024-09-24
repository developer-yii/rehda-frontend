let inputs = "";
$(document).ready(function () {
    $("body").on("click", ".category-items", function () {
        if(validatePasscode(room_id)) {
            var template_id = $(this).data("id");
            var formName = (inputsString = inputs = "");
            var type = $(this).attr("type");
            var id = $(this).attr("category-id");
            if (type == 0) {
                formName = "saveItems";
                inputsString = localStorage.getItem("saveItems");
                inputs = JSON.parse(inputsString);
            } else if (type == 1) {
                formName = "saveMaintenanceOrder";
                inputsString = localStorage.getItem("saveMaintenanceOrder");
                inputs = JSON.parse(inputsString);
            } else if (type == 2) {
                formName = "saveSpaPackageOrder";
                inputsString = localStorage.getItem("saveSpaPackageOrder");
                inputs = JSON.parse(inputsString);
            } else if (type == 3) {
                formName = "saveCarTypeOrder";
                inputsString = localStorage.getItem("saveCarTypeOrder");
                inputs = JSON.parse(inputsString);
            }

            getMenuItems(room_id, inputs, formName, type, id, template_id);
            }

    });

    $input = $('input[type="text"]').closest(".input-group");
    //$input = $('.btn').parent().siblings('input');

    $("body").on("click", ".btn", function () {
        // Define $input here, so it's based on the button that was clicked
        var $input = $(this).closest(".input-group").find('input[type="text"]');

        // Now $input refers to the correct input element
        var $val = $input.val();

        if ($(this).hasClass("btn-minuse")) {
            if (parseInt($val) > 0) {
                $input.val(parseInt($val) - 1);
            } else {
                $input.val(0);
            }
        } else {
            $input.val(parseInt($val) + 1);
        }
    });

    $("body").on("click", ".back", function () {
        var formId = $(this).attr("form-name");
        inputs = setItemsInLocal(formId);
        var checkInput = validateMainatenaceForm();
        if (checkInput) {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Please turn off the item if you do not require it.",
                customClass: {
                    confirmButton: "btn btn-danger",
                },
            });
            return false;
        } else {
            getMenuItems(room_id, inputs);
        }
    });

    $("body").on("submit", "#saveItems", function (e) {
        e.preventDefault();
        var $this = $(this);
        var allZero = true;

        $('input[name="item_quantity[]').each(function () {
            var value = $(this).val();

            if (value != "0") {
                allZero = false;
                return false;
            }
        });

        if (allZero) {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "All Items Quantity should not zero!",
                customClass: {
                    confirmButton: "btn btn-danger",
                },
            });
            return false;
        } else {
            $.ajax({
                url: saveItems,
                type: $(this).attr("method"),
                typeData: "JSON",
                data: new FormData(this),
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $($this)
                        .find('button[type="submit"]')
                        .prop("disabled", true);
                },
                success: function (res) {
                    $($this)
                        .find('button[type="submit"]')
                        .prop("disabled", false);
                    if (res.status == true) {
                        $($this)[0].reset();
                        Swal.fire({
                            icon: "success",
                            title: res.is_update,
                            text: res.message,
                            customClass: {
                                confirmButton: "btn btn-success",
                            },
                        });
                        localStorage.removeItem("saveItems");
                        localStorage.removeItem("email");
                        $(".error").html("");
                        getMenuItems(room_id);
                    } else if (res.status == false && res.message) {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: res.message,
                            customClass: {
                                confirmButton: "btn btn-danger",
                            },
                        });
                    } else {
                        $(".error").html("");
                        var firstInputSet = false;
                        first_input = "";
                        $("input[name='item_quantity[]']").each(function (
                            index
                        ) {
                            var errorKey = "item_quantity." + index;

                            if (res.errors[errorKey]) {
                                $(this)
                                    .closest(".col-md-6")
                                    .find(".error")
                                    .html(res.errors[errorKey][0]);
                                if (!firstInputSet) {
                                    $(this).focus();
                                    firstInputSet = true;
                                }
                            }
                        });
                    }
                },
                error: function (error) {
                    if (error.responseJSON && error.responseJSON.message) {
                        showToastMessage("error", error.responseJSON.message);
                    } else {
                        showToastMessage("error", "Something went wrong!");
                    }
                    $($this)
                        .find('button[type="submit"]')
                        .prop("disabled", false);
                },
            });
        }
    });

    $("body").on("submit", "#saveMaintenanceOrder", function (e) {
        e.preventDefault();
        var $this = $(this);
        var formdata = new FormData(this);
        $("textarea[name='item_description[]']:visible").each(function () {
            var value = $(this).val();
            formdata.append("itemdescription[]", value);
        });
        $.ajax({
            url: saveMaintenance,
            type: $(this).attr("method"),
            typeData: "JSON",
            data: formdata,
            processData: false,
            contentType: false,
            beforeSend: function () {
                $($this).find('button[type="submit"]').prop("disabled", true);
            },
            success: function (res) {
                $($this).find('button[type="submit"]').prop("disabled", false);
                if (res.status == true) {
                    $($this)[0].reset();
                    Swal.fire({
                        icon: "success",
                        title: res.is_update,
                        text: res.message,
                        customClass: {
                            confirmButton: "btn btn-success",
                        },
                    });
                    $(".error").html("");
                    localStorage.removeItem("saveMaintenanceOrder");
                    localStorage.removeItem("email");
                    getMenuItems(room_id);
                } else if (res.status == false && res.message) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: res.message,
                        customClass: {
                            confirmButton: "btn btn-danger",
                        },
                    });
                } else {
                    $(".error").html("");
                    var firstInputSet = false;
                    first_input = "";
                    $("textarea[name='item_description[]']:visible").each(
                        function (index) {
                            var errorKey = "item_description." + index;

                            if (res.errors[errorKey]) {
                                $(this)
                                    .closest(".maintance-items")
                                    .find(".error")
                                    .html(res.errors[errorKey][0]);
                                if (!firstInputSet) {
                                    $(this).focus();
                                    firstInputSet = true;
                                }
                            }
                        }
                    );
                    $.each(res.errors, function (key) {
                        if (first_input == "") first_input = key;
                        $("." + key)
                            .closest(".maintance-items")
                            .find(".error")
                            .html(res.errors[key]);
                    });
                    $($this)
                        .find("." + first_input)
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

    $("body").on("submit", "#saveSpaPackageOrder", function (e) {
        e.preventDefault();
        var $this = $(this);

        $.ajax({
            url: saveSpaPackage,
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
                    Swal.fire({
                        icon: "success",
                        title: res.is_update,
                        text: res.message,
                        customClass: {
                            confirmButton: "btn btn-success",
                        },
                    });
                    localStorage.removeItem("saveSpaPackageOrder");
                    localStorage.removeItem("email");
                    $(".error").html("");
                    getMenuItems(room_id);
                } else if (res.status == false && res.message) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: res.message,
                        customClass: {
                            confirmButton: "btn btn-danger",
                        },
                    });
                } else {
                    $(".error").html("");
                    first_input = "";
                    $.each(res.errors, function (key) {
                        if (first_input == "") first_input = key;
                        $("." + key)
                            .closest(".row")
                            .find(".error")
                            .html(res.errors[key]);
                    });
                    $($this)
                        .find("." + first_input)
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

    $("body").on("submit", "#saveCarTypeOrder", function (e) {
        e.preventDefault();
        var $this = $(this);

        $.ajax({
            url: saveCarType,
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
                    Swal.fire({
                        icon: "success",
                        text: res.message,
                        customClass: {
                            confirmButton: "btn btn-success",
                        },
                    });
                    localStorage.removeItem("saveCarTypeOrder");
                    localStorage.removeItem("email");
                    $(".error").html("");
                    getMenuItems(room_id);
                } else if (res.status == false && res.message) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: res.message,
                        customClass: {
                            confirmButton: "btn btn-danger",
                        },
                    });
                } else {
                    $(".error").html("");
                    first_input = "";
                    $.each(res.errors, function (key) {
                        if (first_input == "") first_input = key;
                        $("." + key)
                            .closest(".row")
                            .find(".error")
                            .html(res.errors[key]);
                    });
                    $($this)
                        .find("." + first_input)
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

    $("body").on("click", ".items", function () {
        if ($(this).is(":checked")) {
            $(this)
                .closest(".maintance-items")
                .find(".item_description")
                .removeClass("d-none");
        } else {
            $(this)
                .closest(".maintance-items")
                .find(".item_description")
                .addClass("d-none");
        }
    });

    $("body").on("click", ".view", function () {
        if(validatePasscode(room_id)) {
            $.ajax({
                type: "GET",
                url: getOrderItems,
                data: {
                    room_id: room_id,
                },
                success: (result) => {
                    if (result.status == true) {
                        $("#menu-items").html(result.html);
                    } else {
                        showToastMessage("error", result.message);
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
        }
    });

    $("body").on("click", ".delete-order", function () {
        let id = $(this).attr("data-id");
        let order_type = $(this).attr("order-type");
        let order_id = $(this).attr("order-id");

        Swal.fire({
            text: "Are you sure you would like to remove this order?",
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
                    url: deleteOrderItem,
                    type: "GET",
                    data: {
                        id: id,
                        order_id: order_id,
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
                            $("." + order_type + "-" + id).remove();
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

    $("body").on("submit", "#validteRoomPasscode", function (e) {
        e.preventDefault();
        var $this = $(this);

        $.ajax({
            url: validateRoomPasscode,
            type: $(this).attr("method"),
            typeData: "JSON",
            data: new FormData(this),
            processData: false,
            contentType: false,
            beforeSend: function () {
                $($this)
                    .find('button[type="submit"]')
                    .prop("disabled", true);
            },
            success: function (res) {
                $($this)
                    .find('button[type="submit"]')
                    .prop("disabled", false);
                if (res.status == true) {
                    $($this)[0].reset();
                    showToastMessage("success", res.message);
                    localStorage.setItem("passcode_"+room_id, res.passcode);
                    $('#validtePasscode').modal('hide');
                    $(".error").html("");
                    validatePasscode(room_id);
                    getMenuItems(room_id);
                } else if (res.status == false && res.message) {
                    showToastMessage("error", res.message);
                } else {
                    first_input = "";
                    $(".error").html("");
                    $.each(res.errors, function (key) {
                        if (first_input == "") first_input = key;
                        $("#" + key)
                            .closest(".row")
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
                $($this)
                    .find('button[type="submit"]')
                    .prop("disabled", false);
            },
        });
    });

    $('#validtePasscode').modal({
        backdrop: 'static',
        keyboard: true,
    });

    getMenuItems(room_id, inputs);
});

function validateMainatenaceForm() {
    var hasError = false;
    $(".items").each(function () {
        if ($(this).is(":checked")) {
            hasError = true;
            return false;
        }
    });
    return hasError;
}

function setItemsInLocal(formName) {
    var itemQuantities = $('input[name="item_quantity[]"]')
        .map(function () {
            return $(this).val();
        })
        .get();

    var dateValue = $('#saveSpaPackageOrder input[name="date"]').val();
    var packageValue = $('#saveSpaPackageOrder select[name="package"]').val();
    var packageTime = $('#saveSpaPackageOrder input[name="time"]').val();
    var packagePeople = $(
        '#saveSpaPackageOrder input[name="number_of_people"]'
    ).val();

    var transPeople = $(
        '#saveCarTypeOrder input[name="number_of_people"]'
    ).val();
    var transNoOfCar = $('#saveCarTypeOrder input[name="number_of_car"]').val();
    var transTypeOfCar = $('#saveCarTypeOrder select[name="cartype"]').val();
    var transDate = $('#saveCarTypeOrder input[name="date"]').val();
    var transTime = $('#saveCarTypeOrder input[name="time"]').val();
    var emailAddress = $(".email").val();
    var dataToStore = {
        itemQuantities: itemQuantities,
        date: dateValue,
        package: packageValue,
        time: packageTime,
        people: packagePeople,
        tpeople: transPeople,
        nocar: transNoOfCar,
        cartype: transTypeOfCar,
        tdate: transDate,
        trantime: transTime,
    };

    localStorage.setItem(formName, JSON.stringify(dataToStore));
    localStorage.setItem("email", emailAddress);
    return dataToStore;
}
function getMenuItems(
    room_id,
    inputs,
    formName = null,
    type = null,
    id = null,
    template_id = null
) {
    $.ajax({
        type: "GET",
        url: getItemsList,
        data: {
            type: type,
            id: id,
            template_id: template_id,
            room_id: room_id,
        },
        success: (result) => {
            if (result.status == true) {
                $("#menu-items").html(result.html);
                if (inputs) {
                    var email = localStorage.getItem("email");
                    if(email && email != 'undefined') {
                        $('#email').val(email);
                    }
                    if (formName == "saveItems") {
                        $('input[name="item_quantity[]"]').each(function (
                            index
                        ) {
                            if (inputs.itemQuantities[index] !== undefined) {
                                $(this).val(inputs.itemQuantities[index]);
                            }
                        });
                    }
                    if (inputs.date && formName == "saveSpaPackageOrder") {
                        $('#saveSpaPackageOrder input[name="date"]').val(
                            inputs.date
                        );
                        $("#saveSpaPackageOrder #date").flatpickr({
                            monthSelectorType: "static",
                            defaultDate: inputs.date,
                        });
                    }
                    if (inputs.package && formName == "saveSpaPackageOrder") {
                        $('#saveSpaPackageOrder select[name="package"]')
                            .val(inputs.package)
                            .trigger("change");
                    }
                    if (inputs.time && formName == "saveSpaPackageOrder") {
                        $('#saveSpaPackageOrder input[name="time"]').val(
                            inputs.time
                        );
                    }
                    if (inputs.people && formName == "saveSpaPackageOrder") {
                        $(
                            '#saveSpaPackageOrder input[name="number_of_people"]'
                        ).val(inputs.people);
                    }

                    if (inputs.tpeople && formName == "saveCarTypeOrder") {
                        $(
                            '#saveCarTypeOrder input[name="number_of_people"]'
                        ).val(inputs.tpeople);
                    }
                    if (inputs.nocar && formName == "saveCarTypeOrder") {
                        $('#saveCarTypeOrder input[name="number_of_car"]').val(
                            inputs.nocar
                        );
                    }
                    if (inputs.cartype && formName == "saveCarTypeOrder") {
                        $('#saveCarTypeOrder select[name="cartype"]')
                            .val(inputs.cartype)
                            .trigger("change");
                    }
                    if (inputs.tdate && formName == "saveCarTypeOrder") {
                        $('#saveCarTypeOrder input[name="date"]').val(
                            inputs.tdate
                        );
                        $("#saveCarTypeOrder #date").flatpickr({
                            monthSelectorType: "static",
                            defaultDate: inputs.date,
                        });
                    }
                    if (inputs.trantime && formName == "saveCarTypeOrder") {
                        $('#saveCarTypeOrder input[name="time"]').val(
                            inputs.trantime
                        );
                    }
                }
            } else {
                showToastMessage("error", result.message);
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
}
window.onload = function() {
    validatePasscode(room_id);
}

function validatePasscode(room_id) {
    var passcode = localStorage.getItem("passcode_"+room_id);
    if(!passcode || passcode == "undefined") {
        $('#validtePasscode').modal('show');
        return false;
    }
    return true;
}