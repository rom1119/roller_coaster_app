<?php

namespace App\Domain;

use App\Domain\Model\Coaster;
use App\Domain\Model\CoasterID;

interface CoasterPersister 
{

    public function persist(Coaster $model): Coaster;
    public function findCoaster(CoasterID $uuid): ?Coaster;
    public function findAll(): array;


}
