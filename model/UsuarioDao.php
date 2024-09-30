<?php
require_once 'UsuarioBean.php';
require_once '../util/ConexionBD.php';
class UsuarioDao {

public function estaRegistradoUsuario(UsuarioBean $adminobj) {
        try {
            $objc = new ConexionBD();
            $con = $objc->getConexionBD();
            $correo = mysqli_real_escape_string($con, $adminobj->getCorreoElectronico());
            $contrasenha = mysqli_real_escape_string($con, $adminobj->getClave());
            $sql = "SELECT * FROM usuario WHERE CorreoElectronico='$correo' AND Clave='$contrasenha'";
            $rs = mysqli_query($con, $sql);

            if (mysqli_fetch_assoc($rs)) {
                mysqli_close($con);
                return true;
            } else {
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