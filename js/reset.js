$(document).ready(function(){
    $(".toggle-password").click(function() {
          $(this).toggleClass("fa-eye fa-eye-slash");
          var input = $($(this).attr("toggle"));
          if (input.attr("type") == "password") {
              input.attr("type", "text");
          }else{
              input.attr("type", "password");
          }
    });
    $('#password_hint').text("");
    $("#password").keyup(function(){
        var password = $(this).val();
        var pattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/;
          if (!pattern.test(password)) {
            $("#password_hint").text("Password must contain at least 8 characters including an uppercase and a lower case letter and a number");
          }else{
              $("#password_hint").text("");
          }
    });
    $("#cpassword").keyup(function(){
        var c_password = $(this).val();
        var password = $("#password").val();;
        var pattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/;
          if (password != c_password) {
            $("#password_hint").text("Passwords do not match");
          }else{
              $("#password_hint").text("");
          }
    });
    $(document).on('submit', '#validate', function(event){
        $("#submit").html('<img src="user/assets/images/utility/spinner.gif" class="py-1">&nbsp;&nbsp;reseting');
        $("#submit").prop('disabled', true);
        $('#password_hint').text("");
        event.preventDefault();
        $.ajax({
            url:"user/assets/scripts/reset",
            method:"POST",
            data:new FormData(this),
            contentType:false,
            processData:false,
            dataType:"json",
            success:function(data){
                if (data.success) {
                    $(".login-heading").html("Password reset successfull, redirecting...");
                    setTimeout(function(){window.location = 'signin'; }, 2000);
                }else{
                    $('#password_hint').text(data.error);
                    $("#submit").prop('disabled', false);
                    $("#submit").html("Reset password");
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                $("#submit").prop('disabled', false);
                $("#submit").html("Reset password");
                $('#password_hint').text("Network error, please try again");
              }
        });
    });
    $(document).on('click', '.resend', function(event){
        window.location = 'forgot';
    });
});