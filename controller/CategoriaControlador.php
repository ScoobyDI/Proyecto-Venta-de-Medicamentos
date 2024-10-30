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