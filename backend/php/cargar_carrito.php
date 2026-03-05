<?php
require "comprobar_sesion.php";
require "conexion.php";

$id_usuario = $_SESSION['id_usuario'];

$sql = "SELECT cd.id_guitarra_usuario,cd.precio
FROM carrito_detalle cd
JOIN carrito c
ON cd.id_carrito = c.id_carrito
WHERE c.id_usuario = $id_usuario";

$result = mysqli_query($conexion,$sql);

$datos = [];

while($fila = mysqli_fetch_assoc($result)){

    $datos[] = $fila;

}

echo json_encode($datos);