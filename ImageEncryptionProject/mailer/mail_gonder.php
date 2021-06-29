<?php
require("class.phpmailer.php");
$mail = new PHPMailer(); // create a new object
$mail->IsSMTP(); // enable SMTP
$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
$mail->SMTPAuth = true; // authentication enabled
$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
$mail->Host = "smtp.live.com";
$mail->Port = 465; // or 587
$mail->IsHTML(true);
$mail->SetLanguage("tr", "phpmailer/language");
$mail->CharSet  ="utf-8";

$mail->Username = "e-mail"; // Mail adresi
$mail->Password = "password"; // Parola
try {
    $mail->SetFrom("cahmetkaan@hotmail.com", "Deneme");
} catch (phpmailerException $e) {
    echo e;
} // Mail adresi

$mail->AddAddress("e-mail"); // Gönderilecek kişi

$mail->Subject = "Sideden Gönderildi";
$mail->Body = "Bu bir deneme";

if(!$mail->Send()){
                echo "Mailer Error: ".$mail->ErrorInfo;
} else {
                echo "Message has been sent";
}

?>