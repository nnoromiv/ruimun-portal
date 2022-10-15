<?php
require_once 'data.php';
header('Content-Type: application/json');
if (user()) {
  if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $_SERVER['REQUEST_METHOD'] == 'POST'){
  	$query = '';
	$output = array();
	$user_id = clean($_SESSION["userid"]);
	$query .= "SELECT ref_code,amount,captured FROM payments WHERE user_id=:user_id AND ";
	if(isset($_POST["search"]["value"]))
	{	
		$query .= 'email LIKE "%'.clean($_POST["search"]["value"]).'%"';
		$query .= 'OR user_id=:user_id AND pay_type LIKE "%'.clean($_POST["search"]["value"]).'%" ';
		$query .= 'OR user_id=:user_id AND ref_code LIKE "%'.clean($_POST["search"]["value"]).'%" ';
		$query .= 'OR user_id=:user_id AND amount LIKE "%'.clean($_POST["search"]["value"]).'%" ';
		$query .= 'OR user_id=:user_id AND captured LIKE "%'.clean($_POST["search"]["value"]).'%" ';
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
	$statement->execute(['user_id'=>$user_id]);
	$result = $statement->fetchAll();
	$data = array();
	$filtered_rows = $statement->rowCount();
	foreach($result as $row){
		$download = '<button class="btn btn-info btn-sm reciept" id="'.$row["ref_code"].'"><i class="fas fa-print"></i>&nbsp;print</button>';
		$sub_array = array();
		$sub_array[] = $row["ref_code"];
		$sub_array[] = "&#8358;&nbsp;".number_format($row["amount"]);
		$sub_array[] = time_convert($row["captured"]);
		$sub_array[] = $download;
		$data[] = $sub_array;
	}
	$output = array(
		"draw"				=>	intval(clean($_POST["draw"])),
		"recordsTotal"		=> 	$filtered_rows,
		"recordsFiltered"	=>	get_payment($user_id),
		"data"				=>	$data
	);
	echo json_encode($output);
  }
}
mysqli_close($connect);
$access = null;
?>