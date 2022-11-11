<?php 
namespace DAO;
use Models\Request as Request;
use DAO\Connection as Connection;

class RequestDAO
{
    private $connection;
    private $tableName = "Requests";

    /**
     * @throws \Exception
     */
    public function getAll()
    {
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
    }

    /**
     * @throws \Exception
     */
    public function findByRequestId($id_request)
    {
        $sql = "SELECT * FROM " . $this->tableName . " WHERE id_request = :id_request";
        $this->connection = Connection::GetInstance();
        $result = $this->connection->Execute($sql, array("id_request" => $id_request));
        foreach ($result as $row) {
            $request = new Request($row["id_pet"], $row["id_owner"], $row["id_guardian"], $row["init_date"], $row["finish_date"], $row["final_price"], $row['type'], $row['breed'], $row["days_amount"]);
            $request->setReqstatus($row["req_status"]);
            $request->setIdRequest($row["id_request"]);
            $request->setScore($row["score"]);
            $this->autoReqStatus($request);
            return $request;
        }
    }

    /**
     * @throws \Exception
     */
    public function findByOwnerId($id)
    {
        $sql = "SELECT * FROM " . $this->tableName . " WHERE id_owner = :id_owner";
        $this->connection = Connection::GetInstance();
        $result = $this->connection->Execute($sql, array("id_owner" => $id));
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
    }

    /**
     * @throws \Exception
     */
    public function findByGuardianId($id_guardian)
    {
        $sql = "SELECT * FROM " . $this->tableName . " WHERE id_guardian = :id_guardian";
        $this->connection = Connection::GetInstance();
        $result = $this->connection->Execute($sql, array("id_guardian" => $id_guardian));
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
    }

    /**
     * @throws \Exception
     */
    public function countReviewsById($id_guardian)
    {
        $sql = "SELECT count(score) FROM " . $this->tableName . " WHERE id_guardian = :id_guardian and score != 0;";
        $this->connection = Connection::GetInstance();
        $count = 0;
        $result = $this->connection->Execute($sql, array("id_guardian" => $id_guardian));
        foreach ($result as $row) {
            $count = $row["count(score)"];
        }
        return $count;
    }

    /**
     * @throws \Exception
     */
    public function sumReviewsById($id_guardian)
    {
        $sql = "SELECT sum(score) FROM " . $this->tableName . " WHERE id_guardian = :id_guardian";
        $this->connection = Connection::GetInstance();
        $sum = 0;
        $result = $this->connection->Execute($sql, array("id_guardian" => $id_guardian));
        foreach ($result as $row) {
            $sum = $row["sum(score)"];
        }
        return $sum;
    }

    /**
     * @throws \Exception
     */
    public function autoReqStatus($request)
    {
        if ($request->getReqStatus() == 'Confirmado' || $request->getReqStatus() == 'En Curso' && $this->isPay($request)) {
            if (($request->getFinishDate() < date('Y-m-d'))) {
                $this->updateStatusQuery($request->getIdRequest(), 'Completo');
            } elseif ($request->getInitDate() <= date('Y-m-d') && $request->getFinishDate() >= date('Y-m-d')) {
                $this->updateStatusQuery($request->getIdRequest(), 'En Curso');
            }
        } else {
            if ($request->getInitDate() <= date('Y-m-d') && !$this->isPay($request)) {
                $this->updateStatusQuery($request->getIdRequest(), 'Rechazado');
            }
        }
    }

