<?php
class UsuarioBean {
    public $id;
    public $dni;
    public $nombres;
    public $apellidopaterno;
    public $apellidomaterno;
    public $celular;
    public $correo;
    public $contrasenha;
    public $nombreusuario;
    public $fechacreacion;
    public $estadoregistro;

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
    public function getCelular(){
        return $this->celular;
    }
    public function getCorreoElectronico(){
        return $this->correo;
    }
    public function getClave(){
        return $this->contrasenha;
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
    public function setCelular($celular){
        $this->celular = $celular;
    }
    public function setCorreoElectronico($correo){
        $this->correo = $correo;
    }
    public function setClave($contrasenha){
        $this->contrasenha = $contrasenha;
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
}
?>