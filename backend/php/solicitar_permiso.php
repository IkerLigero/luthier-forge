<?php
session_start();
require "conexion.php";

$id_usuario = $_SESSION["id_usuario"];

/* comprobar si ya tiene solicitud */
$sql = "SELECT * FROM solicitudes_distribuidor 
        WHERE id_usuario = $id_usuario 
        AND estado = 'pendiente'";

$resultado = mysqli_query($conn,$sql);

if(mysqli_num_rows($resultado) > 0){
    echo "Ya tienes una solicitud pendiente.";
    exit;
}

/* crear solicitud */
$sql = "INSERT INTO solicitudes_distribuidor (id_usuario, estado) 
        VALUES ($id_usuario,'pendiente')";

mysqli_query($conn,$sql);

echo "Solicitud enviada al administrador";
?>