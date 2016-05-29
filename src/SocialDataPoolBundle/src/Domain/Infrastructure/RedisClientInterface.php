<?php

namespace SocialDataPool\Domain\Infrastructure;

interface RedisClientInterface
{
    public function delete($a_key);

    public function exists($a_key);

    public function get($a_key);

    public function set(
        $a_key,
        $a_value,
        $a_ttl = null
    );

    public function zincrby(
        $key,
        $increment,
        $member
    );

    public function zadd(
        $key,
        array $key_value_members
    );

    public function rpush(
        $key,
        array $values
    );

    public function lpush(
        $key,
        array $values
    );

    public function lrange(
        $key,
        $start,
        $stop
    );

    public function lrem(
        $key,
        $count,
        $value
    );

    public function lpop($key);
}
