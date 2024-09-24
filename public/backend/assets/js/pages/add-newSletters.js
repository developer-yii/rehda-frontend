$(document).ready(function () {
    $("body").on("submit","#addnewsletter", function(e) {
        e.preventDefault();
        var $this = $(this);
        var formData = new FormData(this);

        $.ajax({
            url: storeUrl,
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
                    $('#addnewsletter').find('.form-control').removeClass('is-invalid');
                    $('#addnewsletter').find('.invalid-feedback').html("");
                    showToastMessage("success", res.message);
                    $this[0].reset();
                }
            },
            error: function(xhr) {
                $($this).find('button[type="submit"]').prop("disabled", false);
                var errors = xhr.responseJSON.errors;
                $('#addnewsletter').find('.form-control').removeClass('is-invalid');
                $('#addnewsletter').find('.invalid-feedback').html("");

                $.each(errors, function (key, value) {
                    var input = $('#' + key);
                    input.addClass('is-invalid');
                    input.siblings('.invalid-feedback').html(value[0]);
                });
            }
        });
    })
});

