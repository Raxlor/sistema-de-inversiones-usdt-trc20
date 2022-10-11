<?php
/* Un script PHP que está siendo llamado por la solicitud AJAX. */
session_start();
include '../../assets/db/db.php';
#utilidades
/* Solo un montón de variables que se usan en el script. */
$mensaje = array();
$json = json_encode($_POST);
$json = json_decode($json);
$resp_error = array('mensaje' => 'No hay informacion que guardar');
$resp_error = json_encode($resp_error);
$timestamp = (time());
$tiempo = gmdate("Y-m-d H:i:s", $timestamp);
$hash = md5(time());
$id_producto = $json->produc_id;
#fin utilidad
/* Al verificar si la sesión está configurada, si no está configurada, devolverá un mensaje. Si está
configurado, continuará con el script. */
if (!isset($_SESSION['id_acceso_cliente'])) {
    $mensaje = ['mensaje' => 'Hubo un problema al tratar de completar la acción', 'status' => false];
} else {
    /* Este es un script PHP que está siendo llamado por la solicitud AJAX. */
    /* Obtener la identificación de usuario de la sesión. */
    $id = $_SESSION['id_acceso_cliente'];
    /* Obtener el saldo de la billetera del usuario. */
    $sql = "SELECT `wallet_persona` FROM `usuario` WHERE `id`=$id";
    $query = mysqli_query($conexion, $sql);
    $data = mysqli_fetch_array($query);
    /* Esta es una declaración condicional que verifica si el usuario tiene fondos suficientes para iniciar
    el contrato. Si el usuario tiene fondos suficientes, el contrato se agregará a la base de datos. Si
    el usuario no tiene fondos suficientes, se le enviará un mensaje. */
    if ($data[0] >= $json->mont_id) {
        /* Una consulta que se está ejecutando en la base de datos. */
        $monto = number_format($json->mont_id, 0, '', '');
        $consulta = "INSERT INTO `transacciones`(`id_user`, `monto`, `razon`, `json_inf`, `fecha_registro`,`status`) VALUES ($id,'$monto','Pago de Contrato','$resp_error','$tiempo','Completado')";

        if (mysqli_query($conexion, $consulta)) {
            $sql = "SELECT `num_contrato` FROM `contractos` WHERE `id_user`=$id ORDER BY `contractos`.`id` DESC limit 1;";
            $data = mysqli_fetch_array(mysqli_query($conexion, $sql));
            /* Esta es una variable que se utiliza para obtener el último número de contrato y
            agregarle 1. */
            $aux = $data[0] + 1;
            $sql = "UPDATE `usuario` SET `wallet_persona`=`wallet_persona`-$monto WHERE `id`=$id;";
            mysqli_query($conexion, $sql);
            
            $sql = "INSERT INTO `contractos`(`id_user`, `cantidad`, `recibido`, `estado`, `fecha_start`, `razon`, `hash`, `num_contrato`) VALUES ($id,$monto,0,1,'$tiempo','$id_producto','$hash',$aux)";
            if (mysqli_query($conexion, $sql)) {
                $mensaje = ['mensaje' => 'Contrato agregado', 'status' => true];
            }
        }
    } else {
        /* Este es un mensaje que se envía al usuario si el usuario no tiene fondos suficientes para
        iniciar el contrato. */
        $mensaje = ['mensaje' => 'No cuenta con suficientente fondos para iniciar el contrato', 'status' => false];
    }
}

/* Enviando la respuesta a la solicitud AJAX. */
header("Content-Type: application/json");
/* Enviando la respuesta a la solicitud AJAX. */
print json_encode($mensaje);
