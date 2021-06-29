<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

function sendMail($mailAddr,$code) {
    $mail = new PHPMailer(true);
    $isSuccess=false;
    try {
        //Server settings
        error_reporting(E_ERROR | E_PARSE);
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.live.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'e-mail';                     //SMTP username
        $mail->Password   = 'password';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom('e-mail');
        $mail->addAddress($mailAddr);

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Hello From ImageEncrypter';
        $mail->Body    = 'This is your code to renew your password: '.$code.'. If you did not request this process, please ignore it.';

        $mail->send();
        $isSuccess=true;
    } catch (Exception $e) {
        $isSuccess = false;
    }
    return isSuccess;
}