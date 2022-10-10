<?php

try {
  /* Este es un conjunto de variables que se utilizan en el código. */
  $name_Web_title = "Smart Blessing Consulting";
  $key_encryp = "Cu4lQu3rt@kenD3S3guriD4D";
  $api_uri = "https://sbc-wallet-api.herokuapp.com/";
  $produccion = true;
  $url = $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
  date_default_timezone_set("America/Santo_Domingo");
  /* Una declaración condicional que comprueba si la variable ón es verdadera o falsa. Si es
  verdadero, utilizará el primer conjunto de credenciales, si es falso, utilizará el segundo conjunto
  de credenciales. */
  if ($produccion) {
    $host = "44.211.147.161";
    $dbname = "smartblessingclo_inversiones";
    $user = "smartblessingclo_sbc-inversiones";
    $pass = "jumpjet1503";
  } else {
    $host = "localhost";
    $dbname = "inversion";
    $user = "root";
    $pass = "";
  }

  /* Conexión a la base de datos. */
  $conexion = mysqli_connect($host, $user, $pass, $dbname);
  mysqli_set_charset($conexion, 'utf8');
  $error_message = mysqli_errno($conexion);
} catch (Exception $e) {

  echo 'Excepción capturada: ',  $e->getMessage(), "\n";
}
