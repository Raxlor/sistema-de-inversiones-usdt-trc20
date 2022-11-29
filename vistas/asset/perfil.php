<?php
session_start();
include '../../vistas/asset/header.html';
include '../../assets/db/db.php';
try {
    $id = $_SESSION['id_acceso_cliente'];
    $select = "SELECT usuario.*,COUNT(contractos.id_user) as cuenta,SUM(contractos.cantidad) as invertido,SUM(contractos.recibido) as recibido FROM `usuario` INNER join contractos on usuario.id=contractos.id_user where usuario.id=$id and contractos.estado=1 GROUP by contractos.id_user";
    $data = mysqli_fetch_array(mysqli_query($conexion, $select));
    if (is_null($data['cuenta'])) {
    }
    $es_falso = is_null($data['cuenta']);
    if ($es_falso == false) {
        $porcent = number_format(($data['recibido'] * 100) / $data['invertido'], 2, ',');
    } else {
        $select = "SELECT usuario.*,SUM(0) as cuenta,SUM(0) as invertido,SUM(0) as recibido FROM `usuario` where usuario.id=$id";
        $data = mysqli_fetch_array(mysqli_query($conexion, $select));
    }
} catch (Exception $e) {
    echo 'Excepción capturada: ',  $e->getMessage(), "\n";
}

?>
<main class="custom-height">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="card-custom">
                    <div class="add-balance-area pd-top-40">
                        <div class="ba-add-balance-inner   bg-white">
                            <div class="row custom-gutters-20 p-2">
                                <div class="col-12 pb-2 " style="text-align: center ;">
                                    <img src="https://festivalcineindependiente.com/img/headshots/no-profile-image.jpg"
                                        style="width: 100px;border-radius: 100px;">
                                </div>
                                <div class="col-6 my-2">
                                    Nombre:
                                    <?php echo $data['nombre']; ?>
                                </div>
                                <div class="col-6 my-2">
                                    Email:
                                    <?php echo $data['email']; ?>
                                </div>
                                <div class="col-6 my-2">
                                    fecha de registro:
                                    <?php echo $data['fecha_registro']; ?>
                                </div>
                                <div class="col-12 my-2">
                                    <button type="submit" onclick="Mantenimiento()"
                                        class="btn btn-dark">modificar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if ($data['cuenta'] > 0) {
                ?>
                <div class="card-custom">
                    <div class="add-balance-area pd-top-40">

                        <div class="ba-add-balance-inner   bg-white">
                            <div class="lds-ring spinner2" id="spinner-load-generar-contrato">
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                            <section hidden id="contrato">
                                <div class="row">
                                    <div class="col-md-9 col-xs-6">
                                        <div class="row">
                                            <div class="col-12">
                                                <h5>Inversiones</h5>
                                            </div>
                                            <div class="col-6">
                                                <p>Contratos:
                                                    <?php echo $data['cuenta'] ?>
                                                </p>
                                            </div>
                                            <div class="col-6">
                                                <p>Capital invetido:
                                                    <?php echo $data['invertido'] ?>
                                                </p>
                                            </div>
                                            <div class="col-6">
                                                <p>Recibido:
                                                    <?php echo $data['recibido'] ?>
                                                </p>
                                            </div>
                                            <div class="col-12 ">
                                                <button type="button" onclick="inversion()"
                                                    class="btn btn-smart-login text-white">Area de membresias</button>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-3 col-xs-6">
                                        <?php include '../../vistas/asset/whater_porcent.html' ?>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
                <?php  } else {
                ?>
                <div class="card-custom">
                    <div class="add-balance-area pd-top-40">
                        <div class="ba-add-balance-inner   bg-white">
                            <div class="row custom-gutters-20 p-2">
                                <h6>No existen contrato activo</h6>
                                <button type="button" onclick="inversion()" class="btn btn-smart-login text-white">Area
                                    de membresias</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                } ?>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="add-balance-area pd-top-40">
                    <div class="ba-add-balance-inner   bg-white">
                        <div class="row custom-gutters-20 p-2">
                            <div class="row">
                                <div class="col-md-12 py-2">
                                    <h5>Link de Referencia</h5>
                                </div>
                                    <?php
                                    $sql="SELECT count(*) as cuenta,hash_para_enlance FROM `link_referido` WHERE `enlace_primario`=$id";
                                    $link=mysqli_fetch_array(mysqli_query($conexion,$sql));
                                    if ($data['cuenta'] > 0 && $link['cuenta']>0) {
                                    ?>
                                <div class="col-md-12">
                                    <input id="link_referenc" class="form-control" value='https://app.smartblessingcloud.com/?Registro&ref=<?php echo $link['hash_para_enlance']?>' disabled>
                                </div>
                                <div class="col-md-12 py-2">
                                    <input type="submit" onclick="ejecutar('https://app.smartblessingcloud.com/?Registro&ref=<?php echo $link['hash_para_enlance']?>')" value="Copiar link" class="btn btn-sm btn-dark ">
                                </div>
                                <?php
                              }elseif ($data['cuenta'] > 0) {
                              ?>
                                  </div>
                                     <button type="submit" onclick="link_referido()" class="btn btn-dark text-white">Optener link</button>
                                  <div class="row">
                              <?php
                               } else {
                                require_once '../../assets/php/funciones.php';
                                ?>
                              <div class="col-md-12">
                                    <h6>
                                    Para participar en el plan de recomendación, le solicitamos realizar su membresía.
                                </h6>
                                </div>
                               <?php
                                 }
                              ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>
<script src="../../assets/js/main.js"></script>
<script>
    setTimeout(() => {
        waterpercent(<?php echo $porcent ?>)
    }, 500);
 
</script>
<style>
    .spinner2 {
        margin: 7px 41%;

        position: relative;
        text-align: center;
        animation: sk-rotate 2s infinite linear;
    }
</style>
