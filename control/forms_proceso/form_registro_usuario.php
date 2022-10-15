<?php
include  '../../assets/db/db.php';
require_once '../../assets/php/funciones.php';
/* Es una función que obtiene la dirección IP del usuario. */

$username = strtolower($_POST['username']);
$email = strtolower($_POST['email']);
$full_name = strtolower($_POST['nombre_completo']);
$password = strtolower($_POST['myPassword']);
$respuesta=Registro_usuario($username, $full_name, $email, $password);
// se que esto es muy tedioso
$respuesta=json_encode($respuesta);
$respuesta=json_decode($respuesta);

if ($respuesta->status) {
    $code = ['status'=>$respuesta->status,'msg' => $respuesta->msg];
}else {
    $code = ['status'=>$respuesta->status,'msg' => $respuesta->msg];
}
echo json_encode($code);