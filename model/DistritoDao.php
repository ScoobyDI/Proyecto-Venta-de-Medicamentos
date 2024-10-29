<?php
require_once __DIR__ . '/../util/ConexionBD.php';
include_once 'DistritoBean.php';

class DistritoDao {

    // Método para listar todos los distritos
    public function listarTodos() {
        $db = new ConexionBD();
        $conexion = $db->getConexionBD();
        
        $query = "SELECT * FROM distrito";
        $resultado = $conexion->query($query);

        $distritos = [];
        while ($fila = $resultado->fetch_assoc()) {
            $distrito = new DistritoBean();
            $distrito->setIdDistrito($fila['idDistrito']);
            $distrito->setNombreDistrito($fila['nombreDistrito']);
            $distritos[] = $distrito;
        }
        $conexion->close();
        return $distritos;
    }

    // Método para agregar un nuevo distrito
    public function registrarDistrito (DistritoBean $distritoobj) {
        try {
            $objc = new ConexionBD();
            $con = $objc->getConexionBD();

            $nombreDistrito = mysqli_real_escape_string($con, $distritoobj->getNombreDistrito());

            $sql = "INSERT INTO distrito (NombreDistrito) VALUES ('$nombreDistrito')";
            $rs = mysqli_query($con, $sql);
            mysqli_close($con);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
        return $rs;
    }

    // Método para actualizar un distrito existente
    public function actualizar($distritoBean) {
        $db = new Database();
        $conexion = $db->getConnection();

        $idDistrito = $distritoBean->getIdDistrito();
        $nombreDistrito = $distritoBean->getNombreDistrito();

        $query = "UPDATE distrito SET nombreDistrito = ? WHERE idDistrito = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param('si', $nombreDistrito, $idDistrito);
        $resultado = $stmt->execute();

        $stmt->close();
        $conexion->close();
        return $resultado;
    }
}
?>