<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: login_admin.php");
    exit();
}
?>

<h1>Panel Administrador</h1>

<a href="admin_subir.php">
    <button>Ir a subir archivos</button>
</a>