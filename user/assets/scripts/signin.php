<?php
require_once 'data.php';
header('Content-Type: application/json');
if (!all()) {
	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $_SERVER['REQUEST_METHOD'] == 'POST'){
		if (isset($_SESSION['token']) && $_POST['token'] == $_SESSION['token']) {
			if (isset($_POST['password']) && isset($_POST['email'])) {
				$email = clean($_POST['email']);
				$password = clean($_POST['password']);
				$zero = "0";
				$one = "1";
				if(empty($email) || empty($password) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
					$data = array('error'=>"Both fields are required");
				}else{
					$check = $access->prepare("SELECT user_id,password,user_type,status FROM access WHERE email=:email LIMIT 1");
					$check->execute(['email'=>$email]);
					if($check->rowCount() == 1){
						foreach ($check as $key) {
							$user_id = clean($key["user_id"]);
							$pass = clean($key["password"]);
							$user_type = clean($key["user_type"]);
							$status = clean($key["status"]);
						}
						if ($status == "1") {
							if (password_verify($password, $pass)) {
								$login_time  = date("Y-m-d H:i:s");
		                      	$sql = $access->prepare('UPDATE access SET lastin=:tim WHERE email=:email');
		                      	$sql->execute(['tim'=>$login_time, 'email'=>$email]);
					  			$_SESSION['userid'] = $user_id;
		                        $_SESSION['type'] = $user_type;
		                        $_SESSION['email'] = $email;
		                  		session_regenerate_id(true);
		                  		$data = array('success'=>true);
							}else{
								$data = array('error'=>"Invalid login credentials");
							}
						}else{
							$data = array('error'=>"Account has been de-activated, please contact admin");
						}
					}else{
						$data = array('error'=>"Invalid login credentials");
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