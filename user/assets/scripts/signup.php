<?php
require_once 'data.php';
header('Content-Type: application/json');
if (!all()) {
	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $_SERVER['REQUEST_METHOD'] == 'POST'){
		if (isset($_SESSION['token']) && $_POST['token'] == $_SESSION['token']) {
			if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['password']) && isset($_POST['c_password']) && isset($_POST['type'])) {
				$name = '';
				$mail = '';
				$phone = '';
				$pass = '';
				$pass2 = '';

			    $check_email = $access->prepare("SELECT id FROM enrollment WHERE email=:email LIMIT 1");
				$check_email->execute(['email'=>clean($_POST['email'])]);

				$check_phone = $access->prepare("SELECT id FROM enrollment WHERE phone=:phone LIMIT 1");
				$check_phone->execute(['phone'=>clean($_POST['phone'])]);

				if (empty($_POST['name'])) {
					$name = 'Full name is required';
				}else{
				    $names = explode(' ', $_POST['name']);
					if (!ctype_alpha(str_replace(' ', '', $_POST['name'])) === true) {
						$name = 'Invalid name';
					}elseif (empty($names['1'])) {
                    	$name = 'Provide full name';
                    }else{
						$user_name = clean($_POST['name']);
					}
				}
				if (empty($_POST['email'])) {
					$mail = 'Email is required';
				}else{
					if (!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) {
						$mail = 'Invalid email';
					}elseif ($check_email->rowCount() == 1) {
						$mail = 'Email already exists';
					}else{
						$user_email = clean($_POST['email']);
					}
				}
				if (empty($_POST['phone'])) {
					$phone = 'Phone number is required';
				}else{
					if ($check_phone->rowCount() == 1) {
						$phone = 'Phone number already exists';
					}else{
						$user_phone = clean($_POST['phone']);
					}
				}
				if (empty($_POST['password'])) {
					$pass = 'Password is required';
				}else{
					if (!preg_match("/^.*(?=.{6,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/", $_POST['password'])) {
						$pass = 'Password must contain at least 8 characters including an uppercase case letter and a number';
					}elseif ($_POST['password'] != $_POST['c_password']) {
						$pass2 = 'Passwords do not match';
					}else{
						$user_password = clean($_POST['password']);
						$type = clean($_POST['type']);
					}
				}
				if ($name == '' && $mail == '' && $phone == '' && $pass == '' && $pass2 == '') {
					$password = password_hash($user_password, PASSWORD_BCRYPT, [12]);
			  		$user_id = user_id_code();
			  		$token = account_token();
			  		$code = user_codes();
			  		$captured = date("Y-m-d H:i:s");

			  		$stmt = $access->prepare("INSERT INTO enrollment (user_id, name, email, phone, 
                      user_type, password, code, token, captured, gender, mun_experience, affiliation, 
                      position, department, matric_num, city, state, country, zipcode, advert, tshirt_size, 
                      medical, diet, referral, committee1,country1,committee2,country2,committee3,country3) 
                      VALUES (:user_id, :name, :email, :phone, :user_type, :password, :code, :token, :captured, :gender, 
                      :experience, :affiliation, :position, :department, :matric, :city, :state, :country, :zipcode, :advert, 
                      :tshirt, :medical, :diet, :referral, :committee1,:country1,:committee2,:country2,:committee3,:country3)");
			  		$stmt->bindParam(':user_id', $user_id);
				    $stmt->bindParam(':name', $user_name);
				    $stmt->bindParam(':email', $user_email);
				    $stmt->bindParam(':phone', $user_phone);
				    $stmt->bindParam(':user_type', $type);
				    $stmt->bindParam(':password', $password);
				    $stmt->bindParam(':code', $code);
				    $stmt->bindParam(':token', $token);
				    $stmt->bindParam(':captured', $captured);
				    $stmt->bindParam(':gender', $_POST['gender']);
				    $stmt->bindParam(':experience', $_POST['experience']);
				    $stmt->bindParam(':affiliation', $_POST['affiliation']);
				    $stmt->bindParam(':position', $_POST['position']);
				    $stmt->bindParam(':department', $_POST['department']);
				    $stmt->bindParam(':matric', $_POST['matric']);
				    $stmt->bindParam(':city', $_POST['city']);
				    $stmt->bindParam(':state', $_POST['state']);
				    $stmt->bindParam(':country', $_POST['country']);
				    $stmt->bindParam(':zipcode', $_POST['zipcode']);
				    $stmt->bindParam(':advert', $_POST['advert']);
				    $stmt->bindParam(':tshirt', $_POST['tshirt']);
				    $stmt->bindParam(':medical', $_POST['medical']);
				    $stmt->bindParam(':diet', $_POST['diet']);
				    $stmt->bindParam(':referral', $_POST['referral']);
				    $stmt->bindParam(':committee1', $_POST['committee1']);
				    $stmt->bindParam(':country1', $_POST['country1']);
				    $stmt->bindParam(':committee2', $_POST['committee2']);
				    $stmt->bindParam(':country2', $_POST['country2']);
				    $stmt->bindParam(':committee3', $_POST['committee3']);
				    $stmt->bindParam(':country3', $_POST['country3']);

				    if ($stmt->execute()) {
						$zero = "0";
						$one = "1";
				    	//send  mail
                        $user_name= ucfirst($user_name);
						$date = date("Y");
						$subject = "Your Account Activation Code";		
						$headers = 'From:RUIMUN<payments@ruimun.org>' . "\r\n"; 
						$body = '<body style="margin:0px; font-family:"Arial, Helvetica, sans-serif; font-size:16px;">
									Hi '.$user_name.', Welcome to the <span style="font-weight:bold;">REDEEMERS UNIVERSITY INTERNATIONAL MODEL UNITED NATIONS</span>,
									<p>Your account activation code is:</p>
									<h4 style="font-weight:bold;">'.$code.'</h4>
									<div>
										<p>Please note:</p>
										<p>For security purposes, do not disclose the contents of this email.</p>
									</div>
									<div>
										<p>Thank You</p>
										<p>Copyright © RUIMUN '.$date.'</p>
									</div>
								</body>';
						// $mail_status=mail($user_email, $subject, $body, $headers); 
						// $mail_status = signup_mail($user_name,$user_email,$code);
						// if ($mail_status===true) {
						// 	$_SESSION['validate'] = 1;
				    	// 	$data = array('success'=>true,'mail'=>$user_email,'token'=>$token);
						// }
						// else{
				    	// 	$data = array('false'=>true,'status'=>$mail_status,'token'=>$token);
						// }

						$insert = $access->prepare("INSERT INTO access (user_id, email, password, user_type, captured) VALUES (:user_id, :email, :password, :user_type, :captured)");
						$insert->bindParam(':user_id', $user_id);
						$insert->bindParam(':email', $user_email);
						$insert->bindParam(':password', $password);
						$insert->bindParam(':user_type', $type);
						$insert->bindParam(':captured', $captured);
						$update = $access->prepare("UPDATE enrollment SET token=:token, status=:zero, code=:code WHERE email=:email AND user_id=:user_id LIMIT 1");
						$array = array('token'=>$zero,'zero'=>$one,'code'=>$zero,'email'=>$user_email,'user_id'=>$user_id);

						if ($insert->execute() && $update->execute($array)) {
							unset($_SESSION['validate']);
							$_SESSION['first_time'] = 1;
				  			$_SESSION['userid'] = $user_id;
	                        $_SESSION['type'] = $user_type;
	                        $_SESSION['email'] = $user_email;
	                  		session_regenerate_id(true);
	                  		$data = array('success'=>true);
						}
						else{
							 	$data = array('false'=>true,'error'=>"Server error, please try again later");
							}

				    }else{
				    	$data = array('error'=>"Server error, please try again later");
					}
			    }else{
			    	$data = array('name'=>$name,'email'=>$mail,'phone'=>$phone,'pass'=>$pass,'pass2'=>$pass2);
			    }
   			}else{
   				$data = array('error'=>"Incomplete form data");
   			}
		}else{
			$data = array('error'=>"Invalid request, please refresh your page");
		}
	}	echo json_encode($data);	
}
mysqli_close($connect);
$access = null;
?>