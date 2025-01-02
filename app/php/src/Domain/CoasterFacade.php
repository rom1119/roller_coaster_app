<?php

namespace App\Domain;

use App\Domain\CoasterPersister;
use App\Domain\Model\Coaster;
use Symfony\Component\Validator\Constraints\Uuid;

class CoasterFacade
{
   public function __construct(private CoasterPersister $coasterPersister) {
    
   }

   public function addCoaster(Coaster $coaster) : Coaster {
        $coaster->setUuid(uniqid());
        return $this->coasterPersister->persist($coaster);
   }


}
