<?php
require_once 'data.php';
header('Content-Type: application/json');
if (!all()) {
	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $_SERVER['REQUEST_METHOD'] == 'POST'){
		if (isset($_SESSION['token']) && $_POST['token'] == $_SESSION['token']) {
			if (isset($_POST['code']) && isset($_POST["email"])) {
				$code = clean($_POST['code']);
				$email = clean($_POST['email']);

				if (empty($code) || !ctype_digit($code) || empty($email) || !filter_var($email,FILTER_VALIDATE_EMAIL)) {
					$data = array('error'=>'Code details are required');
				}else{
					$em = $access->prepare('SELECT reset_time,token FROM reset_password WHERE email=:email AND code=:code LIMIT 1');
				    $em->execute(['email'=>$email,'code'=>$code]);
				    if ($em->rowCount() == 1) {
				        foreach ($em as $keys) {
				            $reset_time = clean($keys["reset_time"]);
				            $token = clean($keys["token"]);
				        }
				        $date = new DateTime($reset_time);
			            $now = new DateTime();
			            if($date < $now) {
			                $data = array('error'=>'This reset code has expired, please request a new reset');
			            }else{
			            	$_SESSION["resettoken"] = $token;
			            	$data = array('success'=>true,'token'=>$token);
			            }
				    }else{
				    	$data = array('error'=>'Invalid reset code');
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