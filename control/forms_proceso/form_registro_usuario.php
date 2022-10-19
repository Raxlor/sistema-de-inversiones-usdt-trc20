<?php
include '../../assets/db/db.php';
require_once '../../assets/php/funciones.php';
/* Es una función que obtiene la dirección IP del usuario. */

/* Obtener los datos del formulario. */
$username = strtolower($_POST['username']);
$email = strtolower($_POST['email']);
$full_name = strtolower($_POST['nombre_completo']);
$password = $_POST['myPassword'];
/* Una función que registra al usuario en la base de datos. */
$respuesta = Registro_usuario($username, $full_name, $email, $password);
// se que esto es muy tedioso
/* Está convirtiendo la matriz en un objeto json y luego vuelve a ser una matriz. */
$respuesta = json_encode($respuesta);
$respuesta = json_decode($respuesta);
$id=$respuesta->id_return;
/* Está comprobando si el hash está configurado, si lo está, está llamando a la función
certificar_link_referencia con el id_return y el hash. */
if (isset($_POST['1'])) {
    /* Una función que se utiliza para certificar la referencia del enlace con el id_return y el hash. */
    var_dump(certificar_link_referencia($id, $_POST['1']));
}

/* Comprobando si el estado es verdadero o falso. */
if ($respuesta->status) {
    $code = ['status' => $respuesta->status, 'msg' => $respuesta->msg];
} else {
    $code = ['status' => $respuesta->status, 'msg' => $respuesta->msg];
}
echo json_encode($respuesta);