<?php
require "conexion.php";

$nombre = $_POST["nombre"];
$apellidos = $_POST["apellidos"];
$email = $_POST["email"];
$password = $_POST["password"];

$sql = "INSERT INTO usuario (nombre, apellidos, email, contraseña_hash, id_rol)
        VALUES ('$nombre', '$apellidos', '$email', '$password', 1)";

if (mysqli_query($conn, $sql)) {
    echo "Usuario registrado";
} else {
    echo "Error";
}
?>  