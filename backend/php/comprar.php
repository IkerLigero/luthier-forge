<?php
require "comprobar_sesion.php";
require "conexion.php";

$id_usuario = $_SESSION['id_usuario'];

$sql="SELECT SUM(cd.precio) as total
FROM carrito_detalle cd
JOIN carrito c
ON cd.id_carrito=c.id_carrito
WHERE c.id_usuario=$id_usuario";

$res=mysqli_query($conexion,$sql);
$fila=mysqli_fetch_assoc($res);

$total=$fila['total'];

mysqli_query($conexion,
"INSERT INTO historial_compra(id_usuario,total)
VALUES($id_usuario,$total)");

$id_compra=mysqli_insert_id($conexion);

mysqli_query($conexion,
"INSERT INTO historial_detalle(id_compra,id_guitarra_usuario,precio)
SELECT $id_compra,id_guitarra_usuario,precio
FROM carrito_detalle");

mysqli_query($conexion,"DELETE FROM carrito_detalle");