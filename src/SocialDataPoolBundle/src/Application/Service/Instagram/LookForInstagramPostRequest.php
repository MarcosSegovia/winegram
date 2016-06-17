<?php

namespace SocialDataPool\Application\Service\Instagram;

final class LookForInstagramPostRequest
{
    /** @var string */
    private $query;

    public function __construct(
        $a_query
    )
    {
        $this->query = $a_query;
    }

    public function query()
    {
        return $this->query;
    }
}
