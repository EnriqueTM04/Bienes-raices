<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController {
    
    public static function index(Router $router) {
        
        $propiedades = Propiedad::get(3);
        $inicio = true;
        
        $router->render('pages/index', [
            'propiedades' => $propiedades,
            'inicio' => $inicio
        ]);
    }

    public static function nosotros(Router $router) {
        
        

        $router->render('pages/nosotros');
    }

    public static function propiedades(Router $router) {
        
        $propiedades = Propiedad::all();

        $router->render('pages/propiedades', [
            'propiedades' => $propiedades
        ]);
    }

    public static function propiedad(Router $router) {

        $id = validarORedireccionar('propiedades');
        $propiedad = Propiedad::find($id);

        $router->render('pages/propiedad', [
            'propiedad' => $propiedad
        ]);
    }

    public static function blog(Router $router) {
        
        $router->render('pages/blog');
    }

    public static function entrada(Router $router) {
        
        $router->render('pages/entrada');
    }

    public static function contacto(Router $router) {

        $mensaje = null;
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            $respuestas = $_POST['contacto'];

            // Crear instancia de phpmailer
            $mail = new PHPMailer();

            // Configurar SMTP
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Port = 2525;
            $mail->Username = 'be66f4d0e1c187';
            $mail->Password = '0a76973e56ed81';
            // antes era ssl, no puedan interceptarlo
            $mail->SMTPSecure = 'tls';

            // Configurar contenido
            $mail->setFrom('admin@bienesraices.com');
            $mail->addAddress('admin@bienesraices.com', 'BienesRaices.com');
            $mail->Subject = 'Tienes un Nuevo Mensaje';

            // Habilitar HTML
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            
            // Contenido
            $contenido = '<html>';
            $contenido .= '<p>Tienes un nuevo mensaje</p>';
            $contenido .= '<p>Nombre: ' .  $respuestas['nombre'] . ' </p>';

            // Enviar de forma condicional campos
            if($respuestas['contacto'] === 'telefono') {
                $contenido .= '<p>Eligio ser contactado por teléfono</p>';
                $contenido .= '<p>Telefono: ' .  $respuestas['telefono'] . ' </p>';
                $contenido .= '<p>Fecha de contacto: ' .  $respuestas['fecha'] . ' </p>';
                $contenido .= '<p>Hora de contacto: ' .  $respuestas['hora'] . ' </p>';

            } else {    //es email
                $contenido .= '<p>Eligio ser contactado por email</p>';
                $contenido .= '<p>Email: ' .  $respuestas['email'] . ' </p>';
            }

            $contenido .= '<p>Mensaje: ' .  $respuestas['mensaje'] . ' </p>';
            $contenido .= '<p>Vende o compra: ' .  $respuestas['tipo'] . ' </p>';
            $contenido .= '<p>Precio o presupuesto: $' .  $respuestas['precio'] . ' </p>';
            
            $contenido .= '</html>';
            $mail->AltBody = "Texto sin HTML";

            $mail->Body = $contenido;
            
            // ENviar email
            if($mail->send()) {
                $mensaje = "Mensaje enviado correctamente";
            } else {
                $mensaje = "El mensaje no se pudo enviar";
            }


        }

        $router->render('pages/contacto', [
            'mensaje' => $mensaje
        ]);
    }
}

?>