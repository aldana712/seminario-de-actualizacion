function readGroup() {
    console.log ("Leyendo grupos");
    fetch('read_group.php')
    .then(response => response.json())
    .then(data => {
        const user_groupTableBody = document.getElementById('user_groupTableBody');
        if (!user_groupTableBody) {
            console.error("El elemento user_groupTableBody no se encontró en el DOM");
            return;
        }
        console.log("user_groupTableBody encontrado");
        user_groupTableBody.innerHTML = '';
        data.forEach(user_group => {
            let row = user_groupTableBody.insertRow();
            row.insertCell(0).innerHTML = user_group.id;
            row.insertCell(1).innerHTML = user_group.name;
        
        });
    })
    .catch(error => console.error('Error:', error));
}




function checkUserGroupExists(name) {
    return fetch('check_user_group.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({name: name })
    })
    .then(response => response.json());
}
function createGroup() {
    const name = prompt("Ingrese el nombre del grupo:");

    if (!name) {
        alert('El nombre del grupo es requerido');
        return;
    }

    checkUserGroupExists(name)
        .then(data => {
            if (data.exists) {
                alert('Ya existe el grupo con ese nombre');
            } 
            else {

                const data = { name: name};

                fetch('create_group.php', {
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
                        readGroup();
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
            alert('Error al verificar el nombre del grupo');
        });
}

function updateGroup() {
    const id = prompt("Ingrese el id del grupo");
    if (!id) {
        alert('ID es requerido');
        return;
    }

    const name = prompt("Ingrese el nuevo nombre del grupo:");
    if (!name) {
        alert('El nombre del grupo es requerido');
        return;
    }

    checkUserGroupExists(name)
        .then(data => {
            if (data.exists) {
                alert('El grupo ya fue creado previamente');
            } else {
               
                const data = { id: id, name:name };

                // Enviar los datos al servidor utilizando fetch
                fetch('update_group.php', {
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
                        readGroup();
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
            alert('Error al verificar el nombre del grupo');
        });
}

function deleteGroup() {
    const id = prompt("Ingrese el ID del Grupo:");
    if (!id) {
        alert('El ID es requerido');
        return;
    }

    const name = prompt("Ingrese el nombre del grupo:");
    if (!name) {
        alert('El nombre del grupo es requerido');
        return;
    }

    const data = { id: id, name: name };

    fetch('delete_group.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Grupo eliminado correctamente');
            readGroup();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch((error) => {
        console.error('Error:', error);
        alert('Error al enviar los datos');
    });
}


function linkUsersGroups() {
    const user_name = prompt("Ingrese el nombre de un usuario:");
    if (!user_name) {
        alert('El nombre del usuario es requerido');
        return;
    }
    const name = prompt("Ingrese el nombre del grupo");
    if (!name){
        alert('El nombre del grupo es requerido');
        return;
    }
    const data = { user_name, name };

    fetch('link_group.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Usuario vinculado correctamente');
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch((error) => {
        console.error('Error:', error);
        alert('Error al enviar los datos');
    });
}

function readUser() {
    console.log("Leyendo usuarios");
    fetch('read_user_group.php')  // Ruta ajustada
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
        }
        return response.json();
    })
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
