<?php

include "conexion.php";


if (isset($_GET['id'])) {
    
    $id_contactos = $_GET['id'];
    
    $sql_delete_telefonos = "DELETE FROM telefonos WHERE id_contactos = $id_contactos";
    
    if ($conexion->query($sql_delete_telefonos) === TRUE) {
        
        $sql_delete_contacto = "DELETE FROM contactos WHERE id_contactos = $id_contactos";
        
        if ($conexion->query($sql_delete_contacto) === TRUE) {
           
            echo "El contacto se elimino correctamente";
        } else {
            
            echo "Error al eliminar el contacto: " . $conexion->error;
        }
    } else {
        
        echo "Error al eliminar los telefonos asociados al contacto: " . $conexion->error;
    }
} else {
   
    echo "ID de contacto no valido";
}
?>

