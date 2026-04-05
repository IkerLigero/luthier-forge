<?php
// Inicia la sesión para poder limpiar todos los datos del usuario activo.
session_start();

// Elimina las variables de sesión y destruye la sesión actual.
session_unset();
session_destroy();

// Redirige al formulario de acceso después de cerrar sesión.
header("Location: ../../frontend/auth/login.html");
exit();
