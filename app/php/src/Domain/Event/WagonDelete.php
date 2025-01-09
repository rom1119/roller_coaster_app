<?php

namespace App\Domain\Event;

use App\Domain\DomainEvent;
use App\Domain\Model\Coaster;
use App\Domain\Model\Wagon;

class WagonDelete  implements DomainEvent
{
    public function __construct(
        private Coaster $coaster, 
        private Wagon $wagonOld, 
    ) {
        
    }

    public function getCoaster() : Coaster {
        return $this->coaster;
    }
    
    public function getWagonOld() : Wagon {
        return $this->wagonOld;
    }


    public function __serialize()
    {
        return
            [
                $this->coaster,
                $this->wagonOld,
            ]
        ;
    }

    public function __unserialize($data)
    {
        $this->coaster = $data[0];
        $this->wagonOld = $data[1];
    }

    public function getName(): string
    {
        return WagonDelete::class;
    }

}
