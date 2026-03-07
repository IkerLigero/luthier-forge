<?php
session_start();
require "conexion.php";

if (!isset($_SESSION["id_usuario"]) || $_SESSION["rol"] != 3) {
    header("Location: ../../frontend/auth/login.html");
    exit();
}

$id_usuario = $_SESSION["id_usuario"];

/* Buscar estado de solicitud */
$sql = "SELECT estado FROM solicitudes_distribuidor 
        WHERE id_usuario = $id_usuario 
        ORDER BY id_solicitud DESC 
        LIMIT 1";

$resultado = mysqli_query($conn,$sql);
$estado = null;

if(mysqli_num_rows($resultado) > 0){
    $fila = mysqli_fetch_assoc($resultado);
    $estado = $fila["estado"];
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Panel distribuidor</title>
<link rel="stylesheet" href="php_css/distribuidor_inicio.css">
</head>

<body>

<h2>Panel del distribuidor</h2>

<?php

if($estado == "pendiente"){
    echo "<p>Tu solicitud está pendiente de revisión.</p>";
}

elseif($estado == "aceptada"){
    echo "<p style='color:green;'>Tu solicitud ha sido aceptada. Ya puedes subir modelos.</p>";

    echo '<br>
    <a href="admin_subir.php">
        <button>Ir a subir modelos</button>
    </a>';
}

elseif($estado == "rechazada"){
    echo "<p style='color:red;'>Tu solicitud ha sido rechazada por el administrador.</p>";
}

else{
    echo "<p>No has solicitado acceso todavía.</p>";
}

?>

<br>

<?php
if($estado != "aceptada"){
?>

<form action="solicitar_permiso.php" method="POST">
<button type="submit">Solicitar acceso para subir modelos</button>
</form>

<?php
}
?>

</body>
</html>