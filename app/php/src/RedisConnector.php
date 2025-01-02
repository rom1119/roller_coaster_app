<?php

namespace App;



class RedisConnector
{

    private \Redis $redis;

    public function __construct(string $redisHost, string $redisPort, string $redisPass)
    {
        $this->redis = new \Redis();
        $this->redis->connect($redisHost, (int)$redisPort);
        $this->redis->auth($redisPass);
    }

    public function getObjectsByKey(string $key, callable $callback)
    {
        $response = $this->redis->get($key);

        if (!$response) {
            $dto = $callback();
            $this->redis->set($key, serialize($dto));

            return $dto;
        }

        return unserialize($response);
    }

    public function saveObject(string $namespace, string $key, object $dto): object 
    {
        $this->redis->set($namespace . ':' .$key, serialize($dto));

        return $dto;

    }

    public function clearCache(string $key)
    {
        $this->redis->delete($key);
    }
}
