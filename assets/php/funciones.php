<?php
/*
 ███████████████████████████
 ███████▀▀▀░░░░░░░▀▀▀███████
 ████▀░░░░░░░░░░░░░░░░░▀████
 ███│░░░░░░░░░░░░░░░░░░░│███
 ██▌│░░░░░░░░░░░░░░░░░░░│▐██
 ██░└┐░░░░░░░░░░░░░░░░░┌┘░██
 ██░░└┐░░░░░░░░░░░░░░░┌┘░░██
 ██░░┌┘▄▄▄▄▄░░░░░▄▄▄▄▄└┐░░██
 ██▌░│██████▌░░░▐██████│░▐██
 ███░│▐███▀▀░░▄░░▀▀███▌│░███             THE FUNCTION 0.3
 ██▀─┘░░░░░░░▐█▌░░░░░░░└─▀██
 ██▄░░░▄▄▄▓░░▀█▀░░▓▄▄▄░░░▄██
 ████▄─┘██▌░░░░░░░▐██└─▄████
 █████░░▐█─┬┬┬┬┬┬┬─█▌░░█████
 ████▌░░░▀┬┼┼┼┼┼┼┼┬▀░░░▐████
 █████▄░░░└┴┴┴┴┴┴┴┘░░░▄█████
 ███████▄░░░░░░░░░░░▄███████
 ██████████▄▄▄▄▄▄▄██████████
 ███████████████████████████
 */

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
    $email_institucional = 'x@gmail.com'; // correo para smpt
    $password_institucional = 'x'; /// contraseña del smtp
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
};

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
{
    include '../../vendor/autoload.php';
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

            $info_existencia_sub = consultar_existencia($username, $email);
            $info_existencia_sub = json_decode($info_existencia_sub);
            $respuesta_ = ['status' => true, 'msg' => 'Registrado exitosamente, confirme su cuenta', 'id_return' => $info_existencia_sub->id];
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
        $respuesta_ = ['status' => '1', 'id' => $data_sql['id'], 'sql_data' => $data_sql, 'macth_email' => $emai_macht, 'macth_nick' => $username_macht];
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
                $retorno = 'Validación completada';
            } catch (Exception $e) {
                Auto_report('Excepción capturada: ' . $e->getMessage() . "\n en " . __FILE__ . ' en Linea ' . __LINE__);
            }
        } else {
            $retorno = 'Enlace invalido';
        }
    } catch (Exception $e) {
        Auto_report('Excepción capturada: ' . $e->getMessage() . "\n en " . __FILE__ . ' en Linea ' . __LINE__);
        $retorno = 'Enlace invalido';
    }
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
    return (json_encode($retorno));
}
/**
 * Comprueba si el código es válido y si lo es, actualiza la contraseña.
 * 
 * Args:
 *   hash: El hash que se envió al correo electrónico del usuario.
 *   codigo: El código que se envió al correo electrónico del usuario.
 *   new_password: La nueva contraseña que el usuario quiere cambiar.
 * 
 * Returns:
 *   un objeto JSON con la siguiente estructura:
 * {
 *     "estado": cierto,
 *     "msg": "Contraseña cambiada."
 * }
 */
