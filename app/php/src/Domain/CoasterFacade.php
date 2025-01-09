<?php
declare(strict_types=1);

namespace App\Domain;

use App\Domain\CoasterPersister;
use App\Domain\Event\CoasterChange;
use App\Domain\Event\CoasterCreate;
use App\Domain\Event\CoasterStaffChange;
use App\Domain\Event\WagonCreate;
use App\Domain\Event\WagonDelete;
use App\Domain\Exception\GeneralRollerCoasterError;
use App\Domain\Model\Coaster;
use App\Domain\Model\CoasterID;
use App\Domain\Model\Wagon;
use App\Domain\Model\WagonID;
use App\Domain\MonitoringPubSub;

class CoasterFacade
{
   public function __construct(
      private CoasterPersister $coasterPersister,
      private MonitoringPubSub $monitoringPubSub,
   ) {
    
   }

   public function findCoaster(CoasterID $coasterUuid): ?Coaster
   {
      return $this->coasterPersister->findCoaster($coasterUuid);
   }

   public function updateCoaster(Coaster $model, CoasterID $coasterUuid): Coaster
   {
      $coaster = $this->coasterPersister->findCoaster($coasterUuid);
      if (!$coaster) {
         throw new GeneralRollerCoasterError('Not found coaster w ID = ' . $coasterUuid);
      }
      $event = new CoasterChange(clone $coaster);
      $this->monitoringPubSub->emitEvent($event);

      return $this->coasterPersister->persist($model);


   }
   public function addCoaster(Coaster $coaster) : Coaster 
   {
        $coaster->setUuid(CoasterID::create());

        $event = new CoasterCreate(clone $coaster);
        $this->monitoringPubSub->emitEvent($event);
        return $this->coasterPersister->persist($coaster);
   }

   public function deleteWagon(CoasterID $coasterUuid, WagonID $wagonId): Coaster
   {
      $coaster = $this->coasterPersister->findCoaster($coasterUuid);
      $wagon = $coaster->deleteWagon($wagonId);

      $this->coasterPersister->persist($coaster);

      $event = new WagonDelete(clone $coaster, clone $wagon);
      $this->monitoringPubSub->emitEvent($event);

      return $coaster;

   }
   public function addWagon(Wagon $wagon, CoasterID $coasterUuid) : Coaster {
      $coaster = $this->coasterPersister->findCoaster($coasterUuid);
      $wagon->setUuid(WagonID::create());
      $coaster->addWagon($wagon);

      $this->coasterPersister->persist($coaster);

      $event = new WagonCreate(clone $coaster, clone $wagon);
      $this->monitoringPubSub->emitEvent($event);
      return $coaster;
   }


}
