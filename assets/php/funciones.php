<?php

/* Importación de la biblioteca PHPMailer. */
use PHPMailer\PHPMailer\PHPMailer;

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
    /* Cargando las dependencias para PHPMailer. */
    require(dirname(__FILE__) . '/../../vendor/autoload.php');
    require(dirname(__FILE__) . '/../../PHPMailer/PHPMailer.php'); ///dependencia para uso de email
    require(dirname(__FILE__) . '/../../PHPMailer/SMTP.php'); ///dependencia para uso de email
    require(dirname(__FILE__) . '/../../PHPMailer/Exception.php'); ///dependencia para uso de emal

    $servidor = false;
    $mail = new PHPMailer();
    //Tell PHPMailer to use SMTP
    $mail->isSMTP();
    $email_institucional = 'smartblessingcloud@gmail.com'; // correo para smpt
    $password_institucional = 'fnoqqtypwyjgvltw'; /// contraseña del smtp
    $nombre_envio_mail_smtp = 'SBC';
    $SMTPAuth_config = true; //conguraciones de seguridad de smtp
    $SMTPAutoTLS_config = true; //conguraciones de seguridad de smtp

    $mail->CharSet = 'UTF-8'; // modificar en conexion
    $mail->Encoding = 'quoted-printable'; // modificar en conexion
    $mail->SMTPDebug = 0; // modificar en conexion

    if ($servidor) {
        $mail->Host = 'mail.smartblessingcloud.com'; // modificar en conexion
        $mail->Port = '465'; // modificar en conexion
    } else {
        $mail->Host = 'smtp.gmail.com'; // modificar en conexion
        $mail->Port = '587'; // modificar en conexion
    }

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
        $informacion = 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        $informacion = 'Email enviado';
    }
    return $informacion;
}
;


/**
 * Si el usuario está detrás de un proxy, la función devolverá la dirección IP del proxy; de lo
 * contrario, devolverá la dirección IP del usuario.
 * 
 * Returns:
 *   La dirección IP del usuario.
 */
function get_client_ip_env()
{
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP'); else if (getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR'); else if (getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED'); else if (getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR'); else if (getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED'); else if (getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR'); else
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
 *   n: El número de bytes a generar.
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
function deshabilitar_codigos_anteriores($id)
{
    require '../../assets/db/db.php';

    $sql = "SELECT `id` FROM `codigos_de_restablecimiento` WHERE `id_user` = $id   and `estado`=0 ORDER BY `codigos_de_restablecimiento`.`id`  DESC limit 1";
    $data = mysqli_fetch_array(mysqli_query($conexion, $sql));

    $id_last = $data[0];

    $sql = "UPDATE `codigos_de_restablecimiento` SET `estado` = '1' WHERE `codigos_de_restablecimiento`.`id` != $id_last";
    mysqli_query($conexion, $sql);
}

/**
 * Comprueba si el depósito es válido.
 * 
 * Args:
 *   disponibilidad: La cantidad de dinero que se puede invertir en el plan.
 *   utilizado: la cantidad de dinero que se ha invertido en el plan
 *   capital_total: La cantidad total de dinero que se ha invertido en el plan.
 *   objetivo_capital: La cantidad total de dinero que se puede invertir en el plan.
 *   multiplo: La cantidad de dinero que el usuario puede invertir debe ser un múltiplo de este número.
 *   mindeposito: depósito mínimo
 *   deposito: La cantidad de dinero que el usuario quiere invertir.
 * 
 * Returns:
 *  
 * {"limite":"Verdadero","limite_holder":"Verdadero","multiplo":"Verdadero","min_deposito":"Verdadero"}
 */
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
    return json_encode($respuesta_);
}


/**
 * Cifra los datos utilizando el algoritmo AES-128-ECB.
 * 
 * Args:
 *   dato: Los datos a cifrar.
 * 
 * Returns:
 *  
 * {"datos":"\u0016\u0016\u0016\u0016\u0016\u0016\u0016\u0016\u0016\u0016\u0016\u0016\u0016\u0016\u0016\u0016\u0016\u0016\u
 */
function cifrar($dato)
{        include '../../vendor/autoload.php';
    $dotenv = new Dotenv\Dotenv('../../.');
    $dotenv->load();
    $respuesta_ = array();
  
    $respuesta_ = ['data' => openssl_encrypt($dato, "AES-128-ECB", getenv('key_cifrado'))];

    return json_decode(json_encode($respuesta_));
}

/**
 * Toma 4 parámetros y devuelve una matriz con 2 elementos.
 *
 * Args:
 *   username: El nombre de usuario del usuario.
 *   full_name: "Juan Doe"
 *   email: prueba@prueba.com
 *   password: 123456
 *
 * Returns:
 *   Array
 * (
 *     [status] => 1
 *     [msg] => Registrado exitosamente, confirme su cuenta
 * )
 */

