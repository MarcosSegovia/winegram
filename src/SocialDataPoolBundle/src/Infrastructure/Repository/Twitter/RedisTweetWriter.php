<?php

namespace SocialDataPool\Infrastructure\Repository\Twitter;

use SocialDataPool\Domain\Model\Tweet\Tweet;
use SocialDataPool\Domain\Infrastructure\RedisClientInterface;
use SocialDataPool\Domain\Repository\TweetWriterInterface;

final class RedisTweetWriter implements TweetWriterInterface
{
    const LIST_OF_TWEETS   = 'tweets-list';
    const UNIQUE_ID_PREFIX = 'tweet_';
    const ONE_WEEK_IN_SECONDS = 604800;

    private $redis_client;

    public function __construct(RedisClientInterface $a_redis_client)
    {
        $this->redis_client = $a_redis_client;
    }

    public function persistNewTweet(Tweet $a_new_tweet)
    {
        $this->redis_client->rpush(self::LIST_OF_TWEETS, [$a_new_tweet->associatedData()]);
    }

    public function tagTweetAsRead(Tweet $a_new_tweet)
    {
        $this->redis_client->set(self::UNIQUE_ID_PREFIX . $a_new_tweet->id(), $a_new_tweet->id(), self::ONE_WEEK_IN_SECONDS);
    }
}
