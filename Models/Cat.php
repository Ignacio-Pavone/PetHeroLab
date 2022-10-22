<?php 
    namespace Models;
    class Cat extends Mascota{

    public function __construct($nombre, $edad, $raza, $tipo, $descripcion, $foto, $estado, $duenio){
        parent::__construct($nombre, $edad, $raza, $tipo, $descripcion, $foto, $estado, $duenio);
    }
        
    }
?>