<?php
require_once 'data.php';
header('Content-Type: application/json');
if (admin()) {
  if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $_SERVER['REQUEST_METHOD'] == 'POST'){
  	$query = '';
	$output = array();
	$query .= "SELECT * FROM payments WHERE ";
	if(isset($_POST["search"]["value"]))
	{	
		$query .= 'user_id LIKE "%'.clean($_POST["search"]["value"]).'%"';
		$query .= 'OR email LIKE "%'.clean($_POST["search"]["value"]).'%" ';
		$query .= 'OR pay_type LIKE "%'.clean($_POST["search"]["value"]).'%" ';
		$query .= 'OR ref_code LIKE "%'.clean($_POST["search"]["value"]).'%" ';
		$query .= 'OR status LIKE "%'.clean($_POST["search"]["value"]).'%" ';
		$query .= 'OR amount LIKE "%'.clean($_POST["search"]["value"]).'%" ';
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
		$sub_array = array();
		$sub_array[] = $row["user_id"];
		$sub_array[] = $row["email"];
		$sub_array[] = $row["pay_type"];
		$sub_array[] = $row["ref_code"];
		$sub_array[] = "&#8358;&nbsp;".number_format($row["amount"]);
		$sub_array[] = $row["status"];
		$sub_array[] = time_convert($row["captured"]);
		$data[] = $sub_array;
		
	}
	$output = array(
		"draw"				=>	intval(clean($_POST["draw"])),
		"recordsTotal"		=> 	$filtered_rows,
		"recordsFiltered"	=>	get_payments(),
		"data"				=>	$data
	);
	echo json_encode($output);
  }
}
mysqli_close($connect);
$access = null;
?>