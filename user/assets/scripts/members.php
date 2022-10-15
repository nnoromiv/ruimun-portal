<?php
require_once 'data.php';
header('Content-Type: application/json');
if (admin()) {
  if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $_SERVER['REQUEST_METHOD'] == 'POST'){
  	$query = '';
	$output = array();
	$query .= "SELECT * FROM enrollment WHERE ";
	if(isset($_POST["search"]["value"]))
	{	
		$query .= 'user_id LIKE "%'.clean($_POST["search"]["value"]).'%"';
		$query .= 'OR name LIKE "%'.clean($_POST["search"]["value"]).'%" ';
		$query .= 'OR email LIKE "%'.clean($_POST["search"]["value"]).'%" ';
		$query .= 'OR phone LIKE "%'.clean($_POST["search"]["value"]).'%" ';
		$query .= 'OR captured LIKE "%'.clean($_POST["search"]["value"]).'%" ';
	}
	if(isset($_POST["order"]))
	{
		$query .= 'ORDER BY '.clean($_POST['order']['0']['column']).' '.clean($_POST['order']['0']['dir']).' ';
	}
	else
	{
		$query .= 'ORDER BY captured DESC ';
	}
	if($_POST["length"] != -1)
	{
		$query .= 'LIMIT ' . clean($_POST['start']) . ', ' . clean($_POST['length']);
	}
	$statement = $access->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$data = array();
	$filtered_rows = $statement->rowCount();
	foreach($result as $row){
		$committee1 = mysqli_query($connect, "SELECT committee FROM committee WHERE id='".clean($row["committee1"])."' LIMIT 1");
		$committee2 = mysqli_query($connect, "SELECT committee FROM committee WHERE id='".clean($row["committee2"])."' LIMIT 1");
		$committee3 = mysqli_query($connect, "SELECT committee FROM committee WHERE id='".clean($row["committee3"])."' LIMIT 1");
		$row1 = mysqli_fetch_array($committee1);
		$row2 = mysqli_fetch_array($committee2);
		$row3 = mysqli_fetch_array($committee3);
		$check = mysqli_query($connect, "SELECT status FROM access WHERE user_id='".clean($row["user_id"])."' LIMIT 1");
		if(mysqli_num_rows($check) == 1){
			$acc = mysqli_fetch_array($check);
			$account = $acc["status"];
			if ($account == '1') {
				$active = '<button class="btn btn-success btn-sm active0" id="'.$row["user_id"].'">active</button>';
			}elseif ($account == '0') {
				$active = '<button class="btn btn-danger btn-sm active1" id="'.$row["user_id"].'">not active</button>';
			}
			$status = '<button class="btn btn-success btn-sm">complete</button>';
		}else{
			$status = '<button class="btn btn-warning btn-sm">not complete</button>';
			$active = '<button class="btn btn-warning btn-sm">not complete</button>';
		}

		$sub_array = array();
		$sub_array[] = $row["user_id"];
		$sub_array[] = $row["name"];
		$sub_array[] = $row["email"];
		$sub_array[] = $row["phone"];
		$sub_array[] = strtoupper($row["user_type"]);
		$sub_array[] = $status;
		$sub_array[] = $active;
		$sub_array[] = time_convert($row["captured"]);
		$sub_array[] = '<button class="btn btn-info btn-sm viewMember" data-name="'.$row["name"].'" data-email="'.$row["email"].'"
                        data-phone="'.$row["phone"].'" data-type="'.$row["user_type"].'" data-medical="'.$row["medical"].'"
                        data-gender="'.$row["gender"].'" data-experience="'.$row["mun_experience"].'" data-affiliation="'.$row["affiliation"].'"
                        data-position="'.$row["position"].'" data-matric="'.$row["matric_num"].'" data-dept="'.$row["department"].'"
                        data-referral="'.$row["referral"].'" data-city="'.$row["city"].'" data-state="'.$row["state"].'"
                        data-country="'.$row["country"].'" data-shirt="'.$row["tshirt_size"].'" data-diet="'.$row["diet"].'"
						data-committee1="'.$row1["committee"].'" data-committee2="'.$row2["committee"].'" data-committee3="'.$row3["committee"].'"
						data-country1="'.$row["country1"].'" data-country2="'.$row["country2"].'"
						data-country3="'.$row["country3"].'">View</button><hr>
                        <button class="btn btn-primary btn-sm payment" id="'.$row["user_id"].'" data-name="'.$row["name"].'" 
                        data-email="'.$row["email"].'" data-type="'.$row["user_type"].'">Activate Payment</button>';
		$data[] = $sub_array;
		
	}
	$output = array(
		"draw"				=>	intval(clean($_POST["draw"])),
		"recordsTotal"		=> 	$filtered_rows,
		"recordsFiltered"	=>	get_members(),
		"data"				=>	$data
	);
	echo json_encode($output);
  }
}
mysqli_close($connect);
$access = null;
?>