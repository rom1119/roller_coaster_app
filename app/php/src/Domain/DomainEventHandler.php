<?php

namespace App\Domain;

use App\Domain\Logger\NotificationLogger;

abstract class DomainEventHandler
{
    public function __construct(
        protected NotificationLogger $logger,
        protected CoasterPersister $coasterPersister,
        protected ConstraintChecker $constraintChecker 
        
    ) {
        
    }

    public abstract function getName(): string;
    public abstract function handle(DomainEvent $domainEvent): void;

    protected function printMsg(string $msg) {
        echo '[' . date('Y-m-d h:i:s') .']' . "\n" .$msg;
    }


}
