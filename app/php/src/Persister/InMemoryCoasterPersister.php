<?php

namespace App\Persister;

use App\Domain\CoasterPersister;
use App\Domain\Model\BaseCoaster;
use App\Domain\Model\Coaster;
use App\Domain\Model\CoasterID;

class InMemoryCoasterPersister implements CoasterPersister
{
    private array $data = [];

    public function persist( Coaster $model): Coaster
    {
        $id = $model->getUuid()->getUuid();
        $this->data[$id] = $model;

        return $model;
    }

    public function findCoaster(CoasterID $uuid): ?Coaster
    {
        return $this->data[(string)$uuid];
    }

    public function findAll(): array
    {
        return $this->data;
    }

  
  
}