function Registro_usuario($username, $full_name, $email, $password)
{
    $Exception = false;
    $ip_user = get_client_ip_env();
    $respuesta_ = array();
    include '../../assets/db/db.php';
    $info_existencia = consultar_existencia($username, $email);
    $info_existencia = json_decode($info_existencia);

    if ($info_existencia->status === '0') {
        $fecha_registro = date('Y-m-d');
        $password = cifrar($password)->data;
        $sql = "INSERT INTO `usuario`(`nick`, `nombre`, `email`, `contraseña`, `fecha_registro`,`ip_creacion`) VALUES ('$username','$full_name','$email','$password','$fecha_registro','$ip_user')";
        try {
            mysqli_query($conexion, $sql);
        } catch (Exception $e) {
            $Exception = true;
            Auto_report('Excepción capturada: ' . $e->getMessage() . "\n en " . __FILE__ . ' en Linea ' . __LINE__);
        }
        if ($Exception) {
            $respuesta_ = ['status' => false, 'msg' => 'En esto momentos no podemos hacer registro ya enviamos un  reporte al equipo de sistema, intentelo nuevamente en 5 minutos si el problema continua. comunicarse con soporte'];
        } else {

            $info_existencia_sub=consultar_existencia($username, $email);
            $info_existencia_sub = json_decode($info_existencia_sub);
            $respuesta_ = ['status' => true, 'msg' => 'Registrado exitosamente, confirme su cuenta','id_return'=>$info_existencia_sub->id];
            verificar_cuenta($username, $email);
        }
    } else {

        if ($info_existencia->macth_nick == 1) {
            $caso = 'nombre de usuario';
        }
        if ($info_existencia->macth_email == 1) {
            $caso = 'Correo';
        }
        if ($info_existencia->macth_email == 1 && $info_existencia->macth_nick == 1) {
            $caso = "Recuperar";
        }
        $respuesta_ = ['status' => false, 'msg' => $caso];
    }
    return $respuesta_;
}
/**
 * Envía un correo electrónico a la dirección de correo electrónico especificada en la variable .
 * 
 * Args:
 *   Exception: El objeto de excepción
 */
function Auto_report($Exception)
{
    $email = 'elnova205@gmail.com';
    enviar_email('Exception-bug', $email, $Exception);
}

/**
 * Devuelve una matriz codificada en JSON con una clave de estado y una clave sql_data. La clave de
 * estado es 0 o 1. La clave sql_data es una matriz de los resultados de la consulta.
 * 
 * Args:
 *   username: el nombre de usuario del usuario
 *   email: La dirección de correo electrónico del usuario.
 * 
 * Returns:
 *  
 * <code>{"status":"1","sql_data":["1","username","alexander","admin@gmail.com","password","fecha","estado","disponible","maximo","hash_session"}
 */
function consultar_existencia($username, $email)
{
    $username_macht = 0;
    $emai_macht = 0;
    // implementacion de estatus personal si es  0 es que no tiene contenido y si es uno procedo a mostrar la informacion optienida
    /* Incluyendo el archivo `db.php` del directorio `../../assets/db/`. */
    require '../../assets/db/db.php';
    /* Creando una matriz vacía. */
    $respuesta_ = array();
    /* Una consulta SQL que va seleccionando todos los datos de la tabla `usuario` donde la columna
     `nick` es igual al valor de la variable `` o la columna `email` es igual al valor de la
     variable ` `. */
    $sql = "SELECT * FROM `usuario` WHERE `nick`='$username' or `email`='$email'";
    /* Obtener la primera fila del resultado de la consulta. */

    $data_sql = mysqli_fetch_array(mysqli_query($conexion, $sql));

    /* Comprobando si la consulta devolvió algún dato. Si lo hiciera, devolverá los datos en la clave
     `sql_data`. Si no fuera así, devolverá `0` en la clave `status`. */
    if (!is_null($data_sql)) {
        if ($username === $data_sql[1]) {
            $username_macht = 1;
        }
        if ($email === $data_sql[3]) {
            $emai_macht = 1;
        }
        $respuesta_ = ['status' => '1','id'=>$data_sql['id'], 'sql_data' => $data_sql, 'macth_email' => $emai_macht, 'macth_nick' => $username_macht];
    } else {
        $respuesta_ = ['status' => '0', 'macth_email' => $emai_macht, 'macth_nick' => $username_macht];
    }
    /* Devolver una cadena codificada en JSON. */
    return json_encode($respuesta_);
}

/**
 * Toma el nombre de usuario y el correo electrónico del usuario y envía un correo electrónico al
 * usuario con un enlace para activar su cuenta.
 * 
 * Args:
 *   username: El nombre de usuario del usuario.
 *   email: La dirección de correo electrónico del usuario.
 */
