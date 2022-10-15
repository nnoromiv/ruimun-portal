<?php
require_once 'assets/scripts/data.php';
if (!user()) {
  redirect("payment");
}else{
	if (isset($_GET["id"])) {
		$id = clean($_GET["id"]);
		$stmt = $access->prepare("SELECT * FROM payments WHERE ref_code=:id LIMIT 1");
		$stmt->execute(['id'=>$id]);
		if ($stmt->rowCount() == 1) {
			foreach ($stmt as $row) {
				$user_id = clean($row["user_id"]);
				$email = clean($row["email"]);
				$ref_code = clean($row["ref_code"]);
				$pay_type = clean($row["pay_type"]);
				$trans_id = clean($row["trans_id"]);
				$amount = clean($row["amount"]);
				$captured = clean(time_convert($row["captured"]));
			}
			if($pay_type == 'regular'){
			  $type = 'regular';
			}elseif ($pay_type == 'school') {
			  $type = 'Secondary school';
			}elseif ($pay_type == 'foreign') {
			  $type = 'foreign';
			}
			$sql = mysqli_fetch_array(mysqli_query($connect, "SELECT name,phone FROM enrollment WHERE user_id='$user_id' LIMIT 1"));
			$name = clean($sql["name"]);
			$phone = clean($sql["phone"]);
		}else{
			redirect("payment");
		}
	}else{
		redirect("payment");
	}
}
mysqli_close($connect);
$access = null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="icon" type="image/png" href="assets/images/utility/icon.png">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>RUIMUN RECIEPT</title>
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link rel="stylesheet" href="assets/bootstrap/bootstrap.css">
  <style type="text/css">
  	body{
  		font-family: 'Nunito';
  		font-size: 20px;
  	}
  </style>
</head>

<body onload="window.print();">
	<div class="container h-100">
	  <div class="row h-100 justify-content-center align-items-center" style="padding-top:60px;">
			<div class="col-md-8">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-lg-6">
                            <img class="float-right" width="50%" src="assets/images/utility/payment2.png">
								NAME - <span style="font-weight:bold;text-transform:uppercase;"><?php echo $name; ?></span><br>
								EMAIL - <span style="font-weight:bold;"><?php echo $email; ?></span><br>
								PHONE - <span style="font-weight:bold;text-transform:uppercase;"><?php echo $phone; ?></span>
							</div>
							<!-- <div class="col-lg-6 d-flex">
								<img class="float-right" width="50%" src="assets/images/utility/payment2.png">
							</div> -->
						</div>
						<hr>
						<h4 style="font-weight:bold;">PAYMENT DETAILS</h4>
						PAYMENT TYPE - <span style="font-weight:bold;text-transform:uppercase;">RUIMUN <?php echo $type; ?> DELEGATE FEE</span><br>
						RRR - <span style="font-weight:bold;text-transform:uppercase;"><?php echo $ref_code; ?></span><br>
						TRANSACTION ID - <span style="font-weight:bold;text-transform:uppercase;"><?php echo $trans_id; ?></span><br>
AMOUNT - <span style="font-weight:bold;text-transform:uppercase;">&#8358;<?php echo number_format($amount); ?></span><br>
						DATE - <span style="font-weight:bold;text-transform:uppercase;"><?php echo $captured; ?></span><br>
					</div>
				</div>
			</div>
	  </div>
	</div>
</body>

</html>