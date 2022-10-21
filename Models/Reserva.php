<?php 
namespace Models;
use Utils\EReserva as EReserva;

    class Reserva  {
        
        private $nroReseva;
        private $guardian;
        private $duenio;
        private $mascota;
        private $fechaInicio;
        private $fechaFin;
        private $estado;
        private $costoTotal;

    public function __construct($mascota,$duenio,$guardian,$fechaInicio,$fechaFin,$costoTotal){
        $this->mascota = $mascota;
        $this->duenio = $duenio;
        $this->guardian = $guardian;
        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;
        $this->estado = EReserva::Pendiente;
        $this->costoTotal = $costoTotal;
    }

    

    public function getNroReseva(){
        return $this->nroReseva;
    }

    public function setNroReseva($nroReseva){
        $this->nroReseva = $nroReseva;
    }

    public function getGuardian(){
        return $this->guardian;
    }

    public function setGuardian($guardian){
        $this->guardian = $guardian;
    }

    public function getDuenio(){
        return $this->duenio;
    }

    public function setDuenio($duenio){
        $this->duenio = $duenio;
    }

    public function getMascota(){
        return $this->mascota;
    }

    public function setMascota($mascota){
        $this->mascota = $mascota;
    }

    public function getFechaInicio(){
        return $this->fechaInicio;
    }

    public function setFechaInicio($fechaInicio){
        $this->fechaInicio = $fechaInicio;
    }

    public function getFechaFin(){
        return $this->fechaFin;
    }

    public function setFechaFin($fechaFin){
        $this->fechaFin = $fechaFin;
    }

    public function getEstado(){
        return $this->estado;
    }

    public function setEstado($estado){
        $this->estado = $estado;
    }

    public function getCostoTotal(){
        return $this->costoTotal;
    }

    public function setCostoTotal($costoTotal){
        $this->costoTotal = $costoTotal;
    }


}

?>