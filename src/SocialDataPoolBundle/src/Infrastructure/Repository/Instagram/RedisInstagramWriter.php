<?php

namespace SocialDataPool\Infrastructure\Repository\Instagram;

use SocialDataPool\Domain\Model\Instagram\Post;
use SocialDataPool\Domain\Repository\Instagram\InstagramWriterInterface;
use SocialDataPool\Infrastructure\Redis\RedisClient;

final class RedisInstagramWriter implements InstagramWriterInterface
{
    const SOCIAL_POOL         = 'social-list';
    const UNIQUE_ID_PREFIX    = 'instagram-post_';
    const ONE_WEEK_IN_SECONDS = 604800;

    private $redis_client;

    public function __construct(RedisClient $a_redis_client)
    {
        $this->redis_client = $a_redis_client;
    }

    public function persistNewPost(Post $a_new_post)
    {
        $this->redis_client->rpush(self::SOCIAL_POOL, [$a_new_post->associatedData()]);
    }

    public function tagPostAsRead(Post $a_new_post)
    {
        $this->redis_client->set(self::UNIQUE_ID_PREFIX . $a_new_post->id(),
            $a_new_post->id(),
            self::ONE_WEEK_IN_SECONDS
        );
    }
}
