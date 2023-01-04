<?php
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
    if(isset($registros)){
        $idConcepto = $registros[0]['id'];
        $sentencia = $conexion->prepare("INSERT INTO rrhh_datos (id,
        concepto_id,
        periodo,
        valor) 
        VALUES(NULL, 
        '$idConcepto',
        '$periodo',
        '$valor')");
        $sentencia->execute();
    }else{
        echo "No existe el concepto";
    }
}
$fecha = ['202101',	'202102', '202103',	'202104', '202105', '202106', '202107',	'202108', '202109',	'202110', '202111','202112', '202201', '202202', '202203',	'202204', '202205',	'202206', '202207', '202208', '202209',	'202210','202211','202212'];
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
        return $convertir;
    }
}

function obtener()
{
    // RETURNA TODO EL ARRAY CONVERTIDO DE LA FUNCION
    $convertir = convertirArreglo();
    $fecha = $convertir[0]; # ME TRAE DE MANERA MANUAL TODAS LAS FECHAS QUE ESTAN EN LA POSICION 0
    $valor = $convertir[1]; # ME TRAE DE MANERA MANUAL TODOS LOS VALORES QUE ESTAN EN LA POSICION 1

    for($i = 1; $i < count($valor); $i++ ){
        print_r($convertir[$i]);
    }

    for ($i = 0; $i < 2; $i++) 
    {
        unset($fecha[$i]);  # RECORRO PARA ELIMINAR LOS CAMPOS VACIOS O NULOS
        unset($valor[$i]);
    }
    // $valores = array_values($valor); 
    // print_r($valores);
    die();

    $fechas = array_values($fecha);
    // print_r($valores);
    $conceptoArreglo = array();
    $datoConcepto = "";

    for ($i = 1; $i < 3; $i++) {  # RECORRO PARA TRAER SOLO LOS CONCEPTOS DE FORMA MANUAL 
        $concepto = $convertir[$i][1];
        $datoConcepto = $concepto;
        agregarConcepto($datoConcepto);

        array_push($conceptoArreglo, $concepto); # CONVIERTO LO ENCONTRADO A UN ARREGLO Y LO CARGO AL A VARIABLE CONCEPTOARREGLO
    }

    $arreglo = array($fechas, $valores, $conceptoArreglo);
    return $arreglo;
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
                        <?php
                        list($fechas, $valores, $conceptos) = $arreglo;
                        ?>
                        <?php for ($i = 0; $i < count($fechas); $i++) {  ?>
                            <tr>
                                <td><?php echo $conceptos[1] ?></td>
                                <td><?php echo $fechas[$i] ?></td>
                                <td><?php echo $valores[$i] ?></td>
                            </tr>
                        <?php 
                        // agregarKpi($conceptos[1],$fechas[$i],$valores[$i]);
                    } ?>
                    </tbody>
                </table>
            </form>