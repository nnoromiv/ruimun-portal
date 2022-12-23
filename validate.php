<?php
require_once 'user/assets/scripts/data.php';
if (all()) {
	redirect("user/login");
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {
	if (isset($_SESSION['validate']) && $_SESSION['validate'] == 1 && isset($_GET['request_from']) && $_GET['request_from'] == "validate" && isset($_GET['token'])){
		$email = clean($_GET['email']);
		$token = clean($_GET['token']);
		$zero = '0';
		$check = $access->prepare("SELECT id FROM enrollment WHERE email=:email AND token=:token AND status=:zero LIMIT 1");
		$check->execute(['email'=>$email,'token'=>$token,'zero'=>$zero]);
		if($check->rowCount() != 1){
			redirect("signup");
		}
	}else{
		redirect("signup");
	}
}else{
	redirect("signup");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>RUIMUN&nbsp;-&nbsp;account activation</title>
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
	              	<h4 class="login-heading mb-4">Provide code sent to <b><?php echo $email; ?></b></h4>
	              <form id="validate" method="post" autocomplete="off">
	              	<span id="password_hint" style="font-size:15px;color:darkred;"></span>
	              	<br><br>
	                <div class="form-group">
	                  <input type="text" id="code" placeholder="activation code" name="code" class="form-control" required>
	                </div>
	                <div class="form-group">
	                	<input type="hidden" name="token" id="token" value="<?php echo tokenGenerator();?>">
	                	<input type="hidden" name="email" id="email" value="<?php echo $email;?>">
	                </div>
	                <button class="btn btn-lg btn-block btn-login font-weight-bold" id="submit" style="background:#494263;color:white;" type="submit">Activate</button>
	                <hr>
	                <div class="text-center">
	                	Didn't get activation code?&nbsp;<a href="javascript:void(0);" class="resend" id="<?php echo $email."&".$token; ?>" style="color:#7F6610;font-size:14px;font-weight:lighter;">Resend</a>
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
	
</script>
</body>
</html>