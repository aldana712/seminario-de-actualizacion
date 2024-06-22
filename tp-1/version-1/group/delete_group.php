<?php
include '../conexion.php';
$data = json_decode(file_get_contents("php://input"), true);

if ($data === null) {
    echo json_encode(['success' => false, 'message' => 'Invalid JSON received']);
    exit();
}

$id = $data['id'];
$name = $data['name'];

if (empty($id) || empty($name)) {
    echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios']);
    $conn->close();
    exit();
}

$sql = "DELETE FROM user_group WHERE id = ? AND name = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Error en la preparación de la consulta: ' . $conn->error]);
    $conn->close();
    exit();
}


$stmt->bind_param("is", $id, $name);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Grupo eliminado correctamente']);
    } else {
        echo json_encode(['success' => false, 'message' => 'No se encontró el grupo para eliminar']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Error al ejecutar la consulta: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
