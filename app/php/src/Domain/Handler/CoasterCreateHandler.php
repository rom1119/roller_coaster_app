<?php

namespace App\Domain\Handler;

use App\Domain\DomainEvent;
use App\Domain\DomainEventHandler;
use App\Domain\Event\CoasterCreate;

class CoasterCreateHandler  extends DomainEventHandler
{

    public function getName(): string
    {
        return CoasterCreate::class;
    }

    public function handle(DomainEvent $event): void
    {
        if (!($event instanceof CoasterCreate)) {
            return;
        }

        $coster = $this->coasterPersister->findCoaster($event->getCoaster()->getUuid());

        $msg = 'Utworzono nową kolejkę ' . $event->getCoaster();
        echo $msg;

        $this->logger->info($msg);
    }


}
