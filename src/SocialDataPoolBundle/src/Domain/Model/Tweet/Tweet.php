<?php

namespace SocialDataPool\Domain\Model\Tweet;

use SocialDataPool\Domain\Model\Tweet\Exception\InvalidTweetDataProvided;
use SocialDataPool\Infrastructure\EventQueue\DomainEventRecorder;

final class Tweet
{
    const TWITTER_TYPE = 'tweet';

    /** @var string */
    private $id;

    /** @var mixed */
    private $associated_data;

    public function __construct(
        $an_id,
        $some_new_associated_data
    )
    {
        if (empty($an_id) || null === $an_id)
        {
            throw new InvalidTweetDataProvided();
        }
        if (empty($some_new_associated_data) || null === $some_new_associated_data)
        {
            throw new InvalidTweetDataProvided();
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
