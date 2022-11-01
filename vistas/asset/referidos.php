<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include '../../assets/db/db.php';
    $id = $_SESSION['id_acceso_cliente'];
    $hash=$_SESSION['hash'];
    $sentence = "SELECT usuario.nick,auxiliar_enlace.fecha,id_user,IFNULL(link_referido.cantidad_referidos,0) as referidos, IFNULL(link_referido.nivel_actual,0) as nivel FROM `auxiliar_enlace` INNER JOIN usuario on usuario.id = id_user LEFT join link_referido on usuario.id = link_referido.enlace_primario WHERE auxiliar_enlace.`hash_para_enlance`='$hash' and `invirtiendo`=1";
    $res = mysqli_query($conexion, $sentence);
    $rows = [];
    while ($row = mysqli_fetch_assoc($res)) {
        $rows[] = $row;
    }
    echo json_encode(['data' => $rows]);
}