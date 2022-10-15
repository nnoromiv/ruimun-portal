<?php
require_once 'assets/scripts/data.php';
if (!admin()) {
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
  <title>Members</title>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="assets/css/sb-admin-2.css" rel="stylesheet">
  <link href="assets/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <style>
    .invalid {
      color:#ff0000;
    }
  </style>

</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background:#494263;">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
        <div class="sidebar-brand-text mx-3">RUIMUN ADMIN</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item ">
        <a class="nav-link" href="dashboard">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>
      <li class="nav-item active">
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
          <h1 class="h3 mb-2 text-gray-800">Registered members</h1>
          <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-dark"><a id="refresh" href="javascript:void(0);" style="text-decoration:none;" class="float-right refresh"><i style="padding-bottom:1px;" class="fas fa-fw fa-sync"></i>&nbsp;Refresh</a></h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead class="thead-light">
                    <tr>
                      <th>USERID</th>
                      <th>NAME</th>
                      <th>EMAIL</th>
                      <th>PHONE</th>
                      <th>TYPE</th>
                      <th>STATUS</th>
                      <th>ACCOUNT</th>
                      <th>DATE CREATED</th>
                      <th>Action</th>
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

  <!-- Payment Modal-->
  <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="paymentModalLabel">Activate Payment</h5>
            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">Enter amount paid by delegate</div>
        <div class="container">
          <form method="POST" id="formActivatePayment">
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" class="form-control" id="name" readonly>
              <input type="hidden" class="form-control" name="userid" id="userid">
              <input type="hidden" class="form-control" name="paytype" id="paytype">
            </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" class="form-control" id="email" name="email" readonly>
            </div>
            <div class="form-group">
                <label for="trans_id">Teller/Transaction ID</label>
                <input type="text" class="form-control" id="trans_id" name="trans_id" required>
            </div>
            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="tel" class="form-control" id="amount" name="amount" required>
            </div>
            <div class="modal-footer">
              <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Cancel</button>
              <button id="btnActivatePayment" class="btn btn-primary btn-sm" type="submit">Submit</button>
            </div>
          </form>
      </div>
      </div>
    </div>
  </div>

    <!-- View Details Modal -->
    <div class="modal fade" id="viewdetailsModal" tabindex="-1" aria-labelledby="viewdetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="viewdetailsModalLabel"><span id="member_details"></span> details</h5>
            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                      <div class="col">
                        <p>Name: <span id="name"></span></p>
                        <p>Email: <span id="email"></span></p>
                        <p>Phone: <span id="phone"></span></p>
                        <p>Member Type: <span id="type"></span></p>
                        <p>Gender: <span id="gender"></span></p>
                        <p>Medical Issue: <span id="medical"></span></p>
                        <p>Committee 1: <span id="committee1"></span></p>
                        <p>Country 1: <span id="country1"></span></p>
                      </div>
                      <div class="col">
                        <p>MUN Experience: <span id="experience"></span></p>
                        <p>Affiliation: <span id="affiliation"></span></p>
                        <p>Position: <span id="position"></span></p>
                        <p>Matric no: <span id="matric"></span></p>
                        <p>Department: <span id="dept"></span></p>
                        <p>Referral: <span id="referral"></span></p>
                        <p>Committee 2: <span id="committee2"></span></p>
                        <p>Country 2: <span id="country2"></span></p>
                      </div>
                      <div class="col">
                        <p>City: <span id="city"></span></p>
                        <p>State: <span id="state"></span></p>
                        <p>Country: <span id="country"></span></p>
                        <p>Tshirt Size: <span id="shirt"></span></p>
                        <p>Diet Issue: <span id="diet"></span></p>
                        <p>Committee 3: <span id="committee3"></span></p>
                        <p>Country 3: <span id="country3"></span></p>
                      </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
        </div>
    </div>

  <script src="assets/bootstrap/jquery.js"></script>
  <script src="assets/bootstrap/bootstrap.bundle.min.js"></script>
  <script src="assets/jquery-easing/jquery.easing.min.js"></script>
  <script src="assets/js/sb-admin-2.min.js"></script>
  <script src="assets/js/validation.min.js"></script>
  <script src="assets/datatables/jquery.dataTables.min.js"></script>
  <script src="assets/notify/notify.js"></script>
  <script src="assets/datatables/dataTables.bootstrap4.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      var dataTable = $('#dataTable').DataTable({
        "processing":true,
        "serverSide":true,
        "order":[],
        "ajax":{
          url:"assets/scripts/members",
          type:"POST"
        },
        "columnDefs":[
          {
            "targets":[0, 1, 2, 3, 4, 5, 6, 7],
            "orderable":false,
          },
        ],
      });

        $("#dataTable").on("click", ".viewMember", function () {
            $("#viewdetailsModal").modal("show");           
            $("#member_details").html($(this).data('name'))
            $("#name").html($(this).data('name'))
            $("#email").html($(this).data('email'))
            $("#phone").html($(this).data('phone'))
            $("#type").html($(this).data('type'))
            $("#gender").html($(this).data('gender'))
            $("#medical").html($(this).data('medical'))
            $("#experience").html($(this).data('experience'))
            $("#affiliation").html($(this).data('affiliation'))
            $("#position").html($(this).data('position'))
            $("#matric").html($(this).data('matric'))
            $("#dept").html($(this).data('dept'))
            $("#referral").html($(this).data('referral'))
            $("#city").html($(this).data('city'))
            $("#state").html($(this).data('state'))
            $("#country").html($(this).data('country'))
            $("#shirt").html($(this).data('shirt'))
            $("#diet").html($(this).data('diet'))
            $("#committee1").html($(this).data('committee1'))
            $("#committee2").html($(this).data('committee2'))
            $("#committee3").html($(this).data('committee3'))
            $("#country1").html($(this).data('country1'))
            $("#country2").html($(this).data('country2'))
            $("#country3").html($(this).data('country3'))            
        })

        $("#dataTable").on("click", ".payment", function () {
            $("#paymentModal").modal("show");   
            $("#name").val($(this).data('name'))            
            $("#email").val($(this).data('email'))
            $("#paytype").val($(this).data('type'))
            $("#userid").val($(this).attr('id')) 
            $("#btnActivatePayment").click(function () {
              $("#formActivatePayment").validate({
                  submitHandler: submitformActivatePayment,
                  errorClass: "invalid",
              });

              function submitformActivatePayment(e) {
                  var formData = $("#formActivatePayment").serialize();
                  $.ajax({
                      type: "POST",
                      url: "assets/scripts/activatePayment",
                      data: formData,
                      dataType: "json",
                      beforeSend: function () {
                          $("#btnActivatePayment").html(
                              '<i class="fa fa-spinner fa-spin"></i>'
                          );
                      },
                      success: function (response) {
                          console.log(response);
                          if (response == "1") {
                            $("#btnActivatePayment").html("Submit");
                            notify("Payment Activated");
                          }
                          else{
                            notify(response);
                            $("#btnActivatePayment").html("Submit");
                          }
                      },
                      error: function (response) {
                          console.log(response);
                          $("#btnActivatePayment").html("Submit");
                          notify(response.responseText);
                      },
                  });
              }
            })
          })


      $(document).on('click', '.refresh', function(){
        $("#refresh").html("refreshing.....");
        dataTable.ajax.reload();
        setTimeout(function(){
          $("#refresh").html('<i style="padding-bottom:1px;" class="fas fa-fw fa-sync"></i>&nbsp;Refresh');
        }, 3000);
      });
      function notify(notify){
          $.notifyDefaults({
          type: 'info',
          allow_dismiss: false,
          delay:2000
        });
        $.notify(notify, {
          animate: {
            enter: 'animated fadeInRight',
            exit: 'animated fadeOutRight'
          },
          onShow: function() {
            this.css({'width':'auto','height':'auto'});
          }
        });
      }
      $(document).on('click', '.active0', function(){
        var id = $(this).attr('id');
        var type = 0;
        if (confirm("De-active member account")) {
          $.ajax({
            url:"assets/scripts/active",
            method:"POST",
            data:{id:id,type:type},
            success:function(response){
              if (response === "1") {
                notify("Member account de-activated");
                dataTable.ajax.reload();
              }else{
                notify(response);
              }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
               notify("Network error, please check your connection");
            }
          });
        }else{
          return false;
        }
      });
      $(document).on('click', '.active1', function(){
        var id = $(this).attr('id');
        var type = 1;
        if (confirm("Activate member account")) {
          $.ajax({
            url:"assets/scripts/active",
            method:"POST",
            data:{id:id,type:type},
            success:function(response){
              if (response === "1") {
                notify("Member account activated");
                dataTable.ajax.reload();
              }else{
                notify(response);
              }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
               notify("Network error, please check your connection");
            }
          });
        }else{
          return false;
        }
      });
      
    });
  </script>
</body>

</html>