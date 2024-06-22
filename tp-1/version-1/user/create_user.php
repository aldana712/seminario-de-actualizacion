<?php
include '../conexion.php';
$data = json_decode(file_get_contents("php://input"), true);

if ($data === null) {
    echo json_encode(['success' => false, 'message' => 'Invalid JSON received']);
    exit();
}

$user_name = $data['user_name'];
$email = $data['email'];

if (empty($user_name) || empty($email)) {
    echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios']);
    $conn->close();
    exit();
}


$stmt = $conn->prepare("INSERT INTO user (user_name, email) VALUES (?, ?)");

if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Error en la preparación de la consulta: ' . $conn->error]);
    $conn->close();
    exit();
}

$stmt->bind_param("ss", $user_name, $email);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Datos actualizados correctamente']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al actualizar los datos: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
