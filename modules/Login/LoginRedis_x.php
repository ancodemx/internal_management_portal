<?php

namespace modules\Login;


class LoginRedis
{
    protected $redis;

    public function __construct()
    {
        $this->redis = new \Redis();
        $this->redis->connect($_ENV['REDIS_HOST'], $_ENV['REDIS_PORT']);
        // echo "Connected to Redis server at $host:$port\n";
    }

    public function set(string $key, array $value, int $expiration = 3600)
    {
        return $this->redis->setex($key, $expiration, json_encode($value));
    }

    public function get($key)
    {
        return $this->redis->get($key);
    }

    public function delete($key)
    {
        return $this->redis->del($key);
    }

    public function exists($key)
    {
        return $this->redis->exists($key);
    }
}  