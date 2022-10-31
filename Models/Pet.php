<?php
namespace Models;

class Pet
{
    private $id;
    private $id_owner;
    private $name;
    private $type;
    private $breed;
    private $pet_size;
    private $photo_url;
    private $vaccination_schedule;
    private $video_url;

    public function __construct($id_owner, $name, $type, $breed, $pet_size, $photo_url, $vaccination_schedule, $video_url)
    {
        $this->id_owner = $id_owner;
        $this->name = $name;
        $this->type = $type;
        $this->breed = $breed;
        $this->pet_size = $pet_size;
        $this->photo_url = $photo_url;
        $this->vaccination_schedule = $vaccination_schedule;
        $this->video_url = $video_url;
    }

    public function setidOwner($id_owner)
    {
        $this->id_owner = $id_owner;
    }

    public function getidOwner()
    {
        return $this->id_owner;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getBreed()
    {
        return $this->breed;
    }

    public function getPetsize()
    {
        return $this->pet_size;
    }

    public function getPhotoUrl()
    {
        return $this->photo_url;
    }

    public function getVaccinationschedule()
    {
        return $this->vaccination_schedule;
    }

    public function getVideoUrl()
    {
        return $this->video_url;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function setBreed($breed)
    {
        $this->breed = $breed;
    }

    public function setPetsize($pet_size)
    {
        $this->pet_size = $pet_size;
    }

    public function setPhotoUrl($photo_url)
    {
        $this->photo_url = $photo_url;
    }

    public function setVaccinationschedule($vaccination_schedule)
    {
        $this->vaccination_schedule = $vaccination_schedule;
    }

    public function setVideoUrl($video_url)
    {
        $this->video_url = $video_url;
    }

}

?>