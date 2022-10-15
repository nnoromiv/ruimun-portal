<?php
require_once 'assets/scripts/data.php';
header('Content-Type: application/json');
if (isset($_SESSION['token']) && $_POST['token'] == $_SESSION['token']) {
	if(isset($_POST["trans_id"]) && isset($_POST["ref_code"]) && isset($_POST["amount"]) && isset($_POST["email"]) && isset($_POST["id"])){
	  	$trans_id = clean($_POST["trans_id"]);
	  	$ref_code = clean($_POST["ref_code"]);
	  	$amount = clean($_POST["amount"]);
	  	$email = clean($_POST["email"]);
	  	$id = clean($_POST["id"]);

	  	$get_type = mysqli_fetch_array(mysqli_query($connect, "SELECT user_type FROM enrollment WHERE user_id='$id' LIMIT 1"));
	  	$type = $get_type["user_type"];
	  	if (($type == "nigerian" && $amount >= 55000) || ($type == "RUN" && $amount >= 45000)|| ($type == "virtual" && $amount >= 5000) || ($type == "foreign" && $amount >= 74000)) {
	  		$year = date("Y");
	  		$stmt = $access->prepare("INSERT INTO payments (user_id, email, pay_type, ref_code, trans_id, amount) VALUES (:user_id, :email, :pay_type, :ref_code, :trans_id, :amount)");
	  		$stmt->bindParam(':user_id', $id);
	  		$stmt->bindParam(':email', $email);
	  		$stmt->bindParam(':pay_type', $type);
	  		$stmt->bindParam(':ref_code', $ref_code);
	  		$stmt->bindParam(':trans_id', $trans_id);
	  		$stmt->bindParam(':amount', $amount);
	  		$sql = $access->prepare("INSERT INTO subscription (user_id, year) VALUES (:user_id, :year)");
	  		$sql->bindParam(':user_id', $id);
	  		$sql->bindParam(':year', $year);
	  		if($stmt->execute() && $sql->execute()){
	  			$data = array('success'=>true);
	  		}else{
	  			$data = array('error'=>true,'error_msg'=>"Error, payment cannot be processed at the moment");
	  		}
	  	}else{
	  		$data = array('error'=>true,'error_msg'=>"Invalid payment, please contact admin");
	  	}
  	}
}else{
	$data = array('error'=>true,'error_msg'=>"Invalid request, please refresh your page");
}
echo json_encode($data);
mysqli_close($connect);
$access = null;
?>