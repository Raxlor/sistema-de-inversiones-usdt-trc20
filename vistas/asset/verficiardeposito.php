<?php
include '../../assets/db/db.php';

$sql = "SELECT `id_user`,`json_inf` FROM `transacciones` WHERE `status`='pendiente' and `razon`='Deposito USDT';";
$sql_quety = mysqli_query($conexion, $sql);
while ($data = mysqli_fetch_array($sql_quety)) {
    $id_usuario = $data[0];
    $json = json_decode($data[1]);
    $id = $json->ordenId;
    $url = $api_uri . "consultar/deposito/id/";
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
    $resp = json_decode($resp);

    $hora = date('Y-m-d H:i:s');
    $time = time();
    /* Converting the timestamp to a date and then back to a timestamp. */
    $aux = explode('.', date($json->end / 1000));
    $json->end = $aux[0];

    /* Checking if the current time is greater than the time in the JSON object. */
    if ($time >= $json->end) {
        /* Getting the value of the key `ordenId` from the JSON object ``. */
        $id = $json->ordenId;
        $url = $api_uri . "cancelar/deposito/id/";
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

    /* Inserting a row into the table `alert_user` with the values of ``,
    `Deposito-Cancelado`, `Se cancelo el deposito, el tiempo expiro`, ``, ``. */
            $sql_alert = "INSERT INTO `alert_user`(`id_usuario`, `razon`, `mensaje`, `hora`, `time`) VALUES ($id_usuario,'Deposito-Cancelado','Se cancelo el deposito, el tiempo expiro','$hora','$time');";
            mysqli_query($conexion, $sql_alert);
        }
    } else {
        if ($resp->data->completado) {
            //lo utilizo para realizar una consulta en el paquete jsom
            $consulta_target_json = '"ordenId":';
            $monto = $resp->data->cantidad; // para actualizar la cuenta

            $id_dentificador = $resp->data->identificador; //la usare para consultar
            $usuario = $resp->data->usuario; //la usare para consultar
            $json_update = json_encode($resp);

            $sql_transacciones = "UPDATE `transacciones` SET `monto`='$monto',`status`='Completado',json_inf='$json_update' WHERE `json_inf` like '%$consulta_target_json$id_dentificador%';";
            mysqli_query($conexion, $sql_transacciones);

            $sql_usuarios = "UPDATE `usuario` SET `wallet_persona`=`wallet_persona`+$monto,wallet_historico=wallet_historico+$monto WHERE `id`=$usuario";
            mysqli_query($conexion, $sql_usuarios);

            $sql_alert = "INSERT INTO `alert_user`(`id_usuario`, `razon`, `mensaje`, `hora`, `time`) VALUES ($usuario,'Deposito','$monto USDT recibidos, exitosamente','$hora','$time')";
            mysqli_query($conexion, $sql_alert);
            
        }
    }
};