try {
    //code...

    function restablecer_contraseña($hash, $codigo, $new_password)
    {
        $repuesta = array();
        /* Incluyendo el archivo de la base de datos. */
        include(dirname(__FILE__) . '/../../assets/db/db.php');
        /* Cifrado de la contraseña. */
        /* Validando el código que se envió al correo electrónico del usuario. */
        $informacion = validar_codigo_restablecimiento($hash);
        /* Comprobando si el código es el mismo que el código en la base de datos. */
        $informacion = json_decode($informacion);
        if (is_null($informacion)) {
            $intentos = 4;
        } else {
            $intentos = $informacion->intento;
        }
        /* Comprobando si el código es válido y si lo es, actualizará la contraseña. */
        if ($intentos <= 3) {
            if ($informacion->code === $codigo) {
                $new_password = cifrar($new_password)->data;
                $id_user = $informacion->id_user;
                $repuesta = ['status' => true, 'msg' => 'Contraseña cambiada.'];
                $update = "UPDATE `usuario` SET `contraseña`='$new_password' WHERE `id`='$id_user'";
                $sql = "UPDATE `codigos_de_restablecimiento` SET `estado`=1 WHERE `hash`='$hash'";
                try {
                    mysqli_query($conexion, $update);
                    mysqli_query($conexion, $sql);
                } catch (\Exception $e) {
                    /* Detectar la excepción y enviar un correo electrónico al administrador. */
                    $repuesta = ('Excepción capturada: ' . $e->getMessage() . "\n en " . __FILE__ . ' en Linea ' . __LINE__);
                }
            } else {
                /* Actualización de la base de datos con el nuevo valor de la variable . */
                $intentos = $intentos + 1;
                $sql = "UPDATE `codigos_de_restablecimiento` SET `intento`=$intentos WHERE `hash`='$hash'";
                $repuesta = ['status' => false, 'msg' => 'El código no, es válido.'];
                mysqli_query($conexion, $sql);
            }
        } else {
            $sql = "UPDATE `codigos_de_restablecimiento` SET `estado`=1 WHERE `hash`='$hash'";
            mysqli_query($conexion, $sql);
            $repuesta = ['status' => false, 'msg' => 'Alcanzaste tu límite de intentos.'];
        }
        /* Devolviendo el valor de la variable  en formato JSON. */
        return json_encode($repuesta);
    }
} catch (\Exception $e) {
    print('Excepción capturada: ' . $e->getMessage() . "\n en " . __FILE__ . ' en Linea ' . __LINE__);
}
/** funiones para el uso de bonificacion esto es jodidamente largo */
/**
 * Genera un hash aleatorio y lo inserta en una tabla de base de datos.
 *
 * Args:
 *   id_user: La identificación del usuario
 *   intentos: Número de intentos
 */
function generar_link_referencia($id_user, $intentos)
{
    $intentos = $intentos + 1;
    include(dirname(__FILE__) . '/../../assets/db/db.php');
    $hash = generarhash(7);
    $sql = "INSERT INTO `link_referido`( `enlace_primario`, `hash_para_enlance`) VALUES ($id_user,'$hash')";
    /* Intentando insertar un registro en una base de datos. */
    try {
        mysqli_query($conexion, $sql);
    } catch (\Exception $e) {
        /* Comprobando si la variable  es menor o igual a 3. Si lo es, llamará a la función
         generar_link_referencia() y le pasará las variables  y . Si no es así,
         llamará a la función Auto_report() y le pasará el mensaje de error. */
        if ($intentos <= 3) {
            generar_link_referencia($id_user, $intentos);
        } else {
            /* Detectar la excepción y enviar un correo electrónico al desarrollador. */
            Auto_report('Excepción capturada: ' . $e->getMessage() . "\n en " . __FILE__ . ' en Linea ' . __LINE__);
        }
    }
    return $hash;
}
/**
 * Toma una ID de usuario y un hash, y si el hash existe en la base de datos, inserta la ID de usuario
 * y el hash en otra tabla
 * 
 * Args:
 *   id_user: La identificación del usuario
 *   hash: El hash del enlace en el que el usuario hizo clic.
 * 
 * Returns:
 *   una matriz con una clave de estado y un valor de verdadero o falso.
 */

function certificar_link_referencia($id_user, $hash)
{
    $respuesta_ = array();
    include(dirname(__FILE__) . '/../../assets/db/db.php');
    $sql = "SELECT * FROM `link_referido` WHERE `hash_para_enlance`='$hash'";
    $data_sql = mysqli_fetch_array(mysqli_query($conexion, $sql));
    /* Comprobando si data_sql no es nulo. */
    if (!is_null($data_sql)) {
        /* Intentando conectarse a la base de datos. */

        $sql = "INSERT INTO `auxiliar_enlace`(`id_user`, `hash_para_enlance`) VALUES ($id_user,'$hash')";
        mysqli_query($conexion, $sql);
        $respuesta_ = ['status' => true];
        // mas tarde talves pongamos un sistema de mensaje, osea ya esta
    } else {
        $respuesta_ = ['status' => false];
    }
    return $respuesta_;
}
/**
 * Cuenta el número de referencias de cada cliente y actualiza la base de datos.
 */
/**
 * Si el usuario tiene un contrato, establezca el campo `invirtiendo` del usuario en 1, de lo
 * contrario, configúrelo en 0.
 */
