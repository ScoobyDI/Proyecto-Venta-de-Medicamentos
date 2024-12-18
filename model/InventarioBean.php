<?php
class InventarioBean {
    public $idLote;
    public $cantidad;
    public $fechaCaducidad;
    public $fechaInsercion;
    public $idProducto;

    // Getters y Setters
    public function getIdLote() {
        return $this->idLote;
    }

    public function setIdLote($idLote) {
        $this->idLote = $idLote;
    }

    public function getCantidad() {
        return $this->cantidad;
    }

    public function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    public function getFechaCaducidad() {
        return $this->fechaCaducidad;
    }

    public function setFechaCaducidad($fechaCaducidad) {
        $this->fechaCaducidad = $fechaCaducidad;
    }

    public function getFechaInsercion() {
        return $this->fechaInsercion;
    }

    public function setFechaInsercion($fechaInsercion) {
        $this->fechaInsercion = $fechaInsercion;
    }

    public function getIdProducto() {
        return $this->idProducto;
    }

    public function setIdProducto($idProducto) {
        $this->idProducto = $idProducto;
    }
}
?>