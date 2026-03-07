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

<!-- NOTYF -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

</head>

<body>

<div class="panel">

<h2>Panel del distribuidor</h2>

<div class="estado">

<?php

if($estado == "pendiente"){
    echo "<p>Tu solicitud está pendiente de revisión.</p>";
}

elseif($estado == "aceptada"){
    echo "<p class='aceptado'>Tu solicitud ha sido aceptada. Ya puedes subir modelos.</p>";

    echo '
    <a href="admin_subir.php">
        <button class="btn">Ir a subir modelos</button>
    </a>';
}

elseif($estado == "rechazada"){
    echo "<p class='rechazado'>Tu solicitud ha sido rechazada por el administrador.</p>";
}

else{
    echo "<p>No has solicitado acceso todavía.</p>";
}

?>

</div>

<?php
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

const params = new URLSearchParams(window.location.search);
const solicitud = params.get("solicitud");

if(solicitud){

    const notyf = new Notyf({
        duration:4000,
        position:{x:'right',y:'top'}
    });

    if(solicitud === "enviada"){
        notyf.success("Solicitud enviada al administrador");
    }

    if(solicitud === "pendiente"){
        notyf.error("Ya tienes una solicitud pendiente");
    }

    if(solicitud === "error"){
        notyf.error("Error al enviar la solicitud");
    }

    window.history.replaceState({}, document.title, window.location.pathname);
}

</script>

</body>
</html>