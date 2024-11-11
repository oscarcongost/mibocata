// seleccionbocata.js

// Realizar una solicitud a seleccionbocata.php para verificar autenticación
fetch('../backend/seleccionbocata.php')
    .then(response => response.json())
    .then(data => {
        console.log("Json bocata: ", data);
        if (data.success) {
            // Si el usuario no está autenticado, redirigir a index.html
        } else {
            window.location.href = 'index.html';
            // Aquí puedes añadir la lógica que necesites cuando el usuario esté autenticado
        }
    })
    .catch(error => console.error('Error al verificar autenticación:', error));

