<?php
require_once 'data.php';
header('Content-Type: application/json');
if (!all()) {
	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $_SERVER['REQUEST_METHOD'] == 'POST'){
		if (isset($_SESSION['token']) && $_POST['token'] == $_SESSION['token']) {
			if (isset($_POST['email'])) {
				$email = clean($_POST['email']);
				$em = $access->prepare('SELECT user_id FROM access WHERE email=:email LIMIT 1');
			    $em->execute(['email'=>$email]);
			    if ($em->rowCount() == 1) {
			        foreach ($em as $keys) {
			            $user_id = clean($keys["user_id"]);
			        }
			        $check_name = $access->prepare('SELECT name FROM enrollment WHERE user_id=:user_id LIMIT 1');
	    		 	$check_name->execute(['user_id'=>$user_id]);
	    		 	foreach ($check_name as $value) {
	    				$name = clean($value["name"]);
	    		 	}
			      	$date = date("Y");
                    $time = date("Y-m-d h:i:s");
                    $time = date('Y-m-d H:i:s', strtotime($time . ' +1 day'));
                    $token = account_token();
			  		$code = user_codes();
                    $fam = $access->prepare('SELECT user_id FROM reset_password WHERE email=:email LIMIT 1');
    			    $fam->execute(['email'=>$email]);
    			    if ($fam->rowCount() == 1) {
    			        $update = mysqli_query($connect, "UPDATE reset_password SET code='$code',token='$token',reset_time='$time' WHERE email='$email' LIMIT 1");
    			        if($update){
    			        	//sendmail
    			        	reset_mail($name,$email,$code,$token);
    			        	$_SESSION['reset'] = 1;
    			            $data = array('success'=>true,'mail'=>$email,'token'=>$token);
    			        }else{
    			            $data = array('error'=>'Error encountered, try again');
    			        }
    			    }else{
    			        $insert = mysqli_query($connect, "INSERT INTO reset_password (user_id, email, code, token, reset_time) VALUES ('$user_id', '$email', '$code', '$token', '$time')");
    			        if($insert){
    			            //sendmail
				    	reset_mail($name,$email,$code,$token);
    			            $data = array('success'=>true,'mail'=>$email,'token'=>$token);
    			        }else{
    			            $data = array('error'=>'Error encountered, try again');
    			        }
    			    }
			    }else{
			    	$data = array('error'=>'Sorry, there is no account associated with this email');
			    }
			}else{
   				$data = array('error'=>"Invalid request, on $_POST[email]");
   			}
		}else{
			$data = array('error'=>"Invalid request, on $_SESSION[token], && $_POST[token]");
		}
		$data = json_encode($data);
		echo $data;
	}		
}
mysqli_close($connect);
$access = null;
?>