<?php
require_once '../model/DistritoBean.php';
require_once '../model/DistritoDao.php';

session_start();

$op = $_GET['op'];

switch ($op) {

    case 1: {
        // Listar todos los distritos
        $objDistritoDao = new DistritoDao();
        $distritos = $objDistritoDao->listarTodos();

        if ($distritos) {
            // Mostrar distritos (puedes personalizar este formato según tus necesidades)
            foreach ($distritos as $distrito) {
                echo "ID: " . $distrito->getIdDistrito() . " - Nombre: " . $distrito->getNombreDistrito() . "<br>";
            }
        } else {
            $pagina = "../views/error.php"; // Si hay un error en la consulta
        }
        break;
    }

    case 2: {
        // Agregar un nuevo distrito
        $nombreDistrito = $_GET["NombreDistrito"];

        // Crear objeto DistritoBean
        $objDistritoBean = new DistritoBean();
        $objDistritoBean->setNombreDistrito($nombreDistrito);

        // Instanciar el DistritoDao
        $objDistritoDao = new DistritoDao();

        // Registrar nuevo distrito
        $res = $objDistritoDao->registrarDistrito($objDistritoBean);
        if ($res) {
            $men = "Distrito agregado correctamente";
            $pagina = isset($_SESSION['previous_page']) ? $_SESSION['previous_page'] : "../views/Admin/Administrar/AdmDistritos.php"; // Redirigir según sea necesario
        } else {
            $men = "Error al agregar el distrito";
            $pagina = isset($_SESSION['previous_page']) ? $_SESSION['previous_page'] : "../views/error.php";
        }
        break;
    }

    case 3: {
        // Actualizar un distrito existente
        $idDistrito = $_GET["id_Distrito"];
        $nombreDistrito = $_GET["nombre_Distrito"];

        // Crear objeto DistritoBean
        $objDistritoBean = new DistritoBean();
        $objDistritoBean->setIdDistrito($idDistrito);
        $objDistritoBean->setNombreDistrito($nombreDistrito);

        // Instanciar el DistritoDao
        $objDistritoDao = new DistritoDao();

        // Actualizar el distrito
        $rs = $objDistritoDao->ActualizarDistrito($objDistritoBean);

        // Manejar el resultado de la actualización
        if ($rs) {
            $_SESSION['mensaje'] = "Distrito actualizado correctamente";
            $pagina = isset($_SESSION['previous_page']) ? $_SESSION['previous_page'] : "../views/Admin/Administrar/AdmDistritos.php";
        } else {
            $_SESSION['mensaje'] = "Error al actualizar el distrito";
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

    // Redireccionar y limpiar la sesión
    unset($_SESSION['previous_page']);
    header('Location: ' . $pagina);
    exit; // Asegúrate de llamar a exit después de redirigir

?>