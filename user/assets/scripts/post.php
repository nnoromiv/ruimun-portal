<?php
require_once 'data.php';
if (admin()) {
  if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $_SERVER['REQUEST_METHOD'] == 'POST'){
  	if (isset($_POST["content"]) && isset($_POST['author'])) {
      $content = $_POST["content"];
      $author = clean($_POST["author"]);
      if (empty($content) || empty($author)) {
        echo message("Please fill all post details");
      }else{
        $post_id = rand(100000,999999);
        $stmt = $access->prepare("INSERT INTO posts (post_id, post, author) VALUES (:post_id, :post, :author)");
        $stmt->bindParam(':post_id', $post_id);
        $stmt->bindParam(':post', $content);
        $stmt->bindParam(':author', $author);
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