    /**
     * @throws \Exception
     */
    public function isPay($request)
    {
        $id = $request->getIdRequest();
        $sql = "SELECT * FROM payments WHERE id_request = :id AND paid = true;";
        $this->connection = Connection::GetInstance();
        $result = $this->connection->Execute($sql, array("id" => $id));
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @throws \Exception
     */
    public function updateStatusQuery($id_request, $req_status)
    {
        $sql = "UPDATE " . $this->tableName . " SET req_status = :req_status WHERE id_request = :id_request";
        $parameters["id_request"] = $id_request;
        $parameters["req_status"] = $req_status;
        $this->connection = Connection::GetInstance();
        $this->connection->ExecuteNonQuery($sql, $parameters);
    }

    /**
     * @throws \Exception
     */
    public function add($request)
    {
        var_dump($request);
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

    /**
     * @throws \Exception
     */
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

    /**
     * @throws \Exception
     */
    public function acceptRequest($id_request)
    {
        $requests = $this->getAll();
        foreach ($requests as $request) {
            if ($request->getIdRequest() == $id_request) {
                $request->setReqStatus('Confirmado');
                $sql = "UPDATE " . $this->tableName . " SET req_status = :req_status WHERE id_request = :id_request";
                $parameters["id_request"] = $request->getIdRequest();
                $parameters["req_status"] = $request->getReqStatus();
                $this->connection = Connection::GetInstance();
                $this->connection->ExecuteNonQuery($sql, $parameters);
            }
        }
    }

    /**
     * @throws \Exception
     */
    public function rejectRequestGuardian($id_request)
    {
        $reservas = $this->getAll();
        foreach ($reservas as $reserva) {
            if ($reserva->getIdRequest() == $id_request) {
                $this->updateStatusQuery($reserva->getIdRequest(), "Rechazado");
            }
        }
    }

    /**
     * @throws \Exception
     */
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

    /**
     * @throws \Exception
     */
    public function deleteRequest($id_request)
    {
        $sql = "DELETE FROM " . $this->tableName . " WHERE id_request = :id_request";
        $this->connection = Connection::GetInstance();
        $this->connection->ExecuteNonQuery($sql, array("id_request" => $id_request));
    }

    /**
     * @throws \Exception
     */
    public function filterConfirmed($idGuardian)
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

    /**
     * @throws \Exception
     */
    public function filterInCurse($idGuardian)
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

    /**
     * @throws \Exception
     */
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

    public function dateChecker($dateone, $datetwo)
    {
        $date1 = strtotime($dateone);
        $date2 = strtotime($datetwo);
        if ($date1 <= $date2) {
            return false;
        }
        return true;
    }

    public function countDays($initdate, $finishdate)
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

    public function checkDataNotNull($searchPet, $searchGuardian, $searchOwner)
    {
        if ($searchPet != null && $searchGuardian != null && $searchOwner != null)
            return true;
        else
            return false;
    }

    /**
     * @throws \Exception
     */
    public function changeReqStatus($id_request, $req_status)
    {
        $sql = "UPDATE " . $this->tableName . " SET req_status = :req_status WHERE id_request = :id";
        $parameters["id"] = $id_request;
        $parameters["req_status"] = $req_status;
        $this->connection = Connection::GetInstance();
        $this->connection->ExecuteNonQuery($sql, $parameters);
    }

    /**
     * @throws \Exception
     */
    public function setScore($id_request, $score)
    {
        $reservas = $this->getAll();
        foreach ($reservas as $reserva) {
            if ($reserva->getIdRequest() == $id_request) {
                $reserva->setScore($score);
                $sql = "UPDATE " . $this->tableName . " SET score = :score WHERE id_request = :id_request";
                $parameters["id_request"] = $id_request;
                $parameters["score"] = $score;
                $this->connection = Connection::GetInstance();
                $this->connection->ExecuteNonQuery($sql, $parameters);
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

    /**
     * @throws \Exception
     */
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

    /**
     * @throws \Exception
     */
    public function updateFinalPrice ($id_request, $final_price)
    {
        $sql = "UPDATE " . $this->tableName . " SET final_price = :final_price WHERE id_request = :id_request";
        $parameters["id_request"] = $id_request;
        $parameters["final_price"] = $final_price;
        $this->connection = Connection::GetInstance();
        $this->connection->ExecuteNonQuery($sql, $parameters);
    }

    /**
     * @throws \Exception
     */
    public function checkRequestsPet($idPet){
        $sql = "SELECT id_pet FROM " . $this->tableName . " WHERE id_pet = :id_pet";
        $this->connection = Connection::GetInstance();
        $result = $this->connection->Execute($sql, array("id_pet" => $idPet));
        if ($result) return true;
        else return false;
    }
}
?>



    









