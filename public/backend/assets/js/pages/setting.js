$(document).ready(function () {
    // Update/reset user image of account page
    let accountCoverImage = document.getElementById("uploadedCoverImage");
    const fileCoverInput = document.querySelector(".login-cover-image-input");

    if (accountCoverImage) {
        fileCoverInput.onchange = () => {
            if (fileCoverInput.files[0]) {
                checkCoverImageSize(fileCoverInput.files[0], (isValid, errorMessage) => {
                    if (isValid) {
                        accountCoverImage.src =
                            window.URL.createObjectURL(fileCoverInput.files[0]);
                            $("#login_cover_image").closest(".row").find(".error").html("");
                    } else {
                        $("#login_cover_image").closest(".row").find(".error").html(errorMessage);
                    }
                });
            }
        };
    }

    let accountBackgroundImage = document.getElementById(
        "uploadedBackgroundImage"
    );
    const filebackgroundInput = document.querySelector(
        ".login-background-image-input"
    );

    if (accountBackgroundImage) {
        filebackgroundInput.onchange = () => {
            if (filebackgroundInput.files[0]) {
                checkBackgroundImageSize(filebackgroundInput.files[0], (isValid, errorMessage) => {
                    if (isValid) {
                        accountBackgroundImage.src =
                            window.URL.createObjectURL(filebackgroundInput.files[0]);
                            $("#login_background_image").closest(".row").find(".error").html("");
                    } else {
                        $("#login_background_image").closest(".row").find(".error").html(errorMessage);
                    }
                });
            }
        };
    }

    // Update/reset user image of account page
    let accountUserImage = document.getElementById("uploadedImage");
    const fileInput = document.querySelector(".account-file-input");

    if (accountUserImage) {
        fileInput.onchange = () => {
            if (fileInput.files[0]) {
                checkLogoSize(fileInput.files[0], (isValid, errorMessage) => {
                    if (isValid) {
                        accountUserImage.src = window.URL.createObjectURL(fileInput.files[0]);
                        $("#logo").closest(".row").find(".error").html("");

                    } else {
                        $("#logo").closest(".row").find(".error").html(errorMessage);
                    }
                });
            }
        };
    }

    // Update/reset user image of account page
    let faviconImage = document.getElementById("faviconUpload");
    const fileInput1 = document.querySelector(".account-file-input1");

    // if (faviconImage) {
    //     fileInput1.onchange = () => {
    //         if (fileInput1.files[0]) {
    //             const file = fileInput1.files[0];
    //             const img = new Image();
    //             $("#favicon").closest(".row").find(".error").html("");
    //             img.src = window.URL.createObjectURL(file);

    //             img.onload = () => {
    //                 const width = img.width;
    //                 const height = img.height;

    //                 if ((width === 16 && height === 16) || (width === 32 && height === 32)) {
    //                     faviconImage.src = img.src;
    //                 } else {
    //                     fileInput1.value = '';
    //                      $("#favicon").closest(".row").find(".error").html(`Favicon dimensions must be 16x16 or 32x32 pixels.`);
    //                 }

    //                 // Revoke the object URL after use
    //                 window.URL.revokeObjectURL(img.src);
    //             };
    //         }
    //     };
    // }

    if (faviconImage) {
        fileInput1.onchange = () => {
            if (fileInput1.files[0]) {
                checkFaviconSize(fileInput1.files[0], (isValid, errorMessage) => {
                    if (isValid) {
                        faviconImage.src = window.URL.createObjectURL(fileInput1.files[0]);
                        $("#favicon").closest(".row").find(".error").html("");
                    } else {
                        $("#favicon").closest(".row").find(".error").html(errorMessage);
                    }
                });
            }
        };
    }

    $("body").on("change", "#active", function () {
        var status = $(this).prop("checked") == true ? 1 : 0;
        $(".email_notification").val(status);
    });

    $("#background_color").spectrum({
        type: "component",
        value: "#f3f6f4",
    });

    $("body").on("change", ".background_type", function () {
        var type = $(this).val();
        if (type == 1) {
            $(".background-image").removeClass("d-none");
            $(".background-color").addClass("d-none");
            $(".background_color").val("");
            $('#uploadedBackgroundImage').removeClass('d-none');
        } else if (type == 0) {
            $(".background-image").addClass("d-none");
            $(".background-color").removeClass("d-none");
            $("#background_color").spectrum({
                type: "component",
                value: "#f3f6f4",
            });
            $(".login_background_image").val("");
            $('#uploadedBackgroundImage').addClass('d-none');
        }
    });

    $("body").on("submit", "#updatesetting", function (e) {
        e.preventDefault();
        var $this = $(this);

        $("#updatesetting").find(".error").html("");
        $("#updatesetting").find(".is-invalid").removeClass("is-invalid");

        $.ajax({
            url: updateSetting,
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
                    Swal.fire({
                        icon: "success",
                        title: res.is_update,
                        text: "Updated!",
                        customClass: {
                            confirmButton: "btn btn-success",
                        },
                    });
                    setTimeout(function () {
                        window.location.reload();
                    }, 2000);
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
                $($this).find('button[type="submit"]').prop("disabled", false);
            },
        });
    });
});

