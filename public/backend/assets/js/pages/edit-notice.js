$(document).ready(function () {

    tinymce.init({
        selector: 'textarea#ar_yr',
        plugins: [
            // Core editing features
            'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'media',
            'searchreplace', 'table', 'visualblocks', 'wordcount',
        ],
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
        tinycomments_mode: 'embedded',
        tinycomments_author: 'Author name',
        mergetags_list: [{
            value: 'First.Name',
            title: 'First Name'
        },
        {
            value: 'Email',
            title: 'Email'
        },
        ],
        ai_request: (request, respondWith) => respondWith.string(() => Promise.reject(
            'See docs to implement AI Assistant')),
            statusbar: false
    });


    $("body").on("submit", "#editcircular", function (e) {
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
                if (res.status == true) {
                    $('#editcircular').find('.form-control').removeClass('is-invalid');
                    $('#editcircular').find('.invalid-feedback').html("");
                    showToastMessage("success", res.message);
                    setTimeout(function () {
                        window.location.reload();
                    }, 5000);
                }
            },
            error: function (xhr) {
                $($this).find('button[type="submit"]').prop("disabled", false);
                var errors = xhr.responseJSON.errors;
                $('#editcircular').find('.form-control').removeClass('is-invalid');
                $('#editcircular').find('.invalid-feedback').html("");

                $.each(errors, function (key, value) {
                    var input = $('#' + key);
                    input.addClass('is-invalid');
                    input.siblings('.invalid-feedback').html(value[0]);
                });
            }
        });
    });

    const currentDate = new Date().toISOString().split('T')[0]; // Format: YYYY-MM-DD
    $('#datepicker').val(currentDate);

    // Initialize Flatpickr
    $('#datepicker').flatpickr({
        dateFormat: "Y-m-d",
        enableTime: false,
    });
});
