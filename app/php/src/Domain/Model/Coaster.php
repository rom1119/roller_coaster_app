<?php
declare(strict_types=1);

namespace App\Domain\Model;

use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

class Coaster
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

    public function __serialize()
    {
        return 
            [
                $this->uuid,
                $this->numberOfStaff,
                $this->numberOfCustomers,
                $this->distance,
                $this->hourFrom,
                $this->hourTo,
                $this->wagons,
            ]
        ;
    }

    public function __unserialize(array $data)
    {
        
        $this->uuid = $data[0];
        $this->numberOfStaff = $data[1];
        $this->numberOfCustomers = $data[2];
        $this->distance = $data[3];
        $this->hourFrom = $data[4];
        $this->hourTo = $data[5];
        $this->wagons = $data[6];
    }

    public function __toString()
    {
        $wagonsStr = '[';
        foreach($this->wagons as $wagon) {
            $wagonsStr .= $wagon . ", \n";
        }
        $wagonsStr .= ']';
        $str = "{ " .
        "uuid={$this->uuid},  numberOfStaff=$this->numberOfStaff, numberOfCustomers=$this->numberOfCustomers," .
        " distance=$this->distance, hourFrom=$this->hourFrom, hourTo=$this->hourTo, wagons=$wagonsStr" .
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
    public function getFirstWagon()
    {
        $firstKey = array_key_first($this->wagons);

        return $this->wagons[$firstKey];
    } 
   public function getWagons()
    {
        return $this->wagons;
    }


    public function availableWagons()
    {
        
    }

    public function wagonsTotalPlaces() : int 
    {
        $total = 0;
        array_map(function(Wagon $el) use (&$total) {
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
    
    public function deleteWagon(WagonID $wagonId): Wagon 
    {
        $wagon = $this->wagons[(string)$wagonId];
        unset($this->wagons[(string)$wagonId]);

        return $wagon;
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
     * Set the value of hourTo
     *
     * @return  self
     */ 
    public function setHourTo($hourTo)
    {
        $this->hourTo = $hourTo;

        return $this;
    }
}
