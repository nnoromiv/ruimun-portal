<?php
require_once 'user/assets/scripts/data.php';
if (all()) {
	redirect("user/login");
}
if (isset($_SESSION['reset']) && $_SESSION['reset'] == 1 && isset($_GET['request_from']) && $_GET['request_from'] == "reset" && isset($_GET['token'])){
		$email = clean($_GET['email']);
		$token = clean($_GET['token']);
		$check = $access->prepare("SELECT * FROM reset_password WHERE email=:email AND token=:token LIMIT 1");
		$check->execute(['email'=>$email,'token'=>$token]);
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
echo "string";
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
	              	<h4 class="login-heading mb-4">Provide password resetcode sent to <b><?php echo $row["email"]; ?></b></h4>
	              <form id="validate" method="post" autocomplete="off">
	              	<span id="password_hint" style="font-size:15px;color:darkred;"></span>
	              	<br><br>
	                <div class="form-group">
	                  <input type="text" id="code" name="code" class="form-control" placeholder="Code" required>
	                </div>
	                <div class="form-group">
	                	<input type="hidden" name="token" id="token" value="<?php echo tokenGenerator();?>">
	                	<input type="hidden" name="email" id="email" value="<?php echo $email;?>">
	                </div>
	                <button class="btn btn-lg btn-block btn-login font-weight-bold" id="submit" style="background:#494263;color:white;" type="submit">Validate code</button>
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
	<?php include 'js/resetcode.js' ?>
</script>
</body>
</html>