<?php
require_once __DIR__.'/includes/config.php';
use es\fdi\ucm\aw\Producto;

$id = $_GET['id'];
$nombre = $_GET['nombre'];
$productos = Producto::getByCat($id);
$html='';
foreach($productos as $value){
    $html.=$value->generaTarjeta();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Local Consiguelow</title>
    <link rel="icon" href="img/money.ico"/>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body>
    <?php
    //phpinfo();
        require("includes/common/cabecera.php");
    ?>
    <main role="main">
        <div class="album py-5 bg-light">
            <div class="container">
                <h2>
                    <?php 
                        echo $nombre;
                    ?>
                </h2>
                <div class="row">
              
                <?php
                    echo $html;
                ?>
                </div>
            </div>
        </div>
    </main>
</body>
</html>