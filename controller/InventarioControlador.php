<?php
require_once '../model/InventarioBean.php';
require_once '../model/InventarioDao.php';

session_start();

$op = $_GET['op'];

switch($op) {

    // Registrar nuevo lote de inventario
    case 1: {
        $idProducto = $_GET["IdProducto"];
        $cantidad = $_GET["StockLote"];
        $fechaCaducidad = $_GET["FechaVencimiento"];

        // Crear objeto InventarioBean
        $objInventarioBean = new InventarioBean();
        $objInventarioBean->setIdProducto($idProducto);
        $objInventarioBean->setCantidad($cantidad);
        $objInventarioBean->setFechaCaducidad($fechaCaducidad);

        // Crear objeto InventarioDao
        $objInventarioDao = new InventarioDao();

        $res = $objInventarioDao->registrarLote($objInventarioBean);
        if ($res) {
            $men = "Lote de inventario registrado correctamente";
            $pagina = isset($_SESSION['previous_page']) ? $_SESSION['previous_page'] : "../views/Admin/Administrar/AdministrarInventario.php";
        } else {
            $men = "Error al registrar lote de inventario";
            $pagina = isset($_SESSION['previous_page']) ? $_SESSION['previous_page'] : "../views/index.php";
        }
        break;
    }

    // Eliminar lote de inventario
    case 2: {
        if (isset($_GET["IdLote"])) {
            $idLote = intval($_GET["IdLote"]);

            $objInventarioDao = new InventarioDao();
            $resultado = $objInventarioDao->eliminarLote($idLote);

            if ($resultado) {
                $_SESSION['mensaje'] = "Lote eliminado correctamente";
            } else {
                $_SESSION['mensaje'] = "Error al eliminar el lote";
            }

            $pagina = isset($_SESSION['previous_page']) ? $_SESSION['previous_page'] : "../views/Admin/Administrar/AdministrarInventario.php";
        } else {
            $_SESSION['mensaje'] = "Datos incompletos para eliminar el lote";
            $pagina = "../views/Admin/Administrar/AdministrarInventario.php";
        }
        break;
    }

   /*
    // Actualizar lote de inventario
    case 2: {
        $idLote = $_GET["IdLote"];
        $cantidad = $_GET["Cantidad"];
        $fechaCaducidad = $_GET["FechaCaducidad"];

        // Crear objeto InventarioBean
        $objInventarioBean = new InventarioBean();
        $objInventarioBean->setIdLote($idLote);
        $objInventarioBean->setCantidad($cantidad);
        $objInventarioBean->setFechaCaducidad($fechaCaducidad);

        // Crear objeto InventarioDao
        $objInventarioDao = new InventarioDao();

        $res = $objInventarioDao->actualizarLote($objInventarioBean);

        // Manejar el resultado de la actualización
        if ($res) {
            $_SESSION['mensaje'] = "Lote actualizado correctamente";
            $pagina = isset($_SESSION['previous_page']) ? $_SESSION['previous_page'] : "../views/Admin/Administrar/AdministrarInventario.php";
        } else {
            $_SESSION['mensaje'] = "Error al actualizar el lote de inventario";
            $pagina = isset($_SESSION['previous_page']) ? $_SESSION['previous_page'] : "../views/error.php";
        }
        break;
    }

    // Cambiar estado del lote (habilitar/deshabilitar)
    case 3: {
        if (isset($_GET["IdLote"]) && isset($_GET["NuevoEstado"])) {
            $idLote = intval($_GET["IdLote"]);
            $nuevoEstado = ($_GET["NuevoEstado"] === "habilitado") ? 1 : 0;

            $objInventarioDao = new InventarioDao();
            $resultado = $objInventarioDao->cambiarEstadoLote($idLote, $nuevoEstado);

            if ($resultado) {
                $_SESSION['mensaje'] = "Estado del lote cambiado correctamente";
            } else {
                $_SESSION['mensaje'] = "Error al cambiar el estado del lote";
            }

            $pagina = isset($_SESSION['previous_page']) ? $_SESSION['previous_page'] : "../views/Admin/Administrar/AdministrarInventario.php";
        } else {
            $_SESSION['mensaje'] = "Datos incompletos para cambiar el estado";
            $pagina = "../views/Admin/Administrar/AdministrarInventario.php";
        }
        break;
    }

    // Obtener información de un lote
    case 4: {
        if (isset($_GET["IdLote"])) {
            $idLote = intval($_GET["IdLote"]);

            $objInventarioDao = new InventarioDao();
            $lote = $objInventarioDao->obtenerLotePorId($idLote);

            if ($lote) {
                $_SESSION['mensaje'] = "Lote encontrado correctamente";
                $_SESSION['lote'] = $lote; // Puedes almacenar el lote en sesión si necesitas mostrarlo
            } else {
                $_SESSION['mensaje'] = "No se encontró el lote";
            }

            $pagina = isset($_SESSION['previous_page']) ? $_SESSION['previous_page'] : "../views/Admin/Administrar/AdministrarInventario.php";
        } else {
            $_SESSION['mensaje'] = "Datos incompletos para obtener información del lote";
            $pagina = "../views/Admin/Administrar/AdministrarInventario.php";
        }
        break;
    }
        */

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