<?php

namespace App\Domain;

use App\Domain\Model\BaseCoaster;

interface CoasterPersister 
{

    public function persist($model): BaseCoaster;


}
