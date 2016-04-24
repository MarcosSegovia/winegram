<?php

namespace SocialDataPool\Domain\Entity\Tweet;

use SocialDataPool\Domain\Entity\Tweet\Exception\InvalidDataProvided;
use SocialDataPool\Domain\Entity\Tweet\Exception\InvalidIdProvided;

final class Tweet
{
    private $id;

    private $associated_data;

    public function __construct($a_new_id, $some_new_associated_data)
    {
        if(empty($a_new_id) || null === $a_new_id)
        {
            throw new InvalidIdProvided();
        }

        if(empty($some_new_associated_data) || null === $some_new_associated_data)
        {
            throw new InvalidDataProvided();
        }
        $this->id = $a_new_id;
        $this->associated_data = $some_new_associated_data;
    }

    public function id()
    {
        return $this->id;
    }

    public function associatedData()
    {
        return $this->associated_data;
    }
}
