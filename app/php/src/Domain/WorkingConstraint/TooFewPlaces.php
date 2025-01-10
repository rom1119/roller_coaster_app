<?php

declare(strict_types=1);

namespace App\Domain\WorkingConstraint;

use App\Domain\CoasterWorkingConstraint;
use App\Domain\Model\Coaster;

class TooFewPlaces implements CoasterWorkingConstraint
{

    public function isSatisfied(Coaster $coaster): bool
    {
        $wagonsPlaces = $coaster->wagonsTotalPlaces();

        return $coaster->getNumberOfCustomers() < $wagonsPlaces;
    }

    public function generateMsg(Coaster $coaster): string
    {
        $lackingPlaces = $coaster->wagonsTotalPlaces() - $coaster->getNumberOfCustomers();
        return 'Zbyt dużo wagonów w kolejce o ' . $lackingPlaces . ' miejsc w wagonach jest nieużywanych';
    }
}
