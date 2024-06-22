function readAll() {
    fetch('read_all_data.php')
    .then(response => {
        return response.text().then(text => {
            console.log('Raw response:', text); 
            return JSON.parse(text); // convertir la respuesta a JSON
        });
    })
    .then(data => {
        if (data.error) {
            console.error('Error:', data.error);
            return;
        }
        const userTableBody = document.getElementById('userTableBody');
        userTableBody.innerHTML = '';
        data.forEach(user => {
            let row = userTableBody.insertRow();
            row.insertCell(0).innerHTML = user.user_id;
            row.insertCell(1).innerHTML = user.user_name;
            row.insertCell(2).innerHTML = user.group_name;
            row.insertCell(3).innerHTML = user.actions;
        });
    })
    .catch(error => console.error('Error:', error));
}

function redirectTo(url) {
    window.location.href = url;
}