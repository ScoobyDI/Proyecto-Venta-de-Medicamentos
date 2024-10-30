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
    public function ActualizarDistrito(DistritoBean $distritoobj) {
        try {
        $objc = new ConexionBD();
        $cn = $objc->getConexionBD();

        $idDistrito = mysqli_real_escape_string($cn, $distritoobj->getIdDistrito());
        $nombreDistrito = mysqli_real_escape_string($cn, $distritoobj->getNombreDistrito());

        $sql = "UPDATE distrito SET NombreDistrito = '$nombreDistrito' WHERE IdDistrito = '$idDistrito'";
        $rs = mysqli_query($cn, $sql);
            mysqli_close($cn);
        } catch (Exception $e){
            error_log($e->getMessage());
            return false;
        }
        return $rs;
    }

    public function filtrarDistritoPorId($idDistrito){
        $list = array();
        try {
            $sql = "SELECT * FROM distrito WHERE IdDistrito = ?";
            $objc = new ConexionBD();
            $cn = $objc->getConexionBD();
    
            // Usando consultas preparadas para evitar inyección SQL
            $stmt = $cn->prepare($sql);
            $stmt->bind_param("i", $idDistrito);
            $stmt->execute();
            $result = $stmt->get_result();
    
            while ($row = $result->fetch_assoc()) {
                array_push($list, array(
                    'IdDistrito' => $row['IdDistrito'],
                    'NombreDistrito' => $row['NombreDistrito']
                ));
            }
    
            $stmt->close();
            $cn->close();
        } catch (Exception $e) {
            // Aquí puedes registrar el error o mostrar un mensaje
            error_log($e->getMessage());
        }
    
        return $list;
    }
}
?>