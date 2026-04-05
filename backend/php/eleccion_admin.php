<?php
// Reutiliza la validación común para permitir el acceso solo a administradores.
require "comprobar_admin.php";

// Refuerzo extra: si no existe sesión, devuelve al login.
if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../../frontend/auth/login.html");
    exit;
}

// Evita que un usuario autenticado sin privilegios vea este panel.
if ($_SESSION["rol"] != 2) {
    header("Location: ../../frontend/index.html");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Panel Admin</title>
    <link rel="stylesheet" href="php_css/eleccion_admin.css">
</head>
<body>

<div class="main">
    <!-- Logotipo mostrado en la cabecera del panel de administración. -->
    <img src="../../frontend/assets/logo.png" class="logo" alt="logo">

    <!-- Saludo personalizado usando el nombre almacenado en la sesión. -->
    <h2 class="titulo">Bienvenido Admin <?php echo $_SESSION["nombre"]; ?></h2>

    <div class="alternar">
        <!-- Acceso rápido a la parte pública de la aplicación. -->
        <a href="../../frontend/index.html">
            <button type="button" class="btnLogin activo">Ir a página principal</button>
        </a>

        <!-- Navegación hacia las opciones internas del administrador. -->
        <a href="admin_inicio.php">
            <button type="button" class="btnRegistro">Opciones administrador</button>
        </a>
    </div>
</div>

</body>
</html>
