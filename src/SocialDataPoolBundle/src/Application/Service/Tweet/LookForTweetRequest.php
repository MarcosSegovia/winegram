<?php

namespace SocialDataPool\Application\Service\Tweet;

final class LookForTweetRequest
{
    /** @var string */
    private $query;

    /** @var integer */
    private $search_id;

    /** @var string */
    private $related_search_content;

    /** @var string */
    private $number_of_tweets;

    /** @var string */
    private $language;

    public function __construct(
        $a_query,
        $a_search_id,
        $a_related_search_content,
        $some_number_of_tweets = '1',
        $a_language = 'es'

    )
    {
        $this->query                  = $a_query;
        $this->search_id              = $a_search_id;
        $this->related_search_content = $a_related_search_content;
        $this->number_of_tweets       = $some_number_of_tweets;
        $this->language               = $a_language;
    }

    public function query()
    {
        return $this->query;
    }

    public function searchId()
    {
        return $this->search_id;
    }

    public function relatedSearchContent()
    {
        return $this->related_search_content;
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
