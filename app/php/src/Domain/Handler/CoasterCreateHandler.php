<?php

namespace App\Domain\Handler;

use App\Domain\DomainEvent;
use App\Domain\DomainEventHandler;
use App\Domain\Event\CoasterCreate;

class CoasterCreateHandler extends DomainEventHandler
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

        $msg = 'Utworzono nową kolejkę '.$event->getCoaster();
        $constraintMessages = $this->constraintChecker->check($coster);
        $coasterStatus = implode(' , ', $constraintMessages);
        if ($coasterStatus) {
            $msg .= 'Problem: '.$coasterStatus;
        }
        $this->printMsg($msg);

        $this->logger->logEvent($msg);
    }
}
