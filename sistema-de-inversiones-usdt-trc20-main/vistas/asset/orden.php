<?php
session_start();
/* Comprobando si la variable de sesión `id_acceso_cliente` está configurada. */
if (isset($_SESSION['id_acceso_cliente'])) {
    /* Una solicitud curl a la API. */
    include '../../assets/db/db.php';
    $id = $_SESSION['id_acceso_cliente'];
    $url = $api_uri . "crear/deposito/";
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $headers = array(
        "Content-Type: application/json",
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

    $_SESSION['id_order'] = $resp->ordenId;

    $timestamp = ($resp->time / 1000);
    $tiempo = gmdate("Y-m-d H:i:s", $timestamp - 14400);
    $resp = json_encode($resp);
    $consulta = "SELECT COUNT(*) FROM `transacciones` WHERE `id_user` =$id and `json_inf`='$resp'";
    $data = mysqli_fetch_array(mysqli_query($conexion, $consulta));
    echo '<script src="../../assets/js/script.js"></script>';
    if ($data[0] > 0) {
    } else {
        $consulta = "INSERT INTO `transacciones`(`id_user`, `monto`, `razon`, `json_inf`, `fecha_registro`) VALUES ($id,'0','Deposito USDT','$resp','$tiempo')";
        if (mysqli_query($conexion, $consulta)) {
            echo '<script type="text/JavaScript">
            actualizar_transaciones_tabla_orden();
            </script>';
        } else {
            echo '<script type="text/JavaScript">
            error_conexion_db_consulta();
            </script>';
        }
    }
    $resp = json_decode($resp);

?>

    <div class="wallet" style="text-align: center;">
        <img id="wallet-img" src="/control/helpers/qr_wallet_generador.php?wallet=<?php echo $resp->sendTo ?>" style="width: 50%;">
        <br>
        <h6>Wallet: <?php echo  $resp->sendTo ?></h6>
        <p>Tiempo restante: <span id="end_time"></span></p>
        <code>Deposito minimo 10 usdt, recuende enviar por la red (TRC-20) el envio de otras redes Provocaran perdida de sus USDT</code>
        <br>
        <br>
    </div>
    <button type="submit" onclick="cancel_orden()" class="btn btn-smart-cancel text-white">Cancerlar Deposito </button>
    <script>
        conteo_regresivo(<?php echo $resp->end ?>)
    </script>
<?php
} else {
?>
    <div class="wallet" style="text-align: center;">
        <h5>Para poder usuar esta funcion entra a tu cuenta nuevamente</h5>
        <button type="submit" onclick="window.location.reload()" class="btn btn-smart-login text-white">Salir </button>
    </div>
<?php
}
?>