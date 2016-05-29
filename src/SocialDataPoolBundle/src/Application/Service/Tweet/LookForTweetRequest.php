<?php

namespace SocialDataPool\Application\Service\Tweet;

final class LookForTweetRequest
{
    /** @var string */
    private $query;

    /** @var string */
    private $language;

    /** @var string */
    private $number_of_tweets;

    public function __construct(
        $a_query,
        $a_language = 'es',
        $some_number_of_tweets = '1'
    )
    {
        $this->query            = $a_query;
        $this->language         = $a_language;
        $this->number_of_tweets = $some_number_of_tweets;
    }

    public function query()
    {
        return $this->query;
    }

    public function language()
    {
        return $this->language;
    }

    public function numberOfTweets()
    {
        return $this->number_of_tweets;
    }
}
