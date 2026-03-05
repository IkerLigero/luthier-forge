<?php
header('Content-Type: application/json; charset=utf-8');

error_reporting(E_ALL);
ini_set('display_errors', 0); // IMPORTANTE PARA APIs

require_once __DIR__ . '/conexion.php';

$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode([
        "success" => false,
        "error" => "JSON inválido"
    ]);
    exit;
}

$id_user = 7;

$id_forma = intval($data['id_forma_color'] ?? 0);
$id_mastil = intval($data['id_mastil'] ?? 0);
$id_pastilla = intval($data['id_pastilla_modelo'] ?? 0);

$fecha = date("Y-m-d H:i:s");

try {

    if ($conn->connect_error) {
        throw new Exception("Error de conexión");
    }

    $sql = "INSERT INTO guitarra_usuario 
            (id_usuario, id_forma_color, id_pastilla_modelo, id_mastil, fecha_creacion)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        throw new Exception($conn->error);
    }

    $stmt->bind_param("iiiis", $id_user, $id_forma, $id_pastilla, $id_mastil, $fecha);

    if (!$stmt->execute()) {
        throw new Exception($stmt->error);
    }

    echo json_encode([
        "success" => true,
        "id" => $conn->insert_id
    ]);

} catch (Exception $e) {

    echo json_encode([
        "success" => false,
        "error" => $e->getMessage()
    ]);

}