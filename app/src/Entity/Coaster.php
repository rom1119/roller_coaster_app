<?php
// src/Entity/LoanCalculation.php

namespace App\Entity;

use App\Domain\Model\BaseCoaster;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: "App\\Repository\\CoasterRepository")]
class Coaster extends BaseCoaster
{
   
}
