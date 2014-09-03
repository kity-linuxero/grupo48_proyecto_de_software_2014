    function userPass() {
        var un = formulario.nombre.value;
        var pw = formulario.pass.value;
        var username = "admin"; 
        var password = "admin";
        if ((un == username) && (pw == password)) {
            /* window.location = "backend.html"*/
            /* alert ("Usuario y contraseña correctas.");*/
            window.open("backend.html");
            return false;
        }
        else {
            alert ("Usuario o contraseña incorrectas.");
        }
 }

