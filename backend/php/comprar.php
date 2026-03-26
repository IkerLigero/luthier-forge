<?php
require "comprobar_sesion.php";
require "conexion.php";

$id_usuario = $_SESSION['id_usuario'];

/* Buscar el carrito del usuario */
$sql_carrito = "SELECT id_carrito FROM carrito WHERE id_usuario = $id_usuario";
$res_carrito = mysqli_query($conn, $sql_carrito);

if (!$res_carrito || mysqli_num_rows($res_carrito) == 0) {
    echo "<h2>No tienes carrito creado</h2>";
    exit;
}

$fila_carrito = mysqli_fetch_assoc($res_carrito);
$id_carrito = $fila_carrito["id_carrito"];

/* Sumar productos */
$sql_total = "SELECT COALESCE(SUM(precio), 0) as total
              FROM carrito_detalle
              WHERE id_carrito = $id_carrito";

$res_total = mysqli_query($conn, $sql_total);

if (!$res_total) {
    die("Error en la consulta del total");
}

$fila_total = mysqli_fetch_assoc($res_total);
$total = $fila_total["total"];

if ($total <= 0) {
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Carrito vacío</title>

<link rel="stylesheet" href="../../backend/php/php_css/comprar.css">

</head>

<body>

<div class="container-pago">
    <h2>El carrito está vacío</h2>

    <button class="btn" onclick="window.location.href='../../frontend/index.html'">
        Volver al inicio
    </button>
</div>

</body>
</html>
<?php
exit;
}