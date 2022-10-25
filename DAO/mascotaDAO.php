<?php
namespace DAO;

use Models\Mascota;

class mascotaDAO {
    private $list = array();
    private $filename;
    private $id;

    public function __construct(){
      $this->filename = dirname(__DIR__)."/Data/mascotas.json";
    }

    public function findMascotaByID ($id){
        $this->LoadMascotaJson();
        foreach($this->list as $mascota){
            if($mascota->getIdMascota() == $id){
                return $mascota;
            }
        }
        return null;
    }

    public function GetAllMascotas(){
        $this->LoadMascotaJson();
        return $this->list;
    }

    private function LoadMascotaJson() {
        $this->list = array();
        if(file_exists($this->filename)) 
        {
            $jsonContent = file_get_contents($this->filename);
            $array = ($jsonContent) ? json_decode($jsonContent, true) : array();
            foreach($array as $item) 
            {
                $mascota = new Mascota($item['idDuenio'],$item['nombre'], $item['tipo'], $item['raza'], $item['tamanio'], $item['foto'], $item['planVacunacion'], $item['video']);
                $mascota->setIdMascota($item['idMascota']);
                array_push($this->list, $mascota);

                if ($item["idMascota"] > $this->id) {
                    $this->id = $item["idMascota"];
                }
            }
        }
    }

   public function saveMascota (){
    $arrayToEncode = array();

    foreach($this->list as $mascota){
        $valuesArray["idMascota"] = intval($mascota->getIdMascota());
        $valuesArray["idDuenio"] = intval($mascota->getidDuenio());
        $valuesArray["nombre"] = $mascota->getNombre();
        $valuesArray["tipo"] = $mascota->getTipo();
        $valuesArray["raza"] = $mascota->getRaza();
        $valuesArray["tamanio"] = $mascota->getTamanio();
        $valuesArray["foto"] = $mascota->getFoto();
        $valuesArray["planVacunacion"] = $mascota->getPlanVacunacion();
        $valuesArray["video"] = $mascota->getVideo();
        array_push($arrayToEncode, $valuesArray);
    }
    $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
    file_put_contents($this->filename, $jsonContent);
   }


   public function addMascota ($mascota){
    $this->LoadMascotaJson();
    $mascota->setIdMascota($this->id + 1);
    array_push($this->list, $mascota);
    $this->saveMascota();
   }

   public function deleteMascota ($id){
    $this->LoadMascotaJson();
    foreach($this->list as $mascota){
        if($mascota->getIdMascota() == $id){
            $key = array_search($mascota, $this->list);
            unset($this->list[$key]);
        }
    }
    $this->saveMascota();
   }


   public function updateMascota ($new){
    $this->LoadMascotaJson();
    foreach($this->list as $mascota){
        if($mascota->getIdMascota() == $new->getIdMascota()){
            $mascota->setIdDuenio($new->getIdDuenio());
            $mascota->setNombre($new->getNombre());
            $mascota->setTipo($new->getTipo());
            $mascota->setRaza($new->getRaza());
            $mascota->setTamanio($new->getTamanio());
            $mascota->setFoto($new->getFoto());
            $mascota->setPlanVacunacion($new->getPlanVacunacion());
            $mascota->setVideo($new->getVideo());
            $this->saveMascota();
            return true;
        }    
    }
    return false;
   }


   public function devolverMascotasporDuenio ($id){
    $this->LoadMascotaJson();
    $mascotas = array();
    foreach($this->list as $mascota){
        if($mascota->getIdDuenio() == $id){
            array_push($mascotas, $mascota);
        }
    }
    return $mascotas;
   }

   public function filtrarMascotasporTamanio($tamanio){
    $this->LoadMascotaJson();
    $mascotas = array();
    $todaslasmascotas = $this->GetAllMascotas();
    foreach ($todaslasmascotas as $mascota) {
        if (strtolower($mascota->getTamanio()) == strtolower($tamanio)){
            array_push($mascotas, $mascota);
        }
    }
    return $mascotas;
}

}