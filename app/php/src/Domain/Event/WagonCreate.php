<?php

namespace App\Domain\Event;

use App\Domain\DomainEvent;
use App\Domain\Model\Coaster;
use App\Domain\Model\Wagon;

class WagonCreate implements DomainEvent
{
    public function __construct(
        private Coaster $coasterOld,
        private Wagon $wagon,
    ) {
    }

    public function getCoaster(): Coaster
    {
        return $this->coasterOld;
    }

    public function getWagon(): Wagon
    {
        return $this->wagon;
    }

    public function __serialize()
    {
        return
            [
                $this->coasterOld,
                $this->wagon,
            ]
        ;
    }

    public function __unserialize($data)
    {
        $this->coasterOld = $data[0];
        $this->wagon = $data[1];
    }

    public function getName(): string
    {
        return WagonCreate::class;
    }
}
