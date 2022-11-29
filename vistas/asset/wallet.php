<?php
session_start();
include '../../vistas/asset/header.html';
include '../../assets/db/db.php';
include '../../assets/php/funciones.php';
$id = $_SESSION['id_acceso_cliente'];

$sql = "SELECT `Bono_recibido`,disponible,wallet FROM `usuario` WHERE `id`=$id";
$data_fecha = mysqli_fetch_array(mysqli_query($conexion, $sql));
$wallet= ($data_fecha['wallet']==0) ? '' : $data_fecha['wallet'];
?>
<main class="custom-height">
    <div class="container">
        <div class="balance-area-bg balance-area-bg-home">
            <div class="balance-title text-center">
                <h6>Billetera de retiro</h6>
            </div>
            <div class="ba-balance-inner text-center slider-card-usdt">
                <div
                    style="height: 50px;width: 50px;display: inline-block;line-height: 48px;margin-bottom: 13px; visibility: hidden;">
                    <img src="#" alt="img">
                </div>
                <!--<h5 style="color: white !important;">Billetera de retiro <span class="">
                        <?php echo '$ ' . number_format($data_fecha[1], 2) ?>
                    </span>-->
                </h5>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="add-balance-area pd-top-40">
                    <div class="ba-add-balance-inner bg-white p-2" id="">
                        <form action="javascript:void(0)" method="post" id="wallet_form" >
                            <div class="row">
                                <div class="col-12">
                                    <h6>Formulario de billetera de retiro</h6>
                                </div>
                                <div class="col-12">
                                    <label for="">Dirección de retiro</label>
                                    <input type="text" value="<?php print $wallet ?>" name="wallet" maxlength="34" minlength="34" class="form-control" id="" required placeholder="Escriba su billetera de deposito">
                                    <br>
                                    <cite>Las dirreciones solo pueden ser de la red trc20 USDT, cualquier otra red sera declinada</cite>
                                </div>
                                <div class="col-12 py-2">
                                    <button type="submit" class=" btn btn-success">Guardar</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>
<script src="../../assets/js/script.js"></script>