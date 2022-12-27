<?php
require_once 'assets/scripts/data.php';
if (!user()) {
  redirect("login");
}
if($_SESSION['type'] == 'nigerian'){
    $payment = 55000;
    $type = 'Nigerian';
    $paying = $payment;
    $check = '&#8358;';
}elseif ($_SESSION['type'] == 'sec_school') {
    $payment = 20000;
    $type = 'Secondary school';
    $paying = $payment;
    $check = '&#8358;';
}elseif ($_SESSION['type'] == 'RUN') {
    $payment = 45000;
    $type = 'Redeemers University';
    $paying = $payment;
    $check = '&#8358;';
}
elseif ($_SESSION['type'] == 'virtual') {
      $payment = 10;
      $type = 'Online';
      $paying = "10";
      $check = "$";
}
elseif ($_SESSION['type'] == 'foreign') {
      $payment = 150;
      $type = 'Foreign';
      $paying = "150";
      $check = "$";
}
$name = get_username();
$get_name = explode(' ', $name);
$fname = $get_name[0];
$lname = $get_name[1];
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
  <title>Materials</title>
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
          <?php
            $userid = clean($_SESSION['userid']);
            $current = date("Y");
            $statement = "INSERT INTO subscription VALUES( $userid, $current )";
            $sql = mysqli_query($connect, "SELECT year FROM subscription WHERE user_id='$userid'");
            if (mysqli_num_rows($sql) >= 1) {
              echo '<div class="card shadow mb-4">
                          <div class="card-header py-3">
                              <h6 class="m-0 font-weight-bold text-dark">MATERIALS
                              <a id="refresh" href="javascript:void(0);" style="text-decoration:none;" class="float-right refresh"><i style="padding-bottom:1px;" class="fas fa-fw fa-sync"></i>&nbsp;Refresh</a>
                              </h6>
                          </div>
                        <div class="card-body getdocs">
                        </div>
                      </div>';
            }else{
              echo '<div class="row">
                    <div class="col-lg-4">
                      <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-dark"></h6>
                        </div>
                        <div class="card-body">
                          <p>You are a <b style="font-weight:bold;text-transform:uppercase;">'.$type.' DELEGATE</b></p>
                          <button disabled type="button" class="btn btn-md" style="background:#494263;color:white;" onclick="makePayment()">Pay Fee</button>
                          <button type="button" class="btn btn-md" style="background:#494263;color:white;" >   Subscribe</button>
                        </div>
                      </div>
                    </div>
                  </div>';
            }
          ?>
          
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/js-sha512/0.8.0/sha512.min.js"></script>
  <!-- <script src="https://remitademo.net/payment/v1/remita-pay-inline.bundle.js"></script> -->
  <script src=" https://login.remita.net/payment/v1/remita-pay-inline.bundle.js"></script>

  <script>
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

    var merchantId ='4161150426';
    var serviceTypeId ='6026950643';
    var amount = <?php echo $payment ?>;
    var orderId = <?php echo json_encode(rand(10000,99999)) ?>;
    var apiKey ='258341';
    var desc = 'RUIMUM PROJECT';
    var email = <?php echo json_encode($_SESSION["email"]); ?>;
    var toHash = merchantId+serviceTypeId+orderId+amount+apiKey;
    var apiHash = sha512(toHash);

    var settings = {
        "url": "https://login.remita.net/remita/exapp/api/v1/send/api/echannelsvc/merchant/api/paymentinit",
        "method": "POST",
        "timeout": 0,
        "headers": {
            "Content-Type": "application/json",
            "Authorization": "remitaConsumerKey="+merchantId+",remitaConsumerToken="+apiHash
        },
        "data": JSON.stringify({
            "serviceTypeId": serviceTypeId,
            "amount": amount,
            "orderId": orderId,
            "payerName": "<?php echo ($fname." ".$lname); ?>",
            "payerEmail": "<?php echo ($_SESSION["email"]); ?>",
            "payerPhone": "<?php echo ($_SESSION["phnNumber"]); ?>",
            "description": desc
        }),
    };

    function postpayment(email,id,trans_id,ref_code,amount) {
      var token = <?php echo json_encode(tokenGenerator()); ?>;
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var data = JSON.parse(this.responseText);
          if (data.success) {
            alert("Registration fee payment is successfull");
            setTimeout(function(){location.href="materials"} , 2500);
          }else if (data.error) {
            notify(data.error_msg);
          }
        }
      };
      xmlhttp.open("POST", "postpayment", true);
      xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xmlhttp.send('trans_id='+trans_id+'&ref_code='+ref_code+'&amount='+amount+'&email='+email+'&id='+id+'&token='+token);
    }
    function makePayment() {
        $.ajax(settings).done(function (res) {              
          //console.log(res);
          var obj= res.substring(7,res.length-1);
          //console.log(obj);
          var objJson = JSON.parse(obj);
          //console.log(objJson.RRR);
            rrr = objJson.RRR;

            var paymentEngine = RmPaymentEngine.init({
                key: 'QzAwMDAxNTY4NzN8OTU3M3w1OWUwZmVmMmUxYWYwZTlhMjk3MTU5MzIwNzcxNjc1NWYwYmI5ZWNkZWYyYzcwYWZiZGIwOGZkYmViYzhiYjI3MTkyYzA3MGRhOWZkZDgxNDhlMjdjNmVkMGI0ZjgwYjQ4ZDM1OTkwMzhmNzU4OTJmN2NjMTUxMTljZDY1NjA1NQ==',
                customerId: <?php echo json_encode($_SESSION["userid"]); ?>,
                firstName: <?php echo json_encode(ucfirst($fname)); ?>,
                lastName: <?php echo json_encode(ucfirst($lname)); ?>,
                email: <?php echo json_encode($_SESSION["email"]); ?>,
                narration: <?php echo json_encode("RUIMUN ".strtoupper($type)." DELEGATE FEE"); ?>,
                amount: <?php echo $payment; ?>,
                processRrr: true,
                extendedData: {
                customFields: [
                    {
                    name: "rrr",
                    value: rrr,
                    },
                ],
                },
                onSuccess: function (response) {
                postpayment(<?php echo json_encode($_SESSION["email"]); ?>,<?php echo json_encode($_SESSION["userid"]); ?>,response.transactionId,response.paymentReference,response.amount);
                },
                onError: function (response) {
                notify("Payment cannot be processed, try again later");
                },
                onClose: function () {
                notify("Payment portal closed");
                }
            });
            paymentEngine.showPaymentWidget();
        });
    }
  </script>
  <script>
  <?php include 'js/materials.js' ?>
  </script>
</body>

</html>
