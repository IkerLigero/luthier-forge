<?php
// Inicia la sesión para poder validar la identidad y el rol del usuario.
session_start();

// Si no hay usuario autenticado, se redirige al formulario de acceso.
if(!isset($_SESSION['id_usuario'])){
    header("Location: /luthier_forge/luthier-forge/frontend/auth/login.html");
    exit();
}

// Solo el rol administrador puede continuar; el resto vuelve a la portada.
if($_SESSION['rol'] != 2){
    header("Location: /luthier_forge/luthier-forge/frontend/index.html");
    exit();
}
