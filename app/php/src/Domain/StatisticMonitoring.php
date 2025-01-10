<?php
declare(strict_types=1);

namespace App\Domain;

use App\Domain\DomainEvent;

interface StatisticMonitoring
{
   public function runMonitoring();

   public function emitEvent(DomainEvent $event);


}
