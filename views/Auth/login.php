<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="../../public/css/login.css">

    <script>
        function ingresar(){
            if(!document.form.reportValidity() ){                   //validar datos antes de enviar el formulario
                return;
            }
            document.form.action = "../../controller/UsuarioControlador.php";
            document.form.method = "GET";
            document.form.op.value = "1";
            document.form.submit();    
        }
    </script>
    
    <?php
        session_start();
        $_SESSION['previous_page'] = $_SERVER['REQUEST_URI'];       // Almacena la URL actual
    ?>
    
</head>

<body>
    <main class="cuerpo">
        <section class="cuerpo__contenedor">
            <form name="form" class="form-login">
                <input type="hidden" name="op">
                <h2 class="form-login__titulo">INICIAR SESIÓN</h2>
                <h3 class="form-login__subtitulos"> Correo electrónico </h3>
                <input class="form-login__control" name="Correo" type="email" placeholder="Ingrese su correo" required>
                <h3 class="form-login__subtitulos"> Contraseña </h3>
                <input class="form-login__control" name="Contrasena" type="password" placeholder="Ingrese su contraseña" required>
                <a class="form-login__recupContrasena" href="#">¿Olvidaste tu contraseña?</a>
                <button class="form-login__btnIngresar" onclick="ingresar()" > <img class="form-login__logPerson"> Ingresar </button>
                <p class="form-login__crearCuenta">¿Aún no tienes una cuenta?</p>
                <a class="form-login__crearCuenta__enlace" href="../../views/Auth/register.php">Crear Cuenta</a>
            </form>
        </section>
    </main>
</body>

</html>