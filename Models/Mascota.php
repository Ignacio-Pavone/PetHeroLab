<?php 
namespace Models;
class Mascota {
     private $nombre;
     private $tipo;
     private $raza;
     private $tamanio;
     private $foto;
     private $planVacunacion;
     private $video;

     public function __construct($nombre,$tipo,$raza,$tamanio,$foto,$planVacunacion,$video)
     {
         $this->nombre=$nombre;
         $this->tipo=$tipo;
         $this->raza=$raza;
         $this->tamanio=$tamanio;
         $this->foto=$foto;
         $this->planVacunacion=$planVacunacion;
         $this->video=$video;
     }

        public function getNombre(){
            return $this->nombre;
        }

        public function getTipo()
        {
            return $this->tipo;
        }

        public function getRaza(){
            return $this->raza;
        }

        public function getTamanio(){
            return $this->tamanio;
        }

        public function getFoto(){
            return $this->foto;
        }

        public function getPlanVacunacion(){
            return $this->planVacunacion;
        }

        public function getVideo(){
            return $this->video;
        }

        public function setNombre($nombre){
            $this->nombre=$nombre;
        }

        public function setTipo($tipo)
        {
            $this->tipo = $tipo;
        }

        public function setRaza($raza){
            $this->raza=$raza;
        }

        public function setTamanio($tamanio){
            $this->tamanio=$tamanio;
        }

        public function setFoto($foto){
            $this->foto=$foto;
        }

        public function setPlanVacunacion($planVacunacion){
            $this->planVacunacion=$planVacunacion;
        }

        public function setVideo($video){
            $this->video=$video;
        }

}

?>