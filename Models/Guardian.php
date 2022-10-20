<?php
namespace Models;

use Models\Usuario;

class Guardian extends Usuario {

    private $tipoMascota; //tamaño de mascota chica mediana grande
    private $remuneracionEsperada; //no sabemos si es por hora o no
    private $reputacion;
    private $disponibilidad = array();

    public function __construct($email, $fullname, $dni, $age, $password, $tipoMascota, $remuneracionEsperada,$disponibilidad)
    {
        parent::__construct($email, $fullname, $dni, $age, $password);
        $this->tipoMascota = $tipoMascota;
        $this->remuneracionEsperada = $remuneracionEsperada;
        $this->reputacion = 0;
        $this->disponibilidad = $disponibilidad;
    }

    public function setTipoMascota($tipoMascota)
    {
        $this->tipoMascota = $tipoMascota;
    }

    public function getTipoMascota()
    {
        return $this->tipoMascota;
    }

    public function setRemuneracionEsperada($remuneracionEsperada)
    {
        $this->remuneracionEsperada = $remuneracionEsperada;
    }

    public function getRemuneracionEsperada()
    {
        return $this->remuneracionEsperada;
    }

    public function setReputacion($reputacion)
    {
        $this->reputacion = $reputacion;
    }

    public function getReputacion()
    {
        return $this->reputacion;
    }

    public function getDisponibilidad()
    {
        return $this->disponibilidad;
    }

    public function reiniciarDisponibilidad(){
        $this->disponibilidad = array();
    }

    public function setDisponibilidad($dia){
        if (!($this->checkDisponibilidad($dia)))
            array_push($this->disponibilidad,$dia);
    }
    
    public function checkDisponibilidad($dia){
        $flag=false;
        if ($this->disponibilidad!=null){
            foreach($this->disponibilidad as $value){
                if ($value==$dia)
                    $flag=true;
            }
        }
        return $flag;
    }
}

?>