<?php
require_once __DIR__ . '/../util/ConexionBD.php';
include_once 'ProductoBean.php';

class ProductoDao {

    // Método para registrar un producto
    public function registrarProducto(ProductoBean $productoObj) {
        try {
            $objc = new ConexionBD();
            $con = $objc->getConexionBD();

            $nombreProducto = mysqli_real_escape_string($con, $productoObj->getNombreProducto());
            $descripcionProducto = mysqli_real_escape_string($con, $productoObj->getDescripcionProducto());
            $stockMinimo = mysqli_real_escape_string($con, $productoObj->getStockMinimo());
            $stockMaximo = mysqli_real_escape_string($con, $productoObj->getStockMaximo());
            $precio = mysqli_real_escape_string($con, $productoObj->getPrecio());
            $fechaVencimiento = mysqli_real_escape_string($con, $productoObj->getFechaVencimiento()); // Nuevo campo
            $idSubcategoria = mysqli_real_escape_string($con, $productoObj->getIdSubcategoria());
            $imagenProducto = mysqli_real_escape_string($con, $productoObj->getImagenProducto());

            $sql = "INSERT INTO producto (NombreProducto, DescripcionProducto, StockMinimo, StockMaximo, Precio, FechaVencimiento, IdSubcategoria, ImagenProducto)
                    VALUES ('$nombreProducto', '$descripcionProducto', '$stockMinimo', '$stockMaximo', '$precio', '$fechaVencimiento', '$idSubcategoria', '$imagenProducto')";
            $rs = mysqli_query($con, $sql);
            mysqli_close($con);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
        return $rs;
    }

    // Método para actualizar un producto
    public function actualizarProducto(ProductoBean $productoObj) {
        try {
            $objc = new ConexionBD();
            $con = $objc->getConexionBD();

            $idProducto = mysqli_real_escape_string($con, $productoObj->getIdProducto());
            $nombreProducto = mysqli_real_escape_string($con, $productoObj->getNombreProducto());
            $descripcionProducto = mysqli_real_escape_string($con, $productoObj->getDescripcionProducto());
            $stockMinimo = mysqli_real_escape_string($con, $productoObj->getStockMinimo());
            $stockMaximo = mysqli_real_escape_string($con, $productoObj->getStockMaximo());
            $precio = mysqli_real_escape_string($con, $productoObj->getPrecio());
            $fechaVencimiento = mysqli_real_escape_string($con, $productoObj->getFechaVencimiento()); // Nuevo campo
            $idSubcategoria = mysqli_real_escape_string($con, $productoObj->getIdSubcategoria());
            $imagenProducto = mysqli_real_escape_string($con, $productoObj->getImagenProducto());

            $sql = "UPDATE producto SET NombreProducto = '$nombreProducto', DescripcionProducto = '$descripcionProducto',
                    StockMinimo = '$stockMinimo', StockMaximo = '$stockMaximo', Precio = '$precio', FechaVencimiento = '$fechaVencimiento',
                    IdSubcategoria = '$idSubcategoria', ImagenProducto = '$imagenProducto'
                    WHERE IdProducto = '$idProducto'";
            $rs = mysqli_query($con, $sql);
            mysqli_close($con);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
        return $rs;
    }

    // Método para filtrar un producto por ID
    public function filtrarProductoPorId($idProducto) {
        $producto = null;
        try {
            $sql = "SELECT * FROM producto WHERE IdProducto = ?";
            $objc = new ConexionBD();
            $cn = $objc->getConexionBD();

            // Usando consultas preparadas para evitar inyección SQL
            $stmt = $cn->prepare($sql);
            $stmt->bind_param("i", $idProducto);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                $producto = array(
                    'IdProducto' => $row['IdProducto'],
                    'NombreProducto' => $row['NombreProducto'],
                    'DescripcionProducto' => $row['DescripcionProducto'],
                    'StockMinimo' => $row['StockMinimo'],
                    'StockMaximo' => $row['StockMaximo'],
                    'Precio' => $row['Precio'],
                    'FechaVencimiento' => $row['FechaVencimiento'], // Nuevo campo
                    'IdSubcategoria' => $row['IdSubcategoria'],
                    'ImagenProducto' => $row['ImagenProducto']
                );
            }

            $stmt->close();
            $cn->close();
        } catch (Exception $e) {
            error_log($e->getMessage());
        }

        return $producto;
    }

    // Método para filtrar productos por nombre
    public function filtrarProductoPorNombre($nombreProducto) {
        $list = array();
        try {
            $sql = "SELECT * FROM producto WHERE NombreProducto LIKE ?";
            $objc = new ConexionBD();
            $cn = $objc->getConexionBD();

            // Usando consultas preparadas para evitar inyección SQL
            $stmt = $cn->prepare($sql);
            $nombreProducto = "%" . $nombreProducto . "%";
            $stmt->bind_param("s", $nombreProducto);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                $list[] = array(
                    'IdProducto' => $row['IdProducto'],
                    'NombreProducto' => $row['NombreProducto'],
                    'DescripcionProducto' => $row['DescripcionProducto'],
                    'StockMinimo' => $row['StockMinimo'],
                    'StockMaximo' => $row['StockMaximo'],
                    'Precio' => $row['Precio'],
                    'FechaVencimiento' => $row['FechaVencimiento'], // Nuevo campo
                    'IdSubcategoria' => $row['IdSubcategoria'],
                    'ImagenProducto' => $row['ImagenProducto']
                );
            }

            $stmt->close();
            $cn->close();
        } catch (Exception $e) {
            error_log($e->getMessage());
        }

        return $list;
    }

    public function cambiarEstadoProducto($idProducto, $nuevoEstado) {
        try {
            $objc = new ConexionBD();
            $con = $objc->getConexionBD();
    
            // Sanitizar el ID del producto
            $idProducto = mysqli_real_escape_string($con, $idProducto);
    
            // Preparar la consulta para cambiar el estado
            $sql = "UPDATE producto SET EstadoRegistro = ? WHERE IdProducto = ?";
            $stmt = $con->prepare($sql);
    
            if ($stmt === false) {
                throw new Exception("Error al preparar la consulta: " . $con->error);
            }
    
            // Bindear los parámetros (EstadoRegistro es un entero, IdProducto también)
            $stmt->bind_param("ii", $nuevoEstado, $idProducto);
    
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