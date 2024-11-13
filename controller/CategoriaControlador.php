<?php
require_once '../model/CategoriaBean.php';
require_once '../model/CategoriaDao.php';

session_start();

$op = $_GET['op'];

switch($op) {

    case 1: {
        //Agregar Categoria
        $nombreCategoria = $_GET["NombreCategoria"];
        $descripcionCategoria = $_GET["DescripcionCategoria"];
        
        $objCategoriaBean = new CategoriaBean();
        
        $objCategoriaBean->setNombreCategoria($nombreCategoria);
        $objCategoriaBean->setDescripcionCategoria($descripcionCategoria);
        $objCategoriaBean->setEstadoCategoria(1); 

        $objCategoriaDao = new CategoriaDao();

        $res = $objCategoriaDao->registrarCategoria($objCategoriaBean);
        if ($res) {
            $men = "Categoria Registrado Correctamente";
            // Redirige a la página anterior almacenada en la sesión
            $pagina = isset($_SESSION['previous_page']) ? $_SESSION['previous_page'] : "../views/Admin/Administrar/AdministrarCategorias.php";
        } else {
            $men = "Error al Registrar Categoria";
            $pagina = isset($_SESSION['previous_page']) ? $_SESSION['previous_page'] : "../views/index.php";
        }
        break;
    }

    case 2: {

        //Editar Categoria
        $idCategoria = $_GET["IdCategoria"];
        $nombreCategoria = $_GET["NombreCategoria"];
        $descripcionCategoria = $_GET["DescripcionCategoria"];

        $objCategoriaBean = new CategoriaBean();
        
        $objCategoriaBean->setIdCategoria($idCategoria);
        $objCategoriaBean->setNombreCategoria($nombreCategoria);
        $objCategoriaBean->setDescripcionCategoria($descripcionCategoria);

        $objCategoriaDao = new CategoriaDao();

        $res = $objCategoriaDao->actualizarCategoria($objCategoriaBean);

        // Manejar el resultado de la actualización
        if ($res) {
            $_SESSION['mensaje'] = "Categoria actualizado correctamente";
            $pagina = isset($_SESSION['previous_page']) ? $_SESSION['previous_page'] : "../views/Admin/Administrar/AdmCategorias.php"; // Redirigir a la página anterior
        } else {
            $_SESSION['mensaje'] = "Error al actualizar la categoria";
            $pagina = isset($_SESSION['previous_page']) ? $_SESSION['previous_page'] : "../views/error.php";
        }
        break;

    }

    case 3: {
        //Agregar SubCategoria
        $idCategoria = $_GET["IdCategoria"];
        $nombreSubCategoria = $_GET["NombreSubCategoria"];
        
        $objCategoriaBean = new CategoriaBean();

        $objCategoriaBean->setIdCategoria($idCategoria);
        $objCategoriaBean->setNombreSubCategoria($nombreSubCategoria);
        
        $objCategoriaBean->setEstadoSubCategoria(1); 

        $objCategoriaDao = new CategoriaDao();

        $res = $objCategoriaDao->registrarSubCategoria($objCategoriaBean);
        if ($res) {
            $men = "Sub Categoria Registrado Correctamente";
            // Redirige a la página anterior almacenada en la sesión
            $pagina = isset($_SESSION['previous_page']) ? $_SESSION['previous_page'] : "../views/Admin/Administrar/AdministrarCategorias.php";
        } else {
            $men = "Error al Registrar Sub Categoria";
            $pagina = isset($_SESSION['previous_page']) ? $_SESSION['previous_page'] : "../views/index.php";
        }
        break;
    }

    case 4: {
        
        //Editar SubCategoria
        $idCategoria = $_GET["IdCategoria"];
        $idSubCategoria = $_GET["IdSubCategoria"];
        $nombreSubCategoria = $_GET["NombreSubCategoria"];

        $objCategoriaBean = new CategoriaBean();
        
        $objCategoriaBean->setIdCategoria($idCategoria);
        $objCategoriaBean->setIdSubCategoria($idSubCategoria);
        $objCategoriaBean->setNombreSubCategoria($nombreSubCategoria);

        $objCategoriaDao = new CategoriaDao();

        $res = $objCategoriaDao->actualizarSubCategoria($objCategoriaBean);

        // Manejar el resultado de la actualización
        if ($res) {
            $_SESSION['mensaje'] = "Categoria actualizado correctamente";
            $pagina = isset($_SESSION['previous_page']) ? $_SESSION['previous_page'] : "../views/Admin/Administrar/AdmCategorias.php"; // Redirigir a la página anterior
        } else {
            $_SESSION['mensaje'] = "Error al actualizar la categoria";
            $pagina = isset($_SESSION['previous_page']) ? $_SESSION['previous_page'] : "../views/error.php";
        }
        break;

    }

    case 5: {
        // Cambiar estado de registro (habilitar/deshabilitar)
        if (isset($_GET["IdCategoria"]) && isset($_GET["NuevoEstado"])) {
            $idCategoria = intval($_GET["IdCategoria"]);
            $nuevoEstado = ($_GET["NuevoEstado"] === "habilitado") ? 1 : 0;

            $objCategoriaDao = new CategoriaDao();
            $resultado = $objCategoriaDao->cambiarEstadoCategoria($idCategoria, $nuevoEstado); // Cambiar el estado de la categoria

            if ($resultado) {
                $_SESSION['mensaje'] = "Estado de usuario cambiado correctamente";
            } else {
                $_SESSION['mensaje'] = "Error al cambiar el estado del usuario";
            }

            $pagina = isset($_SESSION['previous_page']) ? $_SESSION['previous_page'] : "../views/AdmCategorias.php";
        } else {
            // Si faltan los parámetros
            $_SESSION['mensaje'] = "Datos incompletos para cambiar el estado";
            $pagina = "../views/AdmCategorias.php";
        }
        break;
    }

    case 6: {
        // Cambiar estado de registro (habilitar/deshabilitar)
        if (isset($_GET["IdSubCategoria"]) && isset($_GET["NuevoEstado"])) {
            $idSubCategoria = intval($_GET["IdSubCategoria"]);
            $nuevoEstado = ($_GET["NuevoEstado"] === "habilitado") ? 1 : 0;

            $objCategoriaDao = new CategoriaDao();
            $resultado = $objCategoriaDao->cambiarEstadoSubCategoria($idSubCategoria, $nuevoEstado); // Cambiar el estado de la categoria

            if ($resultado) {
                $_SESSION['mensaje'] = "Estado de usuario cambiado correctamente";
            } else {
                $_SESSION['mensaje'] = "Error al cambiar el estado del usuario";
            }

            $pagina = isset($_SESSION['previous_page']) ? $_SESSION['previous_page'] : "../views/AdmCategorias.php";
        } else {
            // Si faltan los parámetros
            $_SESSION['mensaje'] = "Datos incompletos para cambiar el estado";
            $pagina = "../views/AdmCategorias.php";
        }
        break;
    }

    default: {
        // Si el valor de $op no es válido
        $pagina = "../views/error.php";
        break;
        }
    }
     
    unset($_SESSION['previous_page']);

    header('Location:' . $pagina);   
    exit; // Asegúrate de llamar a exit después de redirigir

?>