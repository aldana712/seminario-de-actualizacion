<?php
include 'conexion.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $direccion = $_POST["direccion"];
    $email = $_POST["email"];
    $numero = $_POST["numero"];

   
    $sql = "INSERT INTO contactos (nombre, apellido, direccion, email) VALUES (?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    
    $stmt->bind_param("ssss", $nombre, $apellido, $direccion, $email);
    
    $stmt->execute();

    if ($stmt->affected_rows > 0) {

        $id_contacto = $stmt->insert_id;
        
       
        $sql_tel = "INSERT INTO telefonos (numero, id_contactos) VALUES (?, ?)";
        $stmt_tel = $conexion->prepare($sql_tel);

        $stmt_tel->bind_param("si", $numero, $id_contacto);

        $stmt_tel->execute();

        if ($stmt_tel->affected_rows > 0) {
            echo "Contacto agregado correctamente.";
        } else {
            echo "Error al agregar el número de teléfono.";
        }
        
        $stmt_tel->close();
    } else {
        echo "Error al agregar el contacto.";
    }

    $stmt->close();
}
?>

?>
