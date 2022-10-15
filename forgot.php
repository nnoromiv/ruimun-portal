<?php
require_once 'user/assets/scripts/data.php';
if (all()) {
  redirect("user/login");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>RUIMUN&nbsp;-&nbsp;Forgot Password</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="user/assets/images/utility/icon.png">
  <link rel="stylesheet" href="user/assets/bootstrap/bootstrap.css">
  <script src="user/assets/bootstrap/jquery.js"></script>
  <script src="user/assets/bootstrap/popper.js"></script>
  <script src="user/assets/bootstrap/bootstrap.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
</head>
<style type="text/css">
	.field-icon {
	  float: right;
	  margin-left: -25px;
	  margin-right: 10px;
	  margin-top: -30px;
	  position: relative;
	  z-index: 2;
	}
	:root {
	  --input-padding-x: 1.5rem;
	  --input-padding-y: 0.75rem;
	}
	.login,
	.image {
	  min-height: 100vh;
	}
	.bg-image {
	  background-image: url('user/assets/images/utility/rumiun.png');
	  background-size: cover;
	  background-position: center;
	}
	.login-heading {
	  font-weight: 300;
	}
	.btn-login {
	  font-size: 0.9rem;
	}
	.form-group {
	  position: relative;
	  margin-bottom: 1rem;
	}
	.form-group>input,
	.form-label-group>label {
	  padding: var(--input-padding-y) var(--input-padding-x);
	  height: auto;
	}
	.form-label-group input::-webkit-input-placeholder {
	  color: transparent;
	}
	.form-label-group input:-ms-input-placeholder {
	  color: transparent;
	}
	.form-label-group input::-ms-input-placeholder {
	  color: transparent;
	}
	.form-label-group input::-moz-placeholder {
	  color: transparent;
	}
	.form-label-group input::placeholder {
	  color: transparent;
	}
	.form-label-group input:not(:placeholder-shown) {
	  padding-top: calc(var(--input-padding-y) + var(--input-padding-y) * (2 / 3));
	  padding-bottom: calc(var(--input-padding-y) / 3);
	}
	.form-label-group input:not(:placeholder-shown)~label {
	  padding-top: calc(var(--input-padding-y) / 3);
	  padding-bottom: calc(var(--input-padding-y) / 3);
	  font-size: 2px;
	  color: #777;
	}
	@supports (-ms-ime-align: auto) {
	  .form-label-group>label {
	    display: none;
	  }
	  .form-label-group input::-ms-input-placeholder {
	    color: #777;
	  }
	}
	@media all and (-ms-high-contrast: none),
	(-ms-high-contrast: active) {
	  .form-label-group>label {
	    display: none;
	  }
	  .form-label-group input:-ms-input-placeholder {
	    color: #777;
	  }
	}
	input[type="text"]:focus,
	input[type="password"]:focus,
	input[type="datetime"]:focus,
	input[type="datetime-local"]:focus,
	input[type="date"]:focus,
	input[type="month"]:focus,
	input[type="time"]:focus,
	input[type="week"]:focus,
	input[type="number"]:focus,
	input[type="email"]:focus,
	input[type="url"]:focus,
	input[type="search"]:focus,
	input[type="tel"]:focus,
	input[type="color"]:focus,
	.uneditable-input:focus {
	  border-color: #494263;
	  box-shadow: none;
	  outline: 0 none;
	}
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
	              	<h4 class="login-heading mb-4">Forgot password</h4>
	              <form id="signin" method="post" autocomplete="off">
	              	<div class="form-group">
	                  <span id="response" style="font-size:15px;color:darkred;"></span>
	                </div>
	                <div class="form-group">
	                  <input type="email" id="email" name="email" class="form-control" placeholder="Email address" required autofocus>
	                </div>
	                <div class="form-group">
	                	<input required type="hidden" name="token" id="token" value="<?php echo tokenGenerator();?>">
	                	<button id="submit" class="btn btn-lg btn-block btn-login font-weight-bold" style="background:#494263;color:white;" type="submit">Reset</button>
	                </div>
	                <hr>
	                <div class="text-center">
                  		<a href="signin" style="color:#7F6610;font-size:14px;font-weight:lighter;">Cancel reset?</a>
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
	$(document).ready(function(){});
	$('#response').text("");
	$(document).on('submit', '#signin', function(event){
		$("#submit").html('<img src="user/assets/images/utility/spinner.gif" class="py-1">&nbsp;&nbsp;processing');
		$("#submit").prop('disabled', true);
		$('#response').text("");
		event.preventDefault();
		$.ajax({
			url:"user/assets/scripts/forgot",
			method:"POST",
			data:new FormData(this),
			contentType:false,
			processData:false,
			dataType:"json",
			success:function(data){
				if (data.success) {
					window.location = 'resetcode?request_from=reset&email='+data.mail+'&token='+data.token;
				}else{
					$('#response').text(data.error);
					$("#submit").prop('disabled', false);
					$("#submit").html("Reset");
				}
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
		    	$("#submit").prop('disabled', false);
				$("#submit").html("Reset");
				$('#response').text("Network error, please try again");
		  	}
		});
	});
</script>
</body>
</html>


</body>
</html>