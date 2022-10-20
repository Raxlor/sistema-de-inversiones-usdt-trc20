<?php
session_start();
if (isset($_SESSION['id_acceso_cliente'])) {
    include '../../assets/db/db.php';
    $id = $_POST['id'];
    $sql = "SELECT * FROM `productos` WHERE `id`=$id";
    $data = mysqli_fetch_array(mysqli_query($conexion, $sql));
?>
<div class="row">
    <div class="col-md-6 col-6" style='font-size: small;'>Deposito minimo: <span class="color-succes">
            <?php echo $data['min-deposito'] ?>
        </span></div>
    <div class="col-md-6 col-6" style='font-size: small;'> Multiplos de: <span class="color-succes">
            <?php echo $data['multiplo'] ?>
        </span>
    </div>
</div>
<table class="table table-sm my-2">
    <thead class="thead-dark">
        <tr>
            <th scope="col">Mensual</th>
            <th scope="col">Semanal</th>
            <th scope="col">diario</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th scope="row">
                <?php echo $data[2] ?>%
            </th>
            <td>
                <?php echo $data[2] / 4 ?>%
            </td>
            <td>
                <?php echo $data[2] / 20 ?>%
            </td>
        </tr>
    </tbody>
</table>
<cite style="font-size: small;">Las inversiones comienzan a generar en 48 horas automaticamente</cite>
<cite style="font-size: small;">Los rendimiento de la membresia estaran activo hasta 6 meses, hasta llegar al porcentaje
    de
    <?php echo $data[2] * 6 ?>%
</cite>
<?php
} else {
    header("Content-Type: application/json");
    http_response_code(204);
}