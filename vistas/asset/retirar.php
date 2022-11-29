<?php
session_start();
include '../../vistas/asset/header.html';
include '../../assets/db/db.php';
include '../../assets/php/funciones.php';
$id = $_SESSION['id_acceso_cliente'];

$sql = "SELECT `Bono_recibido`,disponible FROM `usuario` WHERE `id`=$id";
$data_fecha = mysqli_fetch_array(mysqli_query($conexion, $sql));
?>
<main class="custom-height">
    <div class="container">
        <div class="balance-area-bg balance-area-bg-home">
            <div class="balance-title text-center">
                <h6>Area de retiro</h6>
            </div>
            <div class="ba-balance-inner text-center slider-card-usdt">
                <div style="height: 50px;width: 50px;display: inline-block;line-height: 48px;margin-bottom: 13px; visibility: hidden;">
                    <img src="#" alt="img">
                </div>
                <h5 style="color: white !important;">Billetera Disponible <span class="">
                        <?php echo '$ ' . number_format($data_fecha[1], 2) ?>
                    </span>
                </h5>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="add-balance-area pd-top-40">
                    <div class="ba-add-balance-inner bg-white p-2" id="">
                        <h6>Formulario de retiro</h6>
                        <?php
                    if (days_block()) {
                        ?>
                            <form action="">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="">Wallet</label>
                                        <input type="text" value="" class="form-control" disabled>
                                    </div>
                                    <div class="col-6">
                                        <label for="">Monto</label>
                                        <input type="text" class="form-control">
                                    </div>

                                </div>
                            </form>
                 <?php }else {
                 ?>
                 <h6>Los retiros se habilitaran los viernes de 6 am  a 6 pm</h6>
                    <?php
                 }?>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="add-balance-area pd-top-40">
                    <div class="ba-add-balance-inner bg-white p-2" id="">
                        <h6>Historial de retiros</h6>
                        <div class="lds-ring spinner" id="spinner-load-generar-table">
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                        <section id="section_table" hidden>
                            <table id="contratos" class="table table-hover table-fixed nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Inversion</th>
                                        <th>Capital</th>
                                        <th>recibido</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                            </table>
                        </section>
                        <script>
                            setTimeout(() => {
                                actualizar_contrato_tabla()
                            }, 500);
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>