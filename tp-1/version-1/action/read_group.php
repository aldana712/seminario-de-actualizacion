<?php
include '../conexion.php';

$sql = "SELECT * FROM user_group";
$result = $conn->query($sql);

$groups = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $groups[] = [
            'id' => $row['id'],
            'name' => $row['name'],
           
        ];
    }
} else {
    echo "No se encontraron grupos";
}

echo json_encode($groups);

$conn->close();
?>