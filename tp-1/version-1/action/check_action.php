<?php
include '../conexion.php';
$data = json_decode(file_get_contents("php://input"), true);

if ($data === null) {
    echo json_encode(['exists' => false, 'message' => 'Invalid JSON received']);
    exit();
}

$name = $data['name'];

if (empty($name)) {
    echo json_encode(['exists' => false, 'message' => 'Nombre de la accion es requerido']);
    $conn->close();
    exit();
}

$stmt = $conn->prepare("SELECT COUNT(*) FROM action WHERE name = ?");
if ($stmt === false) {
    echo json_encode(['exists' => false, 'message' => 'Error en la preparación de la consulta: ' . $conn->error]);
    $conn->close();
    exit();
}

$stmt->bind_param("s", $name);
$stmt->execute();
$stmt->bind_result($count);
$stmt->fetch();

if ($count > 0) {
    echo json_encode(['exists' => true]);
} else {
    echo json_encode(['exists' => false]);
}

$stmt->close();
$conn->close();
?>
