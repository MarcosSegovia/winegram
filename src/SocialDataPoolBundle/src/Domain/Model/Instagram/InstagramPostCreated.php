<?php

namespace SocialDataPool\Domain\Model\Instagram;

use SocialDataPool\Domain\Model\Event\DomainEvent;

final class InstagramPostCreated extends DomainEvent
{
    const EVENT_NAME = 'Instagram_post_created';

    /** @var string */
    private $id;

    /** @var string */
    private $event_name;

    public function __construct($an_id)
    {
        parent::__construct();
        $this->id         = $an_id;
        $this->event_name = self::EVENT_NAME;
    }
}
