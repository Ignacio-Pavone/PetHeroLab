<?php namespace DAO;

use Models\Request as Request;
use DAO\Connection as Connection;

class ReservaDAO
{
    private $connection;
    private $tableName = "Requests";

    public function getAll()
    {
        try {
            $sql = "SELECT * FROM " . $this->tableName;
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($sql);
            $requests = array();
            foreach ($result as $row) {
                $request = new Request($row["id_pet"], $row["id_owner"], $row["id_guardian"], $row["init_date"], $row["finish_date"], $row["final_price"], $row['type'], $row['breed'], $row["days_amount"]);
                $request->setIdRequest($row["id_request"]);
                $request->setReqstatus($row["req_status"]);
                $request->setScore($row["score"]);
                $this->autoReqStatus($request);
                array_push($requests, $request);
            }
            return $requests;
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    public function filterNotConfirmedRequestsByOwner($id){
        try{
            $array = array();
            $sql = "SELECT r.id_request, r.id_pet, r.id_owner, r.id_guardian, r.init_date, r.finish_date, r.req_status, r.score, 
            r.final_price, r.type, r.breed, r.days_amount
            FROM requests as r LEFT OUTER JOIN Payments as p ON p.id_request = r.id_request WHERE p.id_request IS null AND r.id_owner = " .$id. ";";
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($sql);
            foreach ($result as $row) {
                $request = new Request($row["id_pet"], $row["id_owner"], $row["id_guardian"], $row["init_date"], $row["finish_date"], $row["final_price"], $row['type'], $row['breed'], $row["days_amount"]);
                $request->setIdRequest($row["id_request"]);
                $request->setReqstatus($row["req_status"]);
                $request->setScore($row["score"]);
                $this->autoReqStatus($request);
                array_push($array, $request);
            }
            return $array;
            }catch (\PDOException $ex){
                throw $ex;
            }
    }

    public function filterPendingRequestsByOwner($id){
        try{
        $array = array();
        $sql = "SELECT r.id_request, r.id_pet, r.id_owner, r.id_guardian, r.init_date, r.finish_date, r.req_status, r.score, 
        r.final_price, r.type, r.breed, r.days_amount
        FROM requests as r INNER JOIN Payments as p ON p.id_request =  r.id_request WHERE p.paid = false AND r.id_owner = " . $id . ";";
        $this->connection = Connection::GetInstance();
        $result = $this->connection->Execute($sql);
        foreach ($result as $row) {
            $request = new Request($row["id_pet"], $row["id_owner"], $row["id_guardian"], $row["init_date"], $row["finish_date"], $row["final_price"], $row['type'], $row['breed'], $row["days_amount"]);
            $request->setIdRequest($row["id_request"]);
            $request->setReqstatus($row["req_status"]);
            $request->setScore($row["score"]);
            $this->autoReqStatus($request);
            array_push($array, $request);
        }
        return $array;
        }catch (\PDOException $ex){
            throw $ex;
        }
    }

    public function filterPaidRequestsByOwner($id){
        try{
            $array = array();
            $sql = "SELECT r.id_request, r.id_pet, r.id_owner, r.id_guardian, r.init_date, r.finish_date, r.req_status, r.score, 
            r.final_price, r.type, r.breed, r.days_amount
            FROM requests as r INNER JOIN Payments as p ON p.id_request =  r.id_request WHERE p.paid = true AND r.id_owner = " . $id . ";";
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($sql);
            foreach ($result as $row) {
                $request = new Request($row["id_pet"], $row["id_owner"], $row["id_guardian"], $row["init_date"], $row["finish_date"], $row["final_price"], $row['type'], $row['breed'], $row["days_amount"]);
                $request->setIdRequest($row["id_request"]);
                $request->setReqstatus($row["req_status"]);
                $request->setScore($row["score"]);
                $this->autoReqStatus($request);
                array_push($array, $request);
            }
            return $array;
            }catch (\PDOException $ex){
                throw $ex;
            }
    }

    public function findByRequestId($id_request)
    {
        try {
            $sql = "SELECT * FROM " . $this->tableName . " WHERE id_request = " . $id_request;
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($sql);
            foreach ($result as $row) {
                $request = new Request($row["id_pet"], $row["id_owner"], $row["id_guardian"], $row["init_date"], $row["finish_date"], $row["final_price"], $row['type'], $row['breed'], $row["days_amount"]);
                $request->setReqstatus($row["req_status"]);
                $request->setIdRequest($row["id_request"]);
                $request->setScore($row["score"]);
                $this->autoReqStatus($request);
                return $request;
            }
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    public function findByOwnerId($id)
    {
        try {
            $sql = "SELECT * FROM " . $this->tableName . " WHERE id_owner = " . $id;
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($sql);
            $requests = array();
            foreach ($result as $row) {
                $request = new Request($row["id_pet"], $row["id_owner"], $row["id_guardian"], $row["init_date"], $row["finish_date"], $row["final_price"], $row['type'], $row['breed'], $row["days_amount"]);
                $request->setReqstatus($row["req_status"]);
                $request->setIdRequest($row["id_request"]);
                $request->setScore($row["score"]);
                $this->autoReqStatus($request);
                array_push($requests, $request);
            }
            return $requests;
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    public function findByGuardianId($id)
    {
        try {
            $sql = "SELECT * FROM " . $this->tableName . " WHERE id_guardian = " . $id;
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($sql);
            $requests = array();
            foreach ($result as $row) {
                $request = new Request($row["id_pet"], $row["id_owner"], $row["id_guardian"], $row["init_date"], $row["finish_date"], $row["final_price"], $row['type'], $row['breed'], $row["days_amount"]);
                $request->setIdRequest($row["id_request"]);
                $request->setReqstatus($row["req_status"]);
                $request->setScore($row["score"]);
                $this->autoReqStatus($request);
                array_push($requests, $request);
            }
            return $requests;
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    public function countReviewsById($id_guardian)
    {
        $sql = "SELECT count(score) FROM " . $this->tableName . " WHERE id_guardian = " . $id_guardian . " and score != 0;";
        $this->connection = Connection::GetInstance();
        $count = 0;
        $result = $this->connection->Execute($sql);
        foreach ($result as $row) {
            $count = $row["count(score)"];
        }
        return $count;
    }

    public function sumReviewsById($id_guardian)
    {
        $sql = "SELECT sum(score) FROM " . $this->tableName . " WHERE id_guardian = " . $id_guardian . ";";
        $this->connection = Connection::GetInstance();
        $sum = 0;
        $result = $this->connection->Execute($sql);
        foreach ($result as $row) {
            $sum = $row["sum(score)"];
        }
        return $sum;
    }

    public function autoReqStatus($request)
    {
            if ($request->getReqStatus() == 'Confirmado' || $request->getReqStatus() == 'En Curso' && $this->isPay($request)) {
                if (($request->getFinishDate() < date('Y-m-d')) ) {
                    $this->updateStatusQuery($request->getIdRequest(), 'Completo');
                } elseif ($request->getInitDate() <= date('Y-m-d') && $request->getFinishDate() >= date('Y-m-d') ){
                    $this->updateStatusQuery($request->getIdRequest(), 'En Curso');
                }
            }else{
                if ($request->getInitDate() <= date('Y-m-d') && !$this->isPay($request)){
                    $this->updateStatusQuery($request->getIdRequest(), 'Rechazado');
                }
            }
    }

    public function isPay ($request){
        $sql = "SELECT * FROM payments WHERE id_request = " . $request->getIdRequest() . " AND paid = true;";
        $this->connection = Connection::GetInstance();
        $result = $this->connection->Execute($sql);
        if ($result){
            return true;
        }else{
            return false;
        }
    }

    public function updateStatusQuery($id_request, $req_status)
    {
        try {
            $sql = "UPDATE " . $this->tableName . " SET req_status = :req_status WHERE id_request = :id_request";
            $parameters["id_request"] = $id_request;
            $parameters["req_status"] = $req_status;
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($sql, $parameters);
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    public function add($request)
    {
        var_dump($request);
        try {
            $sql = "INSERT INTO " . $this->tableName . " (id_pet, id_owner, id_guardian, init_date, finish_date, req_status, score, final_price, type, breed, days_amount) VALUES (:id_pet, :id_owner, :id_guardian, :init_date, :finish_date, :req_status, :score, :final_price, :type, :breed, :days_amount)";
            $parameters["id_pet"] = $request->getIdPet();
            $parameters["id_owner"] = $request->getIdOwner();
            $parameters["id_guardian"] = $request->getIdGuardian();
            $parameters["init_date"] = $request->getInitDate();
            $parameters["finish_date"] = $request->getFinishDate();
            $parameters["req_status"] = "Pendiente";
            $parameters["score"] = $request->getScore();
            $parameters["final_price"] = $request->getFinalPrice();
            $parameters['type'] = $request->getType();
            $parameters['breed'] = $request->getBreed();
            $parameters["days_amount"] = $request->getDaysAmount();
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($sql, $parameters);
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    public function checkGuardianRequests($requests, $requestToAccept)
    {
        foreach ($requests as $request) {
            if ($request->getReqStatus() == 'En Curso' || $request->getReqStatus() == 'Confirmado') {
                if ($request->getType() == $requestToAccept->getType()) {
                    if ($request->getBreed() == $requestToAccept->getBreed()) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    public function acceptRequestAsGuardian($id_request, $id_guardian)
    {
        $searchedRequest = $this->findByRequestId($id_request);
        $guardiansRequests = $this->findByGuardianId($id_guardian);

        if (empty($guardiansRequests)) {
            $this->acceptRequest($id_request);
            return true;
        }

        if (count($this->filterConfirmed($id_guardian)) == 0 && count($this->filterInCurse($id_guardian)) == 0) {
            $this->acceptRequest($id_request);
            return true;
        }

        if ($this->checkGuardianRequests($guardiansRequests, $searchedRequest)) {
            $this->acceptRequest($id_request);
            return true;
        }

        $this->updateStatusQuery($searchedRequest->getIdRequest(), "Rechazado");
        return false;
    }

    public function acceptRequest($id_request)
    {
        $requests = $this->getAll();
        foreach ($requests as $request) {
            if ($request->getIdRequest() == $id_request) {
                $request->setReqStatus('Confirmado');
                try {
                    $sql = "UPDATE " . $this->tableName . " SET req_status = :req_status WHERE id_request = " . $request->getIdRequest();
                    $parameters["req_status"] = $request->getReqStatus();
                    $this->connection = Connection::GetInstance();
                    $this->connection->ExecuteNonQuery($sql, $parameters);
                } catch (\PDOException $ex) {
                    throw $ex;
                }
            }
        }
    }

    public function rejectRequestGuardian($id_request)
    {
        $reservas = $this->getAll();
        foreach ($reservas as $reserva) {
            if ($reserva->getIdRequest() == $id_request) {
                $this->updateStatusQuery($reserva->getIdRequest(), "Rechazado");
            }
        }
    }

    public function cancelAsOwner($id_request)
    {
        $reservas = $this->getAll();
        foreach ($reservas as $reserva) {
            if (!$this->isPay($reserva)) {
            if ($reserva->getReqStatus() != "Completo") {
                if ($reserva->getIdRequest() == $id_request) {
                    $this->deleteRequest($id_request);
                    return true;
                }
            }
        }
    }
        return false;
    }

    public function deleteRequest($id_request)
    {
        try {
            $sql = "DELETE FROM " . $this->tableName . " WHERE id_request =" . $id_request;
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($sql);
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    public function filterConfirmed ($idGuardian)
    {
        $reservas = $this->findByGuardianId($idGuardian);
        $array = array();
        foreach ($reservas as $reserva) {
            if ($reserva->getIdGuardian() == $idGuardian) {
                if ($reserva->getReqStatus() == "Confirmado") {
                    array_push($array, $reserva);
                }
            }
        }
        return $array;
    }

    public function filterInCurse ($idGuardian)
    {
        $reservas = $this->findByGuardianId($idGuardian);
        $array = array();
        foreach ($reservas as $reserva) {
            if ($reserva->getIdGuardian() == $idGuardian) {
                if ($reserva->getReqStatus() == "En Curso") {
                    array_push($array, $reserva);
                }
            }
        }
        return $array;
    }

    public function analyzeRequest($idGuardian, $type, $breed, $initDate)
    {
        $reservas = $this->findByGuardianId($idGuardian);
        if (empty($reservas)) {
            return true;
        }

        if (count($this->filterConfirmed($idGuardian)) == 0 && count($this->filterInCurse($idGuardian)) == 0) {
            return true;
        }

        foreach ($reservas as $reserva) {
            if ($reserva->getReqStatus() == "Confirmado" || $reserva->getReqStatus() == "En Curso") {
                    if ($type == $reserva->getType()) {
                        if ($breed == $reserva->getBreed()) {
                            return true;
                        }
                    }
            }
        }
        return false;
    }

    public function dateChecker ($dateone, $datetwo)
    {
        $date1 = strtotime($dateone);
        $date2 = strtotime($datetwo);
        if ($date1 <= $date2) {
            return false;
        }
        return true;
    }

    public function countDays ($initdate, $finishdate)
    {
        $date1 = strtotime($initdate);
        $date2 = strtotime($finishdate);
        $diff = abs($date2 - $date1);
        $years = floor($diff / (365 * 60 * 60 * 24));
        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
        if ($days == 0) {
            $days = 1;
        }
        return $days;
    }

    public function checkDataNotNull ($searchPet, $searchGuardian, $searchOwner)
    {
        if ($searchPet != null && $searchGuardian != null && $searchOwner != null)
            return true;
        else
            return false;
    }

    public function changeReqStatus ($id_request, $req_status)
    {
        try {
            $sql = "UPDATE " . $this->tableName . " SET req_status = :req_status WHERE id_request = :id";
            $parameters["id"] = $id_request;
            $parameters["req_status"] = $req_status;
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($sql, $parameters);
            return true;
        } catch (\PDOException $ex) {
            throw $ex;
        }
        return false;
    }

    public function setScore ($id_request, $score)
    {
        $reservas = $this->getAll();
        foreach ($reservas as $reserva) {
            if ($reserva->getIdRequest() == $id_request) {
                $reserva->setScore($score);
                try {
                    $sql = "UPDATE " . $this->tableName . " SET score = :score WHERE id_request = :id_request";
                    $parameters["id_request"] = $id_request;
                    $parameters["score"] = $score;
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

    public function EqualsRequest($request1, $request2)
    {
        if ($request1->getInitDate() == $request2->getInitDate() && $request1->getFinishDate() == $request2->getFinishDate() && $request1->getType() == $request2->getType() && $request1->getBreed() == $request2->getBreed() && $request1->getIdGuardian() == $request2->getIdGuardian() && $request1->getIdOwner() == $request2->getIdOwner() && $request1->getIdPet() == $request2->getIdPet() && $request1->getFinalPrice() == $request2->getFinalPrice()) {
            return true;
        }
        return false;
    }

    public function Exists($requestCompared)
    {
        $reservas = $this->getAll();
        foreach ($reservas as $reserva) {
            if ($reserva->getReqStatus() != "Rechazado") {
                if ($this->EqualsRequest($reserva, $requestCompared)) {
                    return true;
                }
            }
        }
        return false;
    }
}



    









