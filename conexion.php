<?php
$conexion = new PDO("mysql:host=127.0.0.1;dbname=kpi_rrhh","root","");
print_r($conexion);
die();
$sentencia = $conexion->prepare("INSERT INTO prueba (`id`,`descripcion`, VALUES (NULL,'como'");
$sentencia->execute();

?>