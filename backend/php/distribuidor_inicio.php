<?php
// Inicia la sesión para consultar el usuario autenticado y su perfil.
session_start();
require "conexion.php";

// Solo las cuentas con rol de distribuidor pueden acceder a este panel.
if (!isset($_SESSION["id_usuario"]) || $_SESSION["rol"] != 3) {
    header("Location: ../../frontend/auth/login.html");
    exit();
}

// Guarda el id del distribuidor para buscar el estado de su solicitud.
$id_usuario = $_SESSION["id_usuario"];

// Recupera la solicitud más reciente para decidir qué acciones mostrar.
$sql = "SELECT estado FROM solicitudes_distribuidor 
        WHERE id_usuario = $id_usuario 
        ORDER BY id_solicitud DESC 
        LIMIT 1";

$resultado = mysqli_query($conn,$sql);
$estado = null;

// Si existe alguna solicitud previa, se usa su estado en la vista.
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

<!-- NOTYF -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

</head>

<body>

<div class="panel">

<h2>Panel del distribuidor</h2>

<div class="estado">

<?php

// Muestra que la petición sigue pendiente de revisión administrativa.
if($estado == "pendiente"){
    echo "<p>Tu solicitud está pendiente de revisión.</p>";
}

// Cuando está aceptada, habilita el acceso a la subida de modelos.
elseif($estado == "aceptada"){
    echo "<p class='aceptado'>Tu solicitud ha sido aceptada. Ya puedes subir modelos.</p>";

    echo '
    <a href="admin_subir.php">
        <button class="btn">Ir a subir modelos</button>
    </a>';
}

// Informa claramente si la solicitud fue rechazada.
elseif($estado == "rechazada"){
    echo "<p class='rechazado'>Tu solicitud ha sido rechazada por el administrador.</p>";
}

// Mensaje por defecto para distribuidores que aún no han solicitado acceso.
else{
    echo "<p>No has solicitado acceso todavía.</p>";
}

?>

</div>

<?php
// Mientras no esté aprobada, se mantiene visible el botón para solicitar acceso.
if($estado != "aceptada"){
?>

<form action="solicitar_permiso.php" method="POST">
<button class="btn">Solicitar acceso para subir modelos</button>
</form>

<?php
}
?>

<br>

<a href="logout.php">
<button class="btn logout">Cerrar sesión</button>
</a>

</div>

<!-- NOTYF JS -->
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

<script>

// Lee el parámetro de la URL para enseñar el resultado de la última solicitud enviada.
const params = new URLSearchParams(window.location.search);
const solicitud = params.get("solicitud");

if(solicitud){

    // Configura la librería de notificaciones usada en esta pantalla.
    const notyf = new Notyf({
        duration:4000,
        position:{x:'right',y:'top'}
    });

    // Confirma al usuario cuando la solicitud se registra correctamente.
    if(solicitud === "enviada"){
        notyf.success("Solicitud enviada al administrador");
    }

    // Evita confusión si ya existe una petición pendiente.
    if(solicitud === "pendiente"){
        notyf.error("Ya tienes una solicitud pendiente");
    }

    // Muestra un error genérico si algo falló al guardar la solicitud.
    if(solicitud === "error"){
        notyf.error("Error al enviar la solicitud");
    }

    // Limpia la URL para que el aviso no reaparezca al recargar.
    window.history.replaceState({}, document.title, window.location.pathname);
}

</script>

</body>
</html>
