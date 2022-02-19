<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraint as Assert;

class CompanySearch {

    /**
     * @var float|null
     */
    private $lat;

    /**
     * @var float|null
     */
    private $lng;

    /**
     * @var integer|null
     */
    private $distance;

    /**
     * @var int|null
     */
    private $nameActivity;
    

    /**
     * Get the value of lat
     *
     * @return  float|null
     */ 
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Set the value of lat
     *
     * @param  float|null  $lat
     *
     * @return  self
     */ 
    public function setLat($lat)
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * Get the value of lng
     *
     * @return  float|null
     */ 
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * Set the value of lng
     *
     * @param  float|null  $lng
     *
     * @return  self
     */ 
    public function setLng($lng)
    {
        $this->lng = $lng;

        return $this;
    }

    /**
     * Get the value of distance
     *
     * @return  integer|null
     */ 
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * Set the value of distance
     *
     * @param  integer|null  $distance
     *
     * @return  self
     */ 
    public function setDistance($distance)
    {
        $this->distance = $distance;

        return $this;
    }


    /**
     * Get the value of nameActivity
     *
     * @return  int|null
     */ 
    public function getNameActivity()
    {
        return $this->nameActivity;
    }

    /**
     * Set the value of nameActivity
     *
     * @param  int|null  $nameActivity
     *
     * @return  self
     */ 
    public function setNameActivity($nameActivity)
    {
        $this->nameActivity = $nameActivity;

        return $this;
    }
}