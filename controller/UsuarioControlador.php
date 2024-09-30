<?php
require_once '../model/UsuarioBean.php';
require_once '../util/ConexionBD.php';
require_once '../model/UsuarioDao.php';

$op = isset($_GET["op"]) ? $_GET["op"] : null;
switch($op){
case 1: {
    // Verificar usuario por correo y contraseña
    $correo = isset($_GET["correo"]) ? trim($_GET["correo"]) : null;
    $contraseña = isset($_GET["contraseña"]) ? trim($_GET["contraseña"]) : null;



      
    // Redirigir a la página de inicio de sesión si faltan datos
    if (empty($correo) || empty($contraseña)) {
        header('Location: ../login.html?error=datos_vacios');
        exit();
    }
    
    $objUsuarioBean = new UsuarioBean();
    $objUsuarioBean->setCorreoElectronico($correo);
    $objUsuarioBean->setClave($contraseña);

    $objUsuarioDao = new UsuarioDao();

    $rs = $objUsuarioDao->estaRegistradoUsuario($objUsuarioBean);

    if ($rs) {
        // Redirigir a la página principal
        echo" <script>alert('Ingreso con exito')</script>";
        header('Location: ../index.php');
        exit(); // Asegura que no se ejecuta más código después de la redirección
    } else {
        // Redirigir a la página de inicio de sesión si el usuario no es encontrado
        echo" <script>alert('Usuario incorrecto')</script>";
        header('Location: ../views/Auth/login.html?error=usuario_no_encontrado');
    }
    break;
}
default: {
    echo json_encode(["error" => "Operación no válida"]);
    break;
}
}

?>