    function userPass() {
        var un = formulario.nombre.value;
        var pw = formulario.pass.value;
        var username = "admin"; 
        var password = "admin";
        if ((un == username) && (pw == password)) {
          /*  window.close();*/
            window.open("backend.html");
            
            return false;
        }
        else {
            alert ("Usuario o contraseña incorrectas.\nUse: admin/admin");
        }
 }

