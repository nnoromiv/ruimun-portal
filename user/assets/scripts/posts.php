<?php
require_once 'data.php';
header('Content-Type: application/json');
if (admin()) {
  if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $_SERVER['REQUEST_METHOD'] == 'POST'){
  	$query = '';
	$output = array();
	$query .= "SELECT * FROM posts WHERE ";
	if(isset($_POST["search"]["value"]))
	{	
		$query .= 'post_id LIKE "%'.clean($_POST["search"]["value"]).'%"';
		$query .= 'OR post LIKE "%'.clean($_POST["search"]["value"]).'%" ';
		$query .= 'OR author LIKE "%'.clean($_POST["search"]["value"]).'%" ';
		$query .= 'OR ptime LIKE "%'.clean($_POST["search"]["value"]).'%" ';
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
		if ($row["publish"] == '0') {
			$publish = '<button class="btn btn-warning btn-sm publish" id="'.$row["post_id"].'">not published</button>';
			$view = '<button class="btn btn-light btn-sm view" id="'.$row["post_id"].'">preview</button>';
			$comments = '<button class="btn btn-info btn-sm">not published</button>';
		}elseif ($row["publish"] == '1') {
			$publish = '<button class="btn btn-success btn-sm">published</button>';
			$view = '<button class="btn btn-light btn-sm view" id="'.$row["post_id"].'">view post</button>';
			$comments = '<button class="btn btn-info btn-sm comment" id="'.$row["post_id"].'">view</button>';
		}
		$delete = '<button class="btn btn-danger btn-sm btn-circle remove" id="'.$row["post_id"].'"><i class="fas fa-trash"></i></button>';

		$sub_array = array();
		$sub_array[] = $row["post_id"];
		$sub_array[] = $view;
		$sub_array[] = $publish;
		$sub_array[] = $comments;
		$sub_array[] = $delete;
		$sub_array[] = time_convert($row["captured"]);
		$data[] = $sub_array;
		
	}
	$output = array(
		"draw"				=>	intval(clean($_POST["draw"])),
		"recordsTotal"		=> 	$filtered_rows,
		"recordsFiltered"	=>	get_posts(),
		"data"				=>	$data
	);
	echo json_encode($output);
  }
}
mysqli_close($connect);
$access = null;
?>