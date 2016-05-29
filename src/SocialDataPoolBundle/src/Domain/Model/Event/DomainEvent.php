<?php

namespace SocialDataPool\Domain\Model\Event;

abstract class DomainEvent
{
    /** @var \DateTimeImmutable */
    private $occurred_at;
    
    /** @var string */
    private $event_name;

    public function __construct()
    {
        $this->occurred_at = new \DateTimeImmutable();
    }

    public function occurredAt()
    {
        return $this->occurred_at;
    }

    public function eventName()
    {
        return $this->event_name;
    }

}
