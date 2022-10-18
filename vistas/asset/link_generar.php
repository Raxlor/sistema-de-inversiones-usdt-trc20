<?php 
session_start();


if (isset($_SESSION['id_acceso_cliente'])) {
   
    include '../../assets/php/funciones.php';
    generar_link_referencia($_SESSION['id_acceso_cliente'],1);
   
}


?>