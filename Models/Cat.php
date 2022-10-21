<?php 
    namespace Models;
    class Cat extends Mascota{

        public function __construct(){
            parent::__construct($nombre,$raza,$tamanio,$foto,$planVacunacion,$video);
        }
        
    }
?>