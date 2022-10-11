<?php
require_once '../../PHPMailer/PHPMailer.php'; ///dependencia para uso de email
require_once '../../PHPMailer/SMTP.php'; ///dependencia para uso de email
require_once '../../PHPMailer/Exception.php'; ///dependencia para uso de emal
use PHPMailer\PHPMailer\PHPMailer; ///dependencia para uso de email

function enviar_email($Subject, $email, $mensaje)
{
    require '../../vendor/autoload.php';
    $mail = new PHPMailer();
    //Tell PHPMailer to use SMTP
    $mail->isSMTP();
    $email_institucional = 'system@sporouscapital.com.do'; // correo para smpt
    $password_institucional = 'kezbjjkdnaskttad'; /// contraseña del smtp
    $nombre_envio_mail_smtp = 'sistema';
    $SMTPAuth_config = true; //conguraciones de seguridad de smtp
    $SMTPAutoTLS_config = true; //conguraciones de seguridad de smtp

    $mail->CharSet = 'UTF-8'; // modificar en conexion
    $mail->Encoding = 'quoted-printable'; // modificar en conexion
    $mail->SMTPDebug = 0; // modificar en conexion
    $mail->Host  = 'smtp.gmail.com'; // modificar en conexion
    $mail->Port = '587'; // modificar en conexion
    $mail->SMTPAuth = $SMTPAuth_config; // modificar en conexion
    $mail->SMTPAutoTLS = $SMTPAutoTLS_config; // modificar en conexion
    $mail->Username = $email_institucional; // modificar en conexion
    $mail->Password = $password_institucional; // modificar en conexion
    $mail->setFrom($email_institucional, $nombre_envio_mail_smtp); // modificar en conexion
    $mail->addReplyTo($email_institucional, $nombre_envio_mail_smtp); // modificar en conexion

    $mail->Subject = $Subject; // envio el subject
    $mail->addAddress($email); // email de quien evia a la red
    $mail->msgHTML($mensaje);
    # code...
    if (!$mail->send()) {
        $informacion =  'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        $informacion = 'Email enviado';
    }
    return $informacion;
};

function get_client_ip_env()
{
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if (getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';

    return $ipaddress;
}

// Function to generate OTP
function generateNumericOTP($n)
{

    // Take a generator string which consist of
    // all numeric digits
    $generator = "1357902468";

    // Iterate for n-times and pick a single character
    // from generator and append it to $result

    // Login for generating a random character from generator
    //     ---generate a random number
    //     ---take modulus of same with length of generator (say i)
    //     ---append the character at place (i) from generator to result

    $result = "";

    for ($i = 1; $i <= $n; $i++) {
        $result .= substr($generator, (rand() % (strlen($generator))), 1);
    }

    // Return result
    return $result;
}
function generarhash($n)
{
    $result = "";
    //generamos un número aleatorio
    $result = bin2hex(random_bytes($n));
    return $result;
}
/**
 * It gets the last code generated for a user, and then disables all the other codes for that user.
 * 
 * Args:
 *   id: The id of the user
 */
function deshabilitar_codigos_anteriores($id)
{
    require '../../assets/db/db.php';

    $sql = "SELECT `id` FROM `codigos_de_restablecimiento` WHERE `id_user` = $id   and `estado`=0 ORDER BY `codigos_de_restablecimiento`.`id`  DESC limit 1";
    $data = mysqli_fetch_array(mysqli_query($conexion, $sql));

    $id_last = $data[0];

    $sql = "UPDATE `codigos_de_restablecimiento` SET `estado` = '1' WHERE `codigos_de_restablecimiento`.`id` != $id_last";
    mysqli_query($conexion, $sql);
}
function validacion_de_inversiones($disponibilidad, $utilizado, $capital_total, $objetivo_capital, $multiplo, $mindeposito, $deposito)
{
    $respuesta_ = array();

    if ($disponibilidad != 0) { //si disponibilidad no es 0 tiene un limite entonces procedo a asegurarme que no este lleno para proceder con la inversion
        if ($utilizado >= $disponibilidad) {
            $repuesta_disponibilidad = 'Falso'; //tiene limite
        } else {
            $repuesta_disponibilidad = 'Verdadero'; // si tiene limite pero aun no llega a ese limite por ende lo dejo pasar
        }
    } else {
        $repuesta_disponibilidad = 'Verdadero'; // se supone que no tiene limite , y no es nesesario verificar si paso o no
    }

    if ($objetivo_capital != 0) { // si el objetivo no es 0, se entiende que se debe verificar si sobrepaso el limite
        if (($capital_total + $deposito) > $objetivo_capital) {
            $repuesta_capital = 'Falso'; // no lo dejo pasar
        } else {
            $repuesta_capital = 'Verdadero'; // si tiene limite pero la suma de el deposito y el total no superan el limite de holders
        }
    } else {
        $repuesta_capital = 'Verdadero';
    }

    //verificacion de multiplo
    if (($deposito % $multiplo) == 0) { // verificio si es multiplo de x numero
        $repuesta_multiplo = 'Verdadero';
    } else {
        $repuesta_multiplo = 'Falso';
    }

    if ($mindeposito <= $deposito) { // verifico que el deposito sea el por arriba del minimo o igual
        $respuesta_min_deposito = 'Verdadero';
    } else {
        $respuesta_min_deposito = 'Falso';
    }

    $respuesta_ = ['limite' => $repuesta_disponibilidad, 'limite_holder' => $repuesta_capital, 'multiplo' => $repuesta_multiplo, 'min_deposito' => $respuesta_min_deposito];
    return   json_encode($respuesta_);
}
