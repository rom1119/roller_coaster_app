<?php

namespace App\Domain;

use App\Domain\Model\Coaster;

interface DomainEvent 
{

    public function getName(): string;
    public function getCoaster(): Coaster;


}
