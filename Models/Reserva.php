<?php 
namespace Models;
    class Reserva  {
        
        private $nroReseva;
        private $guardian;
        private $duenio;
        private $mascota;
        private $fechaInicio;
        private $fechaFin;
        private $estado;
        private $costoTotal;

    public function __construct(){
        $this->nroReseva=0;
        $this->guardian=null;
        $this->duenio=null;
        $this->mascota=null;
        $this->fechaInicio=null;
        $this->fechaFin=null;
        $this->estado=null;
        $this->costoTotal=0;
    }
}

?>