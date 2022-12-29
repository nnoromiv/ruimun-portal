<?php
session_start();
// include('Mail/mail.php');
include('Mail/mime.php');
header("X-XSS-Protection: 1; mode=block");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("X-Frame-Options: SAMEORIGIN");
header("Strict-Transport-Security: max-age=16070400");
header('X-Content-Type-Options: nosniff');
date_default_timezone_set("Africa/Lagos");
$dbhost = '139.59.172.203';
$dbuser = "uxkjjugyaj";
$password = "4ZffQVN3xM";
$dbname = "uxkjjugyaj";

//Localhost Params
$dbhostlocal = 'localhost';
$dbuserlocal = 'root';
$passwordlocal = '';
$dbnamelocal = 'ruimun';

$local = 0;

if($local === 0){
  $connect = new mysqli($dbhost, $dbuser, $password, $dbname);
}else {
  $connect = new mysqli($dbhostlocal, $dbuserlocal, $passwordlocal, $dbnamelocal);
};


if ($local === 0){
  try {
    $access = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $password);
    $access->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
  catch(PDOException $e){
    echo $e->getMessage();
  }
} else {
  try {
    $access = new PDO("mysql:host=$dbhostlocal;dbname=$dbnamelocal", $dbuserlocal, $passwordlocal);
    $access->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
  catch(PDOException $e){
    echo $e->getMessage();
  }
}

define('URL', 'http://localhost/ruimun/');
define('API_SECRET_KEY', 'sk_test_565dcb3ba1046095667f2fac56d712167d6dfa9d'); 

if (isset($_GET['committee'])) {
  global $access;
  $id = $_GET['committee'];
  $row = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM committee WHERE id='$id' LIMIT 1"));
  $countries = explode(",", $row["country"]);
  $var = json_encode($countries);
  $country = json_encode($row["country"]);
  echo $country;
}

function redirect($location){
  return header("Location: {$location}");
}
function tokenGenerator(){
  $token = $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
  return $token;
}
function account_token(){
  $token = bin2hex(openssl_random_pseudo_bytes(15));
  return $token;
}
function user_id_code() {
    $activation_code = rand(1000000,9999999);
    return $activation_code;
}
function user_codes() {
    $activation_code = rand(100000,999999);
    return $activation_code;
}
function clean($string){
  global $connect;
  $string = trim($string);
  $string = stripslashes($string);
  $string = htmlspecialchars($string, ENT_QUOTES);
  $string = filter_var($string, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
  $string = mysqli_real_escape_string($connect, $string);
  return $string;
}
function all(){
  if (isset($_SESSION['userid']) && isset($_SESSION['email']) && isset($_SESSION['type'])) {
    return true;
  }else {
    return false;
  }
}
function user(){
  if (isset($_SESSION['userid']) && isset($_SESSION['email']) && isset($_SESSION['type'])  && $_SESSION['type'] != 'admin') {
    return true;
  }else {
    return false;
  }
}
function admin(){
  if (isset($_SESSION['userid']) && isset($_SESSION['email']) && isset($_SESSION['type']) && $_SESSION['type'] == 'admin') {
    return true;
  }else {
    return false;
  }
}
function get_username(){
  global $connect;
  if (isset($_SESSION['type']) && $_SESSION['type'] != 'admin') {
    $id = clean($_SESSION['userid']);
    $row = mysqli_fetch_array(mysqli_query($connect, "SELECT name FROM enrollment WHERE user_id='$id' LIMIT 1"));
    $name = $row["name"];
  }else{
    $name = "ADMIN";
  }
  return $name;
}
function time_convert($time_convert){
  if ($time_convert == "0000-00-00 00:00:00") {
    return "0000-00-00 00:00:00";
  }else{
    $dateTimeSplit = explode(" ",$time_convert);
    $date = $dateTimeSplit[0];
    $time = $dateTimeSplit[1];
    $gotten = date('M d, Y',strtotime($date));
    $am = date('h:i A', strtotime($time));
    return $gotten." ".$am;
  }
}
function get_date($time_convert){
  $dateTimeSplit = explode(" ",$time_convert);
  $date = $dateTimeSplit[0];
  $time = $dateTimeSplit[1];
  return $date;
}
function message($text){
  $message = '<div class="alert alert-dismissible py-2 alert-warning border-0 fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><span>'.$text.'</span></div>';
  return $message;
}
function date_convert($date){
  $date_convert = date('M d, Y', strtotime($date));
  return $date_convert;
}
function get_members(){
  global $access;
  $statement = $access->prepare("SELECT * FROM enrollment");
  $statement->execute();
  $result = $statement->fetchAll();
  return $statement->rowCount();
}
function get_payments(){
  global $access;
  $statement = $access->prepare("SELECT * FROM payments");
  $statement->execute();
  $result = $statement->fetchAll();
  return $statement->rowCount();
}
function get_posts(){
  global $access;
  $statement = $access->prepare("SELECT * FROM posts");
  $statement->execute();
  $result = $statement->fetchAll();
  return $statement->rowCount();
}
function get_docs(){
  global $access;
  $statement = $access->prepare("SELECT * FROM docs");
  $statement->execute();
  $result = $statement->fetchAll();
  return $statement->rowCount();
}
function upload_doc(){
  if(isset($_FILES["document"])){
    $new_name = $_FILES['document']['name'];
    $destination = $_SERVER['DOCUMENT_ROOT'].'/portal/user/assets/docs/'.$new_name;
    move_uploaded_file($_FILES['document']['tmp_name'], $destination);
    return $new_name;
  }
}
function get_payment($user_id){
  global $access;
  $statement = $access->prepare("SELECT * FROM payments WHERE user_id=:user_id");
  $statement->execute(['user_id'=>$user_id]);
  $result = $statement->fetchAll();
  return $statement->rowCount();
}

function getCommittee(){
  global $access;
  $statement = $access->prepare("SELECT * FROM committee");
  $statement->execute();
  $result = $statement->fetchAll();
  return $result;
}

function getCountries($committee_id){
  global $access;
  $statement = $access->prepare("SELECT * FROM committee WHERE id=:committee_id");
  $statement->execute(['committee_id'=>$committee_id]);
  $result = $statement->fetchAll();
  //$countries = explode(",", $result);
  return $result;
}

function signup_mail($name,$email,$code){
  $date = date("Y");
  $sendto = "$name<$email>";
  $sendfrom = "RUIMUN<payments@ruimun.org>";
  $sendsubject = "Account Activation Code";

  $body = '<body style="margin:0px; font-family:"Arial, Helvetica, sans-serif; font-size:16px;">
              Hi '.$name.', Welcome to the <span style="font-weight:bold;">REDEEMERS UNIVERSITY INTERNATIONAL MODEL UNITED NATIONS</span>,
              <p>Your account activation code is:</p>
              <h4 style="font-weight:bold;">'.$code.'</h4>
              <div>
                <p>Please note:</p>
                <p>For security purposes, do not disclose the contents of this email.</p>
              </div>
              <div>
                <p>Thank You</p>
                <p>Copyright © RUIMUN '.$date.'</p>
              </div>
            </body>';
    // send message to customers
  $message = new Mail_mime();
  $message->setHTMLBody($body);
  $body = $message->get();
  $extraheaders = array("From"=>"$sendfrom", "Subject"=>"$sendsubject");
  $headers = $message->headers($extraheaders);
  $mail = Mail::factory("mail");
      if ($mail->send("$sendto", $headers, $body)) {
        return true;
      }else{
        return false;
      }
}


function reset_mail($name,$email,$code){
  $date = date("Y");
  $sendto = "$name<$email>";
  $sendfrom = "RUIMUN<payments@ruimun.org>";
  $sendsubject = "Password Reset Code";

  $body = '<body style="margin:0px; font-family:"Arial, Helvetica, sans-serif; font-size:16px;">
              Hi '.$name.', you requested a password reset,
              <p>Your account reset code is:</p>
              <h4 style="font-weight:bold;">'.$code.'</h4>
              <div>
                <p>Please note:</p>
                <p>This code expires after 24 hours<br>
                For security purposes, do not disclose the contents of this email
                </p>
              </div>
              <div>
                <p>Thank You</p>
                <p>Copyright © RUIMUN '.$date.'</p>
              </div>
            </body>';
    //send message to customers
  $message = new Mail_mime();
  $message->setHTMLBody($body);
  $body = $message->get();
  $extraheaders = array("From"=>"$sendfrom", "Subject"=>"$sendsubject");
  $headers = $message->headers($extraheaders);
  $mail = Mail::factory("mail");
      if ($mail->send("$sendto", $headers, $body)) {
        return true;
      }else{
        return false;
      }
}
?>