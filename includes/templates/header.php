<?php
    if(!isset($_SESSION)) {
        session_start();
    }

    $auth = $_SESSION['login'] ?? false;

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienes Raices</title>
    <link rel="stylesheet" href="/build/css/app.css">
</head>
<body>

    <header class="header 

    <?php echo $inicio ? 'inicio': ''; 
    //con isset compruebo si una variable esta definida
    ?>">
        <div class="contenedor contenido-header">
            <div class="barra">
                <a href="/index.php">
                    <img src="/build/img/logo.svg" alt="Logotipo de bienes raices">
                </a>

                <div class="mobile-menu">
                    <img src="/build/img/barras.svg" alt="Icono menu responsive">
                </div>

                <div class="derecha">
                    <img class="dark-mode-boton" src="/build/img/dark-mode.svg" alt="Imagen modo oscuro">
                    <nav class="navegacion">
                        <a href="nosotros.php">Nosotros</a>
                        <a href="anuncios.php">Anuncios</a>
                        <a href="blog.php">Blog</a>
                        <a href="contacto.php">Contacto</a>
                        <?php if($auth) : ?>
                            <a href="cerrar-sesion.php">Cerrar Sesión</a>
                        <?php endif; ?>
                    </nav>
                </div>

            </div> <!-- barra -->
            
            <?php
                if($inicio) { ?>
                    <h1>Venta de Casas y Departamentos exclusivos de lujo</h1>
                <?php }
            ?>
        </div>
    </header>