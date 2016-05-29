<?php

namespace SocialDataPool\Infrastructure\EventQueue;

use SocialDataPool\Domain\Model\Event\DomainEvent;

final class DomainEventRecorder
{
    /** @var DomainEventRecorder */
    private static $instance = null;

    /** @var DomainEvent[] */
    private $events = [];

    public static function instance()
    {
        if (null === static::$instance)
        {
            static::$instance = new self();
        }

        return static::$instance;
    }

    public function recordMessage(DomainEvent $event)
    {
        $this->events[] = $event;
    }

    public function recordedEvents()
    {
        return $this->events;
    }

    public function eraseEvents()
    {
        $this->events = [];
    }
}
