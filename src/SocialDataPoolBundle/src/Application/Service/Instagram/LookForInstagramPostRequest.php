<?php

namespace SocialDataPool\Application\Service\Instagram;

final class LookForInstagramPostRequest
{
    /** @var string */
    private $query;

    /** @var integer */
    private $search_id;

    /** @var string */
    private $related_search_content;

    public function __construct(
        $a_query,
        $a_search_id,
        $a_related_search_content
    )
    {
        $this->query                  = $a_query;
        $this->search_id              = $a_search_id;
        $this->related_search_content = $a_related_search_content;
    }

    public function query()
    {
        return $this->query;
    }

    public function searchId()
    {
        return $this->search_id;
    }

    public function relatedSearchContent()
    {
        return $this->related_search_content;
    }
}
