<?php
include '../conexion.php';

$sql = "SELECT * FROM action ";
$result = $conn->query($sql);

$actions = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $actions[] = [
            'id' => $row['id'],
            'name' => $row['name'],

        ];
    }
} else {
    echo "No se encontraron acciones";
}

echo json_encode($actions);

$conn->close();
?>