<?php 
namespace DAO;
use Models\Payment as Payment;
use DAo\Connection as Connection;

class PaymentDAO
{
    private $connection;
    private $tableName = "Payments";

    public function add($payment)
    {
        try {
            $sql = "INSERT INTO " . $this->tableName . "(id_owner,id_request,paid,price,payment_method,payment_date) VALUES 
            (:id_owner,:id_request,:paid,:price,:payment_method,:payment_date)";
            $parameters['id_owner'] = $payment->getId_owner();
            $parameters['id_request'] = $payment->getId_request();
            $parameters['paid'] = $payment->getPaid();
            $parameters['price'] = $payment->getPrice();
            $parameters['payment_method'] = $payment->getPayment_method();
            $parameters['payment_date'] = $payment->getPayment_date();
            $this->connection = Connection::GetInstance();
            $result = $this->connection->ExecuteNonQuery($sql, $parameters);
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    public function GetAll()
    {
        $sql = "SELECT * FROM " . $this->tableName;
        $this->connection = Connection::GetInstance();
        $result = $this->connection->Execute($sql);
        $payments = array();
        foreach ($result as $row) {
            $payment = new Payment($row['id_owner'], $row['id_request'], $row['price']);
            $payment->setPaid($row['paid']);
            $payment->setPayment_method($row['payment_method']);
            $payment->setPayment_date($row['payment_date']);
            $payment->setId_payment($row['id_payment']);
            array_push($payments, $payment);
        }
        return $payments;
    }

    public function GetAllByOwner($id)
    {
        try {
            $array = array();
            $sql = "SELECT * FROM " . $this->tableName . " WHERE id_owner = " . $id;
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($sql);
            foreach ($result as $row) {
                $payment = new Payment($row['id_owner'], $row['id_request'], $row['price']);
                $payment->setPaid($row['paid']);
                $payment->setPayment_method($row['payment_method']);
                $payment->setPayment_date($row['payment_date']);
                $payment->setId_payment($row['id_payment']);
                array_push($array, $payment);
            }
            return $array;
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    public function setPayment($id,$finalPrice,$method)
    {
        try {
            $sql = "UPDATE " . $this->tableName . " SET paid = 1, payment_date = NOW(), price = :finalPrice, payment_method = :payment_method  WHERE (id_payment = :id ) ";
            $parameters['finalPrice'] = $finalPrice;
            $parameters['payment_method'] = $method;
            $parameters['id'] = $id;
            $this->connection = Connection::GetInstance();
            $result = $this->connection->ExecuteNonQuery($sql,$parameters);
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    public function findybyID($id)
    {
        try {
            $sql = "SELECT * FROM " . $this->tableName . " WHERE id_payment = " . $id;
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($sql);
            foreach ($result as $row) {
                $payment = new Payment($row['id_owner'], $row['id_request'], $row['price']);
                $payment->setPaid($row['paid']);
                $payment->setPayment_method($row['payment_method']);
                $payment->setPayment_date($row['payment_date']);
                $payment->setId_payment($row['id_payment']);
            }
            return $payment;
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    public function getStatusByRequestId($id)
    {
        try {
            $sql = "SELECT paid FROM " . $this->tableName . " WHERE id_request = " . $id;
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($sql);
            foreach ($result as $row) {
                $flag = $row['paid'];
            }
            return $flag;
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    public function updateFinalPrice ($id, $price)
    {
        try {
            $sql = "UPDATE " . $this->tableName . " SET price = :price WHERE id_payment = :id_payment";
            $parameters['price'] = $price;
            $parameters['id_payment'] = $id;
            $this->connection = Connection::GetInstance();
            $result = $this->connection->ExecuteNonQuery($sql, $parameters);
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }
}
?>