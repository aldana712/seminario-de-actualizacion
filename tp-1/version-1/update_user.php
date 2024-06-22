<?php
include '../conexion.php';
$data = json_decode(file_get_contents("php://input"), true);

if ($data === null) {
    echo json_encode(['success' => false, 'message' => 'Invalid JSON received']);
    exit();
}

$id = $data['id'];
$user_name = $data['user_name'];
$email = $data['email'];

if (empty($id) || empty($user_name) || empty($email)) {
    echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios']);
    $conn->close();
    exit();
}

$sql = "UPDATE user SET user_name = ?, email = ? WHERE id = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Error en la preparación de la consulta: ' . $conn->error]);
    $conn->close();
    exit();
}

$stmt->bind_param("ssi", $user_name, $email, $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Datos actualizados correctamente']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al actualizar los datos: ' . $stmt->error]);
}

$stmt->close();
$conn->close();

?>