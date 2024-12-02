document.addEventListener("DOMContentLoaded", function () {
    fetchPedidos();
});

function cerrarSesion() {
    fetch('http://localhost/mibocata/backend/sw_pedido.php', {
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



function fetchPedidos() {
    fetch('http://localhost/mibocata/backend/sw_pedido.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ action: 'listar_pedidos' })
    })
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById('pedidos-body');
            tbody.innerHTML = '';

            if (data.success) {
                data.pedidos.forEach(pedido => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                    <td>${pedido.id}</td>
                    <td>${pedido.alumno_mac}</td>
                    <td>${pedido.bocadillo_nombre}</td>
                    <td>${pedido.fecha}</td>
                    <td>${pedido.hora}</td>
                    <td>
                        <input type="checkbox" class="retirado-checkbox" data-id="${pedido.id}" ${pedido.retirado ? 'checked' : ''}>
                    </td>
                `;
                    tbody.appendChild(tr);
                });

                // Asignar eventos a los checkboxes
                document.querySelectorAll('.retirado-checkbox').forEach(checkbox => {
                    checkbox.addEventListener('change', function () {
                        const id = checkbox.dataset.id;
                        const retirado = checkbox.checked;
                        actualizarRetirado(id, retirado);
                    });
                });
            } else {
                tbody.innerHTML = `<tr><td colspan="6">No se encontraron pedidos.</td></tr>`;
            }
        })
        .catch(error => {
            console.error('Error al obtener los pedidos:', error);
        });
}

function actualizarRetirado(id, retirado) {
    fetch('http://localhost/mibocata/backend/sw_pedido.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ 
            action: 'actualizar_retirado', 
            id: id, 
            retirado: retirado 
        })
    })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                alert('Error al actualizar el estado del pedido.');
            }
        })
        .catch(error => {
            console.error('Error al actualizar el estado:', error);
        });
}
