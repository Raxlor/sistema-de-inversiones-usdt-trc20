<?php
ini_set('session.gc_maxtime', 6000 * 59 * 59);
$lifetime = 6000 * 59 * 59;
setcookie(session_name(), session_id(), time() + $lifetime);
session_start();
header('Content-Type: application/json');
include '../assets/db/db.php';

$c = $_POST['nick'];

$cc = $_POST['contraseña'];
$cc = openssl_encrypt($cc, "AES-128-ECB", $key_encryp);
$sentence = "SELECT count(*),id FROM `usuario` WHERE `nick`='$c' AND `contraseña`='$cc'";
$data_mysli = mysqli_fetch_array(mysqli_query($conexion, $sentence));

$code = array();

$error_message = mysqli_errno($conexion);
if ($data_mysli[0] > 0) {
  $id = $_SESSION['id_acceso_cliente'] = $data_mysli[1];
  $id_browser = $_SESSION['id_browser'] = session_id();
  $update = "UPDATE `usuario` SET `session_id`='$id_browser' , estado=1 WHERE `id`=$id";
  mysqli_query($conexion, $update);
  $code = ['access' => true];
} else {
  $code = ['msg' => 'Datos no localizado'];
}
echo json_encode($code);
