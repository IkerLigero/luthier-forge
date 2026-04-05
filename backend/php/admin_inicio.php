<?php
// Comprueba que el usuario sea administrador antes de mostrar esta página.
require "comprobar_admin.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Admin Inicio</title>
    <link rel="stylesheet" href="php_css/admin_inicio.css">
</head>

<body>

<div class="main">

    <!-- Título principal del panel de administración -->
    <h2 class="titulo">Panel de Administración</h2>

    <!-- Botones para entrar a las distintas funciones del administrador -->
    <div class="botones">

        <a href="admin_subir.php">
            <!-- Ir a la pantalla para subir nuevas piezas -->
            <button type="button" class="btn">Subir pieza</button>
        </a>

        <a href="gestionar_usuarios.php">
            <!-- Ir a la pantalla para cambiar roles o eliminar usuarios -->
            <button type="button" class="btn">Gestionar usuarios</button>
        </a>

        <a href="ver_solicitudes.php">
            <!-- Ir a la pantalla para revisar solicitudes de distribuidores -->
            <button type="button" class="btn">Ver solicitudes de distribuidores</button>
        </a>
        
        <a href="eleccion_admin.php">
            <!-- Volver a la pantalla anterior -->
            <button type="button" class="btnVolver">Volver</button>
        </a>

    </div>

</div>

</body>
</html>