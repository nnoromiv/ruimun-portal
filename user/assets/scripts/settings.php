<?php
require 'data.php';
if (all()) {
  if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $_SERVER['REQUEST_METHOD'] == 'POST'){
		if (isset($_SESSION['token']) && $_POST['token'] == $_SESSION['token']) {
			if (isset($_POST['oldpass']) && isset($_POST['pass']) && isset($_POST['cpass'])) {
				$errors = [];
			    $current = clean($_POST['oldpass']);
			    $password = clean($_POST['pass']);
			    $c_password = clean($_POST['cpass']);
			    $user_id = clean($_SESSION['userid']);

				if(empty($current) || empty($password) || empty($c_password)){
			      $errors[] = "All details are required for a password change";
			    }else{
  					if (!preg_match("/^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/", $password)) {
			      		$errors[] = "password must contain at least 8 characters including an uppercase and a lower case letter and a number";
				  	}
					if ($password != $c_password) {
					    $errors[] = "passwords do not match";
			  		}
			    }
			    if (!empty($errors)) {
					echo '<div class="alert alert-dismissible alert-warning border-0 fade show" role="alert">';
			  		echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
			            </button>';
				    foreach ($errors as $error) {
				        echo '<span>&bull;&nbsp;'.$error.'</span>';
				        echo "<br>";
				    }
			  		echo  '</div>';
			  	}else{
			  		$sql = $access->prepare("SELECT password FROM access WHERE user_id=:user_id LIMIT 1");
				    $sql->execute(['user_id'=>$user_id]);
				    if ($sql->rowCount() == 1) {
				      foreach ($sql as $row) {
				      	$hash = $row["password"];
				      }
				      if (password_verify($password, $hash)) {
				           echo message("You can not use your previous password as new password");
				        }else{
				        	if (password_verify($current, $hash)) {
					            $new = password_hash($password, PASSWORD_BCRYPT, [12]);
					            $query = $access->prepare("UPDATE access SET password=:key WHERE user_id=:user_id LIMIT 1");
					            if ($query->execute(['key'=>$new,'user_id'=>$user_id])) {
					              echo "1";
					            }else{
					            	echo message("Cannot change password at the moment, try again later");
					            }
				          	}else{
					            echo message("Incorrect current password");
				          	}
				        }
				  	}else{
				  		echo message("Cannot change password, contact admin");
				  	}
				}
			}
		}else{
			echo message("Invalid request, please refresh page");
		}
	}
}else{
	echo message("You are not logged in, please refresh page");
}
mysqli_close($connect);
$access = null;
?>