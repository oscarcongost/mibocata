function obtenerPedidos() {
    // Elementos HTML donde se mostrarán los mensajes
    var ul = document.getElementById("listado-pedidos");
    var mensaje = document.getElementById("mensaje");
    var seccion_datos = document.getElementById("seccion-datos");

    // Estructura de los datos para la solicitud
    var data = {
        action: "get",  // Acción "get" para obtener los pedidos
        data: {
            filters: {},  // No hay filtros
        }
    };

    // Realizar el fetch a sw_pedido.php para obtener los pedidos
    fetch("../backend/sw_pedido.php", {
        headers: {
            "Content-Type": "application/json; charset=utf-8",
            'Accept': 'application/json'
        },
        method: 'POST',
        body: JSON.stringify(data)
    })
    .then((response) => response.json())
    .catch((error) => console.error("Error:", error))
    .then(function (json) {
        console.log("Pedidos: ", json);
        
        if (json.rol == "alumno") {
            mensaje.innerHTML = "El usuario no tiene permisos para acceder a esta sección";
            seccion_datos.className = "no-mostrar";
        } else if (json.success == false) {
            mensaje.innerHTML = json.msg;
            seccion_datos.className = "no-mostrar";
        } else {
            ul.innerHTML = ""; // Limpiar la lista de pedidos
            seccion_datos.className = ""; // Mostrar la sección de datos
            
            // Si hay pedidos
            if (json.data.data.length >= 1) {
                mensaje.innerHTML = ""; // Limpiar mensaje de error
                for (i = 0; i < json.data.data.length; i++) {
                    var li = document.createElement("li");
                    var div = document.createElement("div");

                    // Crear elementos con los datos del pedido
                    var p_nombre_alumno = document.createElement("p");
                    p_nombre_alumno.innerHTML = json.data.data[i].nombre_alumno;

                    var p_bocadillo = document.createElement("p");
                    p_bocadillo.innerHTML = json.data.data[i].bocadillo_nombre;

                    var p_fecha = document.createElement("p");
                    p_fecha.innerHTML = json.data.data[i].fecha;

                    var p_hora = document.createElement("p");
                    p_hora.innerHTML = json.data.data[i].hora;

                    var p_retirado = document.createElement("p");
                    p_retirado.innerHTML = json.data.data[i].retirado ? "Sí" : "No";

                    // Agregar los datos al div
                    div.appendChild(p_nombre_alumno);
                    div.appendChild(p_bocadillo);
                    div.appendChild(p_fecha);
                    div.appendChild(p_hora);
                    div.appendChild(p_retirado);

                    // Agregar el div al li y el li a la lista
                    li.appendChild(div);
                    ul.appendChild(li);
                }
            } else {
                mensaje.innerHTML = "No hay pedidos disponibles";
            }
        }
    });
}
