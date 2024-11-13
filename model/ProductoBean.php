<?php
class ProductoBean {
    private $idProducto;
    private $nombreProducto;
    private $descripcionProducto;
    private $stockMinimo;
    private $stockMaximo;
    private $precio;
    private $fechaVencimiento; // Nuevo atributo
    private $idSubcategoria;
    private $imagenProducto;

    // Getters y Setters
    public function getIdProducto() {
        return $this->idProducto;
    }

    public function setIdProducto($idProducto) {
        $this->idProducto = $idProducto;
    }

    public function getNombreProducto() {
        return $this->nombreProducto;
    }

    public function setNombreProducto($nombreProducto) {
        $this->nombreProducto = $nombreProducto;
    }

    public function getDescripcionProducto() {
        return $this->descripcionProducto;
    }

    public function setDescripcionProducto($descripcionProducto) {
        $this->descripcionProducto = $descripcionProducto;
    }

    public function getStockMinimo() {
        return $this->stockMinimo;
    }

    public function setStockMinimo($stockMinimo) {
        $this->stockMinimo = $stockMinimo;
    }

    public function getStockMaximo() {
        return $this->stockMaximo;
    }

    public function setStockMaximo($stockMaximo) {
        $this->stockMaximo = $stockMaximo;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function setPrecio($precio) {
        $this->precio = $precio;
    }

    public function getFechaVencimiento() { // Getter para la nueva columna
        return $this->fechaVencimiento;
    }

    public function setFechaVencimiento($fechaVencimiento) { // Setter para la nueva columna
        $this->fechaVencimiento = $fechaVencimiento;
    }

    public function getIdSubcategoria() {
        return $this->idSubcategoria;
    }

    public function setIdSubcategoria($idSubcategoria) {
        $this->idSubcategoria = $idSubcategoria;
    }

    public function getImagenProducto() {
        return $this->imagenProducto;
    }

    public function setImagenProducto($imagenProducto) {
        $this->imagenProducto = $imagenProducto;
    }
}
?>