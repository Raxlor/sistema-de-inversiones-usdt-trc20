<?php
session_start();
include '../../assets/db/db.php';
require_once '../../assets/php/funciones.php';

if (!isset($_SESSION['id_acceso_cliente'])) {
    $mensaje = 'Hubo un problema al tratar de completar la acción';
} else {
    if (isTrc20($_POST['wallet'])) {
        $mensaje='Se ha enviado, el la validacion a su correo, favor de confirmar la Billetera de retiro';
        add_wallet($_SESSION['id_acceso_cliente'],$_POST['wallet']);
    }else {
        $mensaje='La dirección no es valida, verifica e intenta nuevamente';
    }
}
print $mensaje;