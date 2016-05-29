<?php

namespace SocialDataPool\Application\Service\Tweet;

use MarcosSegovia\Twitter\TwitterApiClient;
use SocialDataPool\Application\Service\Core\ApplicationService;
use SocialDataPool\Domain\Service\TweetProcessor;

final class LookForTweet implements ApplicationService
{
    /** @var TwitterApiClient */
    private $api_client;

    /** @var TweetProcessor */
    private $tweet_processor;

    public function __construct(
        TwitterApiClient $twitter_api_client,
        TweetProcessor $a_tweet_processor
    )
    {
        $this->api_client      = $twitter_api_client;
        $this->tweet_processor = $a_tweet_processor;
    }

    public function __invoke($a_request)
    {
        /** @var LookForTweetRequest $a_request */
        $api_response = $this->api_client->getSearch($a_request->query(),
            $a_request->language(),
            $a_request->numberOfTweets()
        );

        $this->processTweets($api_response->json());
    }

    private function processTweets($all_tweets_to_process)
    {
        $this->tweet_processor->__invoke($all_tweets_to_process);
    }
}
