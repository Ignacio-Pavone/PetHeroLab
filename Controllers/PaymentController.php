<?php namespace Controllers;
use DAO\PaymentDAO as paymentDAO;
use Models\Payment as Payment;
class PaymentController{
    private $paymentDAO;

    public function __construct(){
        $this->paymentDAO = new paymentDAO();
    }

    public function updatePayment(){}

    public function showPaymentForm($id){
        header("location: ".FRONT_ROOT."Auth/showPaymentForm/".$id);
    }
}
?>