<?php
require_once 'UsuarioBean.php';
require_once __DIR__ . '/../util/ConexionBD.php';

class UsuarioDao {

    public function estaRegistradoUsuario (UsuarioBean $usuobj) {
        try {
            // Conexión a la base de datos
            $objc = new ConexionBD();
            $con = $objc->getConexionBD();
            
            // Sanitizamos el correo ingresado por el usuario
            $correo = mysqli_real_escape_string($con, $usuobj->getCorreoElectronico());
            
            // Obtenemos la contraseña en texto plano ingresada por el usuario
            $contrasena = $usuobj->getContrasena();
            
            // Preparar la consulta SQL para obtener el hash de la contraseña
            $sql = "SELECT Contrasena FROM usuario WHERE BINARY CorreoElectronico='$correo'";
            $rs = mysqli_query($con, $sql);
            
            if (mysqli_num_rows($rs) == 1) {
                // Obtenemos el hash de la base de datos
                $row = mysqli_fetch_assoc($rs);
                $hash_contrasena = $row['Contrasena'];
                
                // Verificar la contraseña ingresada contra el hash almacenado
                if (password_verify($contrasena, $hash_contrasena)) {
                    mysqli_close($con);
                    return true;  // Contraseña correcta
                } else {
                    mysqli_close($con);
                    return false;  // Contraseña incorrecta
                }
            } else {
                // No se encontró el correo electrónico
                mysqli_close($con);
                return false;  // Usuario no encontrado
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    
    }

    public function registrarUsuario (UsuarioBean $usuobj) {
        
        try {
            $objc = new ConexionBD();
            $con = $objc->getConexionBD();
    
            // Sanitize input
            $nombres = mysqli_real_escape_string($con, $usuobj->getNombres());
            $correo = mysqli_real_escape_string($con, $usuobj->getCorreoElectronico());
            $apellidopaterno = mysqli_real_escape_string($con, $usuobj->getApellidoPaterno());
            $apellidomaterno = mysqli_real_escape_string($con, $usuobj->getApellidoMaterno());
            $fechanacimiento = mysqli_real_escape_string($con, $usuobj->getFechaNacimiento());
            $telefono = mysqli_real_escape_string($con, $usuobj->getTelefono());
            $dni = mysqli_real_escape_string($con, $usuobj->getDNI());
            $direccion = mysqli_real_escape_string($con, $usuobj->getDireccion());
            $distrito = mysqli_real_escape_string($con, $usuobj->getDistrito());
            $estadoRegistro = 1;
            $perfil = 3;
    
            // Hash the password
            $contrasena = password_hash($usuobj->getContrasena(), PASSWORD_DEFAULT);
    
            $sql = "INSERT INTO usuario (Nombres, ApellidoPaterno, ApellidoMaterno, FechaNacimiento, Telefono, Direccion, IdDistrito, DNI, CorreoElectronico, Contrasena, EstadoRegistro, FechaCreacion, IdPerfil) 
                    VALUES ('$nombres', '$apellidopaterno', '$apellidomaterno', '$fechanacimiento', '$telefono', '$direccion', '$distrito', '$dni', '$correo', '$contrasena','$estadoRegistro', NOW(),'$perfil')";
    
            $rs = mysqli_query($con, $sql);
    
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
                    'FechaNacimiento' => $row['FechaNacimiento'],
                    'Telefono' => $row['Telefono'],
                    'Direccion' => $row['Direccion'],
                    'IdDistrito' => $row['IdDistrito'],
                    'CorreoElectronico' => $row['CorreoElectronico'],
                    'Contrasena' => $row['Contrasena'],
                    'UsuarioCreacion' => $row['UsuarioCreacion'],
                    'FechaCreacion' => $row['FechaCreacion'],
                    'UsuarioModificacion' => $row['UsuarioModificacion'],
                    'FechaModificacion' => $row['FechaModificacion'],
                    'EstadoRegistro' => $row['EstadoRegistro'],
                    'IdPerfil' => $row['IdPerfil'],
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

    public function filtrarUsuarioPorCorreo($correo){
        $list = array();
        try {
            $sql = "SELECT u.*, p.Nombre AS NombrePerfil
            FROM usuario u
            JOIN perfiles p ON u.IdPerfil = p.IdPerfil
            WHERE u.CorreoElectronico = ?";
            $objc = new ConexionBD();
            $cn = $objc->getConexionBD();
    
            // Usando consultas preparadas para evitar inyección SQL
            $stmt = $cn->prepare($sql);
            $stmt->bind_param("s", $correo);
            $stmt->execute();
            $result = $stmt->get_result();
    
            while ($row = $result->fetch_assoc()) {
                array_push($list, array(
                    'IdUsuario' => $row['IdUsuario'],
                    'DNI' => $row['DNI'],
                    'Nombres' => $row['Nombres'],
                    'ApellidoPaterno' => $row['ApellidoPaterno'],
                    'ApellidoMaterno' => $row['ApellidoMaterno'],
                    'FechaNacimiento' => $row['FechaNacimiento'],
                    'Telefono' => $row['Telefono'],
                    'Direccion' => $row['Direccion'],
                    'IdDistrito' => $row['IdDistrito'],
                    'CorreoElectronico' => $row['CorreoElectronico'],
                    'Contrasena' => $row['Contrasena'],
                    'UsuarioCreacion' => $row['UsuarioCreacion'],
                    'FechaCreacion' => $row['FechaCreacion'],
                    'UsuarioModificacion' => $row['UsuarioModificacion'],
                    'FechaModificacion' => $row['FechaModificacion'],
                    'EstadoRegistro' => $row['EstadoRegistro'],
                    'NombrePerfil' => $row['NombrePerfil']
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

    public function ActualizarUsuario(UsuarioBean $usuobj) {
        try {
            $objc = new ConexionBD();
            $cn = $objc->getConexionBD();
    
            $id = mysqli_real_escape_string($cn, $usuobj->getIdUsuario());
            $nombres = mysqli_real_escape_string($cn, $usuobj->getNombres());
            $apellidopaterno = mysqli_real_escape_string($cn, $usuobj->getApellidoPaterno());
            $apellidomaterno = mysqli_real_escape_string($cn, $usuobj->getApellidoMaterno());
            $fechanacimiento = mysqli_real_escape_string($cn, $usuobj->getFechaNacimiento());
            $correo = mysqli_real_escape_string($cn, $usuobj->getCorreoElectronico());
            $telefono = mysqli_real_escape_string($cn, $usuobj->getTelefono());
            $dni = mysqli_real_escape_string($cn, $usuobj->getDNI());
            $direccion = mysqli_real_escape_string($cn, $usuobj->getDireccion());
            $distrito = mysqli_real_escape_string($cn, $usuobj->getDistrito());
            $perfil = mysqli_real_escape_string($cn, $usuobj->getPerfil());
    
            // Hash the password outside the SQL query
            $contrasena = password_hash($usuobj->getContrasena(), PASSWORD_DEFAULT);
    
            // Correct SQL query
            $sql = "UPDATE usuario 
                    SET Nombres = '$nombres', 
                    ApellidoPaterno = '$apellidopaterno', 
                    ApellidoMaterno = '$apellidomaterno', 
                    FechaNacimiento = '$fechanacimiento',
                    Telefono = '$telefono',
                    Direccion = '$direccion',
                    IdDistrito = '$distrito',
                    DNI = '$dni',
                    IdPerfil = '$perfil',
                    CorreoElectronico = '$correo',
                    Contrasena = '$contrasena'
                    WHERE IdUsuario = '$id'";
    
            $rs = mysqli_query($cn, $sql);
            mysqli_close($cn);
    
            return $rs;
    
        } catch (Exception $e) {
            // Registrar el error o mostrar un mensaje
            error_log($e->getMessage());
            return false;
        }
    }
    
    public function cambiarEstadoUsuario($idUsuario, $nuevoEstado) {
        try {
            $objc = new ConexionBD();
            $con = $objc->getConexionBD();
    
            // Sanitizar el ID del usuario
            $idUsuario = mysqli_real_escape_string($con, $idUsuario);
    
            // Preparar la consulta para cambiar el estado
            $sql = "UPDATE usuario SET EstadoRegistro = ? WHERE IdUsuario = ?";
            $stmt = $con->prepare($sql);
    
            if ($stmt === false) {
                throw new Exception("Error al preparar la consulta: " . $con->error);
            }
    
            // Bindear los parámetros (EstadoRegistro es un entero, IdUsuario también)
            $stmt->bind_param("ii", $nuevoEstado, $idUsuario);
    
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
    
    public function obtenerIdPerfil($objUsuarioBean) {
        try {
            $objc = new ConexionBD();
            $con = $objc->getConexionBD();

            $correo = $objUsuarioBean->getCorreoElectronico();
            
        
            $sql = "SELECT IdPerfil FROM usuario WHERE CorreoElectronico = ?";
            
            $stmt = $con->prepare($sql);
            $stmt->bind_param("s", $correo);
            $stmt->execute();
            $stmt->bind_result($idPerfil);
        
            if ($stmt->fetch()) {
                return $idPerfil;
            } else {
                return null;
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function obtenerIdUsuario($objUsuarioBean) {
        try {
            $objc = new ConexionBD();
            $con = $objc->getConexionBD();

            $idUsuario = $objUsuarioBean->getCorreoElectronico();
            
        
            $sql = "SELECT IdUsuario FROM usuario WHERE CorreoElectronico = ?";
            
            $stmt = $con->prepare($sql);
            $stmt->bind_param("s", $idUsuario);
            $stmt->execute();
            $stmt->bind_result($idUsuario);
        
            if ($stmt->fetch()) {
                return $idUsuario;
            } else {
                return null;
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

}
?>