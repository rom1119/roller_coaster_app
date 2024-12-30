<?php
// src/Entity/LoanCalculation.php

namespace App\Persister;


class InMemoryCoaster extends BaseCoaster
{

    public function setId(int $id) {
        $this->id = $id;
    }
   
}
