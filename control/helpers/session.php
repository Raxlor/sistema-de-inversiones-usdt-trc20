<?php
session_start();

$code = array();
if (!isset($_SESSION['id_acceso_cliente'])) {
    header('Content-Type: application/json');
    $code = ['finalizado' => 1];
    echo json_encode($code);
}else {
    include '../../assets/db/db.php';
    $id=$_SESSION['id_acceso_cliente'];
    $id_browser = $_SESSION['id_browser'];
    $sql="SELECT COUNT(*) FROM `usuario` WHERE `id`='$id' AND `session_id`='$id_browser'";
    $data=mysqli_fetch_array(mysqli_query($conexion,$sql));
    if ($data[0]>0) {
       // no pasa nada aun sigue sin nadie entrar
    }else {
       // error alguien entro
          header('Content-Type: application/json');
          ///esto me indica que no hay forma de recartar la session
    $code = ['finalizado' => 2];
    echo json_encode($code);
    }
}