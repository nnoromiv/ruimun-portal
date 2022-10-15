
<?php

//######################################################### ***** MAIL CONFIG TO CUSTOMER START ************************ #################################################

// mail function config to Customers


$fullpath = preg_replace("/register.php/","",$fullpath);
$fullpath = str_replace("/post", "", $fullpath);

$hash = "token=$token&phone=$phone";
$parameters=base64_encode($hash);
$visitpath = $fullpath . "index.php?url=activate&hash=$parameters"; 
$visitpathmail = $fullpath . "post/validate.php?hash=$parameters"; 

$fullname="$firstname $lastname";

//config mail to user
$email = "abonayodeji@gmail.com";

$sendto = "Abon ayodeji<$email>";
$sendfrom = "RUIMUN<sender@motocare.com.ng>";
$sendsubject = "Your Account Activation Token";

//echo "$sendto, $sendfrom";  

//Message settings
$msg = "<table width=592 height=227 cellspacing=0 border=0 cellpadding=0 style='color:#000000;padding:5;font:13 verdana;padding-left:5'><tr><td> \r\n";
$msg .= "Welcome $Friend_Name, <br><br>  \r\n";
$msg .= "Your ICOBA account has been created successfully. Please use Token: $token for account activation by clicking below link <a href=$visitpath>clickhere</a> or <a href=$visitpathmail>clickhere</a> to verify and activate your account.<br><br>  \r\n";
$msg .= "<br><br>  \r\n";
$msg .= "Thank you.<br><br>Kind Regards.<br><br><b></b><br>ICOBA Database Team<br>$appsupportdept,<br>$appname, $appaddress<br>$appcontact<br>e:<a href=mailto:webmaster@$appdomainname>webmaster@$appdomainname</a><br>w:<a href=www.$appdomainname>www.$appdomainname</a> \r\n";
$msg .= "</td></tr></table>\r\n\n\n";


//add message body
$bodyofemail = "$msg";
// don't need to edit below this section



// Mail the file
include('Mail.php');
include('Mail/mime.php');

//send message to customers
$message = new Mail_mime();
$text = "$bodyofemail";
//$message->setTXTBody($text); plain text body
$message->setHTMLBody($text);   //html body
$body = $message->get();
$extraheaders = array("From"=>"$sendfrom", "Subject"=>"$sendsubject");
$headers = $message->headers($extraheaders);
$mail = Mail::factory("mail");
if ($mail->send("$sendto", $headers, $body)) {
	echo "yes";
}else{
	echo "no";
}

//######################################################### ***** MAIL CONFIG TO CUSTOMER END ************************ #################################################


?>