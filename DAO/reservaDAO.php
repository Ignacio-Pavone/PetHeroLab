<?php namespace DAO;

use Models\Reserva as Reserva;
use Utils\Session;

use Models\Guardian;

    class reservaDAO
    {
      private $list = array();
      private $filename;
      private $id;

      public function __construct()
      {
        $this->filename = dirname(__DIR__)."/Data/reservas.json";
      }

    public function SaveData()
    {
      $arrayToEncode = array();

      foreach($this->list as $reserva)
      {
        $valuesArray["nroReserva"] = $reserva->getNroReserva();
        $valuesArray["Mascota"] = $reserva->getMascota();
        $valuesArray["Duenio"] = $reserva->getDuenio();
        $valuesArray["Guardian"] = $reserva->getGuardian();
        $valuesArray["fechaInicio"] = $reserva->getFechaInicio();
        $valuesArray["fechaFin"] = $reserva->getFechaFin();
        $valuesArray["estado"] = $reserva->getEstado();
        $valuesArray["costoTotal"] = $reserva->getCostoTotal();

        array_push($arrayToEncode, $valuesArray);
      }

      $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
      file_put_contents($this->filename, $jsonContent);
    }
    

    public function GetAllReservas(){
        $this->LoadReservaJson();
        return $this->list;
    }

    public function getReservasByGuardian($guardianName){
      $this->LoadReservaJson();
      $array = array();
      foreach($this->list as $reserva){
        if($reserva->getGuardian() == $guardianName){
          array_push($array,$reserva);
        }
      }
      return $array;
    }

    private function LoadReservaJson() {
        $this->list = array();
        if(file_exists($this->filename)) 
            {
                $jsonContent = file_get_contents($this->filename);
                $array = ($jsonContent) ? json_decode($jsonContent, true) : array();
                foreach($array as $item) 
                {
                    $reserva = new Reserva($item['Mascota'], $item['Duenio'],$item['Guardian'], $item['fechaInicio'], $item['fechaFin'], $item['costoTotal']);
                    $reserva->setEstado($item['estado']);
                    $reserva->setNroReserva($item['nroReserva']);
                    array_push($this->list, $reserva);
                    if ($item["nroReserva"] > $this->id) {
                      $this->id = $item["nroReserva"];
                  }
                 }                  
        }
    }

    public function add ($reserva){
        $this->LoadReservaJson();
        $reserva->setNroReserva($this->id + 1);
        array_push($this->list, $reserva);
        $this->SaveData();
    }

    public function aceptarReservaGuardian($nroReserva){
      $this->LoadReservaJson();
      foreach($this->list as $reserva){
        if ($reserva->getNroReserva() == $nroReserva){
          $reserva->setEstado("Confirmado");
        }
      }
      $this->SaveData();
    }

    public function rechazarReservaGuardian($nroReserva){
      $this->LoadReservaJson();
      foreach($this->list as $reserva){
        if ($reserva->getNroReserva() == $nroReserva){
          $reserva->setEstado("Rechazado");
        }
      }
      $this->SaveData();
    }
}



    









