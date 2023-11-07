<?php

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

require '../Public/src/Exception.php';
require '../Public/src/PHPMailer.php';
require '../Public/src/SMTP.php';

class Emailmanager
{
    public static function sendEmail($address, $subject, $html)
    {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host = 'smtp.strato.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth = true;                                   //Enable SMTP authentication
            $mail->Username = 'student@ictcampus.nl';                     //SMTP username
            $mail->Password = 'N13tSp@mmen';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('student@ictcampus.nl', 'Formula 1 Predict');
            $mail->addAddress($address);     //Add a recipient

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body = $html;
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function verify($userid)
    {
        global $con;
        $stmt = $con->prepare("update users set isVerified = 1 where UserId = ?");
        $stmt->bindValue(1, $userid);
        $stmt->execute();
    }
}
