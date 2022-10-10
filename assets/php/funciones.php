<?php
require_once '../../PHPMailer/PHPMailer.php'; ///dependencia para uso de email
require_once '../../PHPMailer/SMTP.php'; ///dependencia para uso de email
require_once '../../PHPMailer/Exception.php'; ///dependencia para uso de emal
use PHPMailer\PHPMailer\PHPMailer; ///dependencia para uso de email

/**
 * Envía un correo electrónico.
 * 
 * Args:
 *   Subject: El asunto del correo electrónico.
 *   email: La dirección de correo electrónico del destinatario.
 *   mensaje: El mensaje a enviar.
 * 
 * Returns:
 *   Error de la aplicación de correo: SMTP connect() falló.
 * https://github.com/PHPMailer/PHPMailer/wiki/Solución de problemas
 */
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

    if (!$mail->send()) {
        $informacion =  'Mailer Error: ' . $mail->ErrorInfo;
        return $informacion;
    }
};

/**
 * Si el usuario está detrás de un proxy, la dirección IP del usuario es la primera dirección IP en el
 * encabezado HTTP_X_FORWARDED_FOR. De lo contrario, la dirección IP del usuario es REMOTE_ADDR.
 * 
 * Returns:
 *   La dirección IP del usuario.
 */
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

/**
 * Genera un número aleatorio entre 0 y la longitud de la cadena del generador, luego usa ese número
 * para elegir un carácter de la cadena del generador.
 * 
 * Args:
 *   n: La duración de la OTP.
 * 
 * Returns:
 *   Un número aleatorio.
 */
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
/**
 * Genera una cadena aleatoria de caracteres hexadecimales.
 * 
 * Args:
 *   n: El número de bytes a generar. Debe ser un entero positivo.
 * 
 * Returns:
 *   Una cadena de caracteres aleatorios.
 */
function generarhash($n)
{
    $result = "";
    //generamos un número aleatorio
    $result = bin2hex(random_bytes($n));
    return $result;
}

/**
 * Deshabilita todos los códigos anteriores excepto el último.
 *
 * Args:
 *   id: La identificación del usuario
 */
/**
 * Deshabilita todos los códigos anteriores excepto el último.
 * La identificación del usuario
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
