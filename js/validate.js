$(document).ready(function(){
    $('#password_hint').text("");
    $(document).on('submit', '#validate', function(event){
        $("#submit").html('<img src="user/assets/images/utility/spinner.gif" class="py-1">&nbsp;&nbsp;validating');
        $("#submit").prop('disabled', true);
        $('#password_hint').text("");
        event.preventDefault();
        $.ajax({
            url:"user/assets/scripts/validate",
            method:"POST",
            data:new FormData(this),
            contentType:false,
            processData:false,
            dataType:"json",
            success:function(data){
                if (data.success) {
                    $(".login-heading").html("Account activated, redirecting...");
                    setTimeout(function(){window.location = 'user/login'; }, 2000);
                }else{
                    $('#password_hint').text(data.error);
                    $("#submit").prop('disabled', false);
                    $("#submit").html("Activate");
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                $("#submit").prop('disabled', false);
                $("#submit").html("Activate");
                $('#password_hint').text("Network error, please try again");
              }
        });
    });
    $(document).on('click', '.resend', function(event){
        var id = $(this).attr("id");
        $(".text-center").html('<img src="user/assets/images/utility/spinner.gif" class="py-1">&nbsp;&nbsp;sending code');
        $('#password_hint').text("");
        event.preventDefault();
        $.ajax({
            url:"user/assets/scripts/resend",
            method:"POST",
            data:{id:id},
            dataType:"json",
            success:function(data){
                if (data.success) {
                    window.location = 'validate?request_from=validate&email='+data.mail+'&token='+data.token;
                }else{
                    $('#password_hint').text(data.error);
                    $(".text-center").html('Didnt get activation code?&nbsp;<a href="javascript:void(0);" class="resend" id="<?php echo $email."&".$token; ?>" style="color:#7F6610;font-size:14px;font-weight:lighter;">Resend</a>');
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                $(".text-center").html('Didnt get activation code?&nbsp;<a href="javascript:void(0);" class="resend" id="<?php echo $email."&".$token; ?>" style="color:#7F6610;font-size:14px;font-weight:lighter;">Resend</a>');
                $('#password_hint').text("Network error, please try again");
              }
        });
    });
});