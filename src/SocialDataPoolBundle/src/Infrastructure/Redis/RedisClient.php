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
        $this->redis_client->exists($a_key);
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
}
