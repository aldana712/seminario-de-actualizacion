<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $id_contactos = $_POST["id_contactos"];
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $email = $_POST["email"];
    $direccion = $_POST["direccion"];

    $sql = "UPDATE contactos SET nombre='$nombre', apellido='$apellido', email='$email', direccion='$direccion' WHERE id_contactos=$id_contactos";

    if ($conexion->query($sql) === TRUE) {
        echo "Los datos del contacto se actualizaron correctamente";
    } else {
        echo "Error al actualizar los datos del contacto: " . $conexion->error;
    }
}


if (isset($_GET['id'])) {
    $id_contactos = $_GET['id'];
    $sql = "SELECT * FROM contactos WHERE id_contactos=$id_contactos";
    $result = $conexion->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nombre = $row["nombre"];
        $apellido = $row["apellido"];
        $email = $row["email"];
        $direccion = $row["direccion"];
    } else {
        echo "No se encontró ningún contacto con ese ID";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Contacto</title>
</head>
<body>
    <h1>Editar Contacto</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="hidden" name="id_contactos" value="<?php echo $id_contactos; ?>">
        Nombre: <input type="text" name="nombre" value="<?php echo $nombre; ?>"><br><br>
        Apellido: <input type="text" name="apellido" value="<?php echo $apellido; ?>"><br><br>
        Email: <input type="text" name="email" value="<?php echo $email; ?>"><br><br>
        Dirección: <input type="text" name="direccion" value="<?php echo $direccion; ?>"><br><br>
        <input type="submit" value="Actualizar">
    </form>
</body>
</html>



