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
<style>
<?php include 'css/styles.css'; ?>
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
	              	<h4 class="login-heading mb-4">Reset Password</h4>
	              <form id="signin" method="post" autocomplete="off">
	              	<div class="form-group">
	                  <span id="response" style="font-size:15px;color:darkred;"></span>
	                </div>
	                <div class="form-group">
	                  <input type="email" id="email" name="email" class="form-control" placeholder="Email address" required autofocus>
	                </div>
	                <div class="form-group">
	                	<input required type="hidden" name="token" id="token" value="<?php echo tokenGenerator();?>">
	                	<button id="submit" class="btn btn-lg btn-block btn-login font-weight-bold" style="background:#494263;color:white;border-radius:30px;" type="submit">Reset</button>
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
<script>
	<?php include 'js/forgot.js' ?>
</script>
</body>
</html>


</body>
</html>