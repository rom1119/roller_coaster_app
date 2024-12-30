<?php

declare(strict_types=1);

namespace App\Domain\Exception;


class GeneralRollerCoasterError extends \Exception implements RollerCoasterException
{

    public function __construct(string $msg) {
        parent::__construct($msg);
    }
}
