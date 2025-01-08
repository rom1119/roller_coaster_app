<?php

namespace App\Domain;

use App\Domain\Model\Coaster;

class Statistics 
{
    
    public function __construct(private CoasterPersister $persister, private ConstraintChecker $constraintChecker )
    {
        
    }

    public function generateTotal(): array
    {
        $totalItems = $this->persister->findAll();

        $result = [
            'time' => '[Godzina ' . date('h:i') .']',
            'items' => [],
        ];

        /** @var Coaster $item */
        foreach ($totalItems as $item) {
            $availableWagons = $item->totalWagons();
            $totalWagons = $item->totalWagons();
            $coasterStatus = $this->constraintChecker->check($item);
            $result['items'][] = [
                'name' => 'Kolejka' . $item->getUuid(),
                'working_hour' => 'Godziny działania: ' . $item->getHourFrom() . ' - ' . $item->getHourTo(),
                'amount_wagons' => 'Liczba wagonów: ' . $availableWagons . '/' . $totalWagons,
                'amount_staff' => 'Dostępny personel: ' . $availableWagons . '/' . $totalWagons,
                'status' => implode(' | ', $coasterStatus),
            ];
        }

        return $result;
    }
    public function generateByEvent(DomainEvent $domainEvent): string
    {
        return '';
    }


}
