<?php
// src/Entity/LoanCalculation.php

namespace App\Domain\Model;


abstract class BaseWagon
{
    protected $id;

    protected int $numberOfPlaces;

    protected float $speed;

    private BaseCoaster $coaster;

    
    public function __construct() {
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * Get the value of coaster
     */ 
    public function getCoaster()
    {
        return $this->coaster;
    }

    /**
     * Set the value of coaster
     *
     * @return  self
     */ 
    public function setCoaster($coaster)
    {
        $this->coaster = $coaster;

        return $this;
    }
}
