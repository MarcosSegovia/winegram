<?php

namespace SocialDataPool\Infrastructure\Repository\Twitter;

use SocialDataPool\Domain\Infrastructure\RedisClientInterface;
use SocialDataPool\Domain\Repository\TweetReaderInterface;

class RedisTweetReader implements TweetReaderInterface
{
    const LIST_OF_TWEETS = 'tweets-list';

    private $redis_client;

    public function __construct(RedisClientInterface $a_redis_client)
    {
        $this->redis_client = $a_redis_client;
    }

    public function getTweet()
    {
        return $this->redis_client->lpop(self::LIST_OF_TWEETS);
    }
}
