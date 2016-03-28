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

	public function set(
		$key,
		$value
	)
	{
		$command_set = $this->redis_client->createCommand('set');
		$command_set->setArgumentsArray(array($key, $value));

		return $this->redis_client->executeCommand($command_set);
	}

	public function get($key)
	{
		$command_get = $this->redis_client->createCommand('get');
		$command_get->setArgumentsArray(array($key));

		return $this->redis_client->executeCommand($command_get);
	}

}
