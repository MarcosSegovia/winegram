<?php

namespace SocialDataPool\Infrastructure\Redis;

use Predis\Client;
use SocialDataPool\Domain\Infrastructure\RedisClientInterface;

class RedisClient implements RedisClientInterface
{
    private $redis_client;

    public function __construct(Client $a_redis_client)
    {
        $this->redis_client = $a_redis_client;
    }

    public function delete($a_key)
    {
        $this->redis_client->del([$a_key]);
    }

    public function exists($a_key)
    {
        return $this->redis_client->exists($a_key);
    }

    public function get($a_key)
    {
        return $this->redis_client->get($key);
    }

    public function set(
        $a_key,
        $a_value,
        $a_ttl = null
    )
    {
        $this->redis_client->set($a_key, $a_value);
        $this->redis_client->expire($a_key, $a_ttl);
    }

    public function zincrby($key, $increment, $member)
    {
        $this->redis_client->zincrby($key, $increment, $member);
    }
    
    public function zadd($key, array $key_value_members)
    {
        $this->redis_client->zadd($key, $key_value_members);
    }

    public function rpush($key, array $values)
    {
        $this->redis_client->rpush($key, $values);
    }

    public function lpush($key, array $values)
    {
        $this->redis_client->lpush($key, $values);
    }

    public function lrange($key, $start, $stop)
    {
        $this->redis_client->lrange($key, $start, $stop);
    }
    
    public function lrem($key, $count, $value)
    {
        $this->redis_client->lrem($key, $count, $value);
    }

    public function lpop($key)
    {
        $this->redis_client->lpop($key);
    }
}
