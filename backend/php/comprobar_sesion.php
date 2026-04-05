<?php
// Inicia la sesión para comprobar si el usuario ya ha iniciado sesión.
session_start();

// Si no existe un usuario autenticado, se fuerza el regreso al login.
if(!isset($_SESSION['id_usuario'])){
    header("Location: /luthier_forge/luthier-forge/frontend/auth/login.html");
    exit();
}
