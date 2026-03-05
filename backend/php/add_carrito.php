<?php
require "comprobar_sesion.php";
require "conexion.php";

$id_usuario = $_SESSION['id_usuario'];
$id_guitarra = $_POST['id_guitarra'];

$sql = "SELECT id_carrito FROM carrito WHERE id_usuario = $id_usuario";
$result = mysqli_query($conexion,$sql);

if(mysqli_num_rows($result)==0){

    mysqli_query($conexion,"INSERT INTO carrito(id_usuario) VALUES($id_usuario)");

    $id_carrito = mysqli_insert_id($conexion);

}else{

    $fila = mysqli_fetch_assoc($result);
    $id_carrito = $fila['id_carrito'];

}

mysqli_query($conexion,
"INSERT INTO carrito_detalle(id_carrito,id_guitarra_usuario,precio)
VALUES($id_carrito,$id_guitarra,1000)");