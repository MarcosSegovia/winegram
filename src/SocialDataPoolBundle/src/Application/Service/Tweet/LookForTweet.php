<?php

namespace SocialDataPool\Application\Service\Tweet;

use MarcosSegovia\Twitter\TwitterApiClient;
use SocialDataPool\Application\Service\Core\ApplicationService;
use SocialDataPool\Domain\Model\Core\Search;
use SocialDataPool\Domain\Service\Twitter\TweetProcessor;
use SocialDataPool\Infrastructure\Api\Uvinum\UvinumApiClient;

final class LookForTweet implements ApplicationService
{
    /** @var TwitterApiClient */
    private $twitter_api_client;

    /** @var UvinumApiClient */
    private $uvinum_api_client;

    /** @var TweetProcessor */
    private $tweet_processor;

    public function __construct(
        TwitterApiClient $a_twitter_api_client,
        UvinumApiClient $an_uvinum_api_client,
        TweetProcessor $a_tweet_processor
    )
    {
        $this->twitter_api_client = $a_twitter_api_client;
        $this->uvinum_api_client  = $an_uvinum_api_client;
        $this->tweet_processor    = $a_tweet_processor;
    }

    public function __invoke($a_request)
    {
        /** @var LookForTweetRequest $a_request */
        $api_response = $this->twitter_api_client->getSearch($a_request->query(),
            $a_request->language(),
            $a_request->numberOfTweets()
        );
        
        $search_data = new Search($a_request->searchId(), $a_request->query(), $a_request->relatedSearchContent()
        );
        $this->tweet_processor->__invoke($api_response->json(), $search_data);
    }
}
