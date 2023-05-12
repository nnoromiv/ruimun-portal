<?php
require_once 'assets/scripts/data.php';
if (!user()) {
  redirect("login");
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
  <title>Payments</title>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="assets/css/sb-admin-2.css" rel="stylesheet">
  <link href="assets/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

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
          <h1 class="h3 mb-2 text-gray-800">Your Payments</h1>
          <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-dark"><a id="refresh" href="javascript:void(0);" style="text-decoration:none;" class="float-right refresh"><i style="padding-bottom:1px;" class="fas fa-fw fa-sync"></i>&nbsp;Refresh</a></h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead class="thead-light">
                    <tr>
                      <th>REFERNCE CODE</th>
                      <th>AMOUNT</th>
                      <th>CAPTURED</th>
                      <th>RECIEPT</th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
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
  <script src="assets/datatables/jquery.dataTables.min.js"></script>
  <script src="assets/datatables/dataTables.bootstrap4.min.js"></script>
  <script >
    <?php include 'js/payment.js' ?>
  </script>
</body>

</html>