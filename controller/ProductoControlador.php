<?php
require_once '../model/ProductoBean.php';
require_once '../model/ProductoDao.php';

session_start();

$op = $_GET['op'];

switch ($op) {

    case 1: {
        // Agregar un nuevo producto
        $nombreProducto = $_GET["NombreProducto"];
        $descripcionProducto = $_GET["DescripcionProducto"];
        $precio = $_GET["Precio"];
        $fechaVencimiento = $_GET["FechaVencimiento"];
        $idSubcategoria = $_GET["IdSubcategoria"];
        // $imagenProducto = $_GET["ImagenProducto"];  POR EL MOMENTO NO XD

        // Crear objeto ProductoBean
        $objProductoBean = new ProductoBean();
        $objProductoBean->setNombreProducto($nombreProducto);
        $objProductoBean->setDescripcionProducto($descripcionProducto);
        $objProductoBean->setPrecio($precio);
        $objProductoBean->setFechaVencimiento($fechaVencimiento);
        $objProductoBean->setIdSubcategoria($idSubcategoria);
        $objProductoBean->setImagenProducto($imagenProducto);

        // Instanciar el ProductoDao
        $objProductoDao = new ProductoDao();

        // Registrar nuevo producto
        $res = $objProductoDao->registrarProducto($objProductoBean);
        if ($res) {
            $men = "Producto agregado correctamente";
            $pagina = isset($_SESSION['previous_page']) ? $_SESSION['previous_page'] : "../views/Admin/Administrar/AdmProductos.php";
        } else {
            $men = "Error al agregar el producto";
            $pagina = isset($_SESSION['previous_page']) ? $_SESSION['previous_page'] : "../views/error.php";
        }
        break;
    }

    case 2: {
        // Filtrar productos por nombre
        $nombreProducto = $_GET["NombreProducto"];

        // Instanciar el ProductoDao
        $objProductoDao = new ProductoDao();

        // Filtrar productos
        $res = $objProductoDao->filtrarProductoPorNombre($nombreProducto);

        if ($res) {
            $men = "Nombre de producto filtrado";
            $pagina = isset($_SESSION['previous_page']) ? $_SESSION['previous_page'] : "../views/Admin/Administrar/AdmProductos.php";
        } else {
            $men = "Error al filtrar los productos";
            $pagina = isset($_SESSION['previous_page']) ? $_SESSION['previous_page'] : "../views/error.php";
        }
        break;
    }

    case 3: {
        // Actualizar un producto
        $idProducto = $_GET["IdProducto"];
        $nombreProducto = $_GET["NombreProducto"];
        $descripcionProducto = $_GET["DescripcionProducto"];
        $precio = $_GET["Precio"];
        $fechaVencimiento = $_GET["FechaVencimiento"];
        $idSubcategoria = $_GET["IdSubcategoria"];

        // Crear objeto ProductoBean
        $objProductoBean = new ProductoBean();
        $objProductoBean->setIdProducto($idProducto);
        $objProductoBean->setNombreProducto($nombreProducto);
        $objProductoBean->setDescripcionProducto($descripcionProducto);
        $objProductoBean->setPrecio($precio);
        $objProductoBean->setFechaVencimiento($fechaVencimiento);
        $objProductoBean->setIdSubcategoria($idSubcategoria);

        // Instanciar el ProductoDao
        $objProductoDao = new ProductoDao();

        // Actualizar producto
        $rs = $objProductoDao->actualizarProducto($objProductoBean);

        if ($rs) {
            $_SESSION['mensaje'] = "Producto actualizado correctamente";
            $pagina = isset($_SESSION['previous_page']) ? $_SESSION['previous_page'] : "../views/Admin/Administrar/AdmProductos.php";
        } else {
            $_SESSION['mensaje'] = "Error al actualizar el producto";
            $pagina = isset($_SESSION['previous_page']) ? $_SESSION['previous_page'] : "../views/error.php";
        }
        break;
    }

    case 4: {
        // Cambiar estado de registro (habilitar/deshabilitar) para producto
        if (isset($_GET["IdProducto"]) && isset($_GET["NuevoEstado"])) {
            $idProducto = intval($_GET["IdProducto"]);
            $nuevoEstado = ($_GET["NuevoEstado"] === "habilitado") ? 1 : 0;
    
            $objProductoDao = new ProductoDao();
            $resultado = $objProductoDao->cambiarEstadoProducto($idProducto, $nuevoEstado); // Cambiar el estado del producto
     
            if ($resultado) {
                $_SESSION['mensaje'] = "Estado del producto cambiado correctamente";
            } else {
                $_SESSION['mensaje'] = "Error al cambiar el estado del producto";
            }
    
            $pagina = isset($_SESSION['previous_page']) ? $_SESSION['previous_page'] : "../views/AdmProductos.php";
        } else {
            // Si faltan los parámetros
            $_SESSION['mensaje'] = "Datos incompletos para cambiar el estado";
            $pagina = "../views/AdmProductos.php";
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