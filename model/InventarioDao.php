<?php
require_once __DIR__ . '/../util/ConexionBD.php'; // Clase para la conexión a la base de datos
require_once 'InventarioBean.php';  // Clase del Bean para Inventario

class InventarioDao {

    // Registrar Lote
    public function registrarLote(InventarioBean $inventarioBean) {
        try {
            $objc = new ConexionBD();
            $con = $objc->getConexionBD();

            $idProducto = mysqli_real_escape_string($con, $inventarioBean->getIdProducto());
            $cantidad = mysqli_real_escape_string($con, $inventarioBean->getCantidad());
            $fechaCaducidad = mysqli_real_escape_string($con, $inventarioBean->getFechaCaducidad());

            $sql = "INSERT INTO inventario (IdProducto, Cantidad, FechaCaducidad, FechaInsercion) 
                    VALUES ('$idProducto', '$cantidad', '$fechaCaducidad', NOW())";

            $rs = mysqli_query($con, $sql);
            mysqli_close($con);
            
            return $rs;

        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    // Actualizar Lote
    public function actualizarLote(InventarioBean $inventarioBean) {
        try {
            $objc = new ConexionBD();
            $con = $objc->getConexionBD();

            $idLote = mysqli_real_escape_string($con, $inventarioBean->getIdLote());
            $cantidad = mysqli_real_escape_string($con, $inventarioBean->getCantidad());
            $fechaCaducidad = mysqli_real_escape_string($con, $inventarioBean->getFechaCaducidad());

            $sql = "UPDATE inventario 
                    SET Cantidad = '$cantidad', FechaCaducidad = '$fechaCaducidad' 
                    WHERE IdLote = '$idLote'";

            $rs = mysqli_query($con, $sql);
            mysqli_close($con);
            
            return $rs;

        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    // Filtrar por Lote
    public function obtenerLotePorId($idLote) {
        try {
            $objc = new ConexionBD();
            $con = $objc->getConexionBD();

            $sql = "SELECT * FROM inventario WHERE IdLote = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("i", $idLote);
            $stmt->execute();
            $result = $stmt->get_result();

            $inventarios = array();
            while ($row = $result->fetch_assoc()) {
                $inventarios[] = $row;
            }

            $stmt->close();
            mysqli_close($con);

            return $inventarios;

        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    // Cambiar estado de Lote (habilitar/deshabilitar)
    public function cambiarEstadoLote($idLote, $nuevoEstado) {
        try {
            $objc = new ConexionBD();
            $con = $objc->getConexionBD();

            $sql = "UPDATE inventario SET EstadoLote = ? WHERE IdLote = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("ii", $nuevoEstado, $idLote);

            $rs = $stmt->execute();
            $stmt->close();
            mysqli_close($con);

            return $rs;

        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function eliminarLote($idLote) {
        try {
            $objc = new ConexionBD();
            $con = $objc->getConexionBD();
    
            $sql = "DELETE FROM inventario WHERE IdLote = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("i", $idLote);
    
            $rs = $stmt->execute();
            $stmt->close();
            mysqli_close($con);
    
            return $rs;
    
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}
?>