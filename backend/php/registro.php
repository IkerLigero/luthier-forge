<?php
require "conexion.php";

$nombre = $_POST["nombre"];
$apellidos = $_POST["apellidos"];
$email = $_POST["email"];
$password = $_POST["password"];

$sql = "INSERT INTO usuario (nombre, apellidos, email, contrasenia_hash, id_rol)
        VALUES ('$nombre', '$apellidos', '$email', '$password', 1)";

$correcto = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <link rel="stylesheet" href="php_css/registro.css">
</head>

<body>

<div class="card">

    <?php if ($correcto) { ?>
        <h2>Usuario registrado correctamente</h2>
    <?php } else { ?>
        <h2>Error al registrar</h2>
    <?php } ?>

    <a href="../../frontend/auth/login.html">
        <button>Volver al login</button>
    </a>

</div>

</body>
</html>