function certificar_auxiliar_enlace()
{
    include(dirname(__FILE__) . '/../../assets/db/db.php');
    $sql = "SELECT `id_user` FROM `auxiliar_enlace` WHERE 1";
    $query = mysqli_query($conexion, $sql);
    while ($sql_data = mysqli_fetch_array($query)) {
        $verficando = "SELECT COUNT(*),id_user FROM `contractos` WHERE `id_user`=$sql_data[0]";
        $data_verificacion = mysqli_fetch_array(mysqli_query($conexion, $verficando));
        if ($data_verificacion[0] > 0) {
            $sql_update = "UPDATE `auxiliar_enlace` SET `invirtiendo` = 1 WHERE id_user=$data_verificacion[1]";
        } else {
            $sql_update = "UPDATE `auxiliar_enlace` SET `invirtiendo` = 0 WHERE id_user=$sql_data[0] ";
        }
        mysqli_query($conexion, $sql_update);
    }
}
/**
 * Para cada fila de la tabla link_referido, verifique si el usuario ha cumplido con los requisitos
 * para el siguiente nivel, y si es así, actualice la columna nivel_actual al siguiente nivel, de lo
 * contrario, déjelo como está.
 */
function verificar_nivel_personal()
{
    include(dirname(__FILE__) . '/../../assets/db/db.php');
    $maximo_nivel = "SELECT MAX(`nivel`) FROM `condiciones_de_niveles` WHERE 1";
    $maximo_nivel = mysqli_fetch_array(mysqli_query($conexion, $maximo_nivel));
    $nivel_max = $maximo_nivel[0];
    $sql = "SELECT * FROM `link_referido`";
    $query = mysqli_query($conexion, $sql);
    while ($data = mysqli_fetch_array($query)) {
        $nivel_actual = $data['nivel_actual'];

        if ($nivel_max !== $nivel_actual) {
            $verificar = $nivel_actual + 1;
        } else {
            $verificar = $nivel_max;
        }
        $sql_condicones = "SELECT * FROM `condiciones_de_niveles` where nivel=$verificar";
        $query_verificar = mysqli_query($conexion, $sql_condicones);
        $condiciones = mysqli_fetch_array($query_verificar);
        if ($condiciones['cantidad_usuario'] <= $data['cantidad_referidos'] && $condiciones['cantidad_dinero'] <= $data['dinero_activo']) {
            $update = "UPDATE `link_referido` SET `nivel_actual`=$verificar WHERE `id`=$data[0]";
        } else {
            $update = "UPDATE `link_referido` SET `nivel_actual`=$verificar-1 WHERE `id`=$data[0]";
        }
        mysqli_query($conexion, $update);
    }
}

/**
 * Actualiza la base de datos con el número de referidos y la cantidad de dinero que ha invertido el
 * referido.
 */
function Contar_referidos_del_cliente()
{
    include(dirname(__FILE__) . '/../../assets/db/db.php');
    $sql = "SELECT hash_para_enlance,SUM(contractos.cantidad) as dinero FROM auxiliar_enlace INNER JOIN contractos on contractos.id_user = auxiliar_enlace.id_user WHERE 1 and contractos.estado=1 and invirtiendo=1 GROUP by auxiliar_enlace.hash_para_enlance";
    $query = mysqli_query($conexion, $sql);
    while ($sql_data = mysqli_fetch_array($query)) {
        $sql_update = "UPDATE `link_referido` SET  dinero_activo=$sql_data[1] WHERE `hash_para_enlance`='$sql_data[0]'";
        mysqli_query($conexion, $sql_update);
    }
    /* Contar el número de veces que aparece un hash_para_enlance en la tabla auxiliar_enlace. */
    $sql = "SELECT hash_para_enlance,count(*) FROM `auxiliar_enlace` WHERE 1 and invirtiendo=1 GROUP BY `hash_para_enlance`";
    $query = mysqli_query($conexion, $sql);
    while ($sql_data = mysqli_fetch_array($query)) {
        $sql_update = "UPDATE `link_referido` SET  cantidad_referidos=$sql_data[1] WHERE `hash_para_enlance`='$sql_data[0]'";
        mysqli_query($conexion, $sql_update);
    }
}
function check_if_you_are_invited()
{
    include(dirname(__FILE__) . '/../../assets/db/db.php');
    $sql = "SELECT enlace_primario FROM `link_referido` where 1";
    $query = mysqli_query($conexion, $sql);
    while ($data = mysqli_fetch_array($query)) {
        $id = $data[0];
        $sql_certificador = "SELECT * FROM `auxiliar_enlace` where `id_user` = $id";
        $data2 = mysqli_fetch_array(mysqli_query($conexion, $sql_certificador));
        if (is_null($data2)) {
            $valor = 0;
        } else {
            $valor = 1;
        }
        $update = "UPDATE `link_referido` SET `invitado`=$valor WHERE `enlace_primario`=$id";
        mysqli_query($conexion, $update);
    }
}
/**
 * Si el usuario no está invitado, actualice la base de datos para indicar que el usuario ha recibido
 * su bono.
 */
