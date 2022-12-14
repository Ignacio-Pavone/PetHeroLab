<?php 
namespace DAO;
use Models\Payment as Payment;
use DAo\Connection as Connection;

class PaymentDAO
{
    private $connection;
    private $tableName = "Payments";

    /**
     * @throws \Exception
     */
    public function add($payment)
    {
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
    }

    /**
     * @throws \Exception
     */
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

    /**
     * @throws \Exception
     */
    public function GetAllByOwner($id)
    {
        $array = array();
        $sql = "SELECT * FROM " . $this->tableName . " WHERE id_owner = :id_owner";
        $this->connection = Connection::GetInstance();
        $result = $this->connection->Execute($sql, array('id_owner' => $id));
        foreach ($result as $row) {
            $payment = new Payment($row['id_owner'], $row['id_request'], $row['price']);
            $payment->setPaid($row['paid']);
            $payment->setPayment_method($row['payment_method']);
            $payment->setPayment_date($row['payment_date']);
            $payment->setId_payment($row['id_payment']);
            array_push($array, $payment);
        }
        return $array;
    }

    /**
     * @throws \Exception
     */
    public function setPayment($id, $finalPrice, $method)
    {
        $sql = "UPDATE " . $this->tableName . " SET paid = 1, payment_date = NOW(), price = :finalPrice, payment_method = :payment_method  WHERE (id_payment = :id ) ";
        $parameters['finalPrice'] = $finalPrice;
        $parameters['payment_method'] = $method;
        $parameters['id'] = $id;
        $this->connection = Connection::GetInstance();
        $result = $this->connection->ExecuteNonQuery($sql,$parameters);
    }

    /**
     * @throws \Exception
     */
    public function findybyID($id_payment)
    {
        $sql = "SELECT * FROM " . $this->tableName . " WHERE id_payment = :id_payment";
        $this->connection = Connection::GetInstance();
        $result = $this->connection->Execute($sql, array('id_payment' => $id_payment));
        foreach ($result as $row) {
            $payment = new Payment($row['id_owner'], $row['id_request'], $row['price']);
            $payment->setPaid($row['paid']);
            $payment->setPayment_method($row['payment_method']);
            $payment->setPayment_date($row['payment_date']);
            $payment->setId_payment($row['id_payment']);
        }
        return $payment;
    }

    /**
     * @throws \Exception
     */
    public function getStatusByRequestId($id_request)
    {
        $sql = "SELECT paid FROM " . $this->tableName . " WHERE id_request = :id_request";
        $this->connection = Connection::GetInstance();
        $result = $this->connection->Execute($sql, array('id_request' => $id_request));
        foreach ($result as $row) {
            $flag = $row['paid'];
        }
        return $flag;
    }

    /**
     * @throws \Exception
     */
    public function updateFinalPrice ($id, $price)
    {
        $sql = "UPDATE " . $this->tableName . " SET price = :price WHERE id_payment = :id_payment";
        $parameters['price'] = $price;
        $parameters['id_payment'] = $id;
        $this->connection = Connection::GetInstance();
        $result = $this->connection->ExecuteNonQuery($sql, $parameters);
    }
}
?>