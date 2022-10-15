<?php
require_once 'data.php';
if (user()) {
  if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $_SERVER['REQUEST_METHOD'] == 'GET'){
    $user_id = clean($_SESSION["userid"]);
    $posts = '';
    $one = '1';
    // $sql = $access->prepare("SELECT year FROM subscription WHERE user_id=:user_id");
    // $sql->execute(['user_id'=>$user_id]);
    // foreach ($sql as $row) {
      //$year = $row["year"];
      $year = date('Y');
      $query = $access->prepare("SELECT * FROM posts WHERE publish=:one AND YEAR(captured)=:year");
      $query->execute(['one'=>$one,'year'=>$year]);
    if($query->rowCount() >= 1){
        foreach ($query as $rows) {
            $posts .= '<a href="viewpost?id='.$rows["post_id"].'" id="postcolor" style="color:black;text-decoration:none;">
                        <div class="media p-3">
                            <div class="media-body">
                            <h5><b>'.$rows["author"].'</b>&nbsp;<small><i>Posted on '.time_convert($rows["captured"]).'</i></small></h5>
                            <p>'.$rows["post"].'</p>
                            </div>
                        </div>
                        </a>';
        }
    }else{
        $posts = 'No topics found';
    }
    //}
    echo $posts;
  }
}else{
	echo message("You are not logged in, please refresh page");
}
mysqli_close($connect);
$access = null;
?>