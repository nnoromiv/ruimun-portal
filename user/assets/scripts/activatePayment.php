<?php
require_once 'data.php';
if (admin()) {
  if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $_SERVER['REQUEST_METHOD'] == 'POST'){
  	if (isset($_POST["userid"]) && isset($_POST["paytype"])) {
  		  $id = clean($_POST["userid"]);
  		  $type = clean($_POST["paytype"]);
        $status = "success";
        $current = date("Y");
  			$sql = $access->prepare("SELECT * FROM payments WHERE user_id=:user_id");
        $sqltwo = $access->prepare("SELECT * FROM subscription WHERE user_id=:user_id_two");
	  		$sql->execute(['user_id'=>$id]);
        $sqltwo->execute(['user_id_two'=>$id]);
	  		if ($sql->rowCount() == 0 && $sqltwo->rowCount() == 0) {
                $stmt = $access->prepare("INSERT INTO payments (user_id, email, pay_type, ref_code, trans_id, amount, status) 
                    VALUES (:user_id, :email, :pay_type, :ref_code, :trans_id, :amount, :status)");
                $stmb = $access->prepare("INSERT INTO subscription ( user_id, year ) 
                    VALUES( :user_id_two, :current )");
                $stmt->bindParam(':user_id', $id);
                $stmt->bindParam(':email', $_POST["email"]);
                $stmt->bindParam(':pay_type', $_POST["paytype"]);
                $stmt->bindParam(':ref_code', $_POST["trans_id"]);
                $stmt->bindParam(':trans_id', $_POST["trans_id"]);
                $stmt->bindParam(':amount', $_POST["amount"]);
                $stmt->bindParam(':status', $status);
                $stmb->bindParam(':user_id_two', $id);
                $stmb->bindParam(':current', $current);
                if($stmt->execute() && $stmb->execute()){
                    echo "1";
                }else{
                  echo "Error activating payment";
                }
            }
            else{
                echo "Payment already activated!";
            }
  	}
  }
}else{
	echo "You are not logged in, please refresh your page";
}
mysqli_close($connect);
$access = null;
?>