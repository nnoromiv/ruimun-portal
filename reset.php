<?php
require_once 'user/assets/scripts/data.php';
if (all()) {
	redirect("user/login");
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {
	if (isset($_SESSION['resettoken']) && isset($_GET['token']) && $_SESSION['resettoken'] == $_GET['token']){
		$token = clean($_GET['token']);
		$check = $access->prepare("SELECT email,reset_time FROM reset_password WHERE token=:token LIMIT 1");
		$check->execute(['token'=>$token]);
		if($check->rowCount() != 1){
			header("refresh:1;url=forgot");
            echo '<script>alert("Invalid password reset link");</script>';
		}else{
			foreach($check as $row){
    	        $reset_time = $row["reset_time"];
    	    }
    	    $date = new DateTime($reset_time);
            $now = new DateTime();
            if($date < $now) {
                header("refresh:1;url=forgot");
                echo '<script>alert("This password reset link has expired, please request new reset");</script>';
            }
		}
	}else{
		redirect("forgot");
	}
}else{
	redirect("forgot");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>RUIMUN&nbsp;-&nbsp;reset password</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="user/assets/images/utility/icon.png">
  <link rel="stylesheet" href="user/assets/bootstrap/bootstrap.css">
  <script src="user/assets/bootstrap/jquery.js"></script>
  <script src="user/assets/bootstrap/popper.js"></script>
  <script src="user/assets/bootstrap/bootstrap.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
</head>
<style>
<?php include 'css/authenication.css'; ?>
</style>
<body>

<div class="container-fluid">
  	<div class="row no-gutter">
    	<div class="d-none d-md-flex col-md-4 col-lg-8 bg-image"></div>
	    <div class="col-md-8 col-lg-4">
	      <div class="login d-flex align-items-center py-5">
	        <div class="container">
	          <div class="row">
	            <div class="col-md-9 col-lg-8 mx-auto">
	              	<h4 class="login-heading mb-4">Set new password</h4>
	              <form id="validate" method="post" autocomplete="off">
	              	<span id="password_hint" style="font-size:15px;color:darkred;"></span>
	              	<br><br>
	                <div class="form-group">
	                  <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
	                  <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
	                  <span id="password_hint" style="font-size:15px;color:darkred;"></span>
	                </div>
	                <div class="form-group">
	                  <input type="password" id="cpassword" name="cpassword" class="form-control" placeholder="Confirm password" required>
	                </div>
	                <div class="form-group">
	                	<input type="hidden" name="token" id="token" value="<?php echo tokenGenerator();?>">
	                	<input type="hidden" name="email" id="email" value="<?php echo $row["email"];?>">
	                </div>
	                <button class="btn btn-lg btn-block btn-login font-weight-bold" id="submit" style="background:#494263;color:white;" type="submit">Reset password</button>
	                <hr>
	                <div class="text-center">
	                	Didn't get reset code?&nbsp;<a href="javascript:void(0);" class="resend" style="color:#7F6610;font-size:14px;font-weight:lighter;">Resend</a>
                  	</div>
	              </form>
	            </div>
	          </div>
	        </div>
	      </div>
	    </div>
  	</div>
</div>
<script type="text/javascript">
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
	
</script>
</body>
</html>