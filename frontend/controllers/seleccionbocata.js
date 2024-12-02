fetch('http://localhost/mibocata/backend/sw_seleccionbocata.php')
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            window.location.href = 'index.html';
        }
    })
    .catch(error => console.error('Error al verificar autenticación:', error));

document.addEventListener("DOMContentLoaded", function () {
    const cerrarSesionBtn = document.getElementById('cerrar-sesion-btn');
    cerrarSesionBtn.addEventListener('click', cerrarSesion);
});

function cerrarSesion() {
    fetch('http://localhost/mibocata/backend/sw_seleccionbocata.php', {
        method: 'POST',
        body: JSON.stringify({ action: "cerrar_sesion" }),
        headers: {
            'Content-Type': 'application/json',
            'Logout-Request': 'true'
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = 'index.html';
            } else {
                alert('Error al cerrar sesión');
            }
        })
        .catch(error => console.error('Error:', error));
}

document.addEventListener("DOMContentLoaded", function () {
    let bocadilloSeleccionado = null;
    const dineroTotal = document.getElementById('dinero-total');
    const botonFrio = document.getElementById('boton-frio');
    const botonCaliente = document.getElementById('boton-caliente');
    const confirmarSeleccionBtn = document.getElementById('confirmar-seleccion-btn');
    const fechaActual = new Date();
    const diasDeLaSemana = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
    const diaActual = diasDeLaSemana[fechaActual.getDay()];

    fetch('http://localhost/mibocata/backend/sw_seleccionbocata.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ dia: diaActual, action: "listar" })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.bocadillos) {
                const bocadillos = data.bocadillos;
                const bocadilloFrio = document.querySelector('#bocadillo-frio');
                const bocadilloCaliente = document.querySelector('#bocadillo-caliente');
                const descripcionFrio = document.querySelector('#descripcion-frio');
                const descripcionCaliente = document.querySelector('#descripcion-caliente');
                const precioFrio = document.querySelector('#precio-frio');
                const precioCaliente = document.querySelector('#precio-caliente');

                if (bocadillos.length > 0) {
                    bocadilloFrio.textContent = bocadillos[0].nombre;
                    descripcionFrio.textContent = bocadillos[0].ingredientes;
                    precioFrio.textContent = `Precio: €${Number.parseFloat(bocadillos[0].pvp)}`;
                    bocadilloCaliente.textContent = bocadillos[1].nombre;
                    descripcionCaliente.textContent = bocadillos[1].ingredientes;
                    precioCaliente.textContent = `Precio: €${Number.parseFloat(bocadillos[1].pvp)}`;
                }
            } else {
                console.error('No se encontraron bocadillos para el día actual');
            }
        })
        .catch(error => console.error('Error al obtener los bocadillos:', error));

    botonFrio.addEventListener('click', function () {
        const bocadilloNombre = document.querySelector('#bocadillo-frio').textContent;
        const precio = parseFloat(document.querySelector('#precio-frio').textContent.replace('Precio: €', ''));
        bocadilloSeleccionado = { nombre: bocadilloNombre, precio: precio };
        dineroTotal.textContent = `${precio}€`;
        botonFrio.style.backgroundColor = "#43a047";
        botonFrio.style.color ="white"
        botonCaliente.style.color = "#e53935";
        botonCaliente.style.backgroundColor= "#f9f9f9";
        botonCaliente.style.border= "2px solid #e53935";
    });

    botonCaliente.addEventListener('click', function () {
        const bocadilloNombre = document.querySelector('#bocadillo-caliente').textContent;
        const precio = parseFloat(document.querySelector('#precio-caliente').textContent.replace('Precio: €', ''));
        bocadilloSeleccionado = { nombre: bocadilloNombre, precio: precio };
        dineroTotal.textContent = `${precio}€`;
        botonCaliente.style.backgroundColor = "#e53935";
        botonCaliente.style.color ="white"
        botonFrio.style.color = "#43a047";
        botonFrio.style.backgroundColor= "#f9f9f9";
        botonFrio.style.border= "2px solid #43a047";
    });

    confirmarSeleccionBtn.addEventListener('click', function () {
        if (bocadilloSeleccionado) {
            const pedido = {
                bocadillo_nombre: bocadilloSeleccionado.nombre,
                retirado: false
            };
            fetch('http://localhost/mibocata/backend/sw_seleccionbocata.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ action: 'añadirpedido', pedido: pedido })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Pedido realizado con éxito');
                        bocadilloSeleccionado = null;
                        dineroTotal.textContent = '0€';
                    } else {
                        alert('Error al realizar el pedido');
                    }
                })
                .catch(error => console.error('Error al realizar el pedido:', error));
        } else {
            alert('Primero selecciona un bocadillo antes de confirmar.');
        }
    });

    const cerrarSesionBtn = document.getElementById('cerrar-sesion-btn');
    cerrarSesionBtn.addEventListener('click', function () {
        fetch('http://localhost/mibocata/backend/sw_seleccionbocata.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: "cerrar_sesion" })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = 'index.html';
                } else {
                    alert('Error al cerrar sesión');
                }
            })
            .catch(error => console.error('Error al cerrar sesión:', error));
    });

    
});
