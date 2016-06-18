<?php

namespace SocialDataPool\Application\Service\Tweet;

final class LookForTweetRequest
{
    /** @var string */
    private $query;

    /** @var string */
    private $number_of_tweets;

    /** @var string */
    private $language;

    public function __construct(
        $a_query,
        $some_number_of_tweets = '1',
        $a_language = 'es'
    )
    {
        $this->query            = $a_query;
        $this->number_of_tweets = $some_number_of_tweets;
        $this->language         = $a_language;
    }

    public function query()
    {
        return $this->query;
    }

    public function numberOfTweets()
    {
        return $this->number_of_tweets;
    }

    public function language()
    {
        return $this->language;
    }
}
