<?php

namespace SocialDataPool\Domain\Model\Tweet;

use SocialDataPool\Domain\Model\Event\DomainEvent;

final class TweetCreated extends DomainEvent
{
    const EVENT_NAME = 'Tweet_created';

    /** @var integer */
    private $id;

    public function __construct($an_id)
    {
        parent::__construct();
        $this->id         = $an_id;
        $this->event_name = self::EVENT_NAME;
    }
}
