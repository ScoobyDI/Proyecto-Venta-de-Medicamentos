<?php
require_once __DIR__ . '/../util/ConexionBD.php';
include_once 'PerfilBean.php';


class PerfilDao {

    public function registrarPerfil(PerfilBean $perfilobj) {
        try {

            $objc = new ConexionBD();
            $con = $objc->getConexionBD();

            $nombrePerfil = mysqli_real_escape_string($con, $perfilobj->getNombre());
            $descripcionPerfil =mysqli_real_escape_string($con, $perfilobj->getDescripcion());
            $estadoRegistroPerfil = 1;

            $sql = "INSERT INTO perfiles (Nombre, Descripcion, EstadoRegistro) VALUES ('$nombrePerfil', '$descripcionPerfil', '$estadoRegistroPerfil')";
            $rs = mysqli_query($con, $sql);
            mysqli_close($con);
        }   catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
        return $rs;
    }

    public function ActualizarPerfil(PerfilBean $perfilobj) {
        try{

            $objc = new ConexionBD();
            $con = $objc->getConexionBD();

            $idPerfil = mysqli_real_escape_string($con, $perfilobj->getIdPerfil());
            $nombrePerfil = mysqli_real_escape_string($con, $perfilobj->getNombre());
            $descripcionPerfil =mysqli_real_escape_string($con, $perfilobj->getDescripcion());

            $sql = "UPDATE perfiles SET Nombre = '$nombrePerfil', Descripcion = '$descripcionPerfil' WHERE IdPerfil = '$idPerfil'";
            $rs = mysqli_query($con, $sql);
            mysqli_close($con);
        }   catch (Exception $e){
            error_log($e->getMessage());
            return false;
        }
        return $rs;
    }

    public function filtrarPerfilPorId($idPerfil){
        $list = array();
        try {
            $sql = "SELECT * FROM perfiles WHERE IdPerfil = ?";
            $objc = new ConexionBD();
            $cn = $objc->getConexionBD();
    
            // Usando consultas preparadas para evitar inyección SQL
            $stmt = $cn->prepare($sql);
            $stmt->bind_param("i", $idPerfil);
            $stmt->execute();
            $result = $stmt->get_result();
    
            while ($row = $result->fetch_assoc()) {
                array_push($list, array(
                    'IdPerfil' => $row['IdPerfil'],
                    'Nombre' => $row['Nombre'],
                    'Descripcion' => $row['Descripcion']
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

    public function cambiarEstadoPerfil($idPerfil, $nuevoEstado) {
        try {
            $objc = new ConexionBD();
            $con = $objc->getConexionBD();
    
            // Sanitizar el ID del usuario
            $idPerfil = mysqli_real_escape_string($con, $idPerfil);
    
            // Preparar la consulta para cambiar el estado
            $sql = "UPDATE perfiles SET EstadoRegistro = ? WHERE IdPerfil = ?";
            $stmt = $con->prepare($sql);
    
            if ($stmt === false) {
                throw new Exception("Error al preparar la consulta: " . $con->error);
            }
    
            // Bindear los parámetros (EstadoRegistro es un entero, IdPerfil también)
            $stmt->bind_param("ii", $nuevoEstado, $idPerfil);
    
            // Ejecutar la consulta
            if ($stmt->execute()) {
                $stmt->close();
                mysqli_close($con);
                return true;
            } else {
                $stmt->close();
                mysqli_close($con);
                return false;
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}

?>