<?php
require_once 'data.php';
header('Content-Type: application/json');
if (!all()) {
	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $_SERVER['REQUEST_METHOD'] == 'POST'){
		if (isset($_SESSION['token']) && $_POST['token'] == $_SESSION['token']) {
			if (isset($_POST['password']) && isset($_POST["cpassword"]) && isset($_POST["email"])) {
				$pass = clean($_POST['password']);
				$pass2 = clean($_POST['cpassword']);
				$email = clean($_POST['email']);

				if (empty($pass) || empty($pass2) || empty($email) || !filter_var($email,FILTER_VALIDATE_EMAIL)) {
					$data = array('error'=>'All fields are required');
				}else{
					if (!preg_match("/^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/", $pass)) {
    				$data = array('error'=>'Password must contain at least 8 characters including an uppercase and a lower case letter and a number');
					}elseif ($pass != $pass2) {
						$data = array('error'=>'Passwords do not match');
					}else{
						$em = $access->prepare('SELECT user_id,password FROM access WHERE email=:email LIMIT 1');
					    $em->execute(['email'=>$email]);
					    if ($em->rowCount() == 1) {
					        foreach ($em as $keys) {
					            $user_id = clean($keys["user_id"]);
					            $hash = clean($keys["password"]);
					        }
					        if (password_verify($pass, $hash)) {
				             	$data = array('error'=>'Password is similar to previous one, use another one');
				          	}else{
					            $new = password_hash($pass, PASSWORD_BCRYPT, [12]);
					            $query = $access->prepare("UPDATE access SET password=:password WHERE email=:email");
					            $time = '0000-00-00 00:00:00';
					            $update_reg = $access->prepare("UPDATE reset_password SET token=:token, code=:code, reset_time=:reset WHERE email=:email");
					            if ($query->execute(['password'=>$new,'email'=>$email]) && $update_reg->execute(['token'=>0,'code'=>0,'reset'=>$time,'email'=>$email])) {
					            	unset($_SESSION["reset"]);
					            	unset($_SESSION["resettoken"]);
					              	$data = array('success'=>true);
					            }else{
					            	$data = array('error'=>'Error encountered, try again');
					            }
			          		}
					    }else{
					    	$data = array('error'=>'Sorry, there is no account associated with this email');
					    }
					}
				}
			}else{
   				$data = array('error'=>"Invalid request, please refresh your page");
   			}
		}else{
			$data = array('error'=>"Invalid request, please refresh your page");
		}
		echo json_encode($data);
	}		
}
mysqli_close($connect);
$access = null;
?>