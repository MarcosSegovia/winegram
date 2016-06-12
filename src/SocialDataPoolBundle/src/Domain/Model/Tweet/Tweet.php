<?php

namespace SocialDataPool\Domain\Model\Tweet;

use SocialDataPool\Domain\Model\Tweet\Exception\InvalidDataProvided;
use SocialDataPool\Infrastructure\EventQueue\DomainEventRecorder;

final class Tweet
{
    /** @var integer */
    private $id;
    
    /** @var mixed */
    private $associated_data;

    public function __construct($an_id, $some_new_associated_data)
    {
        if(empty($an_id) || null === $an_id)
        {
            throw new InvalidDataProvided();
        }
        if(empty($some_new_associated_data) || null === $some_new_associated_data)
        {
            throw new InvalidDataProvided();
        }
        $this->id = $an_id;
        $this->associated_data = $some_new_associated_data;

        DomainEventRecorder::instance()->recordMessage(new TweetCreated($an_id));
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