function verificar_cuenta($username, $email)
{
    require '../../assets/db/db.php';

    /* la id 3 pertenece a esa plantilla */
    $sql = "SELECT * FROM `plantillas_email` where id=3";
    $data = mysqli_fetch_array(mysqli_query($conexion, $sql));
    $html = $data['estructura'];
    $codigo = generarhash(24);
    $sql = "SELECT * FROM `usuario` WHERE nick='$username'";
    $data = mysqli_fetch_array(mysqli_query($conexion, $sql));
    $id = $data[0];
    $nombre = $data[2];
    insertar_codigo_de_activacion($id, $codigo);

    /* Replacing the values in the array with the values in the database. */
    $palabras_claves = array("@nombre@", "@link@");
    $palabras_claves_changer = array($nombre, 'https://app.smartblessingcloud.com/?verificar=' . $codigo);
    $html = str_replace($palabras_claves, $palabras_claves_changer, $html);
    /* Sending the email. */
    enviar_email('Activar cuenta', $email, $html);
}
/**
 * Inserta una fila en la base de datos.
 * 
 * Args:
 *   id: La identificación del usuario
 *   codigo: El código que se insertará en la base de datos.
 */
function insertar_codigo_de_activacion($id, $codigo)
{
    require '../../assets/db/db.php';
    $sql = "INSERT INTO `codigo_de_activacion`( `id_user`, `hash`) VALUES ($id,'$codigo')";
    try {
        mysqli_query($conexion, $sql);
    } catch (Exception $e) {
        Auto_report('Excepción capturada: ' . $e->getMessage() . "\n en " . __FILE__ . ' en Linea ' . __LINE__);
    }
}
/*
 * Toma una cadena como argumento y devuelve una cadena.
 *
 * Args:
 *   codigo: el código que ingresa el usuario
 *
 * Returns:
 *   La cadena de consulta.
 */
function validar_codigo($codigo)
{
    include(dirname(__FILE__) . '/../../assets/db/db.php');
    $sql = "SELECT * FROM `codigo_de_activacion` WHERE `hash`='$codigo' and estado=0";
    try {
        $retorno = mysqli_fetch_array(mysqli_query($conexion, $sql));
        if (!is_null($retorno)) {
            $id = $retorno['id_user'];
            $sql = "UPDATE `usuario` SET `estado`=1 WHERE `id`=$id;";
            $sql2 = "UPDATE `codigo_de_activacion` SET `estado`=1 WHERE `id_user`=$id";
            try {
                mysqli_query($conexion, $sql);
                mysqli_query($conexion, $sql2);
            } catch (Exception $e) {
                Auto_report('Excepción capturada: ' . $e->getMessage() . "\n en " . __FILE__ . ' en Linea ' . __LINE__);
            }
        } else {
            $retorno = '';
        }
    } catch (Exception $e) {
        Auto_report('Excepción capturada: ' . $e->getMessage() . "\n en " . __FILE__ . ' en Linea ' . __LINE__);
        $retorno = '';
    }
    return $retorno;
}
/**
 * Comprueba si el hash existe en la base de datos y si su estado es 0 (no utilizado).
 * 
 * Args:
 *   hash: El hash que se envió al correo electrónico del usuario.
 * 
 * Returns:
 *   una matriz.
 */
function validar_codigo_restablecimiento($hash)
{
    $retorno = '0';
    include(dirname(__FILE__) . '/../../assets/db/db.php');
    $sql = "SELECT * FROM `codigos_de_restablecimiento` WHERE `hash`='$hash' and `estado`=0;";
    try {
        $retorno = mysqli_fetch_array(mysqli_query($conexion, $sql));
    } catch (Exception $e) {
        Auto_report('Excepción capturada: ' . $e->getMessage() . "\n en " . __FILE__ . ' en Linea ' . __LINE__);
    }
    return ($retorno);
}


/**
 * Genera un hash aleatorio y lo inserta en una tabla de base de datos.
 * 
 * Args:
 *   id_user: La identificación del usuario
 *   intentos: Número de intentos
 */
function generar_link_referencia($id_user,$intentos)
{
    $intentos=$intentos+1;
    include(dirname(__FILE__) . '/../../assets/db/db.php');
    $hash=generarhash(7);
    $sql="INSERT INTO `link_referido`( `enlace_primario`, `hash_para_enlance`) VALUES ($id_user,'$hash')";
   /* Intentando insertar un registro en una base de datos. */
    try {
      mysqli_query($conexion,$sql);
    } catch (\Exception $e) {
        /* Comprobando si la variable  es menor o igual a 3. Si lo es, llamará a la función
        generar_link_referencia() y le pasará las variables  y . Si no es así,
        llamará a la función Auto_report() y le pasará el mensaje de error. */
        if ($intentos<=3) {
           generar_link_referencia($id_user,$intentos);
        }else {
            Auto_report('Excepción capturada: ' . $e->getMessage() . "\n en " . __FILE__ . ' en Linea ' . __LINE__);
        }
    }
    return $hash;
}