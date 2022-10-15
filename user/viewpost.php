<?php
require_once 'assets/scripts/data.php';
if (!user()) {
  redirect("login");
}
if (isset($_GET['id'])) {
  $id = clean($_GET['id']);
  $sql = $access->prepare("SELECT post FROM posts WHERE post_id=:id");
  $sql->execute(['id'=>$id]);
  if ($sql->rowCount() >= 1) {
    foreach ($sql as $file) {
      $post = $file["post"];
    }
  }else{
    $post = "Topic has been removed";
  }
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
  <title><?php echo $post; ?></title>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="assets/css/sb-admin-2.css" rel="stylesheet">
  <style type="text/css">
    #postcolor:hover{
      background:grey;
    }
  </style>
</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background:#494263;">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
        <div class="sidebar-brand-text mx-3">RUIMUN</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
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
        <a class="nav-link active" href="payment">
          <i class="fas fa-fw fa-money-bill-alt"></i>
          <span>Payments</span></a>
      </li>

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
          <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-dark"><a href="javascript:void(0);" style="text-decoration:none;color:black;" class="back"><i style="padding-bottom:1px;" class="fas fa-fw fa-arrow-left"></i></a>&nbsp;
                  <button style="font-weight:bold;background:#494263;color:white;" type="button" class="btn btn-sm new" data-toggle="modal" data-target="#postModal"><i class="fas fa-fw fa-share-square"></i>&nbsp;&nbsp;post comment</button>
                <a id="refresh" href="javascript:void(0);" style="text-decoration:none;" class="float-right refresh"><i style="padding-bottom:1px;" class="fas fa-fw fa-sync"></i>&nbsp;Refresh</a>
                </h6>
            </div>
            <div class="card-body">
              <h5 style="font-weight:bold;"><?php echo $post; ?></h5>
              <div class="getcomments"></div>
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>DESIGNED BY <b><a style="color:orange;" target="_blank" href="https://kreateng.com">KREATENG</a></b></span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary btn-sm" href="logout">Logout</a>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="postModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Post comment</h5>
        </div>
        <form id="postForm" method="post">
          <div class="modal-body">
            <div id="info"></div>
            <div class="form-group">
                <label style="font-weight:bold;">Comment</label>
                <textarea required class="form-control" name="content" id="content" rows="5" cols="20"></textarea>
            </div>
            <div class="form-group">
                <input type="hidden" name="post_id" id="post_id" value="<?php echo $id; ?>">
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary btn-sm" id="submit_post">Post</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="assets/bootstrap/jquery.js"></script>
  <script src="assets/bootstrap/bootstrap.bundle.min.js"></script>
  <script src="assets/jquery-easing/jquery.easing.min.js"></script>
  <script src="assets/js/sb-admin-2.min.js"></script>
  <script src="assets/notify/notify.js"></script>
  <script type="text/javascript">
    $(document).ready(function (){
      $(document).on('click', '.new', function(event) {
        $('#postForm')[0].reset();
        $('#info').html("");
        $("#submit_post").prop('disabled', false);
        $("#submit_post").html("Post");
      });
      setInterval(function(){get_comments()} , 300000);
      $(document).on('click', '.back', function(){
       window.location = 'home';
      });
      $(document).on('click', '.refresh', function(){
        $("#refresh").html("getting comments.....");
        get_comments();
        setTimeout(function(){
          $("#refresh").html('<i style="padding-bottom:1px;" class="fas fa-fw fa-sync"></i>&nbsp;Refresh');
        }, 3000);
      });
      get_comments();
      function get_comments(){
        var id = <?php echo json_encode($id); ?>;
        $.ajax({
          url:"assets/scripts/getcomments",
          method:"POST",
          dataType:"html",
          data:{id:id},
          success:function(response){
              $(".getcomments").html("");
              $('.getcomments').html(response);
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
            notify("Network error, cannot get posts at this time, check your connection");
          }
        });
      }
      $(document).on('submit', '#postForm', function(event){
        $("#submit_post").prop('disabled', true);
        $("#submit_post").html('posting....');
        $('#info').html("");
        event.preventDefault();
        $.ajax({
          url:"assets/scripts/postcomment",
          method:"POST",
          data:new FormData(this),
          processData: false,
          contentType: false,
          success:function(response){
            if (response === "1") {
              get_comments();
              $('#postForm')[0].reset();
              $('#postModal').modal('hide');
              notify("Comment posted");
            }else{
              $("#submit_post").prop('disabled', false);
              $("#submit_post").text("Post");
              $('#info').html(response);
            }
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
            $("#submit_post").prop('disabled', false);
            $("#submit_post").html("Create");
            notify("Network error, please check your connection");
          }
        });
      });
    });
  </script>
</body>

</html>
