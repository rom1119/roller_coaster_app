<?php
declare(strict_types=1);

namespace App\Domain\Model;

use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

class Coaster implements \Serializable
{

    protected string $uuid;

    #[JMS\SerializedName("liczba_personelu")]
    #[Assert\Positive]
    #[Assert\NotBlank()]
    protected ?int $numberOfStaff;
    
    #[JMS\SerializedName("liczba_klientow")]
    #[Assert\Positive]
    #[Assert\NotBlank()]
    protected ?int $numberOfCustomers;
    
    #[JMS\SerializedName("dl_trasy")]
    #[Assert\Positive]
    #[Assert\NotBlank()]
    protected ?int $distance;
    
    #[JMS\SerializedName("godziny_od")]
    #[Assert\Time(withSeconds:false)]
    #[Assert\NotBlank()]
    protected ?string $hourFrom;
    
    #[JMS\SerializedName("godziny_do")]
    #[Assert\Time(withSeconds:false)]
    #[Assert\NotBlank()]
    protected ?string $hourTo;
    
    #[JMS\SerializedName("wagony")]
    private array $wagons = [];

    
    public function __construct() {
        // $this->uuid = $uuid;
        $this->wagons = [];
    }

    public function serialize()
    {
        return serialize(
            [
                $this->uuid,
                $this->numberOfStaff,
                $this->numberOfCustomers,
                $this->distance,
                $this->hourFrom,
                $this->hourTo,
                $this->wagons,
            ]
        );
    }

    public function unserialize($dataStr)
    {
        list(
            $this->uuid,
            $this->numberOfStaff,
            $this->numberOfCustomers,
            $this->distance,
            $this->hourFrom,
            $this->hourTo,
            $this->wagons,
        ) = unserialize($dataStr);

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
     * Get the value of numberOfStaff
     */ 
    public function getNumberOfStaff()
    {
        return $this->numberOfStaff;
    }

    /**
     * Set the value of numberOfStaff
     *
     * @return  self
     */ 
    public function setNumberOfStaff($numberOfStaff)
    {
        $this->numberOfStaff = $numberOfStaff;

        return $this;
    }

    /**
     * Get the value of numberOfCustomers
     */ 
    public function getNumberOfCustomers()
    {
        return $this->numberOfCustomers;
    }

    /**
     * Set the value of numberOfCustomers
     *
     * @return  self
     */ 
    public function setNumberOfCustomers($numberOfCustomers)
    {
        $this->numberOfCustomers = $numberOfCustomers;

        return $this;
    }

    /**
     * Get the value of distance
     */ 
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * Set the value of distance
     *
     * @return  self
     */ 
    public function setDistance($distance)
    {
        $this->distance = $distance;

        return $this;
    }

    /**
     * Get the value of hourFrom
     */ 
    public function getHourFrom()
    {
        return $this->hourFrom;
    }

    /**
     * Set the value of hourFrom
     *
     * @return  self
     */ 
    public function setHourFrom($hourFrom)
    {
        $this->hourFrom = $hourFrom;

        return $this;
    }

    /**
     * Get the value of hourTo
     */ 
    public function getHourTo()
    {
        return $this->hourTo;
    }

    /**
     * Set the value of hourTo
     *
     * @return  self
     */ 
    public function setHourTo($hourTo)
    {
        $this->hourTo = $hourTo;

        return $this;
    }

    /**
     * Get the value of wagons
     */ 
    public function getWagons()
    {
        return $this->wagons;
    }

    /**
     * Set the value of wagons
     *
     * @return  self
     */ 
    public function setWagons($wagons)
    {
        $this->wagons = $wagons;
        
        return $this;
    }
    public function addWagon(Wagon $wagon) 
    {
        $this->wagons[$wagon->getUuid()] = $wagon;
    }
    
    public function deleteWagon(string $wagonId) 
    {
        unset($this->wagons[$wagonId]);
    }

}
