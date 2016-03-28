<?php

namespace SocialDataPool\Infrastructure\Repository\Twitter;

use SocialDataPool\Domain\Infrastructure\RedisClientInterface;

class TweetRepository
{
	private $redis_client;

	public function __construct(RedisClientInterface $a_redis_client)
	{
		$this->redis_client = $a_redis_client;
	}

	public function retrieveData($key)
	{
		return $this->redis_client->get($key);
	}
}
