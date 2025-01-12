<?php

declare(strict_types=1);

namespace App\Domain;

class DomainEventListener
{
    /**
     * @param iterable DomainEventHandler[] $eventHandlers
     */
    public function __construct(private iterable $eventHandlers)
    {
    }

    public function handle(DomainEvent $event)
    {
        /** @var DomainEventHandler $eventHan */
        foreach ($this->eventHandlers as $eventHan) {
            if ($eventHan->getName() === $event->getName()) {
                $eventHan->handle($event);
                break;
            }
        }
    }
}
