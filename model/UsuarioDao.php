<?php
require_once 'UsuarioBean.php';
require_once __DIR__ . '/../util/ConexionBD.php';

class UsuarioDao {

    public function estaRegistradoUsuario (UsuarioBean $usuobj) {
        try {
            $objc = new ConexionBD();
            $con = $objc->getConexionBD();
            
            $correo = mysqli_real_escape_string($con, $usuobj->getCorreoElectronico());         // Los valores ingresados se tratan como texto literal, evitando que puedan alterar la consulta SQL.
            $contrasena = mysqli_real_escape_string($con, $usuobj->getContrasena());

            $sql = "SELECT * FROM usuario WHERE BINARY CorreoElectronico='$correo' AND BINARY Contrasena='$contrasena'";
            
            $rs = mysqli_query($con, $sql);

            if (mysqli_num_rows($rs) == 1) {
                mysqli_close($con);                                                                                                     //busca en la tabla si coincide un valor
                return true;
            } else {
                mysqli_close($con); 
                return false;
            }
        }catch (Exception $e) {
            error_log($e->getMessage());
        }
    
    }

    public function registrarUsuario (UsuarioBean $usuobj) {
        
        try {
            $objc=new ConexionBD();
            $con=$objc->getConexionBD();

            $nombres = mysqli_real_escape_string($con, $usuobj->getNombres());
            $correo = mysqli_real_escape_string($con, $usuobj->getCorreoElectronico());
            $contrasena = mysqli_real_escape_string($con, $usuobj->getContrasena());
            $apellidopaterno = mysqli_real_escape_string($con, $usuobj->getApellidoPaterno());
            $apellidomaterno = mysqli_real_escape_string($con, $usuobj->getApellidoMaterno());
            $telefono = mysqli_real_escape_string($con, $usuobj->getTelefono());
            $dni = mysqli_real_escape_string($con, $usuobj->getDNI());
            $direccion = mysqli_real_escape_string($con, $usuobj->getDireccion());

            $sql="INSERT INTO usuario(Nombres,ApellidoPaterno,ApellidoMaterno,Telefono,Direccion,DNI,CorreoElectronico,Contrasena,FechaCreacion) 
            
            VALUES('$nombres','$apellidopaterno','$apellidomaterno','$telefono','$direccion','$dni','$correo','$contrasena',NOW())";
            
            $rs=mysqli_query($con,$sql);
            mysqli_close($con);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
        return $rs;
    }
    
    public function filtrarUsuarioPorId($id){
        $list = array();
        try {
            $sql = "SELECT * FROM usuario WHERE idUsuario = ?";
            $objc = new ConexionBD();
            $cn = $objc->getConexionBD();
    
            // Usando consultas preparadas para evitar inyección SQL
            $stmt = $cn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
    
            while ($row = $result->fetch_assoc()) {
                array_push($list, array(
                    'IdUsuario' => $row['IdUsuario'],
                    'DNI' => $row['DNI'],
                    'Nombres' => $row['Nombres'],
                    'ApellidoPaterno' => $row['ApellidoPaterno'],
                    'ApellidoMaterno' => $row['ApellidoMaterno'],
                    'Telefono' => $row['Telefono'],
                    'Direccion' => $row['Direccion'],
                    'CorreoElectronico' => $row['CorreoElectronico'],
                    'Contrasena' => $row['Contrasena'],
                    'UsuarioCreacion' => $row['UsuarioCreacion'],
                    'FechaCreacion' => $row['FechaCreacion'],
                    'UsuarioModificacion' => $row['UsuarioModificacion'],
                    'FechaModificacion' => $row['FechaModificacion'],
                    'EstadoRegistro' => $row['EstadoRegistro']
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