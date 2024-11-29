function login() {
    const correo = document.getElementById('correo').value;
    const pass = document.getElementById('pass').value;
    const loginMessage = document.getElementById("login-message");

    let rol;

    // Determinar el rol basado en el correo
    const partes = correo.split("@");
    if (partes[0] === "cocina") {
        rol = "cocina";
    } else {
        rol = "alumno";
    }

    // Verificar si los campos están vacíos
    if (correo === "" || pass === "") {
        loginMessage.textContent = "Usuario o contraseña no introducidos. Inténtalo de nuevo.";
        loginMessage.style.color = "red";
        return; // Detiene la ejecución si faltan datos
    }

    const json = {
        action: "find",
        filter: [{ correo: correo }, { pass: pass }, { rol: rol }]
    };

    // Realizar la solicitud de login
    fetch('http://localhost/mibocata/backend/sw_login.php', {
        method: "POST",
        body: JSON.stringify(json),
        headers: { "Content-Type": "application/json" }
    })
    .then(response => response.json())
    .then(json => {
        if (json.success) {
            // Redirigir dependiendo del rol
            const url = (rol === 'cocina') 
                ? 'http://localhost/mibocata/frontend/cocina.html' 
                : 'http://localhost/mibocata/frontend/seleccionbocata.html';
            location.href = url;
        } else {
            loginMessage.textContent = json.msg; // Mostrar el mensaje de error
            loginMessage.style.color = "red";
        }
    })
    .catch(error => {
        console.error(error);
        loginMessage.textContent = "Error al intentar iniciar sesión. Inténtalo más tarde.";
        loginMessage.style.color = "red";
    });
}
