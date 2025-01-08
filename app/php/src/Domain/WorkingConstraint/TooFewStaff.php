<?php

declare(strict_types=1);

namespace App\Domain\WorkingConstraint;

use App\Domain\CoasterWorkingConstraint;
use App\Domain\Model\Coaster;

class TooFewStaff implements CoasterWorkingConstraint
{

    public function isSatisfied(Coaster $coaster): bool
    {
        $minStaff = $coaster->minNeededStaff();

        return $coaster->getNumberOfStaff() < $minStaff;
    }

    public function generateMsg(Coaster $coaster): string
    {
        $lackingStaff = $coaster->minNeededStaff() - $coaster->getNumberOfStaff();
        return 'Brakuje ' . $lackingStaff . ' pracowników';
    }
}
