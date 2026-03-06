<?php
session_start();
require "conexion.php";

$sql = "SELECT solicitudes_distribuidor.id_solicitud, usuario.nombre
FROM solicitudes_distribuidor
JOIN usuario ON solicitudes_distribuidor.id_usuario = usuario.id_usuario
WHERE estado='pendiente'";

$resultado = mysqli_query($conn,$sql);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Solicitudes</title>
<link rel="stylesheet" href="php_css/ver_solicitudes.css">
</head>

<body>

<div class="panel">

<h2>Solicitudes de distribuidores</h2>

<?php
while($fila = mysqli_fetch_assoc($resultado)){
?>

<div class="solicitud">

<span class="nombre"><?php echo $fila["nombre"]; ?></span>

<a class="aceptar" href="aceptar.php?id=<?php echo $fila["id_solicitud"]; ?>">Aceptar</a>

<a class="rechazar" href="rechazar.php?id=<?php echo $fila["id_solicitud"]; ?>">Rechazar</a>

</div>

<?php
}
?>

<div class="volver">
<button onclick="window.location.href='admin_inicio.php'">Volver</button>
</div>

</div>

</body>
</html>