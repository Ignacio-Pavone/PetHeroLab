<?php
namespace Utils;
use PHPMailer\PHPMailer as PHPMailer;	
use PHPMailer\Exception as Exception;
class Tools {

 public static function sendEmail($shippingAddress, $subject, $body, $attachment = null)
        {
            $mail = new PHPMailer(true);
            try {
                //Server settings
                $mail->SMTPDebug = 0;
                $mail->isSMTP();                     
                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );

                $mail->Host       = 'smtp.gmail.com';           // Enable SMTP authentication
                $mail->SMTPAuth   = true;                       // Send using SMTP
                $mail->Username   = 'ignaciopavone@gmail.com';  // SMTP username
                $mail->Password   = 'qhhjjesfjpwqtgtu';           // SMTP password
                $mail->SMTPSecure = 'tls';                      // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
                $mail->Port       = 587;                        // TCP port to connect to

                //Recipients
                $mail->setFrom('ignaciopavone@gmail.com', 'Movie Pass');
                $mail->addAddress($shippingAddress);

                // Content
                $mail->isHTML(true);                             // Set email format to HTML
                $mail->Subject = $subject;
                $mail->Body    = $body;
                if($attachment!=null){
                    $mail->addAttachment($attachment);
                }

                $mail->send();

            } 
            catch (Exception $e) 
            {
            }   
        }
}
?>