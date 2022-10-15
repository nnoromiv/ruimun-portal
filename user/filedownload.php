<?php
require_once 'assets/scripts/data.php';
if (!user()) {
  redirect("materials");
}else{
	if (isset($_GET['id'])) {
	    $id = clean($_GET['id']);
	    $sql = $access->prepare("SELECT * FROM docs WHERE doc_id=:id LIMIT 1");
	    $sql->execute(['id'=>$id]);
	    if ($sql->rowCount() > 0) {
	        foreach ($sql as $file) {
	            $filepath = $_SERVER['DOCUMENT_ROOT'].'/portal/user/assets/docs/' . $file['name'];
	        }
	        if (file_exists($filepath)) {
	            header('Content-Description: File Transfer');
	            header('Content-Type: application/octet-stream');
	            header('Content-Disposition: attachment; filename=' . basename($filepath));
	            header('Expires: 0');
	            header('Cache-Control: must-revalidate');
	            header('Pragma: public');
	            header('Content-Length: ' . filesize($_SERVER['DOCUMENT_ROOT'].'/portal/user/assets/docs/'.$file['name']));
	            readfile($_SERVER['DOCUMENT_ROOT'].'/portal/user/assets/docs/'.$file['name']);
	            $newCount = $file['downloads'] + 1;
	            $updateQuery = "UPDATE docs SET downloads='$newCount' WHERE doc_id=$id LIMIT 1";
	            mysqli_query($connect, $updateQuery);
	            exit;
	        }else{
	            redirect("materials");
	        }
	    }else{
	         redirect("materials");
	    }
	}
}
mysqli_close($connect);
$access = null;
?>