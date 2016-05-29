<?php

namespace SocialDataPool\Domain\Service;

use SocialDataPool\Domain\Model\Tweet\Tweet;
use SocialDataPool\Domain\Repository\TweetWriterInterface;

final class TweetProcessor
{
    private $tweet_writer;

    public function __construct(TweetWriterInterface $a_tweet_writer)
    {
        $this->tweet_writer = $a_tweet_writer;
    }

    public function __invoke($all_tweets_to_process)
    {
        foreach ($all_tweets_to_process['statuses'] as $tweet_info)
        {
            $tweet_information_encoded = $this->encodeTweet($tweet_info);
            $a_new_tweet_to_persist    = new Tweet($tweet_information_encoded);
            $this->tweet_writer->persistNewTweet($a_new_tweet_to_persist);
        }
    }

    private function encodeTweet($tweet_info)
    {
        return json_encode($tweet_info);
    }
}
