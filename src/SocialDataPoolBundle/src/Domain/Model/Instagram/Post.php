<?php

namespace SocialDataPool\Domain\Model\Instagram;

use SocialDataPool\Domain\Model\Core\Social;
use SocialDataPool\Domain\Model\Core\SocialCreated;
use SocialDataPool\Domain\Model\Instagram\Exception\InvalidInstagramPostDataProvided;
use SocialDataPool\Infrastructure\EventQueue\DomainEventRecorder;

final class Post
{
    const INSTAGRAM_TYPE = 'instagram_post';

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
            throw new InvalidInstagramPostDataProvided();
        }
        if (empty($some_new_associated_data) || null === $some_new_associated_data)
        {
            throw new InvalidInstagramPostDataProvided();
        }
        $this->id              = $an_id;
        $this->associated_data = $some_new_associated_data;

        DomainEventRecorder::instance()->recordMessage(new SocialCreated($an_id));
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
