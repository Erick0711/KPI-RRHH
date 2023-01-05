<?php

function agregarIndicador()
{
    include('./conexion.php');

}
function agregarConcepto($descripcion)
{
    include("./conexion.php");
    $busqueda = $conexion->prepare("SELECT descripcion FROM prueba WHERE descripcion = '$descripcion'");
    $busqueda->execute();
    $registros = $busqueda->fetchAll(PDO::FETCH_ASSOC);
    // echo $registros['descripcion'];
    if(empty($registros)){
        $sentencia = $conexion->prepare("INSERT INTO prueba (id,
            descripcion) 
            VALUES(NULL, 
            '$descripcion')");
            $sentencia->execute();
    }else{
        foreach ($registros as $registro) {
            if ($registro['descripcion'] == $descripcion){
            }
        }
    }
}

function agregarKpi($concepto,$periodo,$valor)
{
    // echo $concepto,$periodo,$valor;
    include("./conexion.php");

    $buscadorConcepto = $conexion->prepare("SELECT * FROM prueba WHERE descripcion='$concepto'");
    $buscadorConcepto->execute();
    $registros = $buscadorConcepto->fetchAll(PDO::FETCH_ASSOC);
    $idConcepto = $registros[0]['id'];

    $igualdadDato = $conexion->prepare("SELECT * FROM rrhh_datos WHERE concepto_id = '$idConcepto' AND periodo = '$periodo' AND valor = '$valor'");
    $igualdadDato->execute();
    $igualdad = $igualdadDato->fetchAll(PDO::FETCH_ASSOC);

    switch (!empty($registros)) {
        case empty($igualdad):
            $sentencia = $conexion->prepare("INSERT INTO rrhh_datos (id,
            concepto_id,
            periodo,
            valor) 
            VALUES(NULL, 
            '$idConcepto',
            '$periodo',
            '$valor')");
            $sentencia->execute(); 
            break;
        case !empty($igualdad):
                if($igualdad[0]['concepto_id'] == $idConcepto && $igualdad[0]['periodo'] == $periodo && $igualdad[0]['valor'] == $valor){
                    echo "El dato ya existe";
                }
            break;
        default:
            echo "El array de los registros concepto esta vacio";
            break;
    }

}
function convertirArreglo()
{
    // OBTENER EL DATO DEL POST Y CONVERTIRLO A UN ARRAY
    if (isset($_POST)) {
        $dato = $_POST['datos'];
        $convertir = explode("\n", $dato);
        $i = 0;
        $j = 0;
        foreach ($convertir as $variable) {
            $convertir[$i] = explode("\t", $variable);
            $convertir[$i][0] = $j;
            $j++;
            $i++;
        }
        var_dump($convertir);
    }
}
convertirArreglo();
die();
function obtener()
{
    
    $arreglo = convertirArreglo();
    $longitud = count($arreglo[1]);

    // print_r($arreglo);
    for ($i=0; $i < $longitud ; $i++) { 
        unset($arreglo[$i][0]);
    }


    $conceptoArreglo = array();
    $datoConcepto = "";

    for ($i = 1; $i < 3; $i++) { 
        $concepto = $arreglo[$i][1];
        $datoConcepto = $concepto;
        agregarConcepto($datoConcepto);

        array_push($conceptoArreglo, $concepto);
    }
    // print_r($conceptoArreglo);
    
    $valor = $arreglo;

    $valorArreglo = array();


    for ($i = 1; $i < 3; $i++) { 
        $valor = $arreglo[$i];
        array_push($valorArreglo, $valor);
    }

    $fechas = $arreglo[0];
    $fecha = end($fechas);

    $datos = array($conceptoArreglo, $fecha, $valorArreglo);
    return $datos;
}

$arreglo = obtener();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

</head>

<body>
    <a href="./index.php">Volver</a>
    <div class="container">
        <div class="table-responsive">
            <form action="./Enviar.php" method="POST">
                <table class="table table-bordered table-primary">
                    <thead class="text-center">
                        <tr>
                            <th>CONCEPTO</th>
                            <th>FECHA</th>
                            <th>VALOR</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php list($concepto, $fecha, $valores) = $arreglo;?>
                        <?php for ($i = 0; $i < count($concepto); $i++) {  ?>
                            <tr>
                                <td><?php echo $concepto[$i] ?></td>
                                <td><?php echo $fecha ?></td>
                                <td><?php echo end($valores[$i]) ?></td>
                            </tr>
                        <?php 
                        agregarKpi($concepto[$i],$fecha,end($valores[$i]));
                    } ?>
                    </tbody>
                </table>
            </form>
