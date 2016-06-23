<?php

namespace SocialDataPool\Domain\Service\Twitter;

use SocialDataPool\Domain\Model\Core\Search;
use SocialDataPool\Domain\Model\Tweet\Tweet;
use SocialDataPool\Domain\Repository\Twitter\TweetReaderInterface;
use SocialDataPool\Domain\Repository\Twitter\TweetWriterInterface;
use SocialDataPool\Infrastructure\Service\Adapter\Twitter\JsonAdapter;

final class TweetProcessor
{
    /** @var TweetWriterInterface */
    private $tweet_writer;

    /** @var TweetReaderInterface */
    private $tweet_reader;

    /** @var JsonAdapter */
    private $json_twitter_adapter;

    public function __construct(
        TweetWriterInterface $a_tweet_writer,
        TweetReaderInterface $a_tweet_reader,
        JsonAdapter $a_json_twitter_adapter
    )
    {
        $this->tweet_writer = $a_tweet_writer;
        $this->tweet_reader = $a_tweet_reader;
        $this->json_twitter_adapter = $a_json_twitter_adapter;
    }

    public function __invoke(
        $all_raw_tweets_to_process,
        Search $a_search
    )
    {
        foreach ($all_raw_tweets_to_process['statuses'] as $tweet_raw_info)
        {
            if ($this->tweet_reader->checkIfTweetIdHasBeenAlreadyProcessed($tweet_raw_info['id_str']))
            {
                continue;
            }
            $tweet_information_encoded = $this->json_twitter_adapter->__invoke($tweet_raw_info, $a_search);
            $a_new_tweet_to_persist    = new Tweet($tweet_raw_info['id_str'], $tweet_information_encoded);
            $this->tweet_writer->persistNewTweet($a_new_tweet_to_persist);
            $this->tweet_writer->tagTweetAsRead($a_new_tweet_to_persist);
        }
    }
}
