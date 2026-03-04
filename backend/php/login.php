<?php
session_start();
require "conexion.php";

$email = $_POST["email"];
$password = $_POST["password"];

$sql = "SELECT * FROM usuario WHERE email = '$email'";
$resultado = mysqli_query($conn, $sql);

if (mysqli_num_rows($resultado) == 1) {

    $fila = mysqli_fetch_assoc($resultado);

    if ($password == $fila["contrasenia_hash"]) {

        $_SESSION["id_usuario"] = $fila["id_usuario"];
        $_SESSION["nombre"] = $fila["nombre"];
        $_SESSION["id_rol"] = $fila["id_rol"];


        if ($fila["id_rol"] == 2) {
            header("Location: ./eleccion_admin.php");
            exit;
        } else {
            header("Location: ../../frontend/index.html");
            exit;
        }

        exit;

    } else {
        echo "Contraseña incorrecta";
    }

} else {
    echo "Usuario no encontrado";
}
?>