<?php
    class DistritoBean
    {
        public $idDistrito;
        public $nombreDistrito;


        //Métodos GET
        public function getIdDistrito(){
            return $this->idDistrito;
        }
        public function getNombreDistrito(){
            return $this->nombreDistrito;
        }


        //Métodos SET
        public function setIdDistrito($idDistrito){
            $this->idDistrito = $idDistrito;
        }
        public function setNombreDistrito($nombreDistrito){
            $this->nombreDistrito = $nombreDistrito;
        }
    }
?>