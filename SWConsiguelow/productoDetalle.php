<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/ImageUpload.php';
use es\fdi\ucm\aw\Producto;
use es\fdi\ucm\aw\ImageUpload;
use es\fdi\ucm\aw\FormularioLogin;
use es\fdi\ucm\aw\Aplicacion as App;
use es\fdi\ucm\aw\Pedido;



//podría intentear afinar generando este html solo en caso de usarlo, como respuesta a una petición
$form = new FormularioLogin(); 
$htmlForm = $form->gestiona();


$idproducto = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if(!$idproducto) {
    exit();
}
$producto = Producto::getById($idproducto);
$imgSrc = ImageUpload::getSource($idproducto);
$img='';
if ($imgSrc){
    $img =<<<EOF
    <img class="img-fluid border" src=$imgSrc alt="imagen no disponible">
EOF;
}

$htmlComprar='';
$htmlCarrito='';
$htmlComprar =<<<EOF
    <button id="buy" type="button" class="btn btn-info btn-lg" >Comprar</button>
EOF;

if (App::getSingleton()->usuarioLogueado()){
    $carrito = Pedido::getCarrito();
    $i=0;
    $encontrado = false;
    while($i < count($carrito) && !$encontrado){
        if ($carrito[$i]->producto()==  $idproducto) $encontrado = true;
        $i++;
    }
    if ($encontrado){
        $htmlCarrito=<<<EOF
        <a href="vistaCarrito.php" id="viewCart" type="button" class="btn btn-info btn-lg">Ver carrito</a>
EOF;
    }else{
        $htmlCarrito=<<<EOF
        <button id="addCart" type="button" class="btn btn-info btn-lg">Añadir al carrito</button>
EOF;
    }
}else{
    $htmlCarrito=<<<EOF
    <button id="addCart" type="button" class="btn btn-info btn-lg">Añadir al carrito</button>
EOF; 
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
    <link rel="stylesheet" href="css/modal.css">

    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script> 
    <script src="js/productoDetalle.js"></script> 

    
</head>

<body>
    <?php require("includes/common/cabecera.php");?>
    <main role="main">
    <!-- The Modal -->
    <div id="myModal" class="modal">
    <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <div class="row text-center">
                <div class="col-4"></div>
                    <div class="col-4">
                        <div id="containerForm" class="container  w-75 d-flex flex-column mt-5">
                            <?php echo $htmlForm; ?>
                            <h6 class="mt-4"> 
                                <a href="registro.php">¿Todavía no tienes cuenta? Regístrate aquí</a>
                            </h6>
                        </div>
                    </div>
                    <div class="col-4"></div>
                </div>
            </div>
        </div>
        <div class="container-fluid bg-light">
            <div class="row"> 
                <div class="col-5 m-3">
                    <?php echo $img;?>  
                </div>
                <div class="col-5 m-3">
                    <div class="d-flex flex-column m-3 ">
                        <div class="border-bottom text-center display-4" >
                            <?php echo $producto->nombre(); ?> 
                        </div>
                        <div class="m-3">
                            <div class="mb-3" >
                                <div class="mb-2">
                                    <div class="d-inline p-2 font-weight-bold">Precio</div>
                                    <div class="d-inline p-2 font-weight-ligh text-right"><?php echo $producto->precio()?> €</div>
                                </div>

                                <div class="mb-2">
                                    <div class="d-inline p-2 font-weight-bold">Unidades</div>
                                    <div class="d-inline p-2 font-weight-ligh"><?php echo $producto->unidades()?></div>
                                </div>

                                <div class="mb-2">
                                    <div class="d-inline p-2 font-weight-bold">Talla</div>
                                    <div class="d-inline p-2 font-weight-ligh"><?php echo $producto->talla()?></div>
                                </div>

                                <div class="mb-2">
                                    <div class="d-inline p-2 font-weight-bold">Color</div>
                                    <div class="d-inline p-2 font-weight-ligh"><?php echo $producto->color()?></div>
                                </div>
                            </div>
                            <div class="bg-dark text-white rounded p-3">
                                <div>
                                    <p class="lead"><?php echo $producto->descripcion()?></p>  
                                </div>
                                <div class="m-1 d-flex flex-row">  
                                    <div class="m-1" >
                                            <?php echo $htmlComprar?>                                    
                                    </div> 
                                    <div class="m-1">
                                            <?php echo $htmlCarrito?> 
                                    </div>
                                </div>  
                            </div>  
                        </div>
                    </div>
                </div>
                <div class="col-2">
                </div>
            </div>
        </div>
    </main>
</body>
</html>
