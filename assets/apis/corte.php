<?php
include '../../assets/db/db.php';
/* Es un marcador de posición para una condición futura. */
if (true) {
/* Un marcador de posición para una condición futura. */
    $sql = "SELECT contractos.*,  productos.porciento_mensual,(( contractos.cantidad * productos.porciento_mensual / 100) / 20) AS roi_diario,
    ((  productos.porciento_mensual) / 20) as porciento FROM
    `contractos`INNER JOIN productos ON contractos.razon = productos.nombre WHERE  fecha_start < '2022-10-30 11:25:01'";
    $query = mysqli_query($conexion, $sql);
    while ($data = mysqli_fetch_array($query)) {

        $id = $data[0];
        $id_user = $data[1];
        $monto = $data['roi_diario'];
        $porciento = $data['porciento'];
        $fecha = date('Y-m-28 h:i:s a');
        /* Actualizando la tabla contractos con el valor de . */
        $update = "UPDATE `contractos` SET `recibido`=`recibido`+$monto WHERE `id`=$id";
        mysqli_query($conexion, $update);
        // creo el historial de para que quede registro del corte diario por membresia
       $insert = "INSERT INTO `historico_diario`(`id_user`, `id_contractos`, `monto`, `porciento`, `fecha`) VALUES ($id_user,'$id','$monto','$porciento','$fecha')";
        mysqli_query($conexion, $insert);

    }
}
