<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: login_admin.php");
    exit();
}
?>

<h2>Subir pieza</h2>

<form action="procesar_pieza.php" method="POST" enctype="multipart/form-data">

Tipo de pieza:
<select name="tipo" id="tipo" onchange="cambiarFormulario()">
    <option value="forma">Forma</option>
    <option value="mastil">Mastil</option>
    <option value="pastilla">Pastilla</option>
</select>

<br><br>

Nombre: <input type="text" name="nombre"><br><br>
Descripcion: <input type="text" name="descripcion"><br><br>
Precio: <input type="number" step="0.01" name="precio"><br><br>
Stock: <input type="number" name="stock"><br><br>

<div id="campos_mastil">
    Calidad: <input type="text" name="calidad"><br><br>
    Material: <input type="text" name="material"><br><br>
</div>

<div id="campos_pastilla">
    ID Forma: <input type="number" name="id_forma"><br><br>
    Tipo Pastilla:
    <select name="tipo_pastilla">
        <option value="humbucker">Humbucker</option>
        <option value="singlecoil">Singlecoil</option>
    </select><br><br>
</div>

Imagen: <input type="file" name="imagen"><br><br>
Archivo GLB: <input type="file" name="glb"><br><br>

<button type="submit">Subir</button>
</form>

<script>
function cambiarFormulario() {
    var tipo = document.getElementById("tipo").value;

    document.getElementById("campos_mastil").style.display = "none";
    document.getElementById("campos_pastilla").style.display = "none";

    if (tipo === "mastil") {
        document.getElementById("campos_mastil").style.display = "block";
    }

    if (tipo === "pastilla") {
        document.getElementById("campos_pastilla").style.display = "block";
    }
}

cambiarFormulario();
</script>