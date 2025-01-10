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
    private string $customersDailyAmount;
    
    public function __construct(
        Coaster $item, 
        string $statusArg, 
        
    ) {
        $availableWagons = $item->totalWagons();
        $totalWagons = $item->totalWagons();

        $this->name = '[Kolejka ' .  $item->getUuid() . ']';
        $this->workingHours = '1. Godziny działania: ' . $item->getHourFrom() . ' - ' . $item->getHourTo();
        $this->wagonAmount = '2. Liczba wagonów: ' . $availableWagons . '/' . $totalWagons;
        $this->staffAmount = '3. Dostępny personel: ' . $availableWagons . '/' . $totalWagons;
        $this->customersDailyAmount = '4. Klienci dziennie: ' . $item->getNumberOfCustomers();
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

        return implode(PHP_EOL, $res) . PHP_EOL;

    }


}
