$(document).ready(function(){
    $('#password_hint').text("");
    $(document).on('submit', '#validate', function(event){
        $("#submit").html('<img src="user/assets/images/utility/spinner.gif" class="py-1">&nbsp;&nbsp;validating code');
        $("#submit").prop('disabled', true);
        $('#password_hint').text("");
        event.preventDefault();
        $.ajax({
            url:"user/assets/scripts/resetcode",
            method:"POST",
            data:new FormData(this),
            contentType:false,
            processData:false,
            dataType:"json",
            success:function(data){
                if (data.success) {
                    window.location = 'reset?token='+data.token;
                }else{
                    $('#password_hint').text(data.error);
                    $("#submit").prop('disabled', false);
                    $("#submit").html("Validate code");
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                $("#submit").prop('disabled', false);
                $("#submit").html("Validate code");
                $('#password_hint').text("Network error, please try again");
              }
        });
    });
    $(document).on('click', '.resend', function(event){
        window.location = 'forgot';
    });
});