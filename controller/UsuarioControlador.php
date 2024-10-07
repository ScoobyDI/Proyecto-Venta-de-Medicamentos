<?php
require_once '../model/UsuarioBean.php';
require_once '../model/UsuarioDao.php';

$op = $_GET['op'];

switch($op) {

    case 1: {

        $correo = $_GET['correo'];
        $contraseña = $_GET['contraseña'];
        
        $objUsuarioBean = new UsuarioBean();
        $objUsuarioBean->setCorreoElectronico($correo);
        $objUsuarioBean->setClave($contraseña);

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

        $nombres = $_GET["Nombres"];
        $apellidopaterno = $_GET["ApellidoPaterno"];
        $apellidomaterno = $_GET["ApellidoMaterno"];
        $celular = $_GET["telefono"];
        $dni = $_GET["DNI"];
        $correo = $_GET["Email"];
        $contrasenha = $_GET["Password"];
        
        $objUsuarioBean = new UsuarioBean();
        $objUsuarioBean->setNombres($Nombres);
        $objUsuarioBean->setApellidoPaterno($ApellidoPaterno);
        $objUsuarioBean->setApellidoMaterno($ApellidoMaterno);
        $objUsuarioBean->setCelular($Celular);
        $objUsuarioBean->setDNI($DNI);
        $objUsuarioBean->setCorreoElectronico($CorreoElectronico);
        $objUsuarioBean->setClave($Clave);

        $res = $objUsuarioBean->registrarUsuario($objUsuarioBean);
        if ($res == 1) {
            $men = "Usuario Registrado Correctamente";
        } else {
            $men = "Error al Registrar Usuario";
        }
        $response["state"] = $men;
        echo json_encode($response);
        break;
    }
    case 3:
    {

    }

}

header('Location:' . $pagina);   

?>