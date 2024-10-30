<?php
    class CategoriaBean
    {
        public $idCategoria;
        public $nombreCategoria;
        public $descripcionCategoria;
        public $estadoCategoria;

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
    }
?>