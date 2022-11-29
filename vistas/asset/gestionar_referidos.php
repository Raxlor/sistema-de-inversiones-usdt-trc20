<?php
session_start();
/* Comprobando si la sesión está configurada. */
include '../../vistas/asset/header.html';
include '../../assets/db/db.php';
$id = $_SESSION['id_acceso_cliente'];
if (isset($_SESSION['id_acceso_cliente'])) {
    $referidos_sql ="SELECT * FROM `link_referido` WHERE `enlace_primario` = $id";
    $data_referidos = mysqli_fetch_array(mysqli_query($conexion,$referidos_sql));
    $_SESSION['hash']=$data_referidos['hash_para_enlance'];
    $nivel="SELECT MAX(`nivel`) FROM `condiciones_de_niveles`";
    $data_nivel_max=mysqli_fetch_array(mysqli_query($conexion,$nivel));

    if ($data_referidos['nivel_actual']<$data_nivel_max[0]) {
         $porciento =round( $data_referidos['cantidad_referidos']*100/$data_nivel_max[0]/2, 2); ;
        $nivel_text=$porciento.'%';
    }else {
        $nivel_text='Rango maximo';
        $porciento='100';

    }
    $sql= "SELECT `Bono_recibido`,disponible FROM `usuario` WHERE `id`=$id";
    $data_fecha=mysqli_fetch_array(mysqli_query($conexion,$sql));
    $limite_sql="SELECT SUM(`cantidad`) FROM `contractos` WHERE `id_user`=$id and `estado`=1";
    $data_limite=mysqli_fetch_array(mysqli_query($conexion,$limite_sql));
    $porciento_limite =round($data_fecha[0]*100/$data_limite[0], 2); ;


?>
<main class="custom-height">
    <!-- balance start -->
    <!-- <div class="balance-area"> -->
    <div class="container">
        <div class="balance-area-bg balance-area-bg-home">
            <div class="balance-title text-center">
                <h6>Gestion de referidos</h6>
            </div>
            <div class="ba-balance-inner text-center slider-card-usdt">
                <div
                    style="height: 50px;width: 50px;display: inline-block;line-height: 48px;margin-bottom: 13px; visibility: hidden;">
                    <img src="#" alt="img">
                </div>
             
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="add-balance-area pd-top-40">
                    <div class="ba-add-balance-inner bg-white p-2" id="">
                        <div class="lds-ring spinner" id="spinner-load-generar" hidden>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                        <section id="wallet_deposit">
                        </section>
                        <h5>Estadística de Rango</h5>
                        <div class="row">
                            <div class="col-6">Rango Actual: <?php echo $data_referidos['nivel_actual'] ?> </div>
                            <div class="col-6">Referidos Actuales: <?php echo $data_referidos['cantidad_referidos'] ?>  </div>
                            <div class="col-12 pt-2 pb-2">
                                <div class="progress">

                                    <div class="progress-bar progress-bar-striped progress-bar-animated "
                                        role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"
                                        style="width: <?php echo $porciento; ?>%">
                                        <span class="text-center">
                                            <?php echo $nivel_text; ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <hr>
                            </div>
                            <div class="col-12">Capital de patrocinio:
                                <?php echo '$ ' . number_format($data_referidos['dinero_activo'], 2) ?>
                            </div>
                            <div class="col-6 pt-2">Bono recibido:
                                <?php echo number_format($data_fecha[0], 2) ?>
                            </div>
                            <div class="col-6 pt-2">Bono maximo:
                                <?php echo number_format($data_limite[0], 2) ?>
                            </div>
                            <div class="col-12 pt-2">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated "
                                        role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"
                                        style="width: <?php echo $porciento_limite ?>%">
                                        <?php echo $porciento_limite ?>%
                                    </div>
                                </div>
                            </div>
                            <?php
                                $sql = "SELECT count(*) as cuenta,hash_para_enlance FROM `link_referido` WHERE `enlace_primario`=$id";
                                $link = mysqli_fetch_array(mysqli_query($conexion, $sql));
                            ?>
                            <div class="col-md-12 py-2">
                                <input id="link_referenc" class="form-control "
                                    value='https://app.smartblessingcloud.com/?Registro&ref=<?php echo $link['hash_para_enlance'] ?>'
                                    disabled>
                                <br>
                                <input type="submit" onclick="ejecutar()" value="Copiar link"
                                    class="btn btn-sm btn-dark ">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 pb-5">
                <div class="add-balance-area pd-top-40">
                    <div class="ba-add-balance-inner bg-white" id="">
                        <h6 class="title">Historial de transacciones</h6>
                        <div class="lds-ring spinner" id="spinner-load-generar-table">
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                        <section id="section_table" hidden>
                            <table id="transaciones" class="table table-hover table-fixed nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Usuario</th>
                                        <th>fecha</th>
                                        <th>Referidos</th>
                                        <th>Nivel</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                    </tr>
                                </tbody>
                            </table>
                        </section>
                        <script>
                            $(document).ready(function () {
                                actualizar_transaciones_tabla_referido()
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php
} else {
    echo 1;
}
?>