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

/* Sumar solo los productos de ese carrito */
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
    echo "<h2>El carrito está vacío</h2>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pagar compra</title>
</head>
<body>

    <h2>Total a pagar: <?php echo number_format($total, 2, '.', ''); ?> €</h2>

    <div id="paypal-button-container"></div>

    <script src="https://www.paypal.com/sdk/js?client-id=AaX4MJsBtQdoAhilOe1MWVtEvvGz-kdbI_YK-1DIT2RJUSpb8JloPD32GYJpDlc3FYUX_ZBTeyUbPB_Y&currency=EUR"></script>

    <script>
paypal.Buttons({

    createOrder: function(data, actions) {
        return actions.order.create({
            purchase_units: [{
                amount: {
                    value: "<?php echo number_format($total, 2, '.', ''); ?>"
                }
            }]
        });
    },

    onApprove: function(data, actions) {
        // Si PayPal aprueba, seguimos el flujo normal
        alert("Pago aprobado (Sandbox)");
        window.location.href = "aceptar.php";
    },

    onError: function(err) {
        // Si Sandbox da error, seguimos igualmente para poder probar el sistema
        console.log(err);
        alert("Sandbox de PayPal falló. Continuamos en modo demo.");
        window.location.href = "aceptar.php";
    },

    onCancel: function(data) {
        // Si el usuario cancela el popup, permitimos continuar para testear
        alert("Pago cancelado. Continuamos en modo demo.");
        window.location.href = "aceptar.php";
    }

}).render('#paypal-button-container');
</script>

</body>
</html>