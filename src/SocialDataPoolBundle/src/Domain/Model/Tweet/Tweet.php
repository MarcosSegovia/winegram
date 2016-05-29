<?php

namespace SocialDataPool\Domain\Model\Tweet;

use SocialDataPool\Domain\Model\Tweet\Exception\InvalidDataProvided;
use SocialDataPool\Infrastructure\EventQueue\DomainEventRecorder;

final class Tweet
{
    /** @var mixed */
    private $associated_data;

    public function __construct($some_new_associated_data)
    {
        if(empty($some_new_associated_data) || null === $some_new_associated_data)
        {
            throw new InvalidDataProvided();
        }
        $this->associated_data = $some_new_associated_data;

        DomainEventRecorder::instance()->recordMessage(new TweetCreated());
    }

    public function associatedData()
    {
        return $this->associated_data;
    }
}
