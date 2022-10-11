<?php

/* Including the database connection, the functions and the autoloader. */
include '../../assets/db/db.php';
require_once '../../assets/php/funciones.php';
require '../../vendor/autoload.php';

/* This is a PHP script that is used to send an email to the user. */
if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $data = array();

    /* Checking if the email exists in the database. */
    $sentence = "SELECT count(*),`email`,id,nombre FROM `usuario` WHERE `email`='$email';";
    $query = mysqli_fetch_array(mysqli_query($conexion, $sentence));

    if ($query[0] > 0) {

        $nombre = $query['nombre'];
        $timer = date('Y-m-d H:i:s');

        $data = array('ip' => get_client_ip_env(), 'hora' => $timer);

        /* Converting the array into a json string. */
        $data = json_encode($data);
        $id = $query['id'];

        /* Generating a random number and a hash. */
        $otp = generateNumericOTP(6);
        $hash = generarhash(24);

        /* Inserting the data into the database. */
        $sql = "INSERT INTO `codigos_de_restablecimiento`(`id_user`, `code`, `hash`,json_info ) VALUES ($id,'$otp','$hash','$data');";
        if (mysqli_query($conexion, $sql)) {
           
            /* la id 1 pertenece a esa plantilla */
            $sql = "SELECT * FROM `plantillas_email` where id=1";
            $data = mysqli_fetch_array(mysqli_query($conexion, $sql));

            /* Replacing the values in the array with the values in the database. */
            $palabras_claves = array("@nombre@", "@otp@", "@link@");
            $palabras_claves_changer = array($nombre, $otp, 'https://app.smartblessingcloud.com/?hash=' . $hash);
            $html = str_replace($palabras_claves, $palabras_claves_changer, $data['estructura']);
            /* Sending the email. */
            enviar_email('Restablecer', $email, $html);
             /* A function that disables the previous codes. */
             deshabilitar_codigos_anteriores($id);
        }
        /* Returning a json object with the status of the email. */
        $info = array('status' => true);
    } else {
        /* Returning a json object with the status of the email. */
        $info = array('status' => false);
    }
    /* Setting the content type of the response to JSON. */
    header('Content-Type: application/json; charset=utf-8');
    /* Returning a json object with the status of the email. */
    echo json_encode($info);
}
