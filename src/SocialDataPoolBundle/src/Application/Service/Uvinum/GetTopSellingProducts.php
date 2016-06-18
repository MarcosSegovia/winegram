<?php

namespace SocialDataPool\Application\Service\Uvinum;

use SocialDataPool\Infrastructure\Api\Uvinum\UvinumApiClient;

final class GetTopSellingProducts
{
    /** @var UvinumApiClient */
    private $api_client;

    public function __construct(UvinumApiClient $an_api_client)
    {
        $this->api_client = $an_api_client;
    }

    public function __invoke(GetTopSellingProductsRequest $a_request)
    {
        $response      = $this->api_client->getTopSellingWines($a_request->wineType(), $a_request->offset());
        $json_response = $response->json();

        $array_of_products_to_retrieve = [];

        foreach ($json_response['products'] as $product)
        {
            $array_of_products_to_retrieve[] = [
                'product_id' => $product['id_product'],
                'name'       => $product['name']
            ];
        }
        
        return $array_of_products_to_retrieve;
    }
}
