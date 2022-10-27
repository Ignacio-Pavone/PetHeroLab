<?php 
namespace Models;


abstract class Usuario{
    private $email;
    private $password;
    private $fullname;
    private $dni;
    private $age;

    public function __construct($email, $fullname, $dni, $age, $password){
        $this->email = $email;
        $this->fullname = $fullname;
        $this->dni = $dni;
        $this->age = $age;
        $this->password = $password;
    }
    
    public function setEmail($email){
        $this->email=$email;
    }

    public function getEmail(){
        return $this->email;
    }

    public function setFullName($fullname){
        $this->fullname=$fullname;
    }

    public function getFullName(){
        return $this->fullname;
    }

    public function setDni($dni){
        $this->dni=$dni;
    }

    public function getDni(){
        return $this->dni;
    }

    public function setAge($age){
        $this->age=$age;
    }

    public function getAge(){
        return $this->age;
    }

    public function setPassword($password){
        $this->password=$password;
    }

    public function getPassword(){
        return $this->password;
    }
}

?>