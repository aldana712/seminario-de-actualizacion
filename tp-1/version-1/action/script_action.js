function readAction() {
    console.log ("Leyendo acciones");
    fetch('read_action.php')
    .then(response => response.json())
    .then(data => {
        const actionTableBody = document.getElementById('actionTableBody');
        if (!actionTableBody) {
            console.error("El elemento actionTableBody no se encontró en el DOM");
            return;
        }
        console.log("actionTableBody encontrado");
        actionTableBody.innerHTML = '';
        data.forEach(action => {
            let row = actionTableBody.insertRow();
            row.insertCell(0).innerHTML = action.id;
            row.insertCell(1).innerHTML = action.name;
        
        });
    })
    .catch(error => console.error('Error:', error));
}




function checkAction(name) {
    return fetch('check_action.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({name: name })
    })
    .then(response => response.json());
}
function createAction() {
    const name = prompt("Ingrese una accion:");

    if (!name) {
        alert('La accion es requerida');
        return;
    }

    checkAction(name)
        .then(data => {
            if (data.exists) {
                alert('Ya existe una accion con ese nombre');
            } 
            else {

                const data = { name: name};

                fetch('create_action.php', {
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
                        readAction();
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
            alert('Error al verificar la accion');
        });
}

function updateAction() {
    const id = prompt("Ingrese el id de la accion");
    if (!id) {
        alert('ID es requerido');
        return;
    }

    const name = prompt("Ingrese la nueva accion:");
    if (!name) {
        alert('La accion es requerida');
        return;
    }

    checkAction(name)
        .then(data => {
            if (data.exists) {
                alert('La accion fue creada previamente');
            } else {
               
                const data = { id: id, name:name };

                // Enviar los datos al servidor utilizando fetch
                fetch('update_action.php', {
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
                        readAction();
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
            alert('Error al verificar la accion');
        });
}

function deleteAction() {
    const id = prompt("Ingrese el ID de la accion:");
    if (!id) {
        alert('El ID es requerido');
        return;
    }

    const name = prompt("Ingrese la accion:");
    if (!name) {
        alert('La accion es requerida');
        return;
    }

    const data = { id: id, name: name };

    fetch('delete_action.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Accion eliminada correctamente');
            readAction();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch((error) => {
        console.error('Error:', error);
        alert('Error al enviar los datos');
    });
}
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

function linkGroupAction() {
    const name_group = prompt("Ingrese el nombre de un grupo:");
    if (!name_group) {
        alert('El nombre del grupo es requerido');
        return;
    }
    const name_action = prompt("Ingrese el nombre de una accion");
    if (!name_action){
        alert('El nombre de la accion es requerido');
        return;
    }
    const data = { name_action: name_action,name_group: name_group };

    fetch('link_group_action.php', {
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
