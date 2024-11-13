<?php
require_once 'CategoriaBean.php';
require_once __DIR__ . '/../util/ConexionBD.php';

class CategoriaDao {

    public function registrarCategoria (CategoriaBean $catobj) {
        
        try {

            $objc = new ConexionBD();
            $con = $objc->getConexionBD();
    
            $nombreCategoria = mysqli_real_escape_string($con, $catobj->getNombreCategoria());
            $descripcionCategoria = mysqli_real_escape_string($con, $catobj->getDescripcionCategoria());
            $estadoCategoria = 1;
    
            $sql = "INSERT INTO categoria (NombreCategoria, DescripcionCategoria, EstadoCategoria) 
                    VALUES ('$nombreCategoria', '$descripcionCategoria', '$estadoCategoria')";
    
            $rs = mysqli_query($con, $sql);

            mysqli_close($con);

        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }

        return $rs;
    }

    public function actualizarCategoria(CategoriaBean $catobj) {
        
        try {

            $objc = new ConexionBD();
            $con = $objc->getConexionBD();

            $idCategoria = mysqli_real_escape_string($con, $catobj->getIdCategoria());
            $nombreCategoria = mysqli_real_escape_string($con, $catobj->getNombreCategoria());
            $descripcionCategoria = mysqli_real_escape_string($con, $catobj->getDescripcionCategoria());

            $sql = "UPDATE categoria 
                    SET NombreCategoria = '$nombreCategoria', 
                    DescripcionCategoria = '$descripcionCategoria'
                    
                    WHERE IdCategoria = '$idCategoria'";
    
            $rs = mysqli_query($con, $sql);

            mysqli_close($con);

    
        } catch (Exception $e) {
            // Registrar el error o mostrar un mensaje
            error_log($e->getMessage());
            return false;
        }
        return $rs;
    }

    public function filtrarCategoriaPorId($idCategoria){
        
        $list = array();
        
        try {
            $sql = "SELECT * FROM categoria WHERE IdCategoria = ?";
            $objc = new ConexionBD();
            $con = $objc->getConexionBD();
    
            // Usando consultas preparadas para evitar inyección SQL
            $stmt = $con->prepare($sql);
            $stmt->bind_param("i", $idCategoria);
            $stmt->execute();
            $result = $stmt->get_result();
    
            while ($row = $result->fetch_assoc()) {
                array_push($list, array(
                    'IdCategoria' => $row['IdCategoria'],
                    'NombreCategoria' => $row['NombreCategoria'],
                    'DescripcionCategoria' => $row['DescripcionCategoria'],
                ));
            }
    
            $stmt->close();
            $con->close();
        } catch (Exception $e) {
            // Aquí puedes registrar el error o mostrar un mensaje
            error_log($e->getMessage());
        }
    
        return $list;
    }

    public function registrarSubCategoria (CategoriaBean $catobj) {
        
        try {

            $objc = new ConexionBD();
            $con = $objc->getConexionBD();
    
            $idCategoria = mysqli_real_escape_string($con, $catobj->getIdCategoria());
            $nombreSubCategoria = mysqli_real_escape_string($con, $catobj->getNombreSubCategoria());
            
            $estadoSubCategoria = 1;
    
            $sql = "INSERT INTO subcategoria (IdCategoria, NombreSubCategoria, EstadoSubCategoria) 
                    VALUES ('$idCategoria', '$nombreSubCategoria', '$estadoSubCategoria')";
    
            $rs = mysqli_query($con, $sql);

            mysqli_close($con);

        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }

        return $rs;
    }

    public function actualizarSubCategoria(CategoriaBean $catobj) {
        
        try {

            $objc = new ConexionBD();
            $con = $objc->getConexionBD();

            $idSubCategoria = mysqli_real_escape_string($con, $catobj->getIdSubCategoria());
            $idCategoria = mysqli_real_escape_string($con, $catobj->getIdCategoria());
            $nombreSubCategoria = mysqli_real_escape_string($con, $catobj->getNombreSubCategoria());

            $sql = "UPDATE subcategoria 
                    SET IdCategoria = '$idCategoria', 
                    NombreSubcategoria = '$nombreSubCategoria'
                    
                    WHERE IdSubcategoria = '$idSubCategoria'";
    
            $rs = mysqli_query($con, $sql);

            mysqli_close($con);

    
        } catch (Exception $e) {
            // Registrar el error o mostrar un mensaje
            error_log($e->getMessage());
            return false;
        }
        return $rs;
    }

    
    public function filtrarSubCategoriaPorId($idSubCategoria){
        
        $list2 = array();
        
        try {
            $sql = "SELECT * FROM subcategoria WHERE IdSubcategoria = ?";
            $objc = new ConexionBD();
            $con = $objc->getConexionBD();
    
            // Usando consultas preparadas para evitar inyección SQL
            $stmt = $con->prepare($sql);
            $stmt->bind_param("i", $idSubCategoria);
            $stmt->execute();
            $result = $stmt->get_result();
    
            while ($row = $result->fetch_assoc()) {
                array_push($list2, array(
                    'IdSubcategoria' => $row['IdSubcategoria'],
                    'IdCategoria' => $row['IdCategoria'],
                    'NombreSubcategoria' => $row['NombreSubcategoria'],
                ));
            }
    
            $stmt->close();
            $con->close();
        } catch (Exception $e) {
            // Aquí puedes registrar el error o mostrar un mensaje
            error_log($e->getMessage());
        }
    
        return $list2;
    }

    public function cambiarEstadoCategoria($idCategoria, $nuevoEstado) {
        try {
            $objc = new ConexionBD();
            $con = $objc->getConexionBD();
    
            // Sanitizar el ID del usuario
            $idCategoria = mysqli_real_escape_string($con, $idCategoria);
    
            // Preparar la consulta para cambiar el estado
            $sql = "UPDATE categoria SET EstadoCategoria = ? WHERE IdCategoria = ?";
            $stmt = $con->prepare($sql);
    
            if ($stmt === false) {
                throw new Exception("Error al preparar la consulta: " . $con->error);
            }
    
            // Bindear los parámetros (EstadoRegistro es un entero, IdUsuario también)
            $stmt->bind_param("ii", $nuevoEstado, $idCategoria);
    
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

    public function cambiarEstadoSubCategoria($idSubCategoria, $nuevoEstado) {
        try {
            $objc = new ConexionBD();
            $con = $objc->getConexionBD();
    
            // Sanitizar el ID del usuario
            $idSubCategoria = mysqli_real_escape_string($con, $idSubCategoria);
    
            // Preparar la consulta para cambiar el estado
            $sql = "UPDATE subcategoria SET EstadoSubCategoria = ? WHERE IdSubcategoria = ?";
            $stmt = $con->prepare($sql);
    
            if ($stmt === false) {
                throw new Exception("Error al preparar la consulta: " . $con->error);
            }
    
            // Bindear los parámetros (EstadoRegistro es un entero, IdUsuario también)
            $stmt->bind_param("ii", $nuevoEstado, $idSubCategoria);
    
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