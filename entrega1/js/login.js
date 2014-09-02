    function userPass() {
        var un = formulario.nombre.value;
        var pw = formulario.pass.value;
        var username = "username"; 
        var password = "password";
        if ((un == username) && (pw == password)) {
            /* window.location = "main.html";*/
            alert ("Usuario y contraseña correctas.");
            return false;
        }
        else {
            alert ("Usuario o contraseña incorrectas.");
        }
 }

