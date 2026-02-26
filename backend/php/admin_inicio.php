<?php
session_start();
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

    <h2 class="titulo">Panel de Administración</h2>

    <div class="botones">

        <a href="admin_subir.php">
            <button class="btn">Subir pieza</button>
        </a>

        <a href="gestionar_usuarios.php">
            <button class="btn">Gestionar usuarios</button>
        </a>

        <a href="eleccion_admin.php">
            <button class="btnVolver">Volver</button>
        </a>

    </div>

</div>

</body>
</html>