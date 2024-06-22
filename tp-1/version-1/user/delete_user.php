<?php
include '../conexion.php';
$data = json_decode(file_get_contents("php://input"), true);

if ($data === null) {
    echo json_encode(['success' => false, 'message' => 'Invalid JSON received']);
    exit();
}

$id = $data['id'];
$user_name = $data['user_name'];

if (empty($id) || empty($user_name)) {
    echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios']);
    $conn->close();
    exit();
}

$sql = "DELETE FROM user WHERE id = ? AND user_name = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Error en la preparación de la consulta: ' . $conn->error]);
    $conn->close();
    exit();
}

// Asumiendo que id es un entero y user_name es una cadena
$stmt->bind_param("is", $id, $user_name);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Usuario eliminado correctamente']);
    } else {
        echo json_encode(['success' => false, 'message' => 'No se encontró el usuario para eliminar']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Error al ejecutar la consulta: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
