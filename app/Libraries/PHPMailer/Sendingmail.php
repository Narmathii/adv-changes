<?php

namespace app\Libraries\PHPMailer;
use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer;
// require("class.phpmailer.php");
class SendingMail
{
   public function send($toEmail, $toName, $subject, $body)
   {
      $mail = new PHPMailer();

      try {
         // Set mailer to use SMTP
         $mail->isSMTP();
         $mail->Host = "ssl://smtp.gmail.com";
         $mail->SMTPAuth = true;
         $mail->Username = "narmathi@appteq.in";
         $mail->Password = "ewmnsvyyahdvmapx";
         $mail->Port = 465;
         $mail->SMTPSecure = 'ssl';  // SSL encryption

         // Sender information
         $mail->setFrom("narmathi@appteq.in", "Test");

         // Recipient information
         $mail->addAddress($toEmail, $toName);

         // Email content
         $mail->isHTML(true);
         $mail->Subject = $subject;
         $mail->Body = $body;


         // Send email
         if (!$mail->send()) {
            return "Mailer Error: " . $mail->ErrorInfo;
         }

         return "Message sent to $toName <$toEmail>";

      } catch (Exception $e) {
         return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
      }
   }
}
