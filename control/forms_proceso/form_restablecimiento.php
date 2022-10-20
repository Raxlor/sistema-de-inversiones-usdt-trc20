<?php
session_start();
include '../../assets/db/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json');
    require_once '../../assets/php/funciones.php';
    $password = $_POST['myPassword'];
    $code=$_POST['code'];
    $hash=$_SESSION['Validacion_hash'];
    $respuesta=restablecer_contraseña($hash,$code,$password);
    
    /* Comprobando si el estado es verdadero o falso. */
    echo $respuesta;
};

?>