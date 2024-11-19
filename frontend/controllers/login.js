function llamdaFetch(){
    const correo = document.getElementById('correo').value
    const pass = document.getElementById('pass').value
    const loginMessage = document.getElementById("login-message");

    // Validación: Verificar si los campos están vacíos
    if (correo === "" || pass === "") {
        console.log("Error: Los campos de correo y contraseña no pueden estar vacíos.");
        loginMessage.textContent = "Usuario o contraseña no introducidos. Inténtalo de nuevo."
        loginMessage.style.color = "red";
        return; // Detener la ejecución si faltan datos
    }
    

    const json = {
        action: "find",
        filter: [{correo: correo}, {pass: pass}],
    }

    fetch('http://localhost/mibocata/backend/sw_login.php',{
        method:"POST",
        body:JSON.stringify(json),
        headers:{"content-type":"application/json"}
    })
        .then((response) => response.json())
        .then((json) => {
            console.log("Json login: ", json);
            if(json.success){
                console.log(json)
                location.href = 'http://localhost/mibocata/frontend/seleccionbocata.html'
            } else {
                loginMessage.textContent = "Usuario o contraseña incorrectos. Inténtalo de nuevo."
                loginMessage.style.color = "red";
            }
        })
        .catch((error) => {
            console.log(error)
        })
}