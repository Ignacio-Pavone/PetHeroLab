<?php namespace DAO;

use Models\Reserva as Reserva;
use Utils\EReserva as EReserva;
use Utils\Session;

use Models\Guardian;

    class reservaDAO{
      private $list = array();
      private $filename;
      private $id;

    public function __construct(){
      $this->filename = dirname(__DIR__)."/Data/reservas.json";
    }

    public function SaveData(){
      $arrayToEncode = array();
      foreach($this->list as $reserva){
        $valuesArray["nroReserva"] = $reserva->getNroReserva();
        $valuesArray["idMascota"] = $reserva->getMascota();
        $valuesArray["idDuenio"] = $reserva->getDuenio();
        $valuesArray["idGuardian"] = $reserva->getGuardian();
        $valuesArray["fechaInicio"] = $reserva->getFechaInicio();
        $valuesArray["fechaFin"] = $reserva->getFechaFin();
        $valuesArray["estado"] = $reserva->getEstado();
        $valuesArray["calificacion"] = intval($reserva->getCalificacion());
        $valuesArray["costoTotal"] = $reserva->getCostoTotal();
        $valuesArray["tipo"] = $reserva->getTipo();
        $valuesArray["raza"] = $reserva->getRaza();
        $valuesArray["cantidadDias"] = $reserva->getCantidadDias();
        array_push($arrayToEncode, $valuesArray);
      }
      $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
      file_put_contents($this->filename, $jsonContent);
    }  

    public function findreservaByID ($nroReserva){
      $this->LoadReservaJson();
      foreach ($this->list as $reserva){
        if ($reserva->getNroReserva() == $nroReserva){
          return $reserva;
        }
      }
      return false;
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

    private function LoadReservaJson(){
        $this->list = array();
        if(file_exists($this->filename)){
          $jsonContent = file_get_contents($this->filename);
          $array = ($jsonContent) ? json_decode($jsonContent, true) : array();
          foreach($array as $item){
            $reserva = new Reserva($item['idMascota'], $item['idDuenio'],$item['idGuardian'], $item['fechaInicio'], $item['fechaFin'], $item['costoTotal'],$item['tipo'],$item['raza'],$item['cantidadDias']);
            $reserva->setEstado($item['estado']);
            $reserva->setCalificacion($item['calificacion']);
            $reserva->setNroReserva($item['nroReserva']);                   
            $reserva= $this->estadosAutomaticos($reserva);                
            array_push($this->list, $reserva);
            if ($item["nroReserva"] > $this->id) {
              $this->id = $item["nroReserva"];
            }
          }                  
        }
        //Buscar mejor manera de ejecutar SaveData para mantener los Estados actualizados.
        $this->SaveData();
    }

    public function sumarCalificacionesGuardian($idGuardian){
      $this->LoadReservaJson();
      $sum = 0;
      foreach($this->list as $reserva){
        if($reserva->getGuardian() == $idGuardian){
          if($reserva->getEstado() == "Calificado"){
            $sum += $reserva->getCalificacion();
          }
        }
      }
      return $sum;
    }

    public function contarCalificacionesGuardian($idGuardian){
      $this->LoadReservaJson();
      $count = 0;
      foreach($this->list as $reserva){
        if($reserva->getGuardian() == $idGuardian){
          if($reserva->getEstado() == "Calificado"){
            $count++;
          }
        }
      }
      return $count;
    }

    public function estadosAutomaticos($reserva){
      if($reserva->getEstado() == 'Confirmado'){
        if (($reserva->getFechaFin() < date('Y-m-d')) ){
          $reserva->setEstado('Completo');
        }elseif ($reserva->getFechaInicio() >= date('Y-m-d') && $reserva->getFechaFin() >= date('Y-m-d')){
          $reserva->setEstado('En Curso');
        }
      }
      return $reserva;
    }

    public function add($reserva){
        $this->LoadReservaJson();
        $reserva->setNroReserva($this->id + 1);
        array_push($this->list, $reserva);
        $this->SaveData();
    }

    public function checkReservasdeGuardian($reservas, $reservaaAceptar){
      $this->LoadReservaJson();
      foreach ($reservas as $reserva){
        if ($reserva->getEstado() == 'En Curso'){
          if ($reserva->getTipo() == $reservaaAceptar->getTipo()){
            if ($reserva->getRaza() == $reservaaAceptar->getRaza()){
                return true;
              }       
          }
        }
      }
    return false;
    }

    public function aceptarReservaGuardiann($nroReserva,$idGuardian){
      $this->LoadReservaJson();
      $reservaBuscada = $this->findreservaByID($nroReserva);
      $reservasGuardian = $this->getReservasByGuardianID($idGuardian);
      if(empty($reservasGuardian)){
        $this->aceptarReserva($nroReserva);
        return true;
      }

      if(count($this->filtrarConfirmados($idGuardian)) == 0 && count($this->filtrarEnCurso($idGuardian)) == 0){   
        $this->aceptarReserva($nroReserva);
        return true;
      }

      if($this->checkReservasdeGuardian($reservasGuardian,$reservaBuscada)){
        var_dump($reservaBuscada);
        $this->aceptarReserva($nroReserva);
        return true;
      }

      $this->rechazarAutomatico($nroReserva);
      return false;
    }

    public function rechazarAutomatico ($nroReserva){
      $this->LoadReservaJson();
      foreach ($this->list as $reserva){
        if ($reserva->getNroReserva() == $nroReserva){
          $reserva->setEstado('Rechazado');
          $this->SaveData();
        }
      }
    }

    public function aceptarReserva($nroReserva){
      $this->LoadReservaJson();
      foreach ($this->list as $reserva){
        if ($reserva->getNroReserva() == $nroReserva){
          $reserva->setEstado('Confirmado');
          $this->SaveData();
        }
      }
    }

    public function todaslasReservasdelguardian($idGuardian){
      $this->LoadReservaJson();
      $array = array();
      foreach($this->list as $reserva){
        if($reserva->getGuardian() == $idGuardian){
          array_push($array,$reserva);
        }
      }
      return $array;
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

    public function cancelarcomoDuenio($nroReserva){
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

    public function borrarReserva($nroReserva){
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

    public function checkfirstPetType($idGuardian,$tipo,$raza){
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

    public function filtrarPendientes($idGuardian){
      $this->LoadReservaJson();
      $array = array();
      foreach($this->list as $reserva){
        if($reserva->getGuardian() == $idGuardian){
          if($reserva->getEstado() == "Pendiente"){
            array_push($array,$reserva);
          }
        }
      }
      return $array;
    }

    public function filtrarConfirmados($idGuardian){
      $this->LoadReservaJson();
      $array = array();
      foreach($this->list as $reserva){
        if($reserva->getGuardian() == $idGuardian){
          if($reserva->getEstado() == "Confirmado"){
            array_push($array,$reserva);
          }
        }
      }
      return $array;
    }

    public function filtrarEnCurso($idGuardian){
      $this->LoadReservaJson();
      $array = array();
      foreach($this->list as $reserva){
        if($reserva->getGuardian() == $idGuardian){
          if($reserva->getEstado() == "En Curso"){
            array_push($array,$reserva);
          }
        }
      }
      return $array;
    }

    public function analizarReserva($idGuardian, $tipo, $raza, $fechaInicio){
    $reservas = $this->getReservasByGuardianID($idGuardian);
    if (empty($reservas)){
      return true;
    }
    if (count($this->filtrarConfirmados($idGuardian)) == 0 && count($this->filtrarEnCurso($idGuardian)) == 0){
      return true;
    }
    foreach ($reservas as $reserva){
        if ($reserva->getEstado() == "Confirmado" || $reserva->getEstado() == "En Curso"){
          if ($fechaInicio >= $reserva->getFechaInicio()){
            if ($tipo == $reserva->getTipo()){       
              if ($raza == $reserva->getRaza()){
              return true;      
          }
        }
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

    public function contarDias($fechaInicio, $fechaFin){
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

    public function chequeoDataReserva($searchPet,$searchGuardian,$searchDuenio){
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

    public function cambiarEstado($nroReserva,$estado){
      $this->LoadReservaJson();
      foreach($this->list as $reserva){
        if ($reserva->getNroReserva() == $nroReserva){
          $reserva->setEstado($estado);
          $this->SaveData();
          return true;
        }
      }
      return false;
    }

    public function setearCalificacion($nroReserva,$calificacion){
      $this->LoadReservaJson();
      foreach($this->list as $reserva){
        if ($reserva->getNroReserva() == $nroReserva){
          $reserva->setCalificacion($calificacion);
          $this->SaveData();
          return true;
        }
      }
      return false;
    }

}



    









