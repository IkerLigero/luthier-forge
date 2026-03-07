<?php
require "conexion.php";

$nombre = $_POST["nombre"];
$apellidos = $_POST["apellidos"];
$email = $_POST["email"];
$password = $_POST["password"];

/* comprobar si ya existe el email */
$sql = "SELECT * FROM usuario WHERE email='$email'";
$resultado = mysqli_query($conn,$sql);

if(mysqli_num_rows($resultado) > 0){

    header("Location: ../../frontend/auth/login.html?registro=existe");
    exit();

}

/* insertar usuario */
$sql = "INSERT INTO usuario (nombre, apellidos, email, contrasenia_hash, id_rol)
        VALUES ('$nombre','$apellidos','$email','$password',1)";

$correcto = mysqli_query($conn,$sql);

if($correcto){

    header("Location: ../../frontend/auth/login.html?registro=ok");
    exit();

}else{

    header("Location: ../../frontend/auth/login.html?registro=error");
    exit();

}
?>