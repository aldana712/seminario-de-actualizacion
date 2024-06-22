<?php
include '../conexion.php';

$data = json_decode(file_get_contents("php://input"), true);

if ($data === null) {
    echo json_encode(['success' => false, 'message' => 'Invalid JSON received']);
    exit();
}

$user_name = $data['user_name'] ?? '';
$name = $data['name'] ?? '';

if (empty($user_name) || empty($name)) {
    echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios']);
    $conn->close();
    exit();
}

// Obtener el ID del usuario
$sql_user = "SELECT id FROM user WHERE user_name = ?";
$stmt_user = $conn->prepare($sql_user);

if ($stmt_user === false) {
    echo json_encode(['success' => false, 'message' => 'Error en la preparación de la consulta de usuario: ' . $conn->error]);
    $conn->close();
    exit();
}

$stmt_user->bind_param("s", $user_name);
$stmt_user->execute();
$stmt_user->bind_result($id_user);
$stmt_user->fetch();
$stmt_user->close();

if (empty($id_user)) {
    echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
    $conn->close();
    exit();
}

// Obtener el ID del grupo
$sql_group = "SELECT id FROM user_group WHERE name = ?";
$stmt_group = $conn->prepare($sql_group);

if ($stmt_group === false) {
    echo json_encode(['success' => false, 'message' => 'Error en la preparación de la consulta de grupo: ' . $conn->error]);
    $conn->close();
    exit();
}

$stmt_group->bind_param("s", $name);
$stmt_group->execute();
$stmt_group->bind_result($group_id);
$stmt_group->fetch();
$stmt_group->close();

if (empty($group_id)) {
    echo json_encode(['success' => false, 'message' => 'Grupo no encontrado']);
    $conn->close();
    exit();
}

// Insertar en la tabla intermedia
$sql_link = "INSERT INTO user_group_member (id_user, id_user_group) VALUES (?, ?)";
$stmt_link = $conn->prepare($sql_link);

if ($stmt_link === false) {
    echo json_encode(['success' => false, 'message' => 'Error en la preparación de la consulta de vinculación: ' . $conn->error]);
    $conn->close();
    exit();
}

$stmt_link->bind_param("ii", $id_user, $group_id);

if ($stmt_link->execute()) {
    echo json_encode(['success' => true, 'message' => 'Usuario vinculado correctamente']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al ejecutar la consulta de vinculación: ' . $stmt_link->error]);
}

$stmt_link->close();
$conn->close();
?>
