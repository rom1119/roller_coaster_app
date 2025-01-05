<?php
declare(strict_types=1);

namespace App\Domain;

use App\Domain\CoasterPersister;
use App\Domain\Model\Coaster;
use App\Domain\Model\Wagon;

class CoasterFacade
{
   public function __construct(private CoasterPersister $coasterPersister) {
    
   }

   public function findCoaster(string $coasterUuid): ?Coaster
   {
      return $this->coasterPersister->findCoaster($coasterUuid);

   }

   public function updateCoaster(Coaster $model,string $coasterUuid): Coaster
   {
      $coaster = $this->coasterPersister->findCoaster($coasterUuid);
      return $this->coasterPersister->persist($model);


   }
   public function addCoaster(Coaster $coaster) : Coaster 
   {
        $coaster->setUuid(uniqid());
        return $this->coasterPersister->persist($coaster);
   }

   public function deleteWagon($coasterUuid, string $wagonId): Coaster
   {
      $coaster = $this->coasterPersister->findCoaster($coasterUuid);
      $coaster->deleteWagon($wagonId);

      $this->coasterPersister->persist($coaster);

      return $coaster;

   }
   public function addWagon(Wagon $wagon, string $coasterUuid) : Coaster {
      $coaster = $this->coasterPersister->findCoaster($coasterUuid);
      $wagon->setUuid(uniqid());
      $coaster->addWagon($wagon);

      $this->coasterPersister->persist($coaster);
      return $coaster;
   }


}
