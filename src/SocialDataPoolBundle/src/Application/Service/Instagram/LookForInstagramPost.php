<?php

namespace SocialDataPool\Application\Service\Instagram;

use SocialDataPool\Application\Service\Core\ApplicationService;
use SocialDataPool\Domain\Service\Instagram\InstagramPostProcessor;
use SocialDataPool\Infrastructure\Api\Instagram\InstagramApiClient;
use SocialDataPool\Infrastructure\Api\Uvinum\UvinumApiClient;

final class LookForInstagramPost implements ApplicationService
{
    /** @var InstagramApiClient */
    private $instagram_api_client;

    /** @var UvinumApiClient */
    private $uvinum_api_client;

    /** @var InstagramPostProcessor */
    private $instagram_post_processor;

    public function __construct(
        InstagramApiClient $an_instagram_api_client,
        UvinumApiClient $an_uvinum_api_client,
        InstagramPostProcessor $an_instagram_post_processor
    )
    {
        $this->instagram_api_client     = $an_instagram_api_client;
        $this->uvinum_api_client        = $an_uvinum_api_client;
        $this->instagram_post_processor = $an_instagram_post_processor;
    }

    public function __invoke($a_request)
    {
        /** @var LookForInstagramPostRequest $a_request */
        $api_response = $this->instagram_api_client->getTagMedia($a_request->query());
        $this->instagram_post_processor->__invoke($api_response->data);
    }
}
