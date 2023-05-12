<?php
require_once 'data.php';
header('Content-Type: application/json');
if (!user()) {
	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $_SERVER['REQUEST_METHOD'] == 'POST'){
		if (isset($_SESSION['token']) && $_POST['token'] == $_SESSION['token']) {
			if (isset($_POST['code']) && isset($_POST['email'])) {
				$email = clean($_POST['email']);
				$code = clean($_POST['code']);
				$zero = "0";
				$one = "1";
				if(empty($email) || empty($code) || !ctype_digit($code) || strlen($code) != 6 || !filter_var($email, FILTER_VALIDATE_EMAIL)){
					$data = array('error'=>"Invalid submitted values");
				}else{
					$check = $access->prepare("SELECT user_id,password,user_type FROM enrollment WHERE email=:email AND code=:token AND status=:zero LIMIT 1");
					$check->execute(['email'=>$email,'token'=>$code,'zero'=>$zero]);
					if($check->rowCount() == 1){
						foreach ($check as $key) {
							$user_id = clean($key["user_id"]);
							$password = clean($key["password"]);
							$user_type = clean($key["user_type"]);
						}
						$captured = date("Y-m-d H:i:s");
						$insert = $access->prepare("INSERT INTO access (user_id, email, password, user_type, captured) VALUES (:user_id, :email, :password, :user_type, :captured)");
						$insert->bindParam(':user_id', $user_id);
						$insert->bindParam(':email', $email);
						$insert->bindParam(':password', $password);
						$insert->bindParam(':user_type', $user_type);
						$insert->bindParam(':captured', $captured);
						$update = $access->prepare("UPDATE enrollment SET token=:token, status=:zero, code=:code WHERE email=:email AND user_id=:user_id LIMIT 1");
						$array = array('token'=>$zero,'zero'=>$one,'code'=>$zero,'email'=>$email,'user_id'=>$user_id);

						if ($insert->execute() && $update->execute($array)) {
							unset($_SESSION['validate']);
							$_SESSION['first_time'] = 1;
				  			$_SESSION['userid'] = $user_id;
	                        $_SESSION['type'] = $user_type;
	                        $_SESSION['email'] = $email;
	                  		session_regenerate_id(true);
	                  		$data = array('success'=>true);
						}
					}else{
						$data = array('error'=>"Invalid activation code");
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