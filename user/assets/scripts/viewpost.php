<?php
require_once 'data.php';
if (admin()) {
  if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $_SERVER['REQUEST_METHOD'] == 'POST'){
  	if (isset($_POST["id"])) {
  		$id = clean($_POST["id"]);
  		if(ctype_digit($id) && strlen($id)==6){
        $sql = $access->prepare("SELECT post FROM posts WHERE post_id=:id LIMIT 1");
        $sql->execute(['id'=>$id]);
        if ($sql->rowCount() == 1) {
          foreach($sql as $row){
            $post = $row['post'];
          }
          echo $post;
        }else{
          echo "3";
        }
      }
  	}
  }
}else{
	echo "4";
}
mysqli_close($connect);
$access = null;
?>