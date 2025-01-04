<?php

namespace App\Domain;

use App\Domain\Model\Coaster;

interface CoasterPersister 
{

    public function persist(Coaster $model): Coaster;
    public function findCoaster(string $uuid): Coaster;


}
