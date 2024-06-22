
function readUser() {
    console.log ("Leyendo usuarios");
    fetch('read_user.php')
    .then(response => response.json())
    .then(data => {
        const userTableBody = document.getElementById('userTableBody');
        if (!userTableBody) {
            console.error("El elemento userTableBody no se encontró en el DOM");
            return;
        }
        console.log("userTableBody encontrado");
        userTableBody.innerHTML = '';
        data.forEach(user => {
            let row = userTableBody.insertRow();
            row.insertCell(0).innerHTML = user.id;
            row.insertCell(1).innerHTML = user.user_name;
            row.insertCell(2).innerHTML = user.email;
        
        });
    })
    .catch(error => console.error('Error:', error));
}

function checkUsernameExists(user_name) {
    return fetch('check_username.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ user_name: user_name })
    })
    .then(response => response.json());
}

function createUser() {
    const user_name = prompt("Ingrese su nombre de usuario:");

    if (!user_name) {
        alert('El nombre de usuario es requerido');
        return;
    }

    checkUsernameExists(user_name)
        .then(data => {
            if (data.exists) {
                alert('El nombre de usuario ya esta en uso');
            } else {
                const email = prompt("Ingresar email:");
                if (!email) {
                    alert('El email del usuario es requerido');
                    return;
                }
                const data = { user_name: user_name, email: email };

                fetch('create_user.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Datos actualizados correctamente');
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                    alert('Error al enviar los datos');
                });
            }
        })
        .catch((error) => {
            console.error('Error:', error);
            alert('Error al verificar el nombre de usuario');
        });
}


function updateUser() {
    const id = prompt("Ingrese el id del usuario");
    if (!id) {
        alert('ID es requerido');
        return;
    }

    const user_name = prompt("Ingrese el nuevo nombre de usuario:");
    if (!user_name) {
        alert('El nombre de usuario es requerido');
        return;
    }

    checkUsernameExists(user_name)
        .then(data => {
            if (data.exists) {
                alert('El nombre de usuario ya esta en uso');
            } else {
                const email = prompt("Ingresar email:");
                if (!email) {
                    alert('El email del usuario es requerido');
                    return;
                }

                const data = { id: id, user_name: user_name, email: email };

                // Enviar los datos al servidor utilizando fetch
                fetch('update_user.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Datos actualizados correctamente');
                        readUser();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                    alert('Error al enviar los datos');
                });
            }
        })
        .catch((error) => {
            console.error('Error:', error);
            alert('Error al verificar el nombre de usuario');
        });
}


function deleteUser() {
    const id = prompt("Ingrese el ID del usuario:");
    if (!id) {
        alert('El ID es requerido');
        return;
    }

    const user_name = prompt("Ingrese el nombre de usuario:");
    if (!user_name) {
        alert('El nombre de usuario es requerido');
        return;
    }

    const data = { id: id, user_name: user_name };

    fetch('delete_user.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Usuario eliminado correctamente');
            readUser();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch((error) => {
        console.error('Error:', error);
        alert('Error al enviar los datos');
    });
}
