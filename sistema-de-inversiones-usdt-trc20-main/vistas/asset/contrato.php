<?php
    session_start();
    include '../../assets/db/db.php';
    $id = $_SESSION['id_acceso_cliente'];
    $sentence="SELECT * FROM `contractos` WHERE `id_user`=$id";
    $res = mysqli_query($conexion,$sentence);
    $rows = [];
    while ($row = mysqli_fetch_assoc($res)) {
        $rows[] = $row;
    }
    echo json_encode(['data' => $rows]);