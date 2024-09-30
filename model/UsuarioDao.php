<?php
require_once 'UsuarioBean.php';
require_once '../util/ConexionBD.php';

class UsuarioDao {

    public function estaRegistradoUsuario (UsuarioBean $usuobj) {
        
        $objc = new ConexionBD();
        $con = $objc->getConexionBD();
        
        $correo = mysqli_real_escape_string($con, $usuobj->getCorreoElectronico());         // Los valores ingresados se tratan como texto literal, evitando que puedan alterar la consulta SQL.
        $contrasenha = mysqli_real_escape_string($con, $usuobj->getClave());

        $sql = "SELECT * FROM usuario WHERE BINARY CorreoElectronico='$correo' AND BINARY Clave='$contrasenha'";
        
        $rs = mysqli_query($con, $sql);

        if (mysqli_num_rows($rs) == 1) {
            mysqli_close($con);                                                                                                     //busca en la tabla si coincide un valor
            return true;
        } else {
            mysqli_close($con); 
            return false;
        }
    
    }

    public function registrarUsuario (UsuarioBean $usuobj) {
        
        try {
            $sql="INSERT INTO usuario(Nombres,ApellidoPaterno,ApellidoMaterno,Celular,DNI,CorreoElectronico,Clave) 
            
            VALUES('$usuobj->nombres','$usuobj->apellidopaterno','$usuobj->apellidomaterno','$usuobj->celular','$usuobj->dni'),'$usuobj->correo'),'$usuobj->contrasenha')";
            
            $objc=new ConexionBD();
            $cn=$objc->getConexionBD();
            $rs=mysqli_query($cn,$sql);
            mysqli_close($cn);
        } catch (Exception $e) {
    
        }
        return $rs;
        
    }

}

?>