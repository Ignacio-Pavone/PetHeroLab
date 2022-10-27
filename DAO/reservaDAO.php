<?php namespace DAO;

use Models\Reserva as Reserva;
use DAO\Connection as Connection;

  class reservaDAO{
    private $connection;
    private $tableName = "Requests";

    public function GetAllReservas(){
      try{
        $sql = "SELECT * FROM ".$this->tableName;
        $this->connection = Connection::GetInstance();
        $result = $this->connection->Execute($sql);
        $reservas = array();
        foreach($result as $row){
          $reserva = new Reserva($row["id_pet"], $row["id_owner"], $row["id_guardian"], $row["init_date"], $row["finish_date"], $row["costoTotal"],$row['tipo'],$row['raza'], $row["cantidadDias"]);
          $reserva->setNroReserva($row["id_request"]);
          $reserva->setEstado($row["req_status"]);
          $reserva->setCalificacion($row["calificacion"]);
          $this->estadosAutomaticos($reserva);
          array_push($reservas, $reserva);
        }
        return $reservas;
        }catch(\PDOException $ex){
        throw $ex;
      }
    }


    public function findreservaByID ($nroReserva){
      try{
        $sql = "SELECT * FROM ".$this->tableName." WHERE id_request = " . $nroReserva;
        $this->connection = Connection::GetInstance();
        $result = $this->connection->Execute($sql);
        foreach ($result as $row){
          $reserva = new Reserva($row["id_pet"], $row["id_owner"], $row["id_guardian"], $row["init_date"], $row["finish_date"], $row["costoTotal"],$row['tipo'],$row['raza'], $row["cantidadDias"]);
          $reserva->setEstado($row["req_status"]);
          $reserva->setNroReserva($row["id_request"]);
          $reserva->setCalificacion($row["calificacion"]);
          $this->estadosAutomaticos($reserva);
          return $reserva;
        }
      }catch(\PDOException $ex){
        throw $ex;
      }
    }

    public function getReservasByDuenioID ($id){
      try{
        $sql = "SELECT * FROM ".$this->tableName." WHERE id_owner = " . $id;
        $this->connection = Connection::GetInstance();
        $result = $this->connection->Execute($sql);
        $reservas = array();
        foreach ($result as $row){
          $reserva = new Reserva($row["id_pet"], $row["id_owner"], $row["id_guardian"], $row["init_date"], $row["finish_date"], $row["costoTotal"],$row['tipo'],$row['raza'], $row["cantidadDias"]);
          $reserva->setEstado($row["req_status"]);
          $reserva->setNroReserva($row["id_request"]);
          $reserva->setCalificacion($row["calificacion"]);
          $this->estadosAutomaticos($reserva);
          array_push($reservas, $reserva);
        }
        return $reservas;
      }catch(\PDOException $ex){
        throw $ex;
      }
    }

    public function getReservasByGuardianID($id){
      try{
        $sql = "SELECT * FROM ".$this->tableName." WHERE id_guardian = " . $id;
        $this->connection = Connection::GetInstance();
        $result = $this->connection->Execute($sql);
        $reservas = array();
        foreach ($result as $row){
          $reserva = new Reserva($row["id_pet"], $row["id_owner"], $row["id_guardian"], $row["init_date"], $row["finish_date"], $row["costoTotal"],$row['tipo'],$row['raza'], $row["cantidadDias"]);
          $reserva->setNroReserva($row["id_request"]);
          $reserva->setEstado($row["req_status"]);
          $reserva->setCalificacion($row["calificacion"]);
          $this->estadosAutomaticos($reserva);
          array_push($reservas, $reserva);
        }
        return $reservas;
      }catch(\PDOException $ex){
        throw $ex;
      }
    }

    public function contarCalificacionesGuardian($idGuardian){
      $sql = "SELECT count(calificacion) FROM ".$this->tableName." WHERE id_guardian = ".$idGuardian." and calificacion != 0;";
      $this->connection = Connection::GetInstance();
      $count = 0;
      $result = $this->connection->Execute($sql);
      foreach($result as $row){
        $count = $row["count(calificacion)"];
      }
      return $count;
    }

    public function sumarCalificacionesGuardian($idGuardian){
      $sql = "SELECT sum(calificacion) FROM ".$this->tableName." WHERE id_guardian = ".$idGuardian.";"; 
      $this->connection = Connection::GetInstance();
      $sum = 0;
      $result = $this->connection->Execute($sql);
      foreach($result as $row){
        $sum = $row["sum(calificacion)"];
      }    
      return $sum;
    }

    public function estadosAutomaticos($reserva){
      if($reserva->getEstado() == 'Confirmado'){
        if (($reserva->getFechaFin() < date('Y-m-d')) ){
            $this->reservaUpdateEstadoQuery($reserva, 'Completo');
           }elseif ($reserva->getFechaInicio() >= date('Y-m-d') && $reserva->getFechaFin() >= date('Y-m-d')){
            $this->reservaUpdateEstadoQuery($reserva, 'En Curso');
          }
        }
    }

    public function reservaUpdateEstadoQuery ($reserva,$estado){
      try{
        $sql = "UPDATE ".$this->tableName." SET req_status = :estado WHERE id_request = :id";
        $parameters["id"] = $reserva->getNroReserva();
        $parameters["estado"] = $estado;
        $this->connection = Connection::GetInstance();
        $this->connection->ExecuteNonQuery($sql, $parameters);
      }catch(\PDOException $ex){
        throw $ex;
      }
    }

    public function add($reserva){
      try{
        $sql = "INSERT INTO ".$this->tableName." (id_pet, id_owner, id_guardian, init_date, finish_date, req_status, calificacion, costoTotal, tipo, raza, cantidadDias) VALUES (:id_pet, :id_owner, :id_guardian, :init_date, :finish_date, :req_status, :calificacion, :costoTotal, :tipo, :raza, :cantidadDias)";
        $parameters["id_pet"] = $reserva->getMascota();
        $parameters["id_owner"] = $reserva->getDuenio();
        $parameters["id_guardian"] = $reserva->getGuardian();
        $parameters["init_date"] = $reserva->getFechaInicio();
        $parameters["finish_date"] = $reserva->getFechaFin();
        $parameters["req_status"] = "Pendiente";
        $parameters["calificacion"] = $reserva->getCalificacion();
        $parameters["costoTotal"] = $reserva->getCostoTotal();
        $parameters['tipo'] = $reserva->getTipo();
        $parameters['raza'] = $reserva->getRaza();
        $parameters["cantidadDias"] = $reserva->getCantidadDias();
        $this->connection = Connection::GetInstance();
        $this->connection->ExecuteNonQuery($sql, $parameters);
      }catch(\PDOException $ex){
        throw $ex;
      }
    }

    public function checkReservasdeGuardian($reservas, $reservaaAceptar){
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
        $this->aceptarReserva($nroReserva);
        return true;
      }

      $this->reservaUpdateEstadoQuery($reservaBuscada,"Rechazado");
      return false;
    }

    public function aceptarReserva($nroReserva){
      $reservas = $this->GetAllReservas();
      foreach ($reservas as $reserva){
        if ($reserva->getNroReserva() == $nroReserva){
          $reserva->setEstado('Confirmado');
          try {
            $sql = "UPDATE ".$this->tableName." SET req_status = :req_status WHERE id_request = " . $reserva->getNroReserva();
            $parameters["req_status"] = $reserva->getEstado();
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($sql, $parameters);
          } catch (\PDOException $ex) {
            throw $ex;
          }
        }
      }
    }

    public function todaslasReservasdelguardian($idGuardian){
      $array = array();
      foreach($this->list as $reserva){
        if($reserva->getGuardian() == $idGuardian){
          array_push($array,$reserva);
        }
      }
      return $array;
    }

    public function rechazarReservaGuardian($nroReserva){
      $reservas = $this->GetAllReservas();
      foreach($reservas as $reserva){
        if ($reserva->getNroReserva() == $nroReserva){
          $this->reservaUpdateEstadoQuery($reserva,"Rechazado");
        }
      }
    }

    public function cancelarcomoDuenio($nroReserva){
      $reservas = $this->GetAllReservas();
      foreach($reservas as $reserva){
      if ($reserva->getEstado() != "Confirmado" && $reserva->getEstado() != "Completo"){
          if ($reserva->getNroReserva() == $nroReserva){
            $this->borrarReserva($nroReserva);
            return true;
          }
       }
      }
      return false;
    }

    public function borrarReserva($nroReserva){
      try{
        $sql = "DELETE FROM ".$this->tableName." WHERE id_request =" . $nroReserva;
        $this->connection = Connection::GetInstance();
        $this->connection->ExecuteNonQuery($sql);
      }catch(\PDOException $ex){
        throw $ex;
      }
    }
    
    public function filtrarConfirmados($idGuardian){
      $reservas = $this->getReservasByGuardianID($idGuardian);
      $array = array();
      foreach($reservas as $reserva){
        if($reserva->getGuardian() == $idGuardian){
          if($reserva->getEstado() == "Confirmado"){
            array_push($array,$reserva);
          }
        }
      }
      return $array;
    }

    public function filtrarEnCurso($idGuardian){
      $reservas = $this->getReservasByGuardianID($idGuardian);
      $array = array();
      foreach($reservas as $reserva){
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

    public function cambiarEstado($nroReserva,$estado){
      try {
        $sql = "UPDATE ".$this->tableName." SET req_status = :estado WHERE id_request = :id";
        $parameters["id"] = $nroReserva;
        $parameters["estado"] = $estado;
        $this->connection = Connection::GetInstance();
        $this->connection->ExecuteNonQuery($sql, $parameters);
        return true;
      } catch (\PDOException $ex) {
        throw $ex;
      }
      return false;
    }

    public function setearCalificacion($nroReserva,$calificacion){
      $reservas = $this->GetAllReservas();
      foreach($reservas as $reserva){
        if ($reserva->getNroReserva() == $nroReserva){
          $reserva->setCalificacion($calificacion);
          try {
            $sql = "UPDATE ".$this->tableName." SET calificacion = :calificacion WHERE id_request = :nroReserva";
            $parameters["nroReserva"] = $nroReserva;
            $parameters["calificacion"] = $calificacion;
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($sql, $parameters);
          } catch (\PDOException $ex) {
            throw $ex;
          }
          return true;
        }
      }
      return false;
    }

    public function EqualsReserva ($reserva1,$reserva2){
      if ($reserva1->getFechaInicio() == $reserva2->getFechaInicio() && $reserva1->getFechaFin() == $reserva2->getFechaFin() && $reserva1->getTipo() == $reserva2->getTipo() && $reserva1->getRaza() == $reserva2->getRaza() && $reserva1->getGuardian() == $reserva2->getGuardian() && $reserva1->getDuenio() == $reserva2->getDuenio() && $reserva1->getMascota() == $reserva2->getMascota() && $reserva1->getCostoTotal() == $reserva2->getCostoTotal()){
        return true;
      }
      return false;
    }

    public function Exist($reservaComparar){
      $reservas = $this->GetAllReservas();
      foreach($reservas as $reserva){
        if ($reserva->getEstado() != "Rechazado"){
          if ($this->EqualsReserva($reserva,$reservaComparar)){
            return true;
          }
        }
      }
      return false;
  }
}



    









