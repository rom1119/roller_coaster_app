<?php

namespace App\Domain\Statistics;

use App\Domain\Model\Coaster;

class StatisticsItem 
{

    private string $name;
    private string $workingHours;
    private string $wagonAmount;
    private string $staffAmount;
    private string $status;
    
    public function __construct(
        Coaster $item, 
        string $statusArg, 
        
    ) {
        $availableWagons = $item->totalWagons();
        $totalWagons = $item->totalWagons();

        $this->name = '1. Kolejka' .  $item->getUuid();
        $this->workingHours = '2. Godziny działania: ' . $item->getHourFrom() . ' - ' . $item->getHourTo();
        $this->wagonAmount = '3. Liczba wagonów: ' . $availableWagons . '/' . $totalWagons;
        $this->staffAmount = '4. Dostępny personel: ' . $availableWagons . '/' . $totalWagons;
        if ($statusArg) {
            $this->status = '5. Problem: ' . $statusArg;
        } else {
            $this->status = '5. Status: OK';
        }

    }

    public function __toString()
    {
        $res = [];
        $res[] = $this->name;
        $res[] = $this->workingHours;
        $res[] = $this->wagonAmount;
        $res[] = $this->staffAmount;
        $res[] = $this->status;

        return implode(PHP_EOL, $res);

    }


}
