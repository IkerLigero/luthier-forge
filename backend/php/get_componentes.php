<?php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/conexion.php';

$response = ["formas" => [], "mastiles" => [], "pastillas" => []];

try {
    // 1. Cuerpos: Traemos la descripción del color pero la imagen de la forma base
    $resFormas = mysqli_query($conn, "SELECT fc.id_forma_color as id, fc.descripcion as nombre, fb.imagen as img, fc.referencia_glb as glb 
                                      FROM forma_color fc 
                                      JOIN forma_base fb ON fc.id_forma_base = fb.id_forma_base");
    while ($row = mysqli_fetch_assoc($resFormas)) {
        $response["formas"][] = $row;
    }

    // 2. Mástiles: Estos son independientes
    $resMastiles = mysqli_query($conn, "SELECT id_mastil as id, nombre, imagen as img, referencia_glb as glb FROM mastil");
    while ($row = mysqli_fetch_assoc($resMastiles)) {
        $response["mastiles"][] = $row;
    }

    $resPastillas = mysqli_query($conn, "SELECT 
    id_pastilla_modelo as id, 
    tipo as nombre, 
    imagen_pastillas as img, 
    referencia_glb as glb 
    FROM pastilla_modelo");

    while ($row = mysqli_fetch_assoc($resPastillas)) {
        $response["pastillas"][] = $row;
    }

} catch (Exception $e) {
    $response["error"] = $e->getMessage();
}

echo json_encode($response);