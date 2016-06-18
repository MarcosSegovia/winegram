<?php

namespace SocialDataPool\Infrastructure\Api\Uvinum;

use GuzzleHttp\Client;

final class UvinumApiClient
{
    const NUMBER_OF_PRODUCTS_PER_PAGE = 20;
    const BASE_UVINUM_API_URL         = 'https://api.vcst.net';

    private $http_client;

    private $api_key;

    public function __construct($an_api_key)
    {
        $this->http_client = new Client(['base_uri' => self::BASE_UVINUM_API_URL]);
        $this->api_key     = $an_api_key;
    }

    public function getTopSellingWines(
        $category_wine = 'tinto',
        $offset = 1
    )
    {
        $query_parameters = [
            'language' => 'es_ES',
            'instance' => 'uvinum',
            'api_key'  => $this->api_key
        ];

        return $this->http_client->get(self::BASE_UVINUM_API_URL . '/getProductsList:k:vinos:o:ventas:t:' .
            $category_wine . ':' . $offset . '?' . 'language=' . $query_parameters['language'] . '&instance=' .
            $query_parameters['instance'] . '&api_key=' . $query_parameters['api_key']
        );
    }

    public function getAllDos()
    {
        return [
            'Oporto',
            'Rioja',
            'Douro',
            'Ribera del Duero',
            'Penedés',
            'Priorat',
            'Valdepeñas',
            'Rueda',
            'Navarra',
            'La Mancha',
            'Rías Baixas',
            'Ribeiro',
            'Cariñena'
        ];
    }

}
