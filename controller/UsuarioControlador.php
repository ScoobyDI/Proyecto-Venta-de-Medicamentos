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

}

header('Location:' . $pagina);   

?>