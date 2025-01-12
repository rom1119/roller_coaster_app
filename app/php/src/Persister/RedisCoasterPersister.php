<?php

namespace App\Persister;

use App\Domain\CoasterPersister;
use App\Domain\Model\Coaster;
use App\Domain\Model\CoasterID;
use App\RedisConnector;

class RedisCoasterPersister implements CoasterPersister
{
    private static $namespace = 'coaster_namespace';

    public function __construct(private RedisConnector $redis)
    {
    }

    public function persist(Coaster $model): Coaster
    {
        $this->redis->saveObject(self::$namespace, $model->getUuid(), $model);

        return $model;
    }

    public function findCoaster(CoasterID $uuid): ?Coaster
    {
        $model = $this->redis->getObjectByKey(self::$namespace, $uuid);
        if (!$model) {
            return null;
        }

        return $model;
    }

    public function findAll(): array
    {
        return $this->redis->getListByNamespace(self::$namespace);
    }
}
