<?php
// Inicia la sesión para poder leer los datos del usuario logueado.
session_start();
// Abre la conexión con la base de datos.
require "conexion.php";

// Si no hay usuario en sesión, lo manda al login.
if (!isset($_SESSION["id_usuario"])) {
    header("Location: login.php");
    exit;
}

// Guarda los datos del usuario logueado.
$id_usuario = $_SESSION["id_usuario"];
$id_rol = $_SESSION["rol"];

if ($id_rol == 2) {
    // El administrador puede entrar siempre a esta pantalla.
}

elseif ($id_rol == 3) {

    /* Si es distribuidor, solo puede entrar si su solicitud
       fue aceptada previamente. */
    $sql = "SELECT estado 
            FROM solicitudes_distribuidor 
            WHERE id_usuario = $id_usuario 
            AND estado = 'aceptada'";

    $resultado = mysqli_query($conn,$sql);

    if(mysqli_num_rows($resultado) == 0){
        // Si no tiene una solicitud aceptada, no puede subir modelos.
        echo "No tienes permiso para subir modelos.";
        exit;
    }

}

else {
    // Cualquier otro rol no tiene acceso a esta página.
    echo "No tienes acceso a esta página";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Subir pieza</title>
<link rel="stylesheet" href="php_css/admins_subir.css">

<!-- NOTYF -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

</head>
<body>

<h2>Subir pieza</h2>

<!-- Formulario principal para enviar la pieza al archivo que la guarda en BD -->
<form action="procesar_pieza.php" method="POST" enctype="multipart/form-data">

Tipo:
<!-- Este selector decide qué campos se muestran en pantalla -->
<select name="tipo" id="tipo" onchange="cambiarFormulario()">
<option value="forma_base">Forma Base</option>
<option value="forma_color">Forma + Color</option>
<option value="pastilla_modelo">Pastilla Modelo</option>
<option value="mastil">Mástil</option>
</select>

<br><br>

<!-- Aquí se insertan los campos dinámicos según el tipo elegido -->
<div id="campos"></div>

<button type="submit">Guardar</button>

<a href="eleccion_admin.php">
    <button type="button">Volver</button>
</a>
</form>

<script>
function cambiarFormulario() {
    
    // Lee el tipo de pieza seleccionado.
    let tipo = document.getElementById("tipo").value;
    // Contenedor donde se van pintando los inputs dinámicos.
    let cont = document.getElementById("campos");

    // Limpia los campos anteriores antes de dibujar los nuevos.
    cont.innerHTML = "";

    if(tipo === "forma_base"){

        // Campos necesarios para registrar una forma base.
        cont.innerHTML += 'Nombre: <input type="text" name="nombre"><br><br>';
        cont.innerHTML += 'Imagen: <input type="file" name="imagen"><br><br>';

    }

    if(tipo === "forma_color"){

        // Campos necesarios para una variante de color de una forma base.
        cont.innerHTML += 'ID Forma Base: <input type="number" name="id_forma_base"><br><br>';
        cont.innerHTML += 'Color: <input type="text" name="color"><br><br>';
        cont.innerHTML += 'Descripcion: <input type="text" name="descripcion"><br><br>';
        cont.innerHTML += 'Precio: <input type="number" step="0.01" name="precio"><br><br>';
        cont.innerHTML += 'Unidades: <input type="number" name="unidades"><br><br>';
        cont.innerHTML += 'GLB Base: <input type="file" name="glb"><br><br>';

    }

    if(tipo === "pastilla_modelo"){

        // Campos necesarios para asociar una pastilla a una forma base.
        cont.innerHTML += 'ID Forma Base: <input type="number" name="id_forma_base"><br><br>';
        cont.innerHTML += 'Tipo: <select name="tipo_pastilla"><option value="humbucker">Humbucker</option><option value="singlecoil">Singlecoil</option></select><br><br>';
        cont.innerHTML += 'GLB Pastilla: <input type="file" name="glb"><br><br>';

    }

    if(tipo === "mastil"){

        // Campos necesarios para registrar un mástil completo.
        cont.innerHTML += 'Nombre: <input type="text" name="nombre"><br><br>';
        cont.innerHTML += 'Descripcion: <input type="text" name="descripcion"><br><br>';
        cont.innerHTML += 'Precio: <input type="number" step="0.01" name="precio"><br><br>';
        cont.innerHTML += 'Forma clavijero: <input type="text" name="forma_clavijero"><br><br>';
        cont.innerHTML += 'Stock: <input type="number" name="stock"><br><br>';
        cont.innerHTML += 'Imagen: <input type="file" name="imagen"><br><br>';
        cont.innerHTML += 'GLB: <input type="file" name="glb"><br><br>';

    }

}

// Carga el formulario inicial al abrir la página.
cambiarFormulario();
</script>


<!-- NOTYF JS -->
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

<script>

// Lee los parámetros de la URL para saber si se acaba de subir una pieza.
const params = new URLSearchParams(window.location.search);
const pieza = params.get("pieza");

if(pieza){

    // Crea el aviso emergente en la esquina superior derecha.
    const notyf = new Notyf({
        duration:4000,
        position:{x:'right',y:'top'}
    });

    if(pieza === "ok"){
        // Mensaje de éxito.
        notyf.success("Pieza subida correctamente");
    }

    if(pieza === "error"){
        // Mensaje de error.
        notyf.error("Error al subir la pieza");
    }

    // Limpia la URL para que el aviso no vuelva a salir al recargar.
    window.history.replaceState({}, document.title, window.location.pathname);
}

</script>

</body>
</html>