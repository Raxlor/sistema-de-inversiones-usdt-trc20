<?php
session_start();
include 'assets/db/db.php';

// archivo encargado de manejar todo como siempre primero solicitamos la la session
// confirmo de que exista la session
// $_SESSION['id_acceso_cliente']=6;


if (isset($_GET['deslog'])) {
    session_destroy();
    header('location: /');
} elseif (isset($_GET['ref'])) {
    session_destroy();
    include_once 'vistas/login.php';

} elseif (isset($_SESSION['id_acceso_cliente'])) {

?>
<!DOCTYPE html>
<html lang="es">
<style>
    body {
        background: url(https://i.ibb.co/k0W4jcg/Background-2.jpg)
    }
</style>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes" />
    <title>
        <?php print $name_Web_title; ?>
    </title>
    <link rel="icon"
        href="https://smartblessingcloud.com/wp-content/uploads/2022/09/cropped-cropped-logo-icon-32x32.png"
        sizes="32x32">
    <link rel="stylesheet" href="assets/css/vendor.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <!-- jQuery first, then Bootstrap JS. -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js" charset="utf-8"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js" charset="utf-8"></script>
    <script src="./../assets/js/vendor.js"></script>
    <script src="./assets/js/script.js"></script>
    <!-- jQuery first, then Bootstrap JS. -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/js/bootstrap.min.js"
        integrity="sha384-vZ2WRJMwsjRMW/8U7i6PWi6AlO1L79snBrmgiDpgIWJ82z8eA5lenwvxbMV1PAh7" crossorigin="anonymous">

        </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.37/sweetalert2.css"
        integrity="sha512-XUrMHw+dQMt2eVDMOvfUNxMhe5oUvZLU1krzGAXFiY4CGV4mHEm9K4JVJj1Kw3VekCOpMVDCPL3HJ1Eqw6pD9A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.37/sweetalert2.min.js"
        integrity="sha512-hMhiMG2V37nTipBqREV4+PdbKWnM3qXH9JPcD4s+YC9FStVfOMAyPvZ5tWx/SacBtHjTSsVvx7lg6CBUox1ZEA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- JavaScript -->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <!-- CSS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <!-- Default theme -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/themes/bootstrap.min.css"
        integrity="sha512-6xVTeh6P+fsqDhF7t9sE9F6cljMrK+7eR7Qd+Py7PX5QEVVDLt/yZUgLO22CXUdd4dM+/S6fP0gJdX2aSzpkmg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"
        integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <style>
        .ajs-message {
            border-radius: 10px !important;
        }

        .no-border {
            border: 0 !important;
        }

        .swal2-html-container {
            overflow: inherit !important;
        }
    </style>
    <script>
        alertify.set('notifier', 'position', 'top-center');
    </script>
</head>

<body id="body-global">
</body>

</html>
<?php
} else {
    include_once 'vistas/login.php';
}

?>