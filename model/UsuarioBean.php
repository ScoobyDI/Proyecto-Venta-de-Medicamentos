<?php
class UsuarioBean {
    public $id;
    public $dni;
    public $nombres;
    public $apellidopaterno;
    public $apellidomaterno;
    public $fechanacimiento;
    public $telefono;
    public $correo;
    public $contrasena;
    public $nombreusuario;
    public $fechacreacion;
    public $estadoregistro;
    public $direccion;
    public $distrito;

    // Métodos GET
    public function getIdUsuario(){
        return $this->id;
    }
    public function getDNI(){
        return $this->dni;
    }
    public function getNombres(){
        return $this->nombres;
    }
    public function getApellidoPaterno(){
        return $this->apellidopaterno;
    }
    public function getApellidoMaterno(){
        return $this->apellidomaterno;
    }
    public function getFechaNacimiento(){
        return $this->fechanacimiento;
    }
    public function getTelefono(){
        return $this->telefono;
    }
    public function getCorreoElectronico(){
        return $this->correo;
    }
    public function getContrasena(){
        return $this->contrasena;
    }
    public function getUsuarioCreacion(){
        return $this->nombreusuario;
    }
    public function getFechaCreacion(){
        return $this->fechacreacion;
    }
    public function getEstadoRegistro(){
        return $this->estadoregistro;
    }
    public function getDireccion(){
        return $this->direccion;
    }
    public function getDistrito(){
        return $this->distrito;
    }

    // Métodos SET
    public function setIdUsuario($id){
        $this->id = $id;
    }
    public function setDNI($dni){
        $this->dni = $dni;
    }
    public function setNombres($nombres){
        $this->nombres = $nombres;
    }
    public function setApellidoPaterno($apellidopaterno){
        $this->apellidopaterno = $apellidopaterno;
    }
    public function setApellidoMaterno($apellidomaterno){
        $this->apellidomaterno = $apellidomaterno;
    }
    public function setFechaNacimiento($fechanacimiento){
        $this->fechanacimiento = $fechanacimiento;
    }
    public function setTelefono($telefono){
        $this->telefono = $telefono;
    }
    public function setCorreoElectronico($correo){
        $this->correo = $correo;
    }
    public function setContrasena($contrasena){
        $this->contrasena = $contrasena;
    }
    public function setUsuarioCreacion($nombreusuario){
        $this->nombreusuario = $nombreusuario;
    }
    public function setFechaCreacion($fechacreacion){
        $this->fechacreacion = $fechacreacion;
    }
    public function setEstadoRegistro($estadoregistro){
        $this->estadoregistro = $estadoregistro;
    }
    public function setDireccion($direccion){
        $this->direccion = $direccion;
    }
    public function setDistrito($distrito){
        $this->distrito = $distrito;
    }
}
?>