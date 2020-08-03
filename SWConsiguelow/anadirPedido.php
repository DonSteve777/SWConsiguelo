<?php
require_once __DIR__.'/includes/config.php';
use es\fdi\ucm\aw\Pedido as Pedido;



    if(isset($_SESSION['login']) && $_SESSION['login'] == true){
        $entityBody = file_get_contents('php://input');
        $dictionary = json_decode($entityBody);
        if (!is_object($dictionary)) {
            echo 'No se ha enviado un objeto';
            exit();
            //throw new ParametroNoValidoException('El cuerpo de la petición no es valido');
        }
        $dictionary = json_decode($entityBody, true);
        $idproducto = $dictionary['id'];
        $pagado = $dictionary['pagado'];
        $comprador = $_SESSION['userid'];
        $pedido = new Pedido($idproducto, $pagado, $comprador);
        if (Pedido::inserta($pedido)){
            http_response_code(201); // 201 Created
            $response = '';
            if ( $pagado==0){
                $response=<<<EOF
                <button id="viewCart" type="button" class="btn btn-info btn-lg">Ver carrito</button>
            EOF;
            }

            header('Content-Type: application/html; charset=utf-8');
            header('Content-Length: ' . mb_strlen($response));
            echo $response;
        }  
    }
    //else: mandar a login
    
