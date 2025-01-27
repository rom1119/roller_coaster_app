<?php

namespace App\Domain\Event;

use App\Domain\DomainEvent;
use App\Domain\Model\Coaster;

class CoasterCreate implements DomainEvent
{
    public function __construct(
        private Coaster $coasterOld,
    ) {
    }

    public function getCoaster(): Coaster
    {
        return $this->coasterOld;
    }

    public function __serialize()
    {
        return
            [
                $this->coasterOld,
            ]
        ;
    }

    public function __unserialize($data)
    {
        $this->coasterOld = $data[0];
    }

    public function getName(): string
    {
        return CoasterCreate::class;
    }
}
