<?php
//Importing PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Include library files
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

//Creating instances of `true`
$mail = new PHPMailer;

//Server settings
$mail->isSMTP();
$mail->Host = 'localhost';
$mail->SMTPAuth = true;
$mail->Username = 'nnoromiv.nnorom.com';
$mail->Password = 'nnorom';
$mail->SMTPSecure = 'ssl';
$mail->Port = 3306;

//Send Info
$mail->setFrom('nnoromiv@nnorom.com', 'Nnorom');
//Recipient
$mail->addAddress('nnorom.prince44@gmail.com');
//Set mail format to HTML
$mail->isHTML(true);
//Mail Subject
$mail->Subject = 'Email from localhost server';
//Mail body content
$bodyContent ='
    <h1>How Emails could be sent to verify mail</h1>
    <p>This mail has been sent to test and verify via PHP using PHPMailer</p>
';
$mail->Body = $bodyContent;

//Send the mail
if($mail->send()){
    echo 'Message is sent';
}else {
    echo 'Message is not sent';
}
