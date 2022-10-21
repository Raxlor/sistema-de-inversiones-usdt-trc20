<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include '../../assets/db/db.php';
    require_once '../../assets/php/funciones.php';
    $password = $_POST['myPassword'];
    $code=$_POST['code'];
    $hash=$_SESSION['Validacion_hash'];
    try {
        $respuesta=restablecer_contraseña($hash,$code,$password);
    } catch (\Exception $e) {
        $respuesta='Excepción capturada: ' . $e->getMessage() . "\n en " . __FILE__ . ' en Linea ' . __LINE__;
    }
    header('Content-Type: application/json');
    /* Comprobando si el estado es verdadero o falso. */
    print $respuesta;
};
?>