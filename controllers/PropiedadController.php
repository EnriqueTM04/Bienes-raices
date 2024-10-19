<?php

namespace Controllers;
use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Intervention\Image\ImageManager as Image;
use Intervention\Image\Drivers\Gd\Driver;

class PropiedadController {
    public static function index(Router $router) {

        $propiedades = Propiedad::all();
        $vendedores = Vendedor::all();
        $resultado = null;

        // Muestra mensaje condicional
        $resultado = $_GET['resultado'] ?? null;    //si no existe entonces asignar null

        $router->render('propiedades/admin', [
            'propiedades' => $propiedades,
            'resultado' => $resultado,
            'vendedores' => $vendedores
        ]);
    }

    public static function crear(Router $router) {

        $propiedad = new Propiedad;
        $vendedores = Vendedor::all();
        // ARREGLO CON MENSAJES DE ERRORES
        $errores = Propiedad::getErrores();

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            /** CREA NUEVA INSTANCIA */
            $propiedad = new Propiedad($_POST['propiedad']); 
    
            // Generar un nombre unico
            $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";
    
            // SETEAR IMAGEN
            // REALIZA RISIZE A LA IMAGEN CON INTERVENTION
            if($_FILES['propiedad']['tmp_name']['imagen']){
                $manager = new Image(Driver::class);
                $image = $manager->read($_FILES['propiedad']['tmp_name']['imagen'])->cover(800,600);  
                $propiedad->setImagen($nombreImagen);
            }
            
            $errores = $propiedad->validar();   
    
            // Revisar que arreglo de errores este vacio
            if(empty($errores)) {
    
                // CREAR CARPEYA PARA SUBIR IMAGENES
                if(!is_dir(CARPETA_IMAGENES)) {
                    mkdir(CARPETA_IMAGENES);
                }
                
                // Guarda la imagen en el servidor
                $image->save(CARPETA_IMAGENES . $nombreImagen);
    
                // GUARDAR EN DB
                $propiedad->guardar();
            } 
        }
        
        $router->render('propiedades/crear', [
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
            'errores' => $errores
        ]);
    }

    public static function actualizar(Router $router) {

        $id = validarORedireccionar('admin');
        $propiedad = Propiedad::find($id);
        $vendedores = Vendedor::all();
        // ARREGLO CON MENSAJES DE ERRORES
        $errores = Propiedad::getErrores();

        // EJECUTAR CODIGO DESPUES DE QUE USUARIO ENVIA FORMULARIO
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            // ASIGNAR ATRIBUTOS
            $args = $_POST['propiedad'];

            // ACTUALIZAR VALORES
            $propiedad->sincronizar($args);

            // VALIDACION
            $errores = $propiedad->validar();

            // SUBIDA DE ARCHIVOS
            // Generar un nombre unico
            $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";

            // SETEAR IMAGEN
            if($_FILES['propiedad']['tmp_name']['imagen']){
                $manager = new Image(Driver::class);
                $image = $manager->read($_FILES['propiedad']['tmp_name']['imagen'])->cover(800,600);  
                $propiedad->setImagen($nombreImagen);
            }

            // Revisar que arreglo de errores este vacio
            if(empty($errores)) {

                // ALMACENAR IMAGEN
                if($_FILES['propiedad']['tmp_name']['imagen']){
                    $image->save(CARPETA_IMAGENES . $nombreImagen);
                }

                $propiedad->guardar();
            }

            
        }

        $router->render('/propiedades/actualizar', [
            'propiedad'=> $propiedad,
            'errores' => $errores,
            'vendedores' => $vendedores
        ]);
    }

    public static function eliminar() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
    
            if($id) {
    
                $tipo = $_POST['tipo'];
    
                if(validarTipoContenido($tipo)) {
                    $propiedad = Propiedad::find($id);
                    $propiedad->eliminar();
                }
                
            }
        }
    }
    
}

?>