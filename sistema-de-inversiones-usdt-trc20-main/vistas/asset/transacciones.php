<?php
    session_start();
    include '../../assets/db/db.php';
    $id = $_SESSION['id_acceso_cliente'];
    $sentence="SELECT `id`,`razon`,`monto`,`status`,`fecha_registro` FROM `transacciones` WHERE `id_user`=$id and status='Completado'";
    $res = mysqli_query($conexion,$sentence);
    $rows = [];
    while ($row = mysqli_fetch_assoc($res)) {
        $rows[] = $row;
    }
    echo json_encode(['data' => $rows]);