function bonificacion()
{
    include(dirname(__FILE__) . '/../../assets/db/db.php');



    $sql_contratos = "SELECT * FROM `contractos` WHERE 1 and `rendimiento_entregado`=0;";
    $query = mysqli_query($conexion, $sql_contratos);
    while ($contratos_info = mysqli_fetch_array($query)) {
        // en caso de que invertir sin ser invitado skip a este paso
        $sql_search = "SELECT `hash_para_enlance` FROM `auxiliar_enlace` WHERE `id_user`=$contratos_info[1]";
        $data_hash = mysqli_fetch_array(mysqli_query($conexion, $sql_search));
        if (!is_null($data_hash)) {

            $sql_link = "SELECT * FROM `link_referido` WHERE `hash_para_enlance`='$data_hash[0]'";
            $data_link = mysqli_fetch_array(mysqli_query($conexion, $sql_link));
            Pagar_referencia($data_link[1], $contratos_info['cantidad'], $contratos_info['num_contrato'], $contratos_info['hash'], 1);
            if ($data_link['invitado'] == 1) {
                $sql_search = "SELECT `hash_para_enlance` FROM `auxiliar_enlace` WHERE `id_user`=$data_link[1]";
                $data_hash = mysqli_fetch_array(mysqli_query($conexion, $sql_search));

                $sql_link = "SELECT * FROM `link_referido` WHERE `hash_para_enlance`='$data_hash[0]'";
                $data_link = mysqli_fetch_array(mysqli_query($conexion, $sql_link));
                Wizard_level($data_link[1], 2, $contratos_info['hash']);
            }
        } else {
            $update = "UPDATE `contractos` SET `rendimiento_entregado`=1 WHERE `id`=$contratos_info[0]";
            mysqli_query($conexion, $update);
        }
    }
}

function Wizard_level($usuario_receptor, $nivel, $hash_para_enlance)
{
    include(dirname(__FILE__) . '/../../assets/db/db.php');
    $SQL = "SELECT `hash_para_enlance`,contractos.* FROM `auxiliar_enlace` LEFT JOIN contractos on contractos.id_user = auxiliar_enlace.id_user WHERE `invirtiendo`=1 and rendimiento_entregado_LVL2=0 and `hash` LIKE '$hash_para_enlance'";
    $query = mysqli_query($conexion, $SQL);
    while ($data = mysqli_fetch_array($query)) {
        $num_contrato = ($data['num_contrato'] <= 3) ? $data['num_contrato'] : 3; //* aca no asegurarmos de fijar un limite si los deposito ya va por el numero 4 lo interpretaremos como el 3r caso ya que solo hay 3 coso y buscar otro mas grande generaria errores
        Pagar_referencia($usuario_receptor, $data['cantidad'], $num_contrato, $data['hash'], $nivel);

        $update = "UPDATE `contractos` SET `rendimiento_entregado_LVL2`=1 WHERE id=$data[1]";
        mysqli_query($conexion, $update);
    }
}

/**
 * Inserta una fila en una tabla llamada "transacciones" con las siguientes columnas: id_usuario,
 * cantidad, motivo, json_inf, estado, fecha_registro.
 * La función recibe los siguientes parámetros: , , , , .
 * La función devuelve verdadero.
 * 
 * Args:
 *   usuario_receptor: El usuario que recibirá el bono
 *   cantidad: el monto del contrato
 *   num_contrato: 1, 2 o 3
 *   hash: es el hash del contrato
 *   nivel: El nivel del usuario que hizo el depósito.
 * 
 * Returns:
 *   true si la consulta es exitosa.
 */

