<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <link rel="stylesheet" href="../../public/css/register.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>

    <script>
        function validarCorreo() {
            const correoInput = document.form.Correo;
            const correo = correoInput.value;

            // Verificar si el correo termina en .com o .pe
            const regex = /\.(com|pe)$/;
            
            if (!regex.test(correo)) {
                // Mensaje de error personalizado
                correoInput.setCustomValidity("El correo debe terminar en .com o .pe");
            } else {
                // Si es válido, limpiar el mensaje de error
                correoInput.setCustomValidity("");
            }
        }

        function validarContrasena() {
        const passwordInput = document.form.Contrasena;

        // Verificación de mínimo 8 caracteres
        if (passwordInput.value.length < 8) {
            passwordInput.setCustomValidity("La contraseña debe tener al menos 8 caracteres.");
        } else {
            // Si es válida, limpiar el mensaje de error
            passwordInput.setCustomValidity("");
        }
        }

        function registrarUsuario() {
            if (!document.form.reportValidity()) {
                return;
            }

            // Verificar que las contraseñas coincidan
            if (document.form.Contrasena.value != document.form.Contrasena2.value) {
                alert("Las contraseñas no son iguales.");
                return;
            }

            document.form.action = "../../controller/UsuarioControlador.php";
            document.form.op.value = "2";
            document.form.method = "GET";
            document.form.submit();
        }
    </script>

    <?php
        include_once '../../util/ConexionBD.php';
        $objc = new ConexionBD();
        $con = $objc->getConexionBD();
        $sql = "SELECT * FROM distrito";
        $rs = mysqli_query($con,$sql);
    ?>

</head>

<body>
    <header class="header">
        <img src="../../../public/img/logo.png">
    </header>
    <main class="cuerpo">
        <section class="cuerpo__contenedor_register">
            <h1 class="form-register_titulo">CREAR CUENTA</h1>
            <form name="form" class="form-register">
                <input type="hidden" name="op">
                <img src="../../../public/img/UsuarioRegistro.png">
                <h3 class="form-register__subtitulos"> Nombres </h3>
                <input class="form-register__control"  type= "text" name="Nombres" placeholder="Ingrese sus Nombres" required >
                <h3 class="form-register__subtitulos"> Apellido Paterno </h3>
                <input class="form-register__control"  type= "text" name="ApellidoPaterno" placeholder="Ingrese su Apellido" required >
                <h3 class="form-register__subtitulos"> Apellido Materno </h3>
                <input class="form-register__control" type= "text" name="ApellidoMaterno" placeholder="Ingrese su Apellido" required >          
                <h3 class="form-register__subtitulos"> Fecha de Nacimiento</h3>
                <input class="form-register__control" type= "date" name="FechaNacimiento" placeholder="Ingrese su Fecha de Nacimiento" required >             
                <h3 class="form-register__subtitulos"> Teléfono </h3>
                <input class="form-register__control" type= "text" name="Telefono" placeholder="Ingrese su teléfono" required >          
                <h3 class="form-register__subtitulos"> DNI </h3>
                <input class="form-register__control" type= "text" name="DNI" placeholder="Ingrese su DNI" required >                  
                <h3 class="form-register__subtitulos"> Distrito</h3>
                <select class="form-register__control" name="Distrito" required>
                    <option value="" disabled selected>Seleccione un distrito</option>
                    <?php 
                        while($row = mysqli_fetch_array($rs))
                        {
                            $id= $row['IdDistrito'];
                            $nombre = $row['NombreDistrito'];
                    ?>
                        <option value="<?php echo $id ?>"><?php echo $nombre ?></option>
                        <?php
                        }
                        ?>
                </select>                  
                <h3 class="form-register__subtitulos"> Dirección</h3>
                <input class="form-register__control" type= "text" name="Direccion" placeholder="Ingrese su Dirección" required >             
                <h3 class="form-register__subtitulos"> Correo </h3>
                <input class="form-register__control" type= "email" name="Correo" placeholder="Ingrese su correo" required oninput="validarCorreo()" >
                <h3 class="form-register__subtitulos"> Contraseña </h3>
                <input class="form-register__control" type= "password" name="Contrasena" placeholder="Ingrese su contraseña"  required oninput="validarContrasena()" >
                <h3 class="form-register__subtitulos"> Confirmar contraseña </h3>
                <input class="form-register__control" type= "password" name="Contrasena2" placeholder="Ingrese su contraseña"  required >   
                <button class="btnRegistrarse" onclick="registrarUsuario()">Registrar</button>              
            </form>
        </section>
    </main>
</body>
</html>