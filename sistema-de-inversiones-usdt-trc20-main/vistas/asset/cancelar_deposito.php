<?php
session_start();
if (isset($_SESSION['id_order']) || isset($_POST['id'])) {
    include '../../assets/db/db.php';
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
    } else {
        $id = $_SESSION['id_order'];
    }
    $url = $api_uri."cancelar/deposito/id/";
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $headers = array(
        "Content-Type: application/json"
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    $data =  array("token" => 'Cu4lQu3rt@kenD3S3guriD4D', "id" => $id);
    $data = json_encode($data);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    //for debug only!
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $resp = curl_exec($curl);
    curl_close($curl);
    $resp = json_encode($resp);

    $consulta_target_json = '"ordenId":';
    $sentence = "UPDATE `transacciones` SET `status`='cancelado' WHERE `json_inf` LIKE '%$consulta_target_json$id%'";
    if (mysqli_query($conexion, $sentence)) {
    } else {
    }
} else {
    $code = array('cancelado' => '0', 'msg' => 'no hay orden que cancelar');
    echo json_encode($code);
}
