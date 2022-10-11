<?php
/* Un script PHP que está siendo llamado por la solicitud AJAX. */
session_start();
include '../../assets/db/db.php';
require_once '../../assets/php/funciones.php';

#utilidades
/* Solo un montón de variables que se utilizan en el script. */
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

if (!isset($_SESSION['id_acceso_cliente'])) {
    $mensaje = ['mensaje' => 'Hubo un problema al tratar de completar la acción', 'status' => false];
} else {

    $id = $_SESSION['id_acceso_cliente'];
    $sql = "SELECT `wallet_persona` FROM `usuario` WHERE `id`=$id";
    $query = mysqli_query($conexion, $sql);
    $data = mysqli_fetch_array($query);
    if ($data[0] >= $json->mont_id) {
        $monto = number_format($json->mont_id, 0, '', '');
        $sql = "SELECT  `disponibilidad`, `utilizado`, `capital_total`, `objetivo_capital`, `multiplo`, `min-deposito` FROM `productos` WHERE id=1";
        $verificacion = mysqli_fetch_array(mysqli_query($conexion, $sql));

        $sql = "SELECT `disponibilidad`,`utilizado`,`capital_total`,`objetivo_capital`,`multiplo`,`min-deposito` FROM `productos` where `nombre`='$id_producto'";
        $data = mysqli_fetch_array(mysqli_query($conexion, $sql));
        $verificacion = validacion_de_inversiones($data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $monto);
         $verificacion=json_decode($verificacion);

        if ($verificacion->limite!=='Verdadero') {
            $mensaje = ['mensaje' => 'No hay espacio para nuevos inversores en esta membresia', 'status' => false];
            goto end;
        }
        if ($verificacion->limite_holder!=='Verdadero') {
            $mensaje = ['mensaje' => 'Ya no aceptamos nuevo capitales de esta membresia, pues ya alcanzo la meta', 'status' => false];
            goto end;
        }
        if ($verificacion->multiplo!=='Verdadero') {
            $mensaje = ['mensaje' => 'Esta cantidad no es un multiplo de lo requerido para esta membresia', 'status' => false];
            goto end;
        }
        if ($verificacion->min_deposito!=='Verdadero') {
            $mensaje = ['mensaje' => 'Esta cantidad, esta por debajo de lo minimo', 'status' => false];
            goto end;
        }
            $consulta = "INSERT INTO `transacciones`(`id_user`, `monto`, `razon`, `json_inf`, `fecha_registro`,`status`) VALUES ($id,'$monto','Pago de Contrato','$resp_error','$tiempo','Completado')";

            if (mysqli_query($conexion, $consulta)) {
                $sql = "SELECT `num_contrato` FROM `contractos` WHERE `id_user`=$id ORDER BY `contractos`.`id` DESC limit 1;";
                $data = mysqli_fetch_array(mysqli_query($conexion, $sql));
                $aux = $data[0] + 1;
                $sql = "UPDATE `usuario` SET `wallet_persona`=`wallet_persona`-$monto WHERE `id`=$id;";
                mysqli_query($conexion, $sql);
                $sql = "INSERT INTO `contractos`(`id_user`, `cantidad`, `recibido`, `estado`, `fecha_start`, `razon`, `hash`, `num_contrato`) VALUES ($id,$monto,0,1,'$tiempo','$id_producto','$hash',$aux)";

                // le aumento a la membresia para actualizarla
                $sql_productos = "UPDATE `productos` SET `utilizado`= `utilizado`+ 1,`capital_total`=`capital_total`+$monto  WHERE `nombre`='$id_producto'";
                mysqli_query($conexion, $sql_productos);
                if (mysqli_query($conexion, $sql)) {

                    $mensaje = ['mensaje' => 'Contrato agregado', 'status' => true];
                }
            }
    } else {
        $mensaje = ['mensaje' => 'No cuenta con suficientente fondos para iniciar el contrato', 'status' => false];
    }
}
end:
/* Enviando la respuesta a la solicitud de AJAX. */
header("Content-Type: application/json");
print json_encode($mensaje);