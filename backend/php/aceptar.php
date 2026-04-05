<?php
// Comprueba que el usuario haya iniciado sesión.
require "comprobar_sesion.php";
// Abre la conexión con la base de datos.
require "conexion.php";

// Coge el id del usuario que está logueado.
$id_usuario = $_SESSION['id_usuario'];

/* Buscar el carrito de este usuario.
   Si no tiene carrito creado, no se puede seguir con la compra. */
$sql_carrito = "SELECT id_carrito FROM carrito WHERE id_usuario = $id_usuario";
$res_carrito = mysqli_query($conn, $sql_carrito);

if (!$res_carrito || mysqli_num_rows($res_carrito) == 0) {
  echo "No existe carrito para este usuario";
  exit;
}

// Guarda el id del carrito para usarlo en las siguientes consultas.
$fila_carrito = mysqli_fetch_assoc($res_carrito);
$id_carrito = $fila_carrito["id_carrito"];

/* Sumar el precio total de todos los productos del carrito.
   COALESCE evita que devuelva NULL si no hay filas. */
$sql_total = "SELECT COALESCE(SUM(precio), 0) as total
        FROM carrito_detalle
        WHERE id_carrito = $id_carrito";

$res_total = mysqli_query($conn, $sql_total);

if (!$res_total) {
  echo "Error al calcular el total";
  exit;
}

// Coge el total calculado.
$fila_total = mysqli_fetch_assoc($res_total);
$total = $fila_total["total"];

// Si el total es 0 o menor, significa que el carrito está vacío.
if ($total <= 0) {
  echo "El carrito está vacío";
  exit;
}

/* Guardar la compra principal en el historial.
   Aquí se crea el encabezado de la compra: usuario y total. */
$sql_compra = "INSERT INTO historial_compra(id_usuario, total)
         VALUES($id_usuario, $total)";

if (!mysqli_query($conn, $sql_compra)) {
  echo "Error al guardar la compra";
  exit;
}

// Recupera el id de la compra recién creada.
$id_compra = mysqli_insert_id($conn);

/* Guardar en el historial cada producto que había en el carrito.
   Se copian los datos desde carrito_detalle hacia historial_detalle. */
$sql_detalles = "INSERT INTO historial_detalle(id_compra, id_guitarra_usuario, precio)
         SELECT $id_compra, id_guitarra_usuario, precio
         FROM carrito_detalle
         WHERE id_carrito = $id_carrito";

if (!mysqli_query($conn, $sql_detalles)) {
  echo "Error al guardar los detalles";
  exit;
}

/* Vaciar el carrito después de guardar la compra.
   Así los productos ya comprados no siguen apareciendo en el carrito. */
$sql_borrar = "DELETE FROM carrito_detalle WHERE id_carrito = $id_carrito";

if (!mysqli_query($conn, $sql_borrar)) {
  echo "Error al vaciar el carrito";
  exit;
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Compra realizada</title>

<link rel="stylesheet" href="../../backend/php/php_css/aceptar.css">

</head>

<body>

<div class="container">
  <!-- Mensaje de confirmación para avisar de que la compra ya se guardó -->
  <h2>Compra realizada correctamente</h2>

  <!-- Enlace para ir directamente al historial de compras -->
  <a class="btn" href="../../frontend/carrito/historial.html">
    Ver historial
  </a>

  <!-- Enlace para volver a la página principal -->
  <a class="btn btn-secundario" href="../../frontend/index.html">
    Volver al inicio
  </a>
</div>

</body>
</html>