<?php

namespace SocialDataPool\Application\Service\Uvinum;

final class GetSpecificDoRequest
{
    private $offset;

    public function __construct($an_specific_do_offset)
    {
        $this->offset = $an_specific_do_offset;
    }

    public function offset()
    {
        return $this->offset;
    }
}
