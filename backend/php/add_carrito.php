<?php
// Usamos require_once para evitar errores de carga duplicada
require_once "comprobar_sesion.php";
require_once "conexion.php";

// Verificamos que los datos lleguen por POST
if (!isset($_POST['id_guitarra']) || !isset($_POST['precio'])) {
    http_response_code(400);
    exit("Faltan parámetros");
}

$id_usuario = $_SESSION['id_usuario'];
$id_guitarra = $_POST['id_guitarra'];
$precio = $_POST['precio'];

// 1. Obtener o crear el carrito activo
// Nota: Según tu SQL, la tabla es 'carrito' y tiene 'id_usuario'
$sql_carrito = "SELECT id_carrito FROM carrito WHERE id_usuario = '$id_usuario'";
$res_carrito = mysqli_query($conn, $sql_carrito);

if (mysqli_num_rows($res_carrito) == 0) {
    mysqli_query($conn, "INSERT INTO carrito (id_usuario) VALUES ('$id_usuario')");
    $id_carrito = mysqli_insert_id($conn);
} else {
    $fila = mysqli_fetch_assoc($res_carrito);
    $id_carrito = $fila['id_carrito'];
}

// 2. Insertar en carrito_detalle
// IMPORTANTE: Asegúrate de que la tabla 'carrito_detalle' exista en tu DB.
// Si no existe, debes crearla con las columnas: id_carrito, id_guitarra_usuario, precio.
$sql_detalle = "INSERT INTO carrito_detalle (id_carrito, id_guitarra_usuario, precio) 
                VALUES ('$id_carrito', '$id_guitarra', '$precio')";

if (mysqli_query($conn, $sql_detalle)) {
    echo "success";
} else {
    // Si hay un error de SQL, lo enviamos para debuguear
    http_response_code(500);
    echo "Error SQL: " . mysqli_error($conn);
}
?>