<?php

namespace SocialDataPool\Domain\Entity\Tweet;

final class TweetCreated
{
    private $id;

    public function __construct($an_id)
    {
        $this->id = $an_id;
    }

    public function id()
    {
        return $this->id;
    }
}
