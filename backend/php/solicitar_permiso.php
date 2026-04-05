<?php
session_start();
require "conexion.php";

$id_usuario = $_SESSION["id_usuario"];

/* comprobar si ya tiene solicitud pendiente */
$sql = "SELECT * FROM solicitudes_distribuidor 
        WHERE id_usuario = $id_usuario 
        AND estado = 'pendiente'";

$resultado = mysqli_query($conn,$sql);

if(mysqli_num_rows($resultado) > 0){

    header("Location: distribuidor_inicio.php?solicitud=pendiente");
    exit();

}

/* crear solicitud */
$sql = "INSERT INTO solicitudes_distribuidor (id_usuario, estado) 
        VALUES ($id_usuario,'pendiente')";

$correcto = mysqli_query($conn,$sql);

if($correcto){

    header("Location: distribuidor_inicio.php?solicitud=enviada");
    exit();

}else{

    header("Location: distribuidor_inicio.php?solicitud=error");
    exit();

}
?>