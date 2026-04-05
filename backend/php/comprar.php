<?php
// Protege la página: solo un usuario autenticado puede intentar pagar.
require "comprobar_sesion.php";
// Abre la conexión con MySQL para consultar el carrito y el importe final.
require "conexion.php";

// La compra siempre se calcula a partir del usuario que tiene la sesión activa.
$id_usuario = $_SESSION['id_usuario'];

/* Localiza el carrito asociado al usuario actual. */
$sql_carrito = "SELECT id_carrito FROM carrito WHERE id_usuario = $id_usuario";
$res_carrito = mysqli_query($conn, $sql_carrito);

// Si el usuario todavía no tiene carrito, no se puede continuar con el pago.
if (!$res_carrito || mysqli_num_rows($res_carrito) == 0) {
    echo "<h2>No tienes carrito creado</h2>";
    exit;
}

$fila_carrito = mysqli_fetch_assoc($res_carrito);
$id_carrito = $fila_carrito["id_carrito"];

/* Suma el precio de todos los productos guardados en ese carrito. */
$sql_total = "SELECT COALESCE(SUM(precio), 0) as total
              FROM carrito_detalle
              WHERE id_carrito = $id_carrito";

$res_total = mysqli_query($conn, $sql_total);

// Si falla esta consulta, el sistema no puede saber cuánto debe cobrar.
if (!$res_total) {
    die("Error en la consulta del total");
}

$fila_total = mysqli_fetch_assoc($res_total);
$total = $fila_total["total"];

// Cuando el total es 0, se muestra una vista específica en lugar del botón de pago.
if ($total <= 0) {
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Carrito vacío</title>

<!-- Reutiliza la hoja de estilos del proceso de compra para mantener la misma presentación. -->
<link rel="stylesheet" href="php_css/comprar.css">

</head>

<body>

<div class="container-pago">
    <!-- Mensaje de estado para informar de que no hay productos pendientes de cobro. -->
    <h2>El carrito está vacío</h2>

    <!-- Devuelve al usuario a la portada para que pueda seguir navegando o añadir artículos. -->
    <button class="btn" onclick="window.location.href='../../frontend/index.html'">
        Volver al inicio
    </button>
</div>

</body>
</html>
<?php
exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Pagar con PayPal</title>

<!-- Estilos de la pantalla de pago. -->
<link rel="stylesheet" href="php_css/comprar.css">

<!-- Carga el SDK de PayPal para renderizar el botón y gestionar la transacción en cliente. -->
<script src="https://www.paypal.com/sdk/js?client-id=test&currency=EUR"></script>
</head>

<body>

<div class="container-pago">
    <!-- Muestra el total calculado en el backend para que el usuario confirme el importe. -->
    <h2>Total a pagar: <?= number_format($total, 2) ?> €</h2>
    <!-- Contenedor donde PayPal insertará su botón de pago. -->
    <div id="paypal-button-container"></div>
</div>

<script>
    // Configura el flujo del botón de PayPal con el importe obtenido del carrito actual.
    paypal.Buttons({
        createOrder: function(data, actions) {
            // Crea la orden que PayPal cobrará usando el total generado en PHP.
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: '<?= number_format($total, 2, '.', '') ?>'
                    }
                }]
            });
        },
        onApprove: function(data, actions) {
            // Si PayPal confirma el pago, se captura la operación y se redirige al flujo de aceptación.
            return actions.order.capture().then(function(details) {
                window.location.href = "aceptar.php";
            });
        },
        onError: function(err) {
            // Informa al usuario si la pasarela devuelve un error durante el proceso.
            alert("Error en el pago. Inténtalo de nuevo.");
        }
    // Inserta el botón en el contenedor definido en el HTML.
    }).render('#paypal-button-container');
</script>

</body>
</html>