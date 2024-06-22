<?php
include '../conexion.php';

$data = json_decode(file_get_contents("php://input"), true);

if ($data === null) {
    echo json_encode(['success' => false, 'message' => 'Invalid JSON received']);
    exit();
}

$name_group = $data['name_group'] ?? '';
$name_action = $data['name_action'] ?? '';

if (empty($name_group) || empty($name_action)) {
    echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios']);
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

$stmt_group->bind_param("s", $name_group);
$stmt_group->execute();
$stmt_group->bind_result($group_id);
$stmt_group->fetch();
$stmt_group->close();

if (empty($group_id)) {
    echo json_encode(['success' => false, 'message' => 'Grupo no encontrado']);
    $conn->close();
    exit();
}

// Obtener el ID de la acción
$sql_action = "SELECT id FROM action WHERE name = ?";
$stmt_action = $conn->prepare($sql_action);

if ($stmt_action === false) {
    echo json_encode(['success' => false, 'message' => 'Error en la preparación de la consulta de acción: ' . $conn->error]);
    $conn->close();
    exit();
}

$stmt_action->bind_param("s", $name_action);
$stmt_action->execute();
$stmt_action->bind_result($action_id);
$stmt_action->fetch();
$stmt_action->close();

if (empty($action_id)) {
    echo json_encode(['success' => false, 'message' => 'Acción no encontrada']);
    $conn->close();
    exit();
}

// Insertar en la tabla intermedia
$sql_link = "INSERT INTO group_action (id_action, id_group) VALUES (?, ?)";
$stmt_link = $conn->prepare($sql_link);

if ($stmt_link === false) {
    echo json_encode(['success' => false, 'message' => 'Error en la preparación de la consulta de vinculación: ' . $conn->error]);
    $conn->close();
    exit();
}

$stmt_link->bind_param("ii", $action_id, $group_id);

if ($stmt_link->execute()) {
    echo json_encode(['success' => true, 'message' => 'Grupo vinculado correctamente']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al ejecutar la consulta de vinculación: ' . $stmt_link->error]);
}

$stmt_link->close();
$conn->close();
?>
