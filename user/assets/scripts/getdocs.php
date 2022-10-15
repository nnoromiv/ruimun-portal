<?php
require_once 'data.php';
if (user()) {
  if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $_SERVER['REQUEST_METHOD'] == 'GET'){
    $user_id = clean($_SESSION["userid"]);
    $posts = '';
    $one = '1';
    $sql = $access->prepare("SELECT year FROM subscription WHERE user_id=:user_id");
    $sql->execute(['user_id'=>$user_id]);
    foreach ($sql as $row) {
      $year = $row["year"];
      $query = $access->prepare("SELECT * FROM docs WHERE YEAR(captured)=:year ORDER BY captured DESC");
      $query->execute(['year'=>$year]);
      foreach ($query as $rows) {
        $posts .= '<div class="media p-3">
                    <div class="media-body">
                      <a href="filedownload?id='.$rows["doc_id"].'" style="color:black"><i class="fas fa-download text-info"></i></a>&nbsp;&nbsp;
                      <span class="text-70">'.$rows["name"].'</span><br><small><i>Posted on '.time_convert($rows["captured"]).'</i></small>
                    </div>
                  </div>';

      }
    }
    echo $posts;
  }
}else{
	echo message("You are not logged in, please refresh page");
}
mysqli_close($connect);
$access = null;
?>