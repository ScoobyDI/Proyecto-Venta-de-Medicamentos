<?php
    class CategoriaBean
    {
        public $idCategoria;
        public $nombreCategoria;
        public $descripcionCategoria;
        public $estadoCategoria;
        public $idSubCategoria;
        public $nombreSubCategoria;
        public $estadoSubCategoria;

        //Métodos GET
        public function getIdCategoria(){
            return $this->idCategoria;
        }

        public function getNombreCategoria(){
            return $this->nombreCategoria;
        }

        public function getDescripcionCategoria(){
            return $this->descripcionCategoria;
        }

        public function getEstadoCategoria(){
            return $this->estadoCategoria;
        }

        public function getIdSubCategoria(){
            return $this->idSubCategoria;
        }

        public function getNombreSubCategoria(){
            return $this->nombreSubCategoria;
        }

        public function getEstadoSubCategoria(){
            return $this->estadoSubCategoria;
        }

        //Métodos SET
        public function setIdCategoria($idCategoria){
            $this->idCategoria = $idCategoria;
        }

        public function setNombreCategoria($nombreCategoria){
            $this->nombreCategoria = $nombreCategoria;
        }

        public function setDescripcionCategoria($descripcionCategoria){
            $this->descripcionCategoria = $descripcionCategoria;
        }

        public function setEstadoCategoria($estadoCategoria){
            $this->estadoCategoria = $estadoCategoria;
        }

        public function setIdSubCategoria($idSubCategoria){
            $this->idSubCategoria = $idSubCategoria;
        }

        public function setNombreSubCategoria($nombreSubCategoria){
            $this->nombreSubCategoria = $nombreSubCategoria;
        }

        public function setEstadoSubCategoria($estadoSubCategoria){
            $this->estadoSubCategoria = $estadoSubCategoria;
        }
    }
?>