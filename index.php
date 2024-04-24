<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda</title>
    <link rel="preload" href="styles.css" as="style">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <form class="formulario" action="create.php" method="post">
            <h1>Crear contacto</h1>
            <input type="text" name= "nombre" placeholder= "Nombre">
            <input type="text" name= "apellido" placeholder= "Apellido"> 
            <input type="text" name= "direccion" placeholder= "Direccion">
            <input type="text" name= "email" placeholder= "Email">
            <input type="tel"name= "numero" placeholder= "Numero">
            <input type="submit" value= "Agregar">
        </form>
    </div>
    <div>
        <h2>Contactos</h2>
        <table class="tabla">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Direccion</th>
                    <th>Email</th>
                    <th>Numero de telefono</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    include 'read.php'
                ?>
            </tbody>
        </table>


    </div>

</body>
</html>