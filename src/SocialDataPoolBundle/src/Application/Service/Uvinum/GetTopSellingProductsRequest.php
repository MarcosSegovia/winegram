<?php

namespace SocialDataPool\Application\Service\Uvinum;

final class GetTopSellingProductsRequest
{
    /** @var string */
    private $wine_type;

    /** @var string */
    private $offset;

    public function __construct(
        $a_wine_type = 'tinto',
        $an_offset = '1'
    )
    {
        $this->wine_type = $a_wine_type;
        $this->offset    = $an_offset;
    }

    public function wineType()
    {
        return $this->wine_type;
    }

    public function offset()
    {
        return $this->offset;
    }
}
