<?php
include 'conexion.php'; 

error_reporting(E_ALL);
ini_set('display_errors', 1);


header('Content-Type: application/json');


$sql = "SELECT 
            u.id AS user_id, 
            u.user_name, 
            g.name AS group_name, 
            GROUP_CONCAT(a.name SEPARATOR ', ') AS actions
        FROM user u
        INNER JOIN user_group_member ugm ON u.id = ugm.id_user
        INNER JOIN user_group g ON ugm.id_user_group = g.id
        INNER JOIN group_action ga ON g.id = ga.id_group
        INNER JOIN action a ON ga.id_action = a.id
        GROUP BY u.id, g.name";

$result = $conn->query($sql);

if (!$result) {
    echo json_encode(['error' => $conn->error]);
    exit;
}

$users = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $users[] = [
            'user_id' => $row['user_id'],
            'user_name' => $row['user_name'],
            'group_name' => $row['group_name'],
            'actions' => $row['actions']
        ];
    }
} else {
    echo json_encode(['error' => 'No se encontraron usuarios']);
    exit;
}

echo json_encode($users);

$conn->close();
?>
