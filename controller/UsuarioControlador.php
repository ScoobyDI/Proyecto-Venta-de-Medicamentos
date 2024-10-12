<?php
require_once '../model/UsuarioBean.php';
require_once '../model/UsuarioDao.php';

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
            $pagina = "../views/Admin/perfilAdmin.html";
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
        $telefono = $_GET["Telefono"];
        $dni = $_GET["DNI"];
        $correo = $_GET["Correo"];
        $contrasena = $_GET["Contrasena"];
        $direccion = $_GET["Direccion"];

        $objUsuarioBean = new UsuarioBean();
        $objUsuarioBean->setNombres($nombres);
        $objUsuarioBean->setApellidoPaterno($apellidopaterno);
        $objUsuarioBean->setApellidoMaterno($apellidomaterno);
        $objUsuarioBean->setTelefono($telefono);
        $objUsuarioBean->setDNI($dni);
        $objUsuarioBean->setCorreoElectronico($correo);
        $objUsuarioBean->setContrasena($contrasena);
        $objUsuarioBean->setDireccion($direccion);

        $objUsuarioDao = new UsuarioDao();

        $res = $objUsuarioDao->registrarUsuario($objUsuarioBean);
        if ($res) {
            $men = "Usuario Registrado Correctamente";
            $pagina = "../views/Auth/login.html";
        } else {
            $men = "Error al Registrar Usuario";
        }
        break;
    }

    case 3:
    {
        // Listar usuario por ID
        
    }

}

header('Location:' . $pagina);   

?>