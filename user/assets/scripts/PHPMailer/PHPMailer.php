<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';
require('vendor/phpmailer/phpmailer/src/PHPMailer.php');
require('vendor/phpmailer/phpmailer/src/SMTP.php');
require('vendor/phpmailer/phpmailer/src/Exception.php');

class Mailing {
public $mail;

//Server settings    
public static $MAIL_HOST = "smtp.gmail.com"; //Set the SMTP server to send through
public static $MAIL_NAME = "ruimun@run.edu.ng"; //SMTP username
public static $MAIL_PASSWORD  = "wqbplawtuslntcsd"; //SMTP password
public static $MAIL_PORT = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

public function initialize(){
    //Create an instance; passing `true` enables exceptions
    $this->mail = new PHPMailer();
    $this->mail->isSMTP(); //Send using SMTP
    $this->mail->Host = Mailing::$MAIL_HOST; //initialize the SMTP server to send through
    $this->mail->Port = Mailing::$MAIL_PORT; //initialize the PORT server to send through
    $this->mail->SMTPAuth = true; //Enable SMTP authentication
    $this->mail->Username = Mailing::$MAIL_NAME; //initialize username
    $this->mail->Password = Mailing::$MAIL_PASSWORD ; //initialize password
    $this->mail->SMTPDebug = 2; //Enable verbose debug output   
    $this->mail->SMTPSecure = 'tls'; //Enable implicit TLS encryption
}
public function reset_mail($name,$email,$code,$token){
    $this->initialize();
    $date = date("Y");
    $sendfrom = "ruimun@run.edu.ng";
    $sendsubject = "Password Reset Code";
    $body = '<body style="margin:0px; font-family:"Arial, Helvetica, sans-serif; font-size:16px;">
                Hi '.$name.', you requested a password reset,
                <p>Click the Reset button and insert the code given to you to reset your password</p>
                <a class="btn btn-lg btn-block btn-login font-weight-bold" 
                href="http://ruimun.org/portal/resetcode?request_from=reset&email='.$email.'&token='.$token.'"
                style="background:#494263;color:white;border-radius:30px;padding:5px 10px;" type="button">
                Reset
                </a>
                <p>Your account reset code is:</p>
                <h4 style="font-weight:bold;">'.$code.'</h4>
                <div>
                    <p>Please note:</p>
                    <p>This code expires after 24 hours.
                    For security purposes, do not disclose the contents of this email
                    </p>
                </div>
                <div>
                    <p>Thank You</p>
                    <p>Copyright © RUIMUN '.$date.'</p>
                </div>
                </body>';
            //Recipients
            $this->mail->isHTML(true);
            $this->mail->Subject = $sendsubject;
            $this->mail->Body = $body;
            $this->mail->setFrom($sendfrom, 'RUIMUN');
            $this->mail->addAddress($email, $name);     //Add a recipient
            if ($this->mail->send()){
                echo "Message is sent";
            }else{
            echo "Message not sent";
            }
    }

public function signup_mail($name,$email,$code,$token){
        $this->initialize();
        $date = date("Y");
        $sendfrom = "ruimun@run.edu.ng";
        $sendsubject = "Account Activation Code";
        $body = '<body style="margin:0px; font-family:"Arial, Helvetica, sans-serif; font-size:16px;">
                    Hi '.$name.', Welcome to the <span style="font-weight:bold;">REDEEMERS UNIVERSITY INTERNATIONAL MODEL UNITED NATIONS</span>,
                    <p>Click the Validate button and insert the code given to you to validate your access</p>
                    <a class="btn btn-lg btn-block btn-login font-weight-bold" 
                    href="http://ruimun.org/portal/validate?request_from=validate&email='.$email.'&token='.$token.'"
                    style="background:#494263;color:white;border-radius:30px;padding:5px 10px;" type="button">
                    Validate Account
                    </a>
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
        //Recipients
        $this->mail->isHTML(true);
        $this->mail->Subject = $sendsubject;
        $this->mail->Body = $body;
        $this->mail->setFrom($sendfrom, 'RUIMUN');
        $this->mail->addAddress($email, $name);
        if ($this->mail->send()){
            echo "Message is sent";
        }else{
        echo "Message not sent";
        }
 }
}