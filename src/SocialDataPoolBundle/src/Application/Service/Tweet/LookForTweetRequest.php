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

    /** @var string */
    private $product_id;

    public function __construct(
        $a_query,
        $some_number_of_tweets = '1',
        $a_language = 'es',
        $a_product_id = null
    )
    {
        $this->query            = $a_query;
        $this->number_of_tweets = $some_number_of_tweets;
        $this->language         = $a_language;
        $this->product_id       = $a_product_id;
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
    
    public function productId()
    {
        return $this->product_id;
    }
}
