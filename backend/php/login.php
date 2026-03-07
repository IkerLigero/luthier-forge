<?php
session_start();
require "conexion.php";

/* Evita entrar directamente al login.php */
if (!isset($_POST["email"]) || !isset($_POST["password"])) {
    header("Location: ../../frontend/auth/login.html");
    exit();
}

/* Recoger datos del formulario */
$email = mysqli_real_escape_string($conn, $_POST["email"]);
$password = mysqli_real_escape_string($conn, $_POST["password"]);

/* Buscar usuario */
$sql = "SELECT * FROM usuario WHERE email = '$email'";
$resultado = mysqli_query($conn, $sql);

if (mysqli_num_rows($resultado) == 1) {

    $fila = mysqli_fetch_assoc($resultado);

    /* Comprobar contraseña */
    if ($password == $fila["contrasenia_hash"]) {

        $_SESSION["id_usuario"] = $fila["id_usuario"];
        $_SESSION["nombre"] = $fila["nombre"];
        $_SESSION["rol"] = $fila["id_rol"];

        /* ADMIN */
        if ($fila["id_rol"] == 2) {

            header("Location: eleccion_admin.php");
            exit();

        }

        /* DISTRIBUIDOR */
        elseif ($fila["id_rol"] == 3) {

            header("Location: distribuidor_inicio.php");
            exit();

        }

        /* CLIENTE */
        else {

            header("Location: ../../frontend/index.html");
            exit();

        }

    } else {

        header("Location: ../../frontend/auth/login.html?error=password");
        exit();

    }

} else {

    header("Location: ../../frontend/auth/login.html?error=usuario");
    exit();

}
?>