<?php
require_once __DIR__ . '/PHPMailer/SMTP.php';
require_once __DIR__ . '/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/Exception.php';

use \PHPMailer\PHPMailer\PHPMailer;

function sendMail($to, $subject, $message)
{
    $mail = new PHPMailer();
    //settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->Username = 'appetiteonline0@gmail.com';
    $mail->Password = 'pexprhuazjfoqofy';

    $mail->setFrom('no_reply@onlineappetite.com', 'OnlineAppetite');

    //recipient
    $mail->addAddress($to);

    //content
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body = $message;
    if (!$mail->Send()) {
        echo 'Message was not sent.';
        echo 'Mailer error: ' . $mail->ErrorInfo;
        return false;
    } else {
        return true;
    }
}