function checkFaviconSize(file, callback) {
    const img = new Image();

    img.src = window.URL.createObjectURL(file);
    img.onload = () => {
        const width = img.width;
        const height = img.height;

        if ((width === 16 && height === 16) || (width === 32 && height === 32)) {
            callback(true);
        } else {
            callback(false, "Favicon dimensions must be 16x16 or 32x32 pixels.");
        }

        // Revoke the object URL after use
        window.URL.revokeObjectURL(img.src);
    };
}

function checkLogoSize(file, callback) {
    const logoMinWidth = 500;
    const logoMinHeight = 250;

    const logoMaxWidth = 600;
    const logoMaxHeight = 350;

    const logImg = new Image();
    logImg.src = window.URL.createObjectURL(file);

    logImg.onload = function () {

        if (logImg.width >= logoMinWidth && logImg.width <= logoMaxWidth && logImg.height >= logoMinHeight && logImg.height <= logoMaxHeight) {
            callback(true);
        } else {
            callback(false,
                    `Logo dimensions must be between ${logoMinWidth}x${logoMinHeight} and ${logoMaxWidth}x${logoMaxHeight} pixels.`
                );
        }
        window.URL.revokeObjectURL(logImg.src);
    };
}

function checkBackgroundImageSize(file, callback) {
    const minBackgroundWidth = 1920;
    const minBackgroundHeight = 1080;

    const backImg = new Image();
    backImg.src = window.URL.createObjectURL(file);
    // Event listener for when the image is loaded
    backImg.onload = function () {
        if (
            backImg.width >= minBackgroundWidth && backImg.height >= minBackgroundHeight) {
                callback(true);
        } else {
            callback(false,
                `Image dimensions must be ${minBackgroundWidth}x${minBackgroundHeight} pixels.`
            );

    };
    // Set the source of the image to trigger the load
    window.URL.revokeObjectURL(backImg.src);
    }
}

function checkCoverImageSize(file, callback) {
    const minWidth = 940;
    const minHeight = 1060;

    const maxWidth = 1000;
    const maxHeight = 1100;

    const coverImg = new Image();
    coverImg.src = window.URL.createObjectURL(file);

    // Event listener for when the image is loaded
    coverImg.onload = function () {
        if (
            coverImg.width >= minWidth && coverImg.width <= maxWidth && coverImg.height >= minHeight && coverImg.height <= maxHeight) {
                callback(true);
        } else {
            callback(false, `Image dimensions must be between ${minWidth}x${minHeight} and ${maxWidth}x${maxHeight} pixels.`
                );
        }
        window.URL.revokeObjectURL(coverImg.src);
    };
}