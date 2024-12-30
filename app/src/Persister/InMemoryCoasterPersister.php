<?php

namespace App\Persister;

use App\Domain\CoasterPersister;

class InMemoryCoasterPersister implements CoasterPersister
{

    /**
     * @param array<BaseCoaster> $schedules
     */
    private array $data = [];

    /**
     * @param array<> 
     */
    public function persist(CoasterRequest $model): BaseCoaster
    {

        $Coaster = new InMemoryCoaster();
        $id = rand(1000, 9000000);
        $Coaster->setId($id);


        $this->data[$id] = $Coaster;

        return $Coaster;
        
    }

    public function excludeCoaster(BaseCoaster $baseCoaster): void
    {
        if (!($baseCoaster instanceof InMemoryCoaster)) {
            throw new \InvalidArgumentException();
        }
        
        $baseCoaster->setExcluded(true);

    }
    public function getById(int $id): BaseCoaster
    {
        return $this->data[$id];
    }

    public function getAllSchedules(string $filter = 'all', int $limit = 4): array
    {
        $sorted = $this->data;

        if ($filter == 'all') {
            return array_slice($sorted, 0, $limit);
        }

        $res = [];
        foreach ($sorted as $item) {
            if (count($res) == $limit) {
                break;
            }
            if (!$item->isExcluded()) {
                $res[] = $item;
            }
        }

        
        return $res;
    }

  
}
