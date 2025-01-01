<?php
// src/Entity/LoanCalculation.php

namespace App\Persister;

use App\Domain\Model\BaseCoaster;

class InMemoryCoaster extends BaseCoaster
{

    public function setId(int $id) {
        $this->id = $id;
    }
   
}
