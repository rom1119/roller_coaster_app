<?php

namespace App\Domain\Handler;

use App\Domain\DomainEvent;
use App\Domain\DomainEventHandler;
use App\Domain\Event\CoasterChange;
use App\Domain\Event\CoasterCreate;

class CoasterChangeHandler  extends DomainEventHandler
{

    public function getName(): string
    {
        return CoasterChange::class;
    }

    public function handle(DomainEvent $event): void
    {
        if (!($event instanceof CoasterChange)) {
            return;
        }
        $oldCoaster = $event->getCoaster();
        $newCoster = $this->coasterPersister->findCoaster($event->getCoaster()->getUuid());

        $msg = 'Dokonano zmian w kolejce ' . $oldCoaster->getUuid() . ": \n";
        if ($oldCoaster->getNumberOfStaff() != $newCoster->getNumberOfStaff()) {
            $msg .= 'zmieniono liczbę personelu z ' . $oldCoaster->getNumberOfStaff() . ' na ' . $newCoster->getNumberOfStaff();
        }
        
        if ($oldCoaster->getNumberOfCustomers() != $newCoster->getNumberOfCustomers()) {
            $msg .= 'zmieniono dzienną maksymalną ilość obsłużonych klientów przez kolejkę  z ' . $oldCoaster->getNumberOfCustomers() . ' na ' . $newCoster->getNumberOfCustomers();
        }
        
        if ($oldCoaster->getHourFrom() != $newCoster->getHourFrom()) {
            $msg .= 'zmieniono godzinę rozpoczęcia działania kolejki  z ' . $oldCoaster->getHourFrom() . ' na ' . $newCoster->getHourFrom();
        }
        
        if ($oldCoaster->getHourTo() != $newCoster->getHourTo()) {
            $msg .= 'zmieniono godzinę zakończenia działania kolejki  z ' . $oldCoaster->getHourTo() . ' na ' . $newCoster->getHourTo();
        }


        echo $msg;

        $this->logger->info($msg);
    }


}
