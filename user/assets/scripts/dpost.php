<?php
require_once 'data.php';
if (admin()) {
  if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $_SERVER['REQUEST_METHOD'] == 'POST'){
  	if (isset($_POST["id"])) {
  		$id = clean($_POST["id"]);
  		if(ctype_digit($id) && strlen($id)==6){
        $statement = $access->prepare("DELETE FROM posts WHERE post_id=:id LIMIT 1");
        $result = $statement->execute(['id'=>$id]);
        if(!empty($result)){
          echo '1';
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