<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Model\Coaster;

interface CoasterWorkingConstraint
{

    public function isSatisfied(Coaster $coaster): bool;

    public function generateMsg(Coaster $coaster): string;
}
