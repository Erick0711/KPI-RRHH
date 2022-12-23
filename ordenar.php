
<?php
include("./conexion.php");
function enviarDato($datoConcepto){
    // echo $datoConcepto;
    // die();
    $conexion = Conexion();
    $sentencia = $conexion->prepare("INSERT INTO 
    `prueba` (`id`, 
    `descripcion`, 
    VALUES (NULL, 
    '$datoConcepto'");
    $sentencia->execute();
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
        return $convertir;
    }
}

function obtener()
{
    // RETURNA TODO EL ARRAY CONVERTIDO DEL LA FUNCION
    $convertir = convertirArreglo();
    $fecha = $convertir[0]; # ME TRAE DE MANERA MANUAL TODO LAS FECHAS QUE ESTAN EN LA POSICION 0
    $valor = $convertir[1];
    
    // for ($j=1; $j < count($valor) ; $j++) { 
    //     $valores = $valor[$j];
    //     print_r($valores);
    // }
    for ($i = 0; $i < 2; $i++) {
        unset($fecha[$i]);  # RECORRO PARA ELIMINAR LOS CAMPOS VACIOS O NULOS
        unset($valor[$i]);
    }
    // for ($j=2; $j < count($valor)  ; $j++) { 
    //     $valores = $valor[$j];
    //     echo ($valores)."<br>";
    // }
    $conceptoArreglo = array();
    $datoConcepto = "";
    enviarDato($datoConcepto);
    for ($i = 1; $i < 3; $i++) {  # RECORRO PARA TRAER SOLO LOS CONCEPTOS DE FORMA MANUAL 
        $concepto = $convertir[$i][1];
        $datoConcepto = $concepto;
        // if(empty($datoConcepto)){
        //     break;
        // }
        array_push($conceptoArreglo, $concepto); # CONVIERTO LO ENCONTRADO A UN ARREGLO Y LO CARGO AL A VARIABLE CONCEPTOARREGLO
    }
    
    $arreglo = array($fecha, $valor, $conceptoArreglo);
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
            list($fechas,$valores,$conceptos) = $arreglo;
            ?>
            <?php for ($i=2; $i < count($fechas) ; $i++) {  ?>    
                <tr>   
                    <td><?php echo $conceptos[1]?></td>
                    <td><?php echo $fechas[$i]?></td>
                    <td><?php echo $valores[$i]?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <input type="submit" value="Enviar">
        </form>
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
            list($fechas,$valores,$conceptos) = $arreglo;
            ?>
            <?php for ($i=2; $i < count($fechas) ; $i++) {  ?>    
                <tr>   
                    <td><?php echo $conceptos[0]?></td>
                    <td><?php echo $fechas[$i]?></td>
                    <td><?php echo $valores[$i]?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    </div>
</body>
</html>