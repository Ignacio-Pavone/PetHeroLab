<?php 
namespace Models;

class Payment
{
    private $id_payment;
    private $id_owner;
    private $id_request;
    private $paid;
    private $price;
    private $payment_method;
    private $payment_date;

    public function __construct($id_owner, $id_request, $price)
    {
        $this->id_owner = $id_owner;
        $this->id_request = $id_request;
        $this->paid = 0;
        $this->price = $price;
        $this->payment_method = null;
        $this->payment_date = null;
    }

    public function getPayment_date()
    {
        return $this->payment_date;
    }

    public function setPayment_date($payment_date)
    {
        $this->payment_date = $payment_date;
    }

    public function getPayment_method()
    {
        return $this->payment_method;
    }

    public function setPayment_method($payment_method)
    {
        $this->payment_method = $payment_method;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getId_request()
    {
        return $this->id_request;
    }

    public function setId_request($id_request)
    {
        $this->id_request = $id_request;
    }

    public function getId_owner()
    {
        return $this->id_owner;
    }

    public function setId_owner($id_owner)
    {
        $this->id_owner = $id_owner;

    }

    public function getId_payment()
    {
        return $this->id_payment;
    }

    public function setId_payment($id_payment)
    {
        $this->id_payment = $id_payment;
    }

    public function getPaid()
    {
        return $this->paid;
    }

    public function setPaid($paid)
    {
        $this->paid = $paid;

    }
}

?>