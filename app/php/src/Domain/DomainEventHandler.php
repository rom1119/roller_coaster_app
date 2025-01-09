<?php

namespace App\Domain;

use App\Domain\Logger\NotificationLogger;
use Psr\Log\LoggerInterface;

abstract class DomainEventHandler
{
    public function __construct(
        protected NotificationLogger $logger,
        protected CoasterPersister $coasterPersister,
        
    ) {
        
    }

    public abstract function getName(): string;
    public abstract function handle(DomainEvent $domainEvent): void;

    protected function printMsg(string $msg) {
        echo '[Godzina ' . date('h:i') .']' . "\n" .$msg;

    }


}
