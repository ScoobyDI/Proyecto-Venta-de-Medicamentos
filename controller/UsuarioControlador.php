<?php
require_once '../model/UsuarioBean.php';
require_once '../model/UsuarioDao.php';

session_start();

$op = $_GET['op'];

switch($op) {

    case 1: {
        //Verificar usuario
        $correo = $_GET['Correo'];
        $contrasena = $_GET['Contrasena'];
        
        $objUsuarioBean = new UsuarioBean();
        $objUsuarioBean->setCorreoElectronico($correo);
        $objUsuarioBean->setContrasena($contrasena);

        $objUsuarioDao = new UsuarioDao();

        $rs = $objUsuarioDao->estaRegistradoUsuario($objUsuarioBean);

        if ($rs) {
            session_start();
            $_SESSION['CorreoElectronico'] = $objUsuarioBean->getCorreoElectronico(); 
 
            $pagina = "../views/Admin/perfilAdmin.php";
        } else {
            $pagina = "../index.php";
        }
    
        break;
    }

    case 2: {
        //Agregar usuario
        $nombres = $_GET["Nombres"];
        $apellidopaterno = $_GET["ApellidoPaterno"];
        $apellidomaterno = $_GET["ApellidoMaterno"];
        $fechanacimiento = $_GET["FechaNacimiento"];
        $telefono = $_GET["Telefono"];
        $dni = $_GET["DNI"];
        $correo = $_GET["Correo"];
        $contrasena = $_GET["Contrasena"];
        $direccion = $_GET["Direccion"];
        $distrito = $_GET["Distrito"];


        $objUsuarioBean = new UsuarioBean();
        $objUsuarioBean->setNombres($nombres);
        $objUsuarioBean->setApellidoPaterno($apellidopaterno);
        $objUsuarioBean->setApellidoMaterno($apellidomaterno);
        $objUsuarioBean->setFechaNacimiento($fechanacimiento);
        $objUsuarioBean->setTelefono($telefono);
        $objUsuarioBean->setDNI($dni);
        $objUsuarioBean->setCorreoElectronico($correo);
        $objUsuarioBean->setContrasena($contrasena);
        $objUsuarioBean->setDireccion($direccion);
        $objUsuarioBean->setDistrito($distrito);
        $objUsuarioBean->setEstadoRegistro(1); 
        $objUsuarioBean->setPerfil(3); 

        $objUsuarioDao = new UsuarioDao();

        $res = $objUsuarioDao->registrarUsuario($objUsuarioBean);
        if ($res) {
            $men = "Usuario Registrado Correctamente";
            // Redirige a la página anterior almacenada en la sesión
            $pagina = isset($_SESSION['previous_page']) ? $_SESSION['previous_page'] : "../views/Auth/login.php";
        } else {
            $pagina = isset($_SESSION['previous_page']) ? $_SESSION['previous_page'] : "../views/index.php";
            $men = "Error al Registrar Usuario";
        }
        break;
    }

    case 3: {
        //Editar Usuario
        $id = $_GET["IdUsuario"];
        $nombres = $_GET["Nombres"];
        $apellidopaterno = $_GET["ApellidoPaterno"];
        $apellidomaterno = $_GET["ApellidoMaterno"];
        $fechanacimiento = $_GET["FechaNacimiento"];
        $telefono = $_GET["Telefono"];
        $dni = $_GET["DNI"];
        $correo = $_GET["Correo"];
        $contrasena = $_GET["Contrasena"];
        $direccion = $_GET["Direccion"];
        $distrito = $_GET["Distrito"];
        $perfil = $_GET["Perfil"];

        // Crear objeto UsuarioBean
        $objUsuarioBean = new UsuarioBean();
        $objUsuarioBean->setIdUsuario($id);
        $objUsuarioBean->setNombres($nombres);
        $objUsuarioBean->setApellidoPaterno($apellidopaterno);
        $objUsuarioBean->setApellidoMaterno($apellidomaterno);
        $objUsuarioBean->setFechaNacimiento($fechanacimiento);
        $objUsuarioBean->setTelefono($telefono);
        $objUsuarioBean->setDNI($dni);
        $objUsuarioBean->setCorreoElectronico($correo);
        $objUsuarioBean->setContrasena($contrasena);
        $objUsuarioBean->setDireccion($direccion);
        $objUsuarioBean->setDistrito($distrito);
        $objUsuarioBean->setPerfil($perfil);

        // Instanciar UsuarioDao para manejar la base de datos
        $objUserDao = new UsuarioDao();
        $rs = $objUserDao->ActualizarUsuario($objUsuarioBean);

        // Manejar el resultado de la actualización
        if ($rs) {
            $_SESSION['mensaje'] = "Usuario actualizado correctamente"; // Mensaje de éxito
            $pagina = isset($_SESSION['previous_page']) ? $_SESSION['previous_page'] : "../views/Auth/login.html"; // Redirigir a la página anterior
        } else {
            $_SESSION['mensaje'] = "Error al actualizar el usuario"; // Mensaje de error
            $pagina = isset($_SESSION['previous_page']) ? $_SESSION['previous_page'] : "../views/index.php"; // Redirigir a otra página
        }
    break;

    }

    case 4: {
        // Cambiar estado de registro (habilitar/deshabilitar)
        if (isset($_GET["IdUsuario"]) && isset($_GET["NuevoEstado"])) {
            $idUsuario = intval($_GET["IdUsuario"]);
            $nuevoEstado = ($_GET["NuevoEstado"] === "habilitado") ? 1 : 0;

            $objUsuarioDao = new UsuarioDao();
            $resultado = $objUsuarioDao->cambiarEstadoUsuario($idUsuario, $nuevoEstado); // Cambiar el estado del usuario

            if ($resultado) {
                $_SESSION['mensaje'] = "Estado de usuario cambiado correctamente";
            } else {
                $_SESSION['mensaje'] = "Error al cambiar el estado del usuario";
            }

            $pagina = isset($_SESSION['previous_page']) ? $_SESSION['previous_page'] : "../views/AdmUsuarios.php";
        } else {
            // Si faltan los parámetros
            $_SESSION['mensaje'] = "Datos incompletos para cambiar el estado";
            $pagina = "../views/AdmUsuarios.php";
        }
        break;
    }
       
}

    unset($_SESSION['previous_page']);

    header('Location:' . $pagina);   
    exit; // Asegúrate de llamar a exit después de redirigir

?>