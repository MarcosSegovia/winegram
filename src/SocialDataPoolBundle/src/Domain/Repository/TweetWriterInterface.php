<?php

namespace SocialDataPool\Domain\Repository;

use SocialDataPool\Domain\Model\Tweet\Tweet;

interface TweetWriterInterface
{
    public function persistNewTweet(Tweet $a_new_tweet);
    public function tagTweetAsRead(Tweet $a_new_tweet);
}
