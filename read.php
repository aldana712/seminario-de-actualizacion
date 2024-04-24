<?php
include 'conexion.php'; 


$sql = "SELECT contactos.*, telefonos.numero 
        FROM contactos 
        LEFT JOIN telefonos ON contactos.id_contactos = telefonos.id_contactos";
$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
    
    while ($row = $resultado->fetch_assoc()) {
        
        echo "<tr>";
        echo "<td>" . $row['id_contactos'] . "</td>";
        echo "<td>" . $row['nombre'] . "</td>";
        echo "<td>" . $row['apellido'] . "</td>";
        echo "<td>" . $row['direccion'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['numero'] . "</td>";
        echo "<td><a href='update.php?id=" . $row['id_contactos'] . "'>Editar</a></td>"; 
        echo "<td><a href='delete.php?id=" . $row['id_contactos'] . "'>Eliminar</a></td>";
        echo "</tr>";
    }
} else {
    
    echo "<tr><td colspan='7'>No hay contactos</td></tr>";
}


$conexion->close();
?>
