<?php

namespace SocialDataPool\Domain\Model\Core;

final class Search
{
    /** @var integer */
    private $search_id;

    /** @var string */
    private $query_string;

    /** @var string */
    private $related_search_content;

    public function __construct(
        $a_raw_search_id,
        $a_raw_query_string,
        $a_related_search_content
    )
    {
        $this->search_id              = $a_raw_search_id;
        $this->query_string           = $a_raw_query_string;
        $this->related_search_content = $a_related_search_content;
    }

    public function searchId()
    {
        return $this->search_id;
    }

    public function queryString()
    {
        return $this->query_string;
    }

    public function relatedSearchContent()
    {
        return $this->related_search_content;
    }
}
