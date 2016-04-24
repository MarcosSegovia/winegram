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
        $a_ttl
    );
}
