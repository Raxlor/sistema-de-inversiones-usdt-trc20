<?php
session_start();
/* Comprobando si la sesión está configurada. */
include '../../vistas/asset/header.html';
include '../../assets/db/db.php';
$id = $_SESSION['id_acceso_cliente'];
if (isset($_SESSION['id_acceso_cliente'])) {
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
                <!--<h5 style="color: white !important;">Disponible <span class=""><?php echo '$ ' . number_format($monto[0], 2) ?></span>
                </h5> -->
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
                            <div class="col-6">Rango Actual: 2 </div>
                            <div class="col-6">Referidos Actuales: 7 </div>
                            <div class="col-12 pt-2 pb-2">
                                <div class="progress">

                                    <div class="progress-bar progress-bar-striped progress-bar-animated "
                                        role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"
                                        style="width: 100%">
                                        <span class="text-center">
                                            Rango maximo
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <hr>
                            </div>
                            <div class="col-12">Capital de patrocinio:
                                <?php echo '$ ' . number_format(15000, 2) ?>
                            </div>
                            <div class="col-6 pt-2">Bono recibido:
                                <?php echo number_format(100, 2) ?>
                            </div>
                            <div class="col-6 pt-2">Bono maximo:
                                <?php echo number_format(1000, 2) ?>
                            </div>
                            <div class="col-12 pt-2">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated "
                                        role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"
                                        style="width: 50%">
                                        50%
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
            <div class="col-md-6 col-sm-12">
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