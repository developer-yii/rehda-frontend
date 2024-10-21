$(document).ready(function () {

    $("body").on("click","#nor1", function() {
        $("#resetNor1").modal('show');
    });

    $("body").on("click","#nor2", function() {
        $("#resetNor2").modal('show');
    });

    $("form[name='reset-nor1']").validate({
        rules: {
            resetNor1Name: "required",
            resetNor1MyKad: {
                required: function(element) {
                    return $("#resetNor1MyKadSelect").val() == 1;
                },
                digits: true,
                minlength:12,
                maxlength:12
            },
            resetNor1Passportno: {
                required: function(element) {
                    return $("#resetNor1MyKadSelect").val() == 2;
                },
            }
        },

        messages: {
          resetNor1Name: "Please Insert New Name of Representative",
          resetNor1MyKad: "Please Insert A Valid My Kad Number"
        },
        submitHandler: function(form) {
            $("#submit1").prop('disabled', true);
            var resetNor1Name = $('#resetNor1Name').val().trim();
            var resetNor1MyKad = $('#resetNor1MyKad').val().trim();
            var resetNor1Passportno = $('#resetNor1Passportno').val().trim();
            var resetNor1Id = $('#resetNor1Id').val().trim();
            var resetNor1contact = $("#resetNor1contact").val();
            var resetNor1email = $("#resetNor1email").val();
            $("#chgreq1-msg").html('');

            var passData = {resetNorName:resetNor1Name,resetNorMyKad:resetNor1MyKad,resetNorId:resetNor1Id,resetNorPassportno:resetNor1Passportno,resetNorContact:resetNor1contact,resetNorEmail:resetNor1email};
            $.ajax({
                type:'POST',
                url:nor1url,
                data:passData,
                success:function(response){

                    if(response.status == 1)
                    {
                        $("#chgreq1-msg").html('<div class="alert-success"><i class="fa fa-check-circle"> Request submitted for approval.</div>');
                        setTimeout(() => {
                            $("#resetNor1").modal('hide');
                            $("#resetNor1Name").val('');
                            $("#resetNor1MyKad").val('');
                            $("#resetNor1Passportno").val('');
                            $("#resetNor1contact").val('');
                            $("#resetNor1email").val('');
                            $("#chgreq1-msg").html('');
                            $("#submit1").prop('disabled', false);
                        }, 1000);
                    } else {
                        $("#submit1").prop('disabled', false);
                        $("#chgreq1-msg").html('<div class="alert-danger"><i class="fa fa-close"> Failed to submit! Please contact administrator.</div>');
                    }
                }
            });
        }
    });

    $("form[name='reset-nor2']").validate({
        rules: {
            resetNor2Name: "required",
            resetNor2MyKad: {
                required: function(element) {
                    return $("#resetNor2MyKadSelect").val() == 1;
                },
                digits: true,
                minlength:12,
                maxlength:12
            },
            resetNor2resetNor1Passportno: {
                required: function(element) {
                    return $("#resetNor2MyKadSelect").val() == 2;
                },
            }
        },

        messages: {
          resetNor2Name: "Please Insert New Name of Representative",
          resetNor2MyKad: "Please Insert A Valid My Kad Number"
        },
        submitHandler: function(form) {
            $("#submit2").prop('disabled', true);
            var resetNor2Name = $('#resetNor2Name').val().trim();
            var resetNor2MyKad = $('#resetNor2MyKad').val().trim();
            var resetNor2resetNor1Passportno = $("#resetNor2resetNor1Passportno").val().trim();
            var resetNor2contact = $('#resetNor2contact').val();
            var resetNor2email = $('#resetNor2email').val();
            var resetNor2Id = $('#resetNor2Id').val().trim();
            $("#chgreq2-msg").html('');

            var passData = {resetNorName:resetNor2Name,resetNorMyKad:resetNor2MyKad,resetNorId:resetNor2Id,resetNorPassportno:resetNor2resetNor1Passportno,resetNorContact:resetNor2contact,resetNorEmail:resetNor2email};
            $.ajax({
                type:'POST',
                url:nor1url,
                data:passData,
                success:function(response){

                    if(response.status == 1)
                    {
                        $("#chgreq2-msg").html('<div class="alert-success"><i class="fa fa-check-circle"> Request submitted for approval.</div>');
                        setTimeout(() => {
                            $("#resetNor2").modal('hide');
                            $("#resetNor2Name").val('');
                            $("#resetNor2MyKad").val('');
                            $("#resetNor2resetNor1Passportno").val('');
                            $('#resetNor2contact').val('');
                            $('#resetNor2email').val('');
                            $("#chgreq2-msg").html('');
                            $("#submit2").prop('disabled', false);
                        }, 1000);
                    } else {
                        $("#submit2").prop('disabled', false);
                        $("#chgreq2-msg").html('<div class="alert-danger"><i class="fa fa-close"> Failed to submit! Please contact administrator.</div>');
                    }
                }
            });
        }
    });

    $(".mykadDiv").show();
    $(".passportDiv").hide();

    $(".mykadSelect").on("change", function() {
        if($(this).val() == 1){
            $(".mykadDiv").show();
            $(".passportDiv").hide();
            $(".passport").val('');
        } else {
            $(".mykadDiv").hide();
            $(".passportDiv").show();
            $(".mykad").val('');
        }
    });

});

function disableSubmitButton(form) {
    // Disable the submit button
    const submitButton = form.querySelector("#submitBtn");
    submitButton.disabled = true;
}