/**
 * Toma una identificación de usuario, una identificación de contrato, un hash de contrato y un nivel,
 * y luego le paga al usuario una bonificación basada en el monto del contrato y el nivel.
 * 
 * Args:
 *   usuario_receptor: El usuario que recibirá el bono
 *   cantidad: la cantidad de dinero que el usuario ha depositado
 *   num_contrato: 1, 2, 3
 *   hash: el hash del contrato
 *   nivel: 1 o 2
 * 
 * Returns:
 *   un valor booleano de verdadero.
 */
function Pagar_referencia($usuario_receptor, $cantidad, $num_contrato, $hash, $nivel)
{
    include(dirname(__FILE__) . '/../../assets/db/db.php');
    $razon_deposito = 'Bono Referido';
    $config = "SELECT `deposito_1`,`deposito_2`,`deposito_3` FROM `niveles_referido_bono` WHERE `nivel`= $nivel;";
    $config = mysqli_fetch_array(mysqli_query($conexion, $config));
    $porciento = $config['deposito_' . $num_contrato];
    $calculo = $cantidad * $porciento / 100;
    $calculo = overdraft_bonus($usuario_receptor, $calculo);
    $tiempo = date('Y-m-d h:i:s a');
    $fecha = date('Y-m-d h:i:s a');
    $json_info = [
        'linea_nivel' => $nivel,
        'hash_de_contrato' => $hash,
        'cantidad_base' => $cantidad,
        'deposito_num' => $num_contrato
    ];
    $json_info = json_encode($json_info);
    $insert = "INSERT INTO `transacciones` (`id_user`, `monto`, `razon`, `json_inf`, `status`, `fecha_registro`) VALUES ('$usuario_receptor', '$calculo', '$razon_deposito', '$json_info', 'Completado', '$tiempo')";
    $actualizar = "UPDATE `usuario` SET `disponible`=`disponible`+$calculo,`disponible_historico`=`disponible_historico`+$calculo,Bono_recibido=Bono_recibido+$calculo WHERE `id`=$usuario_receptor";
    $insert2 = "INSERT INTO `historico_diario`(`id_user`, `id_contractos`, `monto`, `porciento`, `fecha`) VALUES ($usuario_receptor,'139','$calculo','$porciento','$fecha')";
    mysqli_query($conexion, $insert2);
    mysqli_query($conexion, $actualizar);
    if (mysqli_query($conexion, $insert)) {
        $update = "UPDATE `contractos` SET `rendimiento_entregado`=1 WHERE `hash`='$hash'";
        mysqli_query($conexion, $update);
    }
    return true;
}



/**
 * Si la suma del bono recibido y el monto a recibir es superior al monto total del contrato, entonces
 * el monto a recibir es la diferencia entre el monto total del contrato y el bono recibido. De lo
 * contrario, la cantidad a recibir es la cantidad a recibir.
 * 
 * Args:
 *   id: La identificación del usuario
 *   cantidad: el monto del bono
 * 
 * Returns:
 *   El valor de la variable .
 */
/**
 * Si la suma de la bonificación recibida y el monto a recibir es superior al monto total del contrato,
 * entonces el monto a recibir es la diferencia entre el monto total del contrato y la bonificación
 * recibida. De lo contrario, la cantidad a recibir es la cantidad a recibir.
 * 
 * Args:
 *   id: La identificación del usuario
 *   cantidad: el monto del bono
 * 
 * Returns:
 *   El valor de la variable .
 */
function overdraft_bonus($id, $cantidad)
{
    include(dirname(__FILE__) . '/../../assets/db/db.php');
    $sql = "SELECT `Bono_recibido`,SUM(contractos.cantidad) FROM `usuario` INNER JOIN contractos on contractos.id_user=usuario.id WHERE usuario.`id`=$id";
    $data = mysqli_fetch_array(mysqli_query($conexion, $sql));
    if (($cantidad + $data[0]) >= $data[1]) {
        $valor = $data[1] - ($data[0]);
    } else {
        $valor = $cantidad;
    }
    return $valor;
}
/**
 * Comprueba si la dirección es una dirección TRC20.
 * 
 * Args:
 *   address: La dirección del contrato.
 * 
 * Returns:
 *   un valor booleano.
 */
