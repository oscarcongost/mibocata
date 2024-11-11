function llamdaFetch(){
    const correo = document.getElementById('correo').value
    const pass = document.getElementById('pass').value

    // Validación: Verificar si los campos están vacíos
    if (correo === "" || pass === "") {
        console.log("Error: Los campos de correo y contraseña no pueden estar vacíos.");
        return; // Detener la ejecución si faltan datos
    }

    const json = {
        action: "find",
        filter: [{correo: correo}, {pass: pass}],
    }

    fetch('http://localhost/mibocata/backend/sw_login.php',{method:"POST",body:JSON.stringify(json),headers:{"content-type":"application/json"}})
        .then((response) => response.json())
        .then((json) => {
            console.log("Json login: ", json);
            if(json.success){
                console.log(json)
                location.href = 'http://localhost/mibocata/frontend/seleccionbocata.html'
            }
        })
        .catch((error) => {
            console.log(error)
        })
}