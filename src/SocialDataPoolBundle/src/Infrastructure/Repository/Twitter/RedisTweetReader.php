<?php

namespace SocialDataPool\Infrastructure\Repository\Twitter;

use SocialDataPool\Domain\Infrastructure\RedisClientInterface;
use SocialDataPool\Domain\Repository\TweetReaderInterface;

class RedisTweetReader implements TweetReaderInterface
{
    const LIST_OF_TWEETS   = 'tweets-list';
    const UNIQUE_ID_PREFIX = 'tweet_';

    private $redis_client;

    public function __construct(RedisClientInterface $a_redis_client)
    {
        $this->redis_client = $a_redis_client;
    }

    public function getTweet()
    {
        return $this->redis_client->lpop(self::LIST_OF_TWEETS);
    }

    public function checkIfTweetIdHasBeenAlreadyProcessed($current_tweet_id)
    {
        if ($this->redis_client->exists(self::UNIQUE_ID_PREFIX . $current_tweet_id))
        {
            return true;
        }

        return false;
    }
}
