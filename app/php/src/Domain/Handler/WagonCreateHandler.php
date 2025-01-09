<?php

namespace App\Domain\Handler;

use App\Domain\DomainEvent;
use App\Domain\DomainEventHandler;
use App\Domain\Event\WagonCreate;

class WagonCreateHandler  extends DomainEventHandler
{

    public function getName(): string
    {
        return WagonCreate::class;
    }

    public function handle(DomainEvent $event): void
    {
        if (!($event instanceof WagonCreate)) {
            return;
        }

        $coster = $this->coasterPersister->findCoaster($event->getCoaster()->getUuid());
        $wagon =$event ->getWagon();

        $msg = 'Dodanow nowy wagon o parametrach prędkość=' . $wagon->getSpeed() . ' oraz o pojemności=' . $wagon->getNumberOfPlaces() .  ' do kolejki' . $event->getCoaster();
        $this->printMsg($msg);

        $this->logger->logEvent($msg);
    }


}
