<?php
declare(strict_types=1);

namespace App\Domain\Model;

use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

class Coaster implements \Serializable
{
    protected CoasterID $uuid;

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

    public function __toString()
    {
        $wagonsStr = '[';
        foreach($this->wagons as $wagon) {
            $wagonsStr .= $wagon . ", \n";
        }
        $wagonsStr .= ']';
        $str = "
            uuid={$this->uuid}
            numberOfStaff=$this->numberOfStaff,
            numberOfCustomers=$this->numberOfCustomers,
            distance=$this->distance,
            hourFrom=$this->hourFrom,
            hourTo=$this->hourTo,
            wagons=$wagonsStr,
            ";

        return $str;
        // ];
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
     * Get the value of numberOfCustomers
     */ 
    public function getNumberOfCustomers()
    {
        return $this->numberOfCustomers;
    }

    /**
     * Get the value of distance
     */ 
    public function getDistance()
    {
        return $this->distance;
    }


    /**
     * Get the value of hourFrom
     */ 
    public function getHourFrom()
    {
        return $this->hourFrom;
    }


    /**
     * Get the value of hourTo
     */ 
    public function getHourTo()
    {
        return $this->hourTo;
    }

    /**
     * Get the value of wagons
     */ 
    public function getWagons()
    {
        return $this->wagons;
    }


    public function availableWagons() : int
    {
        
    }

    public function wagonsTotalPlaces() : int 
    {
        $total = 0;
        array_map(function(Wagon $el) use ($total) {
            $total += $el->getNumberOfPlaces();
        }, $this->wagons);

        return $total;
    }
    public function minNeededStaff() : int 
    {
        return 1 + (2 * $this->totalWagons());
    }

    public function totalWagons() : int
    {
        return count($this->wagons);
    }
    public function addWagon(Wagon $wagon) 
    {
        $this->wagons[(string)$wagon->getUuid()] = $wagon;
    }
    
    public function deleteWagon(WagonID $wagonId) 
    {
        unset($this->wagons[(string)$wagonId]);
    }

}
