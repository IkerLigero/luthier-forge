<?php
session_start();

if(!isset($_SESSION['id_usuario'])){
    header("Location: ../../frontend/auth/login.html");
    exit();
}

if($_SESSION['rol'] != "admin"){
    header("Location: ../../frontend/index.html");
    exit();
}