<?php
require_once 'data.php';
if (admin()) {
  if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $_SERVER['REQUEST_METHOD'] == 'POST'){
  	if (isset($_POST["id"]) && isset($_POST["type"])) {
  		$id = clean($_POST["id"]);
  		$type = clean($_POST["type"]);
  		if (ctype_digit($id) && ctype_digit($type)) {
  			$sql = $access->prepare("SELECT status FROM access WHERE user_id=:user_id LIMIT 1");
	  		$sql->execute(['user_id'=>$id]);
	  		if ($sql->rowCount() == 1) {
	  			foreach ($sql as $key) {
	  				$status = $key["status"];
	  			}
	  			if ($type == 0 && $status == '1') {
		  			$update = mysqli_query($connect, "UPDATE access SET status='0' WHERE user_id='$id' LIMIT 1");
	  				echo 1;
	  			}elseif ($type == 1 && $status == '0') {
		  			$update = mysqli_query($connect, "UPDATE access SET status='1' WHERE user_id='$id' LIMIT 1");
	  				echo 1;
	  			}
	  		}else{
	  			echo "This user has not completed registration";
	  		}
  		}
  	}
  }
}else{
	echo "You are not logged in, please refresh your page";
}
mysqli_close($connect);
$access = null;
?>