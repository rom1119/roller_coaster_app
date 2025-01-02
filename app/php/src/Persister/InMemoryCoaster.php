<?php

namespace App\Persister;

use App\Domain\Model\Coaster;

class InMemoryCoaster extends Coaster
{

    public function setId(int $id) {
        $this->id = $id;
    }
   
}
