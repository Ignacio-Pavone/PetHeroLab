<?php
namespace Utils;
use PHPMailer\PHPMailer as PHPMailer;
use PHPMailer\Exception as Exception;

class Email
{

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

            $mail->Host = 'smtp.gmail.com';           // Enable SMTP authentication
            $mail->SMTPAuth = true;                       // Send using SMTP
            $mail->Username = 'petheroreserve@gmail.com';  // SMTP username
            $mail->Password = 'akzsihofezxrcdyq';           // SMTP password
            $mail->SMTPSecure = 'tls';                      // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
            $mail->Port = 587;                        // TCP port to connect to

            //Recipients
            $mail->setFrom('petheroreserve@gmail.com', 'Pet Hero');
            $mail->addAddress($shippingAddress);

            // Content
            $mail->isHTML(true);                             // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body = $body;
            if ($attachment != null) {
                $mail->addAttachment($attachment);
            }

            $mail->send();

        } catch (Exception $e) {
        }
    }

    public static function sendPassMail($email, $pass)
    {
        $subject = "Pet Hero - Recuperar contrasenia";
        $body = "Su contraseña es: " . $pass;
        self::sendEmail($email, $subject, $body);
    }

    public static function buyaMailBody($guardian, $request, $pet, $owner, $Method)
    {
        $message = "<html>
            <body style='background-color:#fff; background-image:url(https://as1.ftcdn.net/v2/jpg/04/24/35/24/1000_F_424352469_WJYlrdisV68nj5yh3MWteLh8qohN7AZU.jpg); background-size:cover' bgcolor='#fff' >
           
            <table align='center' cellpadding='0' cellspacing='0' font-family: Consolas;border-radius: 80px; background-image: ; background-size: cover' width='650'>
                <tbody>
                    <tr>
                        <td style='font-family: Consolas; font-weight:400;font-size:15px;color:#fff;text-align:center;padding:20px;line-height:25px; ' class=''><center><img src='https://cdn.discordapp.com/attachments/855473848869847050/1035570001761022023/Screenshot_4.png' width='300px' height='150px' style='display: block'></center>
           
            <center><img src='" . $pet->getPhotoUrl() . "' style='display: block; border-radius: 200px' width='200'></center>
            <p style='color: black; font-size: 36px; font-weight: 900; text-align:center' font-family:Consolas;>Reserva</p></td></tr>
            </tbody>
            </table>
           ";
        $message .= "<table align='center' border='0' cellpadding='0' cellspacing='0' style='font-family: Consolas;' width='650'>
                    <tbody>
                        <tr>
                            <td bgcolor='#fff' style='color:#666; text-align:left; font-size:14px;font-family:Consolas; padding:20px 0px 20px 40px; line-height:25px; border-radius:30px 0 0 30px;' valign='middle' width='50%' class=''>                                                
                            <table align='center' border='0' cellpadding='0' cellspacing='0' width='350'>
                                <tbody>
                                    <h4 style= letter-spacing: 1px; font-weight: 700; font-size: 26px; text-align: center; margin: 0; line-height: normal' >Guardian: " . $guardian->getFullName() . "</h4>
                                    <h4 style= letter-spacing: 1px; font-weight: 700; font-size: 26px; text-align: center; margin: 0; line-height: normal' >Email del guardian: " . $guardian->getEmail() . "</h4>
                                    <h4 style= letter-spacing: 1px; font-weight: 700; font-size: 26px; text-align: center; margin: 0; line-height: normal' >Nombre de la mascota: " . $pet->getName() . "</h4>
                                    <h4 style= letter-spacing: 1px; font-weight: 700; font-size: 26px; text-align: center; margin: 0; line-height: normal' >Tipo de mascota: " . $pet->getType() . "</h4>
                                    <h4 style= letter-spacing: 1px; font-weight: 700; font-size: 26px; text-align: center; margin: 0; line-height: normal' >Raza: " . $pet->getBreed() . "</h4>
                                    <h4 style= letter-spacing: 1px; font-weight: 700; font-size: 26px; text-align: center; margin: 0; line-height: normal' >Fecha de inicio: " . $request->getInitDate() . "</h4>
                                    <h4 style= letter-spacing: 1px; font-weight: 700; font-size: 26px; text-align: center; margin: 0; line-height: normal' >Fecha de fin: " . $request->getFinishDate() . "</h4>
                                    <h4 style= letter-spacing: 1px; font-weight: 700; font-size: 26px; text-align: center; margin: 0; line-height: normal' >Dias: " . $request->getDaysAmount() . "</h4>
                                    <h4 style= letter-spacing: 1px; font-weight: 700; font-size: 26px; text-align: center; margin: 0; line-height: normal' >Costo total: $" . $request->getFinalPrice() . "</h4>
                                    <h4 style= letter-spacing: 1px; font-weight: 700; font-size: 26px; text-align: center; margin: 0; line-height: normal' >Modo de Pago: " . $Method . "</h4>                                
                                </tbody>
                            </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
                &nbsp;";
        return $message;
    }
}

?>