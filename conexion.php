<?php
function Conexion(){
            $server = "127.0.0.1";
            $user = "root";
            $name = "kpi_rrhh";
            $password = "";

            $conexion = new PDO("mysql:host=$server;dbname=$name",$user,$password);
            return $conexion;
        }
?>
