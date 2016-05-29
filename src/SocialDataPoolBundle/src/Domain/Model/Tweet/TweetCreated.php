<?php

namespace SocialDataPool\Domain\Model\Tweet;

use SocialDataPool\Domain\Model\Event\DomainEvent;

final class TweetCreated extends DomainEvent
{
    const EVENT_NAME = 'Tweet_created';

    /** @var string */
    private $event_name;

    public function __construct()
    {
        parent::__construct();
        $this->event_name = self::EVENT_NAME;
    }
}
