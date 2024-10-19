<?php

namespace Controllers;

use MVC\Router;
use Model\Vendedor;

class VendedorController {
    public static function crear(Router $router) {
        
        $errores = Vendedor::getErrores();
        $vendedor = new Vendedor();

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            // CREAR NUEVA INSTANCIA
            $vendedor = new Vendedor($_POST['vendedor']);
            
            // VALIDAR QUE NO HAYA CAMPOS VACIOS
            $errores = $vendedor->validar();
        
            // NO HAY ERRORES
            if(empty($errores)) {
                $vendedor->guardar();
            }
        }

        $router->render('vendedores/crear', [
            'errores' => $errores,
            'vendedor' => $vendedor
        ]);
    }

    public static function actualizar(Router $router) {
        
        $errores = Vendedor::getErrores();
        $id = validarORedireccionar('admin');
        // Obtener datos del vendedor
        $vendedor = Vendedor::find($id);
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            // ASIGNAR VALORES
            $args = $_POST['vendedor'];
        
            // SINCRONIZAR OBJETO EN MEMORIA
            $vendedor->sincronizar($args);
        
            // VALIDACION
            $errores = $vendedor->validar();
        
            if(empty($errores)) {
                $vendedor->guardar();
            }
        
        }
        

        $router->render('vendedores/actualizar', [
            'errores' => $errores,
            'vendedor' => $vendedor
        ]);
    }

    public static function eliminar() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            // validar id
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if($id) {
                // valida tipo a eliminar
                $tipo = $_POST['tipo'];

                if(validarTipoContenido($tipo)) {
                    $vendedor = Vendedor::find($id);
                    $vendedor->eliminar();
                }
            }

        }
    }
}

?>