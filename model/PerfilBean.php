<?php
class PerfilBean {
    public $idPerfil;
    public $nombre;
    public $descripcion;
    public $estadoRegistro;


    // Getters y Setters
    public function getIdPerfil() {
        return $this->idPerfil;
    }

    public function setIdPerfil($idPerfil) {
        $this->idPerfil = $idPerfil;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function getEstadoRegistro() {
        return $this->estadoRegistro;
    }

    public function setEstadoRegistro($estadoRegistro) {
        $this->estadoRegistro = $estadoRegistro;
    }
}
?>