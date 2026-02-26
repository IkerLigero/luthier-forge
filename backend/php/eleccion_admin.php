<?php
session_start();

if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../auth/login.html");
    exit;
}

if ($_SESSION["id_rol"] != 2) {
    header("Location: ../index.html");
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
    <img src="../../frontend/assets/logo.png" class="logo" alt="logo">

    <h2 class="titulo">Bienvenido Admin <?php echo $_SESSION["nombre"]; ?></h2>

    <div class="alternar">
        <a href="/luthier_forge/luthier-forge/frontend/index.html">
            <button type="button" class="btnLogin activo">Ir a página principal</button>
        </a>

        <a href="admin_inicio.php">
            <button type="button" class="btnRegistro">Opciones administrador</button>
        </a>
    </div>
</div>

</body>
</html>