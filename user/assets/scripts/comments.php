<?php
require_once 'data.php';
if (admin()) {
  if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $_SERVER['REQUEST_METHOD'] == 'POST'){
  	if (isset($_POST["id"])) {
  		$id = clean($_POST["id"]);
  		if(ctype_digit($id) && strlen($id)==6){
        $comments = '';
        $sql = $access->prepare("SELECT user_id,comment,captured FROM comments WHERE post_id=:id ORDER BY captured DESC");
        $sql->execute(['id'=>$id]);
        if ($sql->rowCount() >= 1) {
          foreach($sql as $row){
            $get_name = mysqli_fetch_array(mysqli_query($connect, "SELECT name FROM enrollment WHERE user_id='".$row["user_id"]."' LIMIT 1"));
            $name = $get_name["name"];
            $comments .= '<div class="media p-3">
                            <div class="media-body">
                              <span>'.$name.' <small><i>Posted on '.time_convert($row["captured"]).'</i></small></span>
                              <p style="font-weight:bold;">'.$row["comment"].'</p>
                            </div>
                          </div>';
          }
          echo $comments;
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