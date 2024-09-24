$(document).ready(function () {
    $("body").on("submit", "#editnewsletter", function(e) {
        e.preventDefault();
        var $this = $(this);
        var formData = new FormData(this);

        $.ajax({
            url: updateUrl,
            type: $(this).attr("method"),
            dataType: "JSON",
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $($this).find('button[type="submit"]').prop("disabled", true);
            },
            success: function (res) {
                $($this).find('button[type="submit"]').prop("disabled", false);
                if(res.status == true) {
                    $('#editnewsletter').find('.form-control').removeClass('is-invalid');
                    $('#editnewsletter').find('.invalid-feedback').html("");
                    showToastMessage("success", res.message);
                    setTimeout(function(){
                        window.location.reload();
                     }, 5000);
                }
            },
            error: function(xhr) {
                $($this).find('button[type="submit"]').prop("disabled", false);
                var errors = xhr.responseJSON.errors;
                $('#editnewsletter').find('.form-control').removeClass('is-invalid');
                $('#editnewsletter').find('.invalid-feedback').html("");

                $.each(errors, function (key, value) {
                    var input = $('#' + key);
                    input.addClass('is-invalid');
                    input.siblings('.invalid-feedback').html(value[0]);
                });
            }
        });
    });
});
