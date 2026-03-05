<?php
session_start();

if(!isset($_SESSION['id_usuario'])){
    header("Location: ../../frontend/auth/login.html");
    exit();
}

if(!isset($_SESSION['rol']) || $_SESSION['rol'] != 2){
    header("Location: ../../frontend/index.html");
    exit();
}