<?php
namespace Models;

use Models\Usuario;

class Guardian extends Usuario {
    private $idGuardian;
    private $tipoMascota; 
    private $remuneracionEsperada;
    private $reputacion;
    private $initDate;
    private $finishDate;

    public function __construct($email, $fullname, $dni, $age, $password, $tipoMascota, $remuneracionEsperada,$initDate,$finishDate){
        parent::__construct($email, $fullname, $dni, $age, $password);
        $this->tipoMascota = $tipoMascota;
        $this->remuneracionEsperada = $remuneracionEsperada;
        $this->reputacion = 0;
        $this->initDate = $initDate;
        $this->finishDate = $finishDate;
    }

    public function getIdGuardian(){
        return $this->idGuardian;
    }

    public function setIdGuardian($idGuardian){
        $this->idGuardian = $idGuardian;
    }
    public function setTipoMascota($tipoMascota){
        $this->tipoMascota = $tipoMascota;
    }

    public function setinitDate($initDate){
        $this->initDate = $initDate;
    }

    public function setfinishDate($finishDate){
        $this->finishDate = $finishDate;
    }

    public function getFinishDate(){
        return $this->finishDate;
    }

    public function getInitDate(){
        return $this->initDate;
    }

    public function getTipoMascota(){
        return $this->tipoMascota;
    }

    public function setRemuneracionEsperada($remuneracionEsperada){
        $this->remuneracionEsperada = $remuneracionEsperada;
    }

    public function getRemuneracionEsperada(){
        return $this->remuneracionEsperada;
    }

    public function setReputacion($reputacion){
        $this->reputacion = $reputacion;
    }

    public function getReputacion(){
        return $this->reputacion;
    }

    public function calcularCalificacion ($calificacion,$count){
        $reputacion = 0;     
        $reputacion = $calificacion/$count; 
        $this->setReputacion($reputacion);
    }

}

?>