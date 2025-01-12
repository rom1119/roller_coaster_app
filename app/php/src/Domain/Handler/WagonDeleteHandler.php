<?php

namespace App\Domain\Handler;

use App\Domain\DomainEvent;
use App\Domain\DomainEventHandler;
use App\Domain\Event\WagonDelete;

class WagonDeleteHandler extends DomainEventHandler
{
    public function getName(): string
    {
        return WagonDelete::class;
    }

    public function handle(DomainEvent $event): void
    {
        if (!($event instanceof WagonDelete)) {
            return;
        }

        $coster = $this->coasterPersister->findCoaster($event->getCoaster()->getUuid());
        $wagon = $event->getWagonOld();

        $msg = 'Usunięto wagon o parametrach prędkość='.$wagon->getSpeed().' oraz o pojemności='.$wagon->getNumberOfPlaces().' do kolejki'.$event->getCoaster();

        $constraintMessages = $this->constraintChecker->check($coster);
        $coasterStatus = implode(' , ', $constraintMessages);
        if ($coasterStatus) {
            $msg .= 'Problem: '.$coasterStatus;
        }
        $this->printMsg($msg);
        $this->logger->logEvent($msg);
    }
}
