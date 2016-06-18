<?php

namespace SocialDataPool\Application\Service\Uvinum;

use SocialDataPool\Infrastructure\Api\Uvinum\UvinumApiClient;

final class GetTopSellingProduct
{
    /** @var UvinumApiClient */
    private $api_client;

    public function __construct(UvinumApiClient $an_api_client)
    {
        $this->api_client = $an_api_client;
    }

    public function __invoke(GetTopSellingProductRequest $a_request)
    {
        $api_call_offset = (integer)floor(($a_request->offset() / UvinumApiClient::NUMBER_OF_PRODUCTS_PER_PAGE) + 1);
        $response        = $this->api_client->getTopSellingWines($a_request->wineType(), $api_call_offset);
        $json_response   = $response->json();

        $element_to_retrieve_from_product_list = (integer)$a_request->offset()
            % UvinumApiClient::NUMBER_OF_PRODUCTS_PER_PAGE;

        $array_product_info = [
            'product_id' => $json_response['products'][$element_to_retrieve_from_product_list]['id_product'],
            'name'       => $json_response['products'][$element_to_retrieve_from_product_list]['name']
        ];

        return $array_product_info;
    }
}
