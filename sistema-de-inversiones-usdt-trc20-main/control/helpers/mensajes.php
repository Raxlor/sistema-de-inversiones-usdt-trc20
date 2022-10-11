<?php
session_start();
include '../../assets/db/db.php';
if (isset($_SESSION['id_acceso_cliente'])) {
    $id = $_SESSION['id_acceso_cliente'];
    $sql_mensajes = "SELECT * FROM `alert_user` WHERE `id_usuario`=$id and visto=0";
    $jquery = mysqli_query($conexion, $sql_mensajes);
    $mensaje = mysqli_fetch_array($jquery);
    $json = array();
    if (!is_null($mensaje)) {
        if ($mensaje['razon'] === 'Deposito') {

            $id = $mensaje[0];
            $sql_mensajes_update = "UPDATE `alert_user` SET `visto`= 1 WHERE `id`=$id";
            mysqli_query($conexion, $sql_mensajes_update);
            header("Content-Type: application/json");
            $json = ['mensaje' => $mensaje['mensaje'], 'razon' => 'Deposito'];
            echo json_encode($json);
        } elseif ($mensaje['razon'] === 'Deposito-Cancelado') {

            $id = $mensaje[0];
            $sql_mensajes_update = "UPDATE `alert_user` SET `visto`=1 WHERE `id`=$id";
            mysqli_query($conexion, $sql_mensajes_update);
            header("Content-Type: application/json");
            $json = ['mensaje' => $mensaje['mensaje'], 'razon' => 'Deposito-Cancelado'];
            echo json_encode($json);
        }
    } else {
        header("Content-Type: application/json");
        $json = ['mensaje' => 'no hay informacion'];
        echo  json_encode($json);
    }
} else {
    header("Content-Type: application/json");
    http_response_code(204);
}
