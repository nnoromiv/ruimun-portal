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
              <input type="text" class="form-control" id="name" name='name'readonly>
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
                <label for="amount"></label>
                <select required class="form-control" id="amount" name="amount">
							  <option value="">Amount</option>
							  <option value="55000" id="amount" name="amount">Nigerian Delegate (₦55,000)</option>
							  <!-- <option value="sec_school">Secondary School Delegate (₦20,000)</option> -->
							  <option value="45000" id="amount" name="amount">Redeemer's University (₦45,000)</option>
							  <!-- <option value="virtual">Virtual Delegate ($10)</option> -->
							  <option value="72000" id="amount" name="amount">International Delegate ($100)</option>
							  </select>
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
                        <p>Name: <span id="my_name"></span></p>
                        <p>Email: <span id="my_email"></span></p>
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
  <script>
    <?php include 'js/members.js' ?>
  </script>
</body>

</html>