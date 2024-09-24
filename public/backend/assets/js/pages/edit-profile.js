$(document).ready(function () {

     // Update/reset user image of account page
     let accountUserImage = document.getElementById('uploadedImage');
     let remove_image = document.getElementById('remove_image');
     const fileInput = document.querySelector('.account-file-input'),
       resetFileInput = document.querySelector('.account-image-reset');

     if (accountUserImage) {
       const resetImage = accountUserImage.src;
       fileInput.onchange = () => {
         if (fileInput.files[0]) {
           accountUserImage.src = window.URL.createObjectURL(fileInput.files[0]);
         }
       };
       resetFileInput.onclick = () => {
         fileInput.value = '';
         remove_image.value = 1;
         accountUserImage.src = default_image;
       };
     }

     $('body').on('submit', '#accountUpdate', function (e) {
        e.preventDefault();
        var $this = $(this);

        $('#accountUpdate').find('.error').html("");
        $('#accountUpdate').find(".is-invalid").removeClass('is-invalid');

        $.ajax({
            url: updateprofile,
            type: $(this).attr('method'),
            typeData: "JSON",
            data: new FormData(this),
            processData: false,
            contentType: false,
            beforeSend: function() {
                $($this).find('button[type="submit"]').prop('disabled', true);
            },
            success: function(res) {
            $($this).find('button[type="submit"]').prop('disabled', false);
            if (res.status == true) {
                setTimeout(function () {
                    showToastMessage("success", res.message);
                }, 200);
                window.setTimeout(function(){window.location.reload();},3000);
                $('#modal-preview').addClass('hidden');
            } else if(res.status == false && res.message) {
                showToastMessage("error", res.message);
            }
            else{
                first_input = "";
                $('.error').html("");
                $.each(res.errors, function(key) {
                    if(first_input=="") first_input=key;
                    $('#'+key).closest('.col-md-6').find('.error').html(res.errors[key]);
                });
                $($this).find("#"+first_input).focus();
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
