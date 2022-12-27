<?php
require_once 'assets/scripts/data.php';
if (!admin()) {
  redirect("login");
}
$get_download = mysqli_fetch_array(mysqli_query($connect, 'SELECT SUM(downloads) AS value_sum FROM docs')); 
$downloads = $get_download['value_sum'];
$get_payments = mysqli_fetch_array(mysqli_query($connect, 'SELECT SUM(amount) AS value_sum FROM payments')); 
$payments = ceil($get_payments['value_sum']);
if (empty($payments)) {
  $payments = 0;
}
$members = mysqli_num_rows(mysqli_query($connect, 'SELECT id FROM enrollment'));
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
  <title>Dashboard</title>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="assets/css/sb-admin-2.css" rel="stylesheet">

</head>

<body id="page-top">
  <div id="wrapper">   
   <!-- Calling the `adminsidebar.html` file. -->
  <?php echo file_get_contents('html/adminsidebar.html') ?>
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
      <!-- Main Content -->
      <div id="content">
    <!-- Calling the admin top bar.  -->
      <?php include 'admintopbar.php' ?>
        <!-- Begin Page Content -->
        <div class="container-fluid">
            <div class="row">
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Registered Members</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $members; ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Revenue (Annual)</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">&#8358;&nbsp;
                        <?php echo $payments; ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-money-bill-alt fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Material Downloads</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $downloads; ?></div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-download fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- <button type="button" class="btn btn-md" style="background:#494263;color:white;" >Update Subscribers</button> -->
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