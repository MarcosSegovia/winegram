<?php

namespace SocialDataPool\Application\Service\Uvinum;

use SocialDataPool\Infrastructure\Api\Uvinum\UvinumApiClient;

final class GetSpecificDo
{
    /** @var UvinumApiClient */
    private $api_client;

    public function __construct(UvinumApiClient $an_api_client)
    {
        $this->api_client = $an_api_client;
    }

    public function __invoke(GetSpecificDoRequest $a_request)
    {
        $all_dos = $this->api_client->getAllDos();

        if (array_key_exists($a_request->offset(), $all_dos))
        {

            return $all_dos[$a_request->offset()];
        }

        return false;
    }
}
