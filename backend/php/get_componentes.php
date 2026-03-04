<?php
// Limpiamos cualquier salida previa
ob_start();
header('Content-Type: application/json; charset=utf-8');

// Desactivar errores visibles (que no rompan el JSON)
ini_set('display_errors', 0);
error_reporting(E_ALL);

require_once __DIR__ . '/conexion.php';

$response = ["formas" => [], "mastiles" => [], "pastillas" => []];

try {
    if (!$conn) throw new Exception("Error de conexión");

    // 1. Cuerpos (Cruzamos con forma_base para traer la imagen correcta)
    $resFormas = mysqli_query($conn, "SELECT fc.id_forma_color as id, fc.descripcion as nombre, fb.imagen as img, fc.referencia_glb as glb FROM forma_color fc JOIN forma_base fb ON fc.id_forma_base = fb.id_forma_base");
    while($row = mysqli_fetch_assoc($resFormas)) { $response["formas"][] = $row; }

    // 2. Mástiles
    $resMastiles = mysqli_query($conn, "SELECT id_mastil as id, nombre, imagen as img, referencia_glb as glb FROM mastil");
    while($row = mysqli_fetch_assoc($resMastiles)) { $response["mastiles"][] = $row; }

    // 3. Pastillas (Como no tienen imagen en tu SQL, usamos la de la forma base por defecto)
    $resPastillas = mysqli_query($conn, "SELECT p.id_pastilla_modelo as id, p.tipo as nombre, p.referencia_glb as glb, fb.imagen as img FROM pastilla_modelo p JOIN forma_base fb ON p.id_forma_base = fb.id_forma_base");
    while($row = mysqli_fetch_assoc($resPastillas)) { $response["pastillas"][] = $row; }

} catch (Exception $e) {
    $response["error"] = $e->getMessage();
}

ob_end_clean();
echo json_encode($response);