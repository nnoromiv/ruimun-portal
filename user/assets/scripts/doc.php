<?php
require_once 'data.php';
if (admin()) {
  if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $_SERVER['REQUEST_METHOD'] == 'POST'){
  	if (isset($_FILES['document']['name'])) {
      $pdfname = clean($_FILES['document']['name']);
      $check_docs = $access->prepare("SELECT id FROM docs WHERE name=:pdfname LIMIT 1");
      $check_docs->execute(['pdfname'=>$pdfname]);
      if ($check_docs->rowCount() == 1) {
        echo message("$pdfname already exists in directory");
      }else{
        if ($pdf = upload_doc()){
          $doc_id = rand(100000,999999);
          $stmt = $access->prepare("INSERT INTO docs (doc_id, name) VALUES (:doc_id, :name)");
          $stmt->bindParam(':doc_id', $doc_id);
          $stmt->bindParam(':name', $pdf);
          if($stmt->execute()){
              echo "1";
          }else{
            echo message("Unable to upload document, try again later");
          }
        }else{
          echo message("Unable to upload document, try again later");
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