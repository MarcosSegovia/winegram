<?php

namespace SocialDataPool\Domain\Service;

use SocialDataPool\Domain\Model\Tweet\Tweet;
use SocialDataPool\Domain\Repository\TweetReaderInterface;
use SocialDataPool\Domain\Repository\TweetWriterInterface;

final class TweetProcessor
{
    private $tweet_writer;

    private $tweet_reader;

    public function __construct(
        TweetWriterInterface $a_tweet_writer,
        TweetReaderInterface $a_tweet_reader
    )
    {
        $this->tweet_writer = $a_tweet_writer;
        $this->tweet_reader = $a_tweet_reader;
    }

    public function __invoke($all_tweets_to_process)
    {
        foreach ($all_tweets_to_process['statuses'] as $tweet_info)
        {
            if ($this->tweet_reader->checkIfTweetIdHasBeenAlreadyProcessed($tweet_info['id']))
            {
                continue;
            }
            $tweet_information_encoded = $this->encodeTweet($tweet_info);
            $a_new_tweet_to_persist    = new Tweet($tweet_info['id'], $tweet_information_encoded);
            $this->tweet_writer->persistNewTweet($a_new_tweet_to_persist);
            $this->tweet_writer->tagTweetAsRead($a_new_tweet_to_persist);
        }
    }

    private function encodeTweet($tweet_info)
    {
        return json_encode($tweet_info);
    }
}
