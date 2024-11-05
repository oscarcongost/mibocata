function llamdaFetch(){
    const correo = document.getElementById('correo').value
    const pass = document.getElementById('pass').value

    
    const json = {
        action: "find",
        filter: [{correo: correo}, {pass: pass}],
    }

    fetch('http://localhost/mibocata/backend/sw_login.php',{method:"POST",body:JSON.stringify(json),headers:{"content-type":"application/json"}})
        .then((response) => response.json())
        .then((json) => {
            if(json.success){
                console.log(json)
                alert(json.msg)
               // location.href = ruta a donde mandar despues
            }
        })
        .catch((error) => {
            console.log(error)
        })
}