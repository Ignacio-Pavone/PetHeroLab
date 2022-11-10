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

    public static function buyaMailBody($guardian, $request, $pet, $owner, $Method, $numeroTarjeta, $finalprice)
    {
        $message = "<body
        style='background-image: url(https://as1.ftcdn.net/v2/jpg/04/24/35/24/1000_F_424352469_WJYlrdisV68nj5yh3MWteLh8qohN7AZU.jpg); background-size:cover; font-family:Consolas;'>
        <table>
            <tbody>
                <tr>
                    
                        <img src='https://cdn.discordapp.com/attachments/855473848869847050/1035570001761022023/Screenshot_4.png'
                        style='width:300px; height:150px; display: block; margin-left:550px;'>
                   
                        <img src='". $pet->getPhotoUrl() ."'
                        style='display: block; border-radius: 200px; width: 200px; margin-left:600px;'>
                </tr>
            </tbody>
        </table>
        <br><br>
        <div style='margin-left:580px;'>
            <table style='height:20px'>
                <tbody>
                    <tr>
                            <h5 style='font-size:16px'> Guardian: ". $guardian->getFullName() ." </h5>
                            <h5 style='font-size:16px'> Email Guardian: ". $guardian->getEmail() ." </h5>
                            <h5 style='font-size:16px'> Mascota: ". $pet->getName() ." </h5>
                            <h5 style='font-size:16px'> Fecha Inicio: ". $request->getInitDate() ." </h5>
                            <h5 style='font-size:16px'> Fecha Fin: ". $request->getFinishDate() ." </h5>
                            <h5 style='font-size:16px'> Dias: ". $request->getDaysAmount() ." </h5>
                            <h5 style='font-size:16px'> Costo Total: $". $finalprice ." </h5>
                            <h5 style='font-size:16px'> Metodo Pago: ".  $Method ." </h5>
                            <h5 style='font-size:16px'> Numero Tarjeta: ".  $numeroTarjeta ." </h5>
                    </tr>
                </tbody>
            </table>
        </div>
        </body>";
        return $message;
    }
}

?>