<?php

declare(strict_types=1);

namespace App\Domain\WorkingConstraint;

use App\Domain\CoasterWorkingConstraint;
use App\Domain\Model\Coaster;

class TooManyStaff implements CoasterWorkingConstraint
{

    public function isSatisfied(Coaster $coaster): bool
    {
        $minStaff = $coaster->minNeededStaff();

        return $coaster->getNumberOfStaff() > $minStaff;
    }

    public function generateMsg(Coaster $coaster): string
    {
        $overflowStaff = $coaster->getNumberOfStaff() - $coaster->minNeededStaff();
        return 'W kolejce jest o ' . $overflowStaff . ' zbyt dużo pracowników';
    }


}
