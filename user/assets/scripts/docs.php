<?php
require_once 'data.php';
header('Content-Type: application/json');
if (admin()) {
  if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $_SERVER['REQUEST_METHOD'] == 'POST'){
    $query = '';
  $output = array();
  $query .= "SELECT * FROM docs WHERE ";
  if(isset($_POST["search"]["value"]))
  { 
    $query .= 'doc_id LIKE "%'.clean($_POST["search"]["value"]).'%"';
    $query .= 'OR name LIKE "%'.clean($_POST["search"]["value"]).'%" ';
    $query .= 'OR downloads LIKE "%'.clean($_POST["search"]["value"]).'%" ';
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
    $delete = '<button class="btn btn-danger btn-sm btn-circle remove" id="'.$row["doc_id"].'"><i class="fas fa-trash"></i></button>';
    $sub_array = array();
    $sub_array[] = $row["doc_id"];
    $sub_array[] = $row["name"];
    $sub_array[] = $row["downloads"];
    $sub_array[] = time_convert($row["captured"]);
    $sub_array[] = $delete;
    $data[] = $sub_array;
    
  }
  $output = array(
    "draw"        =>  intval(clean($_POST["draw"])),
    "recordsTotal"    =>  $filtered_rows,
    "recordsFiltered" =>  get_docs(),
    "data"        =>  $data
  );
  echo json_encode($output);
  }
}
mysqli_close($connect);
$access = null;
?>