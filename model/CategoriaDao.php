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

}
?>