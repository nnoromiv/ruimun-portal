<?php
require_once 'assets/scripts/data.php';
if (!user()) {
  redirect("login");
}
$userid = clean($_SESSION['userid']);
$query = $access->prepare("SELECT name,phone FROM enrollment WHERE user_id=:userid LIMIT 1");
$query->execute(['userid'=>$userid]);
foreach ($query as $row) {
  $name = clean($row["name"]);
  $phone = clean($row["phone"]);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="icon" type="image/png" href="assets/images/utility/icon.png">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Profile</title>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="assets/css/sb-admin-2.css" rel="stylesheet">
  <style>
    <?php include '../css/styles.css' ?>
  </style>
</head>

<body id="page-top">
  <div id="wrapper">
   <!-- Getting the contents of the file usersidebar.html and echoing it out. -->
   <?php echo file_get_contents('html/usersidebar.html') ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

           <!-- /* Including the usertopbar.php file in the current file. */ -->
           <?php include 'usertopbar.php' ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-5">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold">Edit your profile</h6>
                </div>
                <div class="card-body">
                  <form id="profile" method="post">
                    <div class="form-group">
                      <label style="font-weight:bold;">Name</label>
                      <input required type="text" name="name" id="name" class="form-control" value="<?php echo $name; ?>">
                    </div>
                    <div class="form-group">
                      <label style="font-weight:bold;">Phone number</label>
                      <input required type="text" name="phone" id="phone" class="form-control" value="<?php echo $phone; ?>">
                    </div>
                    <div class="form-group">
                      <input required type="hidden" name="token" id="token" value="<?php echo tokenGenerator();?>">
                      <button type="submit" style="background:#494263;color:white;border-radius: 30px;" class="btn btn-md">Edit profile</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

 <!-- Calling the footer.html file. -->
 <?php echo file_get_contents('html/footer.html') ?>

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

<!-- A function that is used to call the scrolltotop.html file.  -->
<?php echo file_get_contents('html/scrolltotop.html') ?>
<!-- Calling the logoutmodal.html file.  -->
<?php echo file_get_contents('html/logoutmodal.html') ?>

  <script src="assets/bootstrap/jquery.js"></script>
  <script src="assets/bootstrap/bootstrap.bundle.min.js"></script>
  <script src="assets/jquery-easing/jquery.easing.min.js"></script>
  <script src="assets/js/sb-admin-2.min.js"></script>

</body>

</html>
