<?php
declare(strict_types=1);

namespace App\Domain\Model;

use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;


#[JMS\ExclusionPolicy('all')]
class Wagon
{
    #[JMS\Expose()]
    protected WagonID $uuid;

    #[JMS\Expose()]
    #[JMS\SerializedName("ilosc_miejsc")]
    #[Assert\Positive]
    protected int $numberOfPlaces;
    
    #[JMS\Expose()]
    #[JMS\SerializedName("predkosc_wagonu")]
    #[Assert\Positive]
    protected float $speed;

    
    public function __construct() {
    }

    public function __serialize()
    {
        return 
            [
                $this->uuid,
                $this->numberOfPlaces,
                $this->speed,
            ]
        ;
    }

    public function __unserialize($data)
    {
        $this->uuid = $data[0];
        $this->numberOfPlaces = $data[1];
        $this->speed = $data[2];
    }

    public function __toString()
    {

        $str = "{ " .
        "uuid={$this->uuid}, numberOfPlaces=$this->numberOfPlaces, speed=$this->speed" .
        "}";

        return $str;

    }

    /**
     * Get the value of uuid
     */ 
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Set the value of uuid
     *
     * @return  self
     */ 
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * Get the value of numberOfPlaces
     */ 
    public function getNumberOfPlaces()
    {
        return $this->numberOfPlaces;
    }

    /**
     * Set the value of numberOfPlaces
     *
     * @return  self
     */ 
    public function setNumberOfPlaces($numberOfPlaces)
    {
        $this->numberOfPlaces = $numberOfPlaces;

        return $this;
    }

    /**
     * Get the value of speed
     */ 
    public function getSpeed()
    {
        return $this->speed;
    }

    /**
     * Set the value of speed
     *
     * @return  self
     */ 
    public function setSpeed($speed)
    {
        $this->speed = $speed;

        return $this;
    }

    
}
