<?php

namespace SocialDataPool\Application\Service\Instagram;

use SocialDataPool\Application\Service\Core\ApplicationService;
use SocialDataPool\Domain\Service\Instagram\InstagramPostProcessor;
use SocialDataPool\Infrastructure\Api\Instagram\Client;

final class LookForInstagramPost implements ApplicationService
{
    /** @var Client */
    private $api_client;

    /** @var InstagramPostProcessor */
    private $instagram_post_processor;

    public function __construct(
        Client $twitter_api_client,
        InstagramPostProcessor $an_instagram_post_processor
    )
    {
        $this->api_client               = $twitter_api_client;
        $this->instagram_post_processor = $an_instagram_post_processor;
    }

    public function __invoke($a_request)
    {
        /** @var LookForInstagramPostRequest $a_request */
        $api_response = $this->api_client->getTagMedia($a_request->query());
        $this->instagram_post_processor->__invoke($api_response->data);
    }
}
