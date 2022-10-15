<?php
require_once 'data.php';
if (admin()) {
  if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $_SERVER['REQUEST_METHOD'] == 'POST'){
  	if (isset($_POST["id"])) {
  		$id = clean($_POST["id"]);
  		if(ctype_digit($id) && strlen($id)==6){
            $ptime = date("Y-m-d H:i:s");
            $sql = $access->prepare("SELECT publish FROM posts WHERE post_id=:id LIMIT 1");
            $sql->execute(['id'=>$id]);
            foreach($sql as $row){
                $publish = $row['publish'];
            }
            if($publish == "1"){
      			echo "This post has been published already";
            }else{
            	$one = "1";
                $query = $access->prepare("UPDATE posts SET publish=:one,ptime=:ptime WHERE post_id=:id LIMIT 1");
                if($query->execute(['one'=>'1','ptime'=>$ptime,'id'=>$id])){
                	echo "1";
                }
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