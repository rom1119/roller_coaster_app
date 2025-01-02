<?php

namespace App\Persister;

use App\Domain\CoasterPersister;
use App\Domain\Model\Coaster;
use App\RedisConnector;

class RedisCoasterPersister implements CoasterPersister
{
    private static $namespace = 'coaster';

    public function __construct(private RedisConnector $redis) {
        
    }

    public function persist(Coaster $model):  Coaster
    {
        $this->redis->saveObject(self::$namespace, $model->getUuid(), $model);
        return $model;
        
    }


    public function getAllSchedules(string $filter = 'all', int $limit = 4): array
    {
        return [];
        // return $this->em->getRepository(Coaster::class)->findByFilter($filter, $limit);
    }
}
