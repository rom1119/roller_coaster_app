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

    public function getObjectByKey(string $namespace, string $key)
    {
        $response = $this->redis->get($namespace . ':' . $key);

        return unserialize($response);
    }

    public function cacheObjectByKey(string $key, callable $callback)
    {
        $response = $this->redis->get($key);

        if (!$response) {
            $dto = $callback();
            $this->redis->set($key, serialize($dto));

            return $dto;
        }

        return unserialize($response);
    }

    public function getListByNamespace(string $namespace): array
    {
        $keys = $this->redis->keys($namespace . ':*');
        $result = [];
        foreach($keys as $key) {
            $result[] = unserialize($this->redis->get($key));
        }
        return $result;
    }

    public function saveObject(string $namespace, string $key, object $dto): object 
    {
        $this->redis->set($namespace . ':' .$key, serialize($dto));

        return $dto;

    }
    public function setKey(string $namespace, string $key, object $val): object
    {
        $this->redis->set($namespace . ':' . $key, $val);

        return $val;

    }
    public function publishMsg(string $key, $val): object 
    {
        $this->redis->publish($key,  serialize($val));

        return $val;

    }

    public function clearCache(string $key)
    {
        $this->redis->delete($key);
    }
}
