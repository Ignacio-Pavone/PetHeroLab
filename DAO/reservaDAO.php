<?php namespace DAO;

use Models\Reserva as Reserva;
use Utils\EReserva as EReserva;
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

      foreach($this->list as $reserva){
        $valuesArray["nroReserva"] = $reserva->getNroReserva();
        $valuesArray["idMascota"] = $reserva->getMascota();
        $valuesArray["idDuenio"] = $reserva->getDuenio();
        $valuesArray["idGuardian"] = $reserva->getGuardian();
        $valuesArray["fechaInicio"] = $reserva->getFechaInicio();
        $valuesArray["fechaFin"] = $reserva->getFechaFin();
        $valuesArray["estado"] = $reserva->getEstado();
        $valuesArray["costoTotal"] = $reserva->getCostoTotal();
        $valuesArray["tipo"] = $reserva->getTipo();
        $valuesArray["raza"] = $reserva->getRaza();
        $valuesArray["cantidadDias"] = $reserva->getCantidadDias();
        array_push($arrayToEncode, $valuesArray);
      }

      $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
      file_put_contents($this->filename, $jsonContent);
    }
    

    public function GetAllReservas(){
        $this->LoadReservaJson();
        return $this->list;
    }

    public function getReservasByDuenioID ($id){
      $this->LoadReservaJson();
      $array = array();
      foreach($this->list as $reserva){
        if($reserva->getDuenio() == $id){
          array_push($array,$reserva);
        }
      }
      return $array;
    }

    public function getReservasByGuardianID($id){
      $this->LoadReservaJson();
      $array = array();
      foreach($this->list as $reserva){
        if($reserva->getGuardian() == $id){
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
                    $reserva = new Reserva($item['idMascota'], $item['idDuenio'],$item['idGuardian'], $item['fechaInicio'], $item['fechaFin'], $item['costoTotal'],$item['tipo'],$item['raza'],$item['cantidadDias']);
                    $reserva->setEstado($item['estado']);
                    $reserva->setNroReserva($item['nroReserva']);
                    
                    if (($reserva->getFechaFin() < date('Y-m-d')) && ($reserva->getEstado() == 'Confirmado')){
                      $reserva->setEstado('Completo');
                    }
                    
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

    public function aceptarReservaGuardiann($nroReserva){
      $this->LoadReservaJson();
      foreach($this->list as $reserva){
        if ($reserva->getNroReserva() == $nroReserva){
            $reserva->setEstado(EReserva::Confirmado);
            $this->SaveData();
            return true;
          }
      }
      return false;
    }

    public function rechazarReservaGuardian($nroReserva){
      $this->LoadReservaJson();
      foreach($this->list as $reserva){
        if ($reserva->getNroReserva() == $nroReserva){
          $reserva->setEstado(EReserva::Rechazado);
        }
      }
      $this->SaveData();
    }

    public function cancelarcomoDuenio ($nroReserva){
      $this->LoadReservaJson();
      foreach($this->list as $reserva){
      if ($reserva->getEstado() != "Confirmado" && $reserva->getEstado() != "Completo"){
          if ($reserva->getNroReserva() == $nroReserva){
            $this->borrarReserva($nroReserva);
            return true;
          }
       }
      }
      $this->SaveData();
      return false;
    }

    public function borrarReserva ($nroReserva){
      $this->LoadReservaJson();
      $newlist = array();
      foreach($this->list as $reserva){
        if ($reserva->getNroReserva() != $nroReserva){
          array_push($newlist, $reserva);
        }
      }
      $this->list = $newlist;
      $this->SaveData();
    }


    public function checkfirstPetType ($idGuardian,$tipo,$raza){
      $reservas = $this->getReservasByGuardianID($idGuardian);
      if (empty($reservas)){
        return true;
      }

      if ($reservas){
        if (strcasecmp($reservas[0]->getTipo(),$tipo) == 0){
          if (strcasecmp($reservas[0]->getRaza(),$raza) == 0){
            return true;
          }
        }
      }
      return false;
    }

    public function dateChecker($dateone, $datetwo){
      $date1 = strtotime($dateone);
      $date2 = strtotime($datetwo);
      if ($date1 <= $date2){
        return false;
      }
      return true;
    }

    public function contarDias ($fechaInicio, $fechaFin){
      $date1 = strtotime($fechaInicio);
      $date2 = strtotime($fechaFin);
      $diff = abs($date2 - $date1);
      $years = floor($diff / (365*60*60*24));
      $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
      $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
      if ($days == 0){
        $days = 1;
      }
      return $days;
    }

    public function chequeoDataReserva ($searchPet,$searchGuardian,$searchDuenio){
      if ($searchPet!=null && $searchGuardian!=null && $searchDuenio!=null)
      return true;
      else
      return false;
    }

    public function buscarReservaporNumero ($nroReserva){
      $this->LoadReservaJson();
      foreach($this->list as $reserva){
        if ($reserva->getNroReserva() == $nroReserva){
          return $reserva;
        }
      }
      return null;
    }

    public function cambiarEstado ($nroReserva,$estado){
      $this->LoadReservaJson();
      foreach($this->list as $reserva){
        if ($reserva->getNroReserva() == $nroReserva){
          $reserva->setEstado($estado);
        }
      }
      $this->SaveData();
    }
}



    









