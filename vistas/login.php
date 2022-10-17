<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes" />
    <link rel="icon" href="https://smartblessingcloud.com/wp-content/uploads/2022/09/cropped-cropped-logo-icon-32x32.png" sizes="32x32">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>
        <?php echo $name_Web_title ?>
    </title>
    <!-- Stylesheet File -->
    <link rel="stylesheet" href="assets/css/vendor.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="stylesheet" href="assets/css/responsive.css">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.37/sweetalert2.css" integrity="sha512-XUrMHw+dQMt2eVDMOvfUNxMhe5oUvZLU1krzGAXFiY4CGV4mHEm9K4JVJj1Kw3VekCOpMVDCPL3HJ1Eqw6pD9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.37/sweetalert2.min.js" integrity="sha512-hMhiMG2V37nTipBqREV4+PdbKWnM3qXH9JPcD4s+YC9FStVfOMAyPvZ5tWx/SacBtHjTSsVvx7lg6CBUox1ZEA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

</head>

<body>

    <main class="custom-height">
        <div class="signin-area">

            <div class="container">

                <div class="row align-items-center align-content-lg-center justify-content-center">

                    <div class="col-sm-12 col-md-6 ">
                        <div style="text-align-last: center;    padding: 5%;">
                            <img src="https://app.smartblessingconsulting.com/app-assets/images/ico/logo-img.png" alt="">
                        </div>
                        <?php

                        ?>
                        <section class="contact-form-inner login_form">

                            <?php
                            if (isset($_GET['Registro'])) {
                                include './html/registro.html';
                            } elseif (isset($_GET['verificar'])) {
                                require_once ('./assets/php/funciones.php');
                                
                                 var_dump(
                                 validar_codigo($_GET['verificar'])
                                 );
                            } else {
                                // indentifico si es un login normal o un intento de registro
                                require_once 'html/form_login.html';
                            }
                            ?>
                        </section>
                    </div>
                </div>
            </div>
        </div>


        <script src="assets/js/vendor.js"></script>

        <script src="assets/js/main.js"></script>
        <script src="../assets/js/puglins/jquery.password-validation.js"></script>
        <script>
            setTimeout(() => {
                alertify.set('notifier', 'position', 'top-center');
            }, 500);

            function resert_password() {
                Swal.fire({
                    title: 'Correo eletronico de la cuenta',
                    input: 'email',
                    inputAttributes: {
                        autocapitalize: 'on'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Enviar',
                    showLoaderOnConfirm: true,
                    preConfirm: (login) => {
                        let formData = {
                            email: login,
                            valor: 1,
                        };
                        $.ajax({
                            type: "POST",
                            url: 'control/helpers/reset_password.php',
                            data: formData,
                            beforeSend: function() {},
                            success: function(resp) {

                                if (resp.status) {
                                    swal.fire("Enviado!", "Revise su correo electronico!", "success");
                                } else {
                                    swal.fire("No tiene cuenta!", "no tiene cuenta, con nosotro, puede registrate", "error");
                                }
                            },
                            error: function(error) {
                                alertify.error(error);
                            },
                        });
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.isConfirmed) {

                    }
                })
            }
            <?php if (isset($_GET['restablecer'])) {
                echo "resert_password()";
            } ?>
        </script>
        <!-- JavaScript -->
        <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
        <!-- CSS -->
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
        <!-- Default theme -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/themes/bootstrap.min.css" integrity="sha512-6xVTeh6P+fsqDhF7t9sE9F6cljMrK+7eR7Qd+Py7PX5QEVVDLt/yZUgLO22CXUdd4dM+/S6fP0gJdX2aSzpkmg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        </script>
        <style>
            .ajs-message {
                border-radius: 10px !important;
            }
        </style>
</body>

</html>