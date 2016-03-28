<?php

namespace SocialDataPool\Domain\Infrastructure;

interface RedisClientInterface
{
	public function set(
		$key,
		$value
	);

	public function get($key);
}
