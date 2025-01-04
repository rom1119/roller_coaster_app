<?php

namespace App\Domain;

use App\Domain\CoasterPersister;
use App\Domain\Model\Coaster;
use App\Domain\Model\Wagon;

class CoasterFacade
{
   public function __construct(private CoasterPersister $coasterPersister) {
    
   }

   public function addCoaster(Coaster $coaster) : Coaster {
        $coaster->setUuid(uniqid());
        return $this->coasterPersister->persist($coaster);
   }
   
   public function addWagon(Wagon $wagon, string $coasterUuid) : Coaster {
      $coaster = $this->coasterPersister->findCoaster($coasterUuid);
      $wagon->setUuid(uniqid());
      $coaster->addWagon($wagon);

      $this->coasterPersister->persist($coaster);
      return $coaster;
   }


}
