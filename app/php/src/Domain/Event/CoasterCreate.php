<?php

namespace App\Domain\Event;

use App\Domain\DomainEvent;
use App\Domain\Model\Coaster;

class CoasterCreate  implements DomainEvent
{
    public function __construct(
        private Coaster $coasterOld, 
    ) {
        
    }

    public function getCoaster() : Coaster {
        return $this->coasterOld;
    }


    public function __serialize()
    {
        return serialize(
            [
                $this->coasterOld,
            ]
        );
    }

    public function __unserialize($dataStr)
    {
        list(
            $this->coasterOld,
        ) = unserialize($dataStr);

    }
    public function getName(): string
    {
        return CoasterCreate::class;
    }


}
