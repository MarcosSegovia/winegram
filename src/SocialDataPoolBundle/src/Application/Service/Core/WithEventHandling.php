<?php

namespace SocialDataPool\Application\Service\Core;

use SocialDataPool\Domain\Model\Event\DomainEvent;
use SocialDataPool\Infrastructure\EventQueue\DomainEventRecorder;
use SqsPhpBundle\Client\Client;

final class WithEventHandling implements ApplicationService
{
    /** @var ApplicationService */
    private $application_service;

    /** @var Client */
    private $sqs_client;

    const QUEUE = 'social_queue';

    public function __construct(
        ApplicationService $an_application_service,
        Client $a_sqs_client
    )
    {
        $this->application_service = $an_application_service;
        $this->sqs_client          = $a_sqs_client;
    }

    public function __invoke($request)
    {
        $this->application_service->__invoke($request);
        $this->publishApplicationServiceEvents();
    }

    private function publishApplicationServiceEvents()
    {
        $recorded_events = DomainEventRecorder::instance()->recordedEvents();
        DomainEventRecorder::instance()->eraseEvents();

        array_map([$this, 'handleEventMessage'], $recorded_events);
    }

    private function handleEventMessage(DomainEvent $event)
    {
        $this->sqs_client->send(self::QUEUE, [$event->occurredAt(), $event->eventName()]);
    }
}
