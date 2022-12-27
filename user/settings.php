<?php
require_once 'assets/scripts/data.php';
if (!all()) {
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
  <title>Settings</title>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="assets/css/sb-admin-2.css" rel="stylesheet">
  <style>
    <?php include '../css/styles.css' ?>
  </style>
</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background:#494263;">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard">
        <div class="sidebar-brand-text mx-3">RUIMUN</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">
      <?php
        if ($_SESSION['type'] == 'admin'){
          echo '<li class="nav-item">
                  <a class="nav-link" href="dashboard">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="members">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Members</span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="payments">
                    <i class="fas fa-fw fa-money-bill-alt"></i>
                    <span>Payments</span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="posts">
                    <i class="fas fa-fw fa-share-square"></i>
                    <span>Posts</span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="docs">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Materials</span></a>
                </li>';
        }elseif ($_SESSION['type'] == 'school' || $_SESSION['type'] == 'regular' || $_SESSION['type'] == 'foreign') {
          echo '<li class="nav-item">
                  <a class="nav-link" href="home">
                    <i class="fas fa-fw fa-home"></i>
                    <span>Home</span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="materials">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Materials</span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="profile">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Profile</span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="payment">
                    <i class="fas fa-fw fa-money-bill-alt"></i>
                    <span>Payments</span></a>
                </li>';
        }
      ?>
      <!-- Nav Item - Dashboard -->
      

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user"></i>&nbsp;
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo get_username(); ?></span>
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="settings">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Settings
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-5">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold">Change password</h6>
                </div>
                <div class="card-body">
                  <div id="info"></div>
                  <form id="profile" method="post">
                    <div class="form-group">
                      <label style="font-weight:bold;">Current password</label>
                      <input required type="password" name="oldpass" id="oldpass" class="form-control">
                    </div>
                    <div class="form-group">
                      <label style="font-weight:bold;">New password</label>
                      <input required type="password" name="pass" id="pass" class="form-control">
                      <span toggle="#pass" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                    </div>
                    <div class="form-group">
                      <label style="font-weight:bold;">Confirm password</label>
                      <input required type="password" name="cpass" id="cpass" class="form-control">
                    </div>
                    <div class="form-group">
                      <input required type="hidden" name="token" id="token" value="<?php echo tokenGenerator();?>">
                      <button type="submit" id="submit_form" style="background:#494263;color:white;" class="btn btn-md">Save</button>
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
  <script src="assets/notify/notify.js"></script>
  <script>
   <?php include 'js/settings.js' ?>
  </script>
</body>

</html>
