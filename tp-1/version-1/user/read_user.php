<?php
include '../conexion.php';

$sql = "SELECT * FROM user";
$result = $conn->query($sql);

$users = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $users[] = [
            'id' => $row['id'],
            'user_name' => $row['user_name'],
            'email' => $row['email']
        ];
    }
} else {
    echo "No se encontraron usuarios";
}

echo json_encode($users);

$conn->close();
?>