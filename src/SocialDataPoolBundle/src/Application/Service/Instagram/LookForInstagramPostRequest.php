<?php

namespace SocialDataPool\Application\Service\Instagram;

final class LookForInstagramPostRequest
{
    /** @var string */
    private $query;

    /** @var string */
    private $product_id;

    public function __construct(
        $a_query,
        $a_product_id = null
    )
    {
        $this->query      = $a_query;
        $this->product_id = $a_product_id;
    }

    public function query()
    {
        return $this->query;
    }

    public function productId()
    {
        return $this->product_id;
    }
}
