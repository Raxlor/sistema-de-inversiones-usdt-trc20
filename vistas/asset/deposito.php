<?php
session_start();
include '../../vistas/asset/header.html';
include '../../assets/db/db.php';
$id = $_SESSION['id_acceso_cliente'];
// para update o/y insert
$sentence = "SELECT `wallet_persona` FROM `usuario` WHERE `id`=$id";
if (mysqli_query($conexion, $sentence)) {
    $monto = mysqli_fetch_array(mysqli_query($conexion, $sentence));
} else {
    echo '<script type="text/JavaScript">
    location.href="/";
    </script>';
}
$sql_verificar = "SELECT count(*) FROM `transacciones` WHERE `id_user`= $id and razon='Deposito USDT' and `status` = 'pendiente'";
$query=mysqli_query($conexion,$sql_verificar);
$data=mysqli_fetch_array($query);
if ($data[0]>0) {
   echo '<script>Generar_wallet()</script>';
}
?>
<main class="custom-height">
    <!-- balance start -->
    <!-- <div class="balance-area"> -->
    <div class="container">
        <div class="balance-area-bg balance-area-bg-home">
            <div class="balance-title text-center">
                <h6>Area de deposito</h6>
            </div>
            <div class="ba-balance-inner text-center slider-card-usdt" >
                <div style="height: 50px;width: 50px;display: inline-block;line-height: 48px;margin-bottom: 13px; visibility: hidden;">
                    <img src="#" alt="img">
                </div>
                <h5 style="color: white !important;">Disponible <span class=""><?php echo '$ ' . number_format($monto[0], 2) ?></span>
                </h5>


            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="add-balance-area pd-top-40">
                    <div class="ba-add-balance-inner bg-white" id="">
                        <div class="lds-ring spinner" id="spinner-load-generar" hidden>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                        <section id="wallet_deposit">
                        </section>
                        <button onclick="Generar_wallet()" class="btn btn-smart-login text-white">Depositar
                        </button>

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
                                        <th>#</th>
                                        <th>razon</th>
                                        <th>status</th>
                                        <th>monto</th>
                                        <th>fecha</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>

                                    </tr>

                                </tbody>

                            </table>

                        </section>
                        <script>
                            $(document).ready(function() {
                                actualizar_transaciones_tabla_orden()
                            });
                        </script>

                    </div>
                </div>

            </div>
        </div>
    </div>
</main>
<style>
.slider-card-usdt {
    background-image: url(https://img.freepik.com/vector-premium/simbolo-token-atadura-icono-moneda-usdt-circulo-digital-tema-criptomoneda-sobre-fondo-azul-oro-digital-estilo-futurista-sitio-web-o-banner-copie-espacio-eps10-vectorial_337410-1040.jpg?w=2000)!important;
    background-position-y: 50%!important;
    background-position-x: center!important;
}
</style>
<?php include '../../vistas/asset/footer.php';  ?>
