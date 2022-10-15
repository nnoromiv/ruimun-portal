<?php
require_once 'data.php';
header('Content-Type: application/json');
if (!user()) {
	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $_SERVER['REQUEST_METHOD'] == 'POST'){
		if (isset($_POST['id'])) {
			$id = $_POST['id'];
			$row = explode('&', $id);
			$email = clean($row[0]);
			$token = clean($row[1]);
			$zero = "0";
			$one = "1";
			if(empty($email) || empty($token) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
				$data = array('error'=>"Invalid data values");
			}else{
				$check = $access->prepare("SELECT name,status,code FROM enrollment WHERE email=:email AND token=:token LIMIT 1");
				$check->execute(['email'=>$email,'token'=>$token]);
				if($check->rowCount() == 1){
					foreach ($check as $key) {
						$status = clean($key["status"]);
						$code = clean($key["code"]);
                        $name = clean(ucfirst(($key["name"])));
					}
					if ($status == "1" || $code == "0") {
						$data = array('error'=>"$email has been activated");
					}else{
						$new_code = user_codes();
						$new_token = account_token();
						$update = $access->prepare("UPDATE enrollment SET token=:token,code=:code WHERE email=:email LIMIT 1");
						$array = array('token'=>$new_token,'code'=>$new_code,'email'=>$email);
						if ($update->execute($array)) {
							//send mail after update
				    	signup_mail($name,$email,$new_code);
	                  		$data = array('success'=>true,'mail'=>$email,'token'=>$new_token);
						}
					}
				}else{
					$data = array('error'=>"Invalid account, $email does not exist");
				}
			}
   			echo json_encode($data);
		}
	}		
}
mysqli_close($connect);
$access = null;
?>