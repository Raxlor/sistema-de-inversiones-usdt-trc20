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
?>
<main class="custom-height">

    <div class="container">
        <div class="balance-area-bg balance-area-bg-home">
            <div class="balance-title text-center">
                <h6>Area de membresías</h6>
            </div>
            <div class="ba-balance-inner text-center slider-card-usdt">
                <div style="height: 50px;width: 50px;display: inline-block;line-height: 48px;margin-bottom: 13px; visibility: hidden;">
                    <img src="#" alt="img">
                </div>
                <h5 style="color: white !important;">Disponible <span class=""><?php echo '$ ' . number_format($monto[0], 2) ?></span>
                </h5>
            </div>
        </div>
        <div class="row">


            <div class="col-md-6 col-sm-12">
                <div class="add-balance-area pd-top-40">
                    <div class="ba-add-balance-inner bg-white" id="">
                        <h6 class="title"></h6>
                   <!-- * Un control giratorio que está oculto hasta que se envía el formulario. */ -->
                        <div class="lds-ring spinner" id="spinner-load-generar-table-two" hidden>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                        <form action="javascript:activar_form_inv()" id="id_inversiones">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <h6>USDT:
                                        <span> <?php echo number_format($monto[0], 2) ?>
                                            <img src="https://static.tronscan.org/production/logo/usdtlogo.png" alt="" width="20px">
                                        </span>
                                    </h6>
                                </div>
                                <div class="col-md-6 col-xs-6  my-2">
                                    <input class="form-control" type="number" name="" id="mont_id" min="10" step="10" placeholder="Monto a Invertir" required>
                                </div>

                                <div class="col-md-6 col-xs-6 my-2">
                                    <select class="form-control" name="" id="produc_id" required>
                                        <option value="">Selecionar Producto</option>
                                        <?php
                                        $sql_productos = "SELECT * FROM `productos` WHERE 1";
                                        $query = mysqli_query($conexion, $sql_productos);
                                        while ($productos = mysqli_fetch_array($query)) {
                                        ?>
                                            <option value="<?php echo $productos[1] ?>"><?php echo $productos[1] ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-12 my-2">
                                    <button class="btn btn-smart-login text-white" type="submit">aceptar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
            <div class="col-md-6 col-sm-12">
                <div class="add-balance-area pd-top-40">
                    <div class="ba-add-balance-inner bg-white" id="">
                        <h6 class="title">Inversiones</h6>
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
                            $(document).ready(function() {
                                actualizar_contrato_tabla()
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include '../../vistas/asset/footer.php';  ?>