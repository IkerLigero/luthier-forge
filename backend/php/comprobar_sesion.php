<?php
session_start();

if(!isset($_SESSION['id_usuario'])){
    header("Location: /luthier_forge/luthier-forge/frontend/auth/login.html");
    exit();
}