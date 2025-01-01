<?php
// src/Entity/LoanCalculation.php

namespace App\Domain\Model;



abstract class BaseCoaster
{

    protected $id;

    protected int $numberOfStaff;

    protected int $numberOfCustomers;

    protected int $distance;
    
    protected int $hourFrom;
    
    protected int $hourTo;

    private Collection $wagons;

    
    public function __construct() {
        $this->wagons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
}
