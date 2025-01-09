<?php

namespace App\Domain\Statistics;

use App\Domain\CoasterPersister;
use App\Domain\ConstraintChecker;
use App\Domain\DomainEvent;
use App\Domain\Model\Coaster;

class StatisticsFactory 
{
    
    public function __construct(private CoasterPersister $persister, private ConstraintChecker $constraintChecker )
    {
        
    }

    public function generateAll(): array
    {
        $totalItems = $this->persister->findAll();

        $result = [
            'time' => '[Godzina ' . date('h:i') .']',
            'items' => [],
        ];

        /** @var Coaster $item */
        foreach ($totalItems as $item) {
            $coasterStatus = $this->constraintChecker->check($item);
            $coasterStatus = implode(' | ', $coasterStatus);
            $item = new StatisticsItem($item, $coasterStatus);
            $result['items'][] = $item;
        }

        return $result;
    }
    public function generateByEvent(DomainEvent $domainEvent): ?string
    {
        return null;
    }


}
