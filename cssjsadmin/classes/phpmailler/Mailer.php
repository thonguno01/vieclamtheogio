<?php
require_once 'PHPMailer.php';
require_once 'Exception.php';
require_once 'SMTP.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
class Mailer{
    public function email($to,$body,$subject)
    {
        $mail = new PHPMailer(true);
        try {
            $mail->CharSet = 'UTF-8';
            $mail->SMTPDebug = SMTP::DEBUG_OFF;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth = true;                                   // Enable SMTP authentication
            $mail->Username = 'tranlong.timviec365@gmail.com';                     // SMTP username
            $mail->Password = 'uadidihdzzrrwdcj';                               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            $mail->setFrom('thanhkudo1o11998@gmail.com', 'Giasu.vn');
            $mail->addAddress("$to");     // Add a recipient

//            $mail->addReplyTo('info@example.com');
//            $mail->addCC('cc@example.com');
//            $mail->addBCC('bcc@example.com');

            //đính kèm file
            //$mail->addAttachment('');         // Add attachments

            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->AltBody = '';
            $mail->send();
            return true;
        } catch (Exception $e) {
            // echo "Không thể gửi tới địa chỉ mail này ! {$mail->ErrorInfo}";
            return false;
        }
    }
}
