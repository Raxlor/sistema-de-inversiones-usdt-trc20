<?php
session_start();
//session_start();
include '../../assets/db/db.php';
$id = $_SESSION['id_acceso_cliente'];

$sentence = "SELECT * FROM `usuario` WHERE `id`=$id";
$query = mysqli_query($conexion, $sentence);
$data_user = mysqli_fetch_array($query);
include '../../vistas/asset/header.html';
?>

<main class="custom-height">
    <!-- balance start -->
    <div class="container">
        <div class="balance-area-bg balance-area-bg-home">
            <div class="balance-title text-center">
                <h6>Bienvenidos! <br>
                    <?php echo ' ' . ucwords($data_user['nombre']) ?>
                </h6>
            </div>
            <div class="ba-balance-inner text-center" style="background-image: url(assets/img/bg/2.png);">
                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <h5 class="title">Billetera Disponible <br>

                                <span class="amount d-block w-100">
                                    <?php echo '$ ' . number_format($data_user['disponible'], 2) ?>
                                    <img src="https://static.tronscan.org/production/logo/usdtlogo.png" alt=""
                                        width="20px">
                                </span>
                        </div>
                        <div class="carousel-item">
                            <h5 class="title">Billetera Deposito <br>
                                <span class="amount d-block w-100">
                                    <?php echo '$ ' . number_format($data_user['wallet_persona'], 2) ?>
                                    <img src="https://static.tronscan.org/production/logo/usdtlogo.png" alt=""
                                        width="20px">
                                </span>
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </a>
                </div>


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
            <div class="col-md-6">
                <div class="row">

                    <div class="col-md-12 col-sm-12">
                        <div class="add-balance-area pd-top-40">
                            <div class="ba-add-balance-inner   bg-white">
                                <div class="row custom-gutters-20">
                                    <div class="col-6">
                                        <a class="btn btn-dark " href="javascript:void()" onclick="perfil()">Perfil <i
                                                class="fas fa-user"></i> </a>
                                    </div>
                                    <div class="col-6">
                                        <a class="btn btn-dark " href="javascript:Mantenimiento()">Historial <i
                                                class="fa fa-history"></i></a>
                                    </div>
                                    <div class="col-6">
                                        <a class="btn btn-dark" href="javascript:void(0)" onclick="deposito()">Depositar
                                            <i class="fas fa-money-check"></i></a>
                                    </div>
                                    <div class="col-6">
                                        <a class="btn btn-dark " href="javascript:Mantenimiento()">Retirar <i
                                                class="fas fa-handshake"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 ">
                <div class="add-balance-area pd-top-40 ">
                    <div class="ba-add-balance-inner  bg-white">
                        <div class="col-md-12 ">
                            <h3 class="text-center">Membresía</h3>
                            <?php
                            /* Comprobar si el usuario tiene contrato. */
                            $sql = "SELECT COUNT(*),SUM(`cantidad`) FROM `contractos` WHERE `id_user`=$id and`estado`=1";
                            $data = mysqli_fetch_array(mysqli_query($conexion, $sql));
                            if ($data == 0) {
                            ?>
                            <button type="button" onclick="inversion()"
                                class="btn btn-smart-login text-white">Iniciar</button>
                            <?php
                            } else {
                            ?>
                            <div class="row">
                                <div class=" col-6">
                                    <span class="amount d-block w-100">
                                        Monto Actual:
                                        <?php echo '$ ' . number_format($data[1], 2) ?>
                                        <img src="https://static.tronscan.org/production/logo/usdtlogo.png" alt=""
                                            width="20px">
                                    </span>
                                </div>
                                <div class=" col-6">
                                    <span class="amount d-block w-100">
                                        Membresias activas:
                                        <?php echo $data[0] ?>
                                    </span>
                                </div>
                                <div class="col-md-12">
                                    <canvas id="myChart" width="100%" height="75%"></canvas>
                                </div>
                            </div>
                            <button type="button" onclick="inversion()" class="btn btn-dark btn-sm text-white">Area de
                                membresía</button>
                            <?php
                                }
 ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
if ($data !== 0) {
    $sql = "SELECT SUM(`monto`),`id_user`,DATE_FORMAT(`fecha`,'%a') FROM `historico_diario` WHERE `id_user`=$id GROUP BY `id_user`, DATE_FORMAT(`fecha`, '%Y-%m-%d') ORDER BY DATE_FORMAT(`fecha`,'%d') ASC;";
    $query = mysqli_query($conexion, $sql);
    $a = 1;
    while ($data = mysqli_fetch_array($query)) {
        if ($a < 2) {
            $label = "'" . $data[2] . "'";
            $valor = $data[0];
        } else {
            $label .= ",'" . $data[2] . "'";
            $valor .= ',' . $data[0];
        }
        $a++;
    }
?>
<script>
    $('.carousel').carousel({
        interval: 2000
    })
</script>
<?php include '../../vistas/asset/footer.php'; ?>
<script>
    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [<?php echo $label ?>],
            datasets: [{
                label: 'Roi Diarios',
                data: [<?php echo $valor ?>],
                backgroundColor: [
                    '#2c304d'
                ],
                borderColor: [
                    '#2c304d'
                ],
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: false
                }
            }
        }
    });
</script>
<?php
}
?>