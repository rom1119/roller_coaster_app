<?php

namespace App\Domain;

use Psr\Log\LoggerInterface;

abstract class DomainEventHandler
{
    public function __construct(
        protected LoggerInterface $logger,
        protected CoasterPersister $coasterPersister,
        
    ) {
        
    }

    public abstract function getName(): string;
    public abstract function handle(DomainEvent $domainEvent): void;


}
