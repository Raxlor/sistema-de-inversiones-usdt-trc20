<?php
session_start();
//session_start();
include '../../assets/db/db.php';
$id = $_SESSION['id_acceso_cliente'];

$sentence  = "SELECT * FROM `usuario` WHERE `id`=$id";
$query = mysqli_query($conexion, $sentence);
$data_user = mysqli_fetch_array($query);
include '../../vistas/asset/header.html';
?>

<main class="custom-height">
    <!-- balance start -->
    <div class="container">
        <div class="balance-area-bg balance-area-bg-home">
            <div class="balance-title text-center">
                <h6>Bienvenidos! <br> <?php echo ' ' . $data_user['nombre'] ?> </h6>
            </div>
            <div class="ba-balance-inner text-center" style="background-image: url(assets/img/bg/2.png);">

                <h5 class="title">Billetera personal <br>
                    <span class="amount"><?php echo '$ ' . number_format($data_user['wallet_persona'], 2) ?>
                        <img src="https://static.tronscan.org/production/logo/usdtlogo.png" alt="" width="20px"> </span>
                </h5>
                <?php $fale = 0;
                if ($fale === 1) {
                ?>
                    <!--
                        <h5 class="text-succes">Total Inventido</h5><span class="amount"><?php echo '$ ' . number_format(2500, 2) ?></span>
                        <h6 class="title">Contratos</h6><span class="amount"><?php echo 5 ?></span>
                    -->
                <?php
                }
                ?>
            </div>
        </div>
        </dv>
    </div>

    <!-- add balance start -->
    <div class="container">
        <div class="row">

            <div class="col-md-6 col-sm-12">
                <div class="add-balance-area pd-top-40">
                    <div class="ba-add-balance-inner   bg-white">
                        <div class="row custom-gutters-20">
                            <div class="col-6">
                                <a class="btn btn-dark " href="javascript:void()" onclick="perfil()">Perfil</a>
                            </div>
                            <div class="col-6">
                                <a class="btn btn-dark " href="javascript:Mantenimiento()">Historial <i class="fa fa-history"></i></a>
                            </div>
                            <div class="col-6">
                                <a class="btn btn-dark" href="javascript:void(0)" onclick="deposito()">Depositar <i class="fas fa-money-check"></i></a>
                            </div>
                            <div class="col-6">
                                <a class="btn btn-dark " href="javascript:Mantenimiento()">Retirar <i class="fas fa-handshake"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 ">
                <div class="add-balance-area pd-top-40 ">
                    <div class="ba-add-balance-inner  bg-white">
                        <div class="col-md-12 ">
                            <h3 class="text-center">Membresias</h3>
                            <button type="button" onclick="inversion()" class="btn btn-smart-login text-white">Iniciar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include '../../vistas/asset/footer.php';  ?>