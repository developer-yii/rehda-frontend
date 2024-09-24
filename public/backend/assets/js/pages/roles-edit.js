$(document).ready(function () {
      // Select All checkbox click
    const selectAll = document.querySelector('#selectAll'),
    checkboxList = document.querySelectorAll('[type="checkbox"]');
    selectAll.addEventListener('change', t => {
      checkboxList.forEach(e => {
        e.checked = t.target.checked;
      });
    });

    $('body').on('submit', '#addRole', function (e) {
        e.preventDefault();
        var $this = $(this);

        $.ajax({
            url: createRole,
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
                        text: res.message,
                        customClass: {
                            confirmButton: "btn btn-success",
                        },
                    });
                    setTimeout(function() {
                        window.location.href = res.data;
                    }, 2000);
                } else if (res.status == false && res.message) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: res.message,
                        customClass: {
                            confirmButton: "btn btn-success",
                        },
                    });
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                } else {
                    first_input = "";
                    $(".error").html("");
                    $.each(res.errors, function (key) {
                        if (first_input == "") first_input = key;
                        $("#" + key)
                            .closest(".col-12")
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