function isTrc20($address)
{
    return substr($address, 0, 1) == "T" and strlen($address) == 34;
}
function days_block()
{
    
    if (date('w') == 6) {
    $fecha_actual = strtotime(date("d-m-Y H:i:00", time()));
    $fecha_entrada = strtotime(date("d-m-Y 04:00:00"));

    if ($fecha_actual > $fecha_entrada) {
        $inicio = 1;
    } else {
        $inicio = 0;
    }

    $fecha_actual = strtotime(date("d-m-Y H:i:00", time()));
    $fecha_entrada = strtotime(date("d-m-Y 13:28:59"));

    if ($fecha_actual > $fecha_entrada) {
        $final = 1;
    } else {
        $final = 0;
    }
    if ($inicio > $final) {
        $activar  = 1;
    } else {
        $activar = 0;
    }

    }else{
        $activar = 0;
    }
    return $activar;
}

/**
 * Toma una identificación y una dirección de billetera y envía un correo electrónico al usuario con la
 * dirección de la billetera.
 * 
 * Args:
 *   id: identificación de usuario
 *   wallet: La dirección de la billetera
 */
function add_wallet($id, $wallet)
{
    $dotenv = new Dotenv\Dotenv(dirname(__FILE__) . '/../../.');
    $dotenv->load();
    include(dirname(__FILE__) . '/../../assets/db/db.php');
    $sql = "SELECT `email`,`nombre` FROM `usuario` WHERE `id`=$id";
    $data = mysqli_fetch_array(mysqli_query($conexion, $sql));
    $email = $data['email'];
    $sql = "SELECT `estructura` FROM `plantillas_email` WHERE `id` = 6";
    $estrutura = mysqli_fetch_array(mysqli_query($conexion, $sql));

    /* Crear una carga útil con la billetera y la identificación. */
    $payload = ['wallet' => $wallet, 'id' => cifrar($id)];
    $jwt = JWT::encode($payload, getenv('key_cifrado'), 'HS256');
    $hora = date('Y-m-d h:i:s a');

    $palabras_claves = array("@nombre@", "@wallet@", '@ip@', '@hora@', "@link@");
    $palabras_claves_changer = array($data['nombre'], $wallet, get_client_ip_env(), $hora, 'https://app.smartblessingcloud.com/?wallet_confirm=' . $jwt);
    $html = str_replace($palabras_claves, $palabras_claves_changer, $estrutura['estructura']);
    $subjet = 'Cambio de dirección de retiro';
    enviar_email($subjet, $email, $html);
}
/**
 * Toma un JWT y lo decodifica.
 * 
 * Args:
 *   jwt: El token JWT que desea decodificar.
 */
function Cambiar_wallet($jwt)
{
    include(dirname(__FILE__) . '/../../assets/db/db.php');
    /* Decodificación del token JWT y obtención de la identificación. */
    $dotenv = new Dotenv\Dotenv(dirname(__FILE__) . '/../../.');
    $dotenv->load();
    $decoded = JWT::decode($jwt, new Key(getenv('key_cifrado'), 'HS256'));
    $id = ($decoded->id);

    /* Convertir la variable  de una cadena a un objeto. */
    $id = json_encode($id);
    $id = json_decode($id);

    /* Descifrando los datos. */
    $id = descrifar($id->data);
    /* Tomando los datos de la variable id y asignándolos a la variable . */
    $id=$id->data;
    /* Decodificando la cadena JSON y luego accediendo a la propiedad de la billetera. */
    $select = "UPDATE `usuario` SET `wallet`='$decoded->wallet' WHERE `id`=$id";
    $json=['razon'=>'Cambio o agrego una wallet','data'=>['wallet agregada'=>$decoded->wallet,'ip de confirmacion'=>get_client_ip_env()]];
    $json = json_encode($json);
    if (mysqli_query($conexion,$select)) {
        $sql="INSERT INTO `seguimiento`(`id_user`, `json`) VALUES ($id,'$json')";
        mysqli_query($conexion,$sql);
        print header("refresh:1.5;url=/?verificada_wallet"); 
    }else {
        print header("refresh:1.5;url=/?error_wallet"); 
    }
}
