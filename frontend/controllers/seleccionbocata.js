// seleccionbocata.js

// Realizar una solicitud a seleccionbocata.php para verificar autenticación
fetch('http://localhost/mibocata/backend/sw_seleccionbocata.php')
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

// seleccionbocata.js

// Esperar a que el DOM esté cargado antes de agregar el event listener
document.addEventListener("DOMContentLoaded", function() {
    // Seleccionar el botón de cerrar sesión por su ID
    const cerrarSesionBtn = document.getElementById('cerrar-sesion-btn');
    
    // Agregar el event listener para el clic en el botón de cerrar sesión
    cerrarSesionBtn.addEventListener('click', cerrarSesion);
});

// Función que realiza la solicitud para cerrar la sesión en el servidor
function cerrarSesion() {
    fetch('http://localhost/mibocata/backend/sw_seleccionbocata.php', {
        method: 'POST',
        body: JSON.stringify({
            action: "cerrar_sesion"
        }),
        headers: {
            'Content-Type': 'application/json',
            'Logout-Request': 'true' // Encabezado personalizado para identificar la solicitud de cierre de sesión
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Redirigir al usuario a la página de inicio de sesión
            window.location.href = 'index.html';
        } else {
            alert('Error al cerrar sesión');
        }
    })
    .catch(error => console.error('Error:', error));
}



