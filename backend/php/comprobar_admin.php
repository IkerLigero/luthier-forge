<?php
session_start();

if(!isset($_SESSION['id_usuario'])){
    header("Location: /luthier_forge/luthier-forge/frontend/auth/login.html");
    exit();
}

if($_SESSION['rol'] != 2){
    header("Location: /luthier_forge/luthier-forge/frontend/index.html");
    exit();
}