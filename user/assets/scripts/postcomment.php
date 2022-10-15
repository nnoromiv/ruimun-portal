<?php
require_once 'data.php';
if (user()) {
  if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $_SERVER['REQUEST_METHOD'] == 'POST'){
  	if (isset($_POST["content"]) && isset($_POST['post_id'])) {
      $comment = $_POST["content"];
      $post_id = $_POST["post_id"];
      $user_id = clean($_SESSION["userid"]);
      if (empty($comment)) {
        echo message("Comment cannot be empty");
      }else{
        $comm_id = rand(100000,999999);
        $stmt = $access->prepare("INSERT INTO comments (user_id, post_id, comm_id, comment) VALUES (:user_id, :post_id, :comm_id, :comment)");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':post_id', $post_id);
        $stmt->bindParam(':comm_id', $comm_id);
        $stmt->bindParam(':comment', $comment);
        if($stmt->execute()){
            echo "1";
        }else{
          echo message("Error creating post, try again later");
        }
      }
  	}
  }
}else{
	echo message("You are not logged in, please refresh your page");
}
mysqli_close($connect);
$access = null;
?>