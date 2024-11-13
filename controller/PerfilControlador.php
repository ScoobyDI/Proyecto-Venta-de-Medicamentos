<?php
require_once '../model/PerfilBean.php';
require_once '../model/PerfilDao.php';

session_start();

$op = $_GET['op'];

switch ($op) {

    case 1: {
        // Agregar un nuevo perfil
        $nombrePerfil = $_GET["Nombre"];
        $descripcionPerfil = $_GET["Descripcion"];

        // Crear objeto PerfilBean
        $objPerfilBean = new PerfilBean();
        $objPerfilBean->setNombre($nombrePerfil);
        $objPerfilBean->setDescripcion($descripcionPerfil);
        $objPerfilBean->setEstadoRegistro(1);

        // Instanciar el PerfilDao
        $objPerfilDao = new PerfilDao();

        // Registrar nuevo perfil
        $res = $objPerfilDao->registrarPerfil($objPerfilBean);
        if ($res) {
            $men = "Perfil agregado correctamente";
            $pagina = isset($_SESSION['previous_page']) ? $_SESSION['previous_page'] : "../views/Admin/Administrar/AdmPerfiles.php"; // Redirigir según sea necesario
        } else {
            $men = "Error al agregar el dPerfil";
            $pagina = isset($_SESSION['previous_page']) ? $_SESSION['previous_page'] : "../views/error.php";
        }
        break;
    }

    case 2: {
        // Filtrar perfiles por nombre
        $nombrePerfil = $_GET["Nombre"];

        // Instanciar el PerfilDao
        $objPerfilDao = new PerfilDao();

        // Filtrar perfiles
        $res = $objPerfilDao->filtrarPorNombre($nombrePerfil);

        if ($res) {
            $men = "Nombre de perfil filtrado";
            $pagina = isset($_SESSION['previous_page']) ? $_SESSION['previous_page'] : "../views/Admin/Administrar/AdmPerfiles.php";
        } else {
            $men = "Error al filtrar los perfiles";
            $pagina = isset($_SESSION['previous_page']) ? $_SESSION['previous_page'] : "../views/error.php";
        }
        break;
    }

    case 3: {
        $idPerfil = $_GET["id_Perfil"];
        $nombrePerfil = $_GET["nombre_Perfil"];
        $descripcionPerfil = $_GET["descripcion_Perfil"];

        $objPerfilBean = new PerfilBean();
        $objPerfilBean->setIdPerfil($idPerfil);
        $objPerfilBean->setNombre($nombrePerfil);
        $objPerfilBean->setDescripcion($descripcionPerfil);

        $objPerfilDao = new PerfilDao();

        $rs = $objPerfilDao->ActualizarPerfil($objPerfilBean);

        if ($rs) {
            $_SESSION['mensaje'] = "Perfil actualizado correctamente";
            $pagina = isset($_SESSION['previous_page']) ? $_SESSION['previous_page'] : "../views/Admin/Administrar/AdmPerfiles.php";
        } else {
            $_SESSION['mensaje'] = "Error al actualizar el perfil";
            $pagina = isset($_SESSION['previous_page']) ? $_SESSION['previous_page'] : "../views/error.php";
        }
        break;
    }

    case 4: {
        // Cambiar estado de registro (habilitar/deshabilitar)
        if (isset($_GET["IdPerfil"]) && isset($_GET["NuevoEstado"])) {
            $idPerfil = intval($_GET["IdPerfil"]);
            $nuevoEstado = ($_GET["NuevoEstado"] === "habilitado") ? 1 : 0;

            $objPerfilDao = new PerfilDao();
            $resultado = $objPerfilDao->cambiarEstadoPerfil($idPerfil, $nuevoEstado); // Cambiar el estado del perfil

            if ($resultado) {
                $_SESSION['mensaje'] = "Estado de usuario cambiado correctamente";
            } else {
                $_SESSION['mensaje'] = "Error al cambiar el estado del usuario";
            }

            $pagina = isset($_SESSION['previous_page']) ? $_SESSION['previous_page'] : "../views/AdmPerfiles.php";
        } else {
            // Si faltan los parámetros
            $_SESSION['mensaje'] = "Datos incompletos para cambiar el estado";
            $pagina = "../views/AdmPerfiles.php";
        }
        break;
    }

    default: {
        // Si el valor de $op no es válido
        $pagina = "../views/error.php";
        break;
        }

    }
    // Redireccionar y limpiar la sesión
    unset($_SESSION['previous_page']);
    header('Location: ' . $pagina);
    exit; // Asegúrate de llamar a exit después de redirigir


?>