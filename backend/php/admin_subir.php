<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: login_admin.php");
    exit();
}
?>

<h2>Subir archivos GLB</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>Pieza</th>
        <th>Archivo</th>
    </tr>

    <tr>
        <td>Mástil</td>
        <td>
            <form action="procesar_glb.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="tipo" value="mastil">
                <input type="file" name="glb">
                <button type="submit">Subir</button>
            </form>
        </td>
    </tr>

    <tr>
        <td>Forma</td>
        <td>
            <form action="procesar_glb.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="tipo" value="forma">
                <input type="file" name="glb">
                <button type="submit">Subir</button>
            </form>
        </td>
    </tr>

    <tr>
        <td>Pastilla</td>
        <td>
            <form action="procesar_glb.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="tipo" value="pastilla">
                <input type="file" name="glb">
                <button type="submit">Subir</button>
            </form>
        </td>
    </tr>

    <tr>
        <td>Guitarra Forma</td>
        <td>
            <form action="procesar_glb.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="tipo" value="guitarra">
                <input type="file" name="glb">
                <button type="submit">Subir</button>
            </form>
        </td>
    </tr>
</table>