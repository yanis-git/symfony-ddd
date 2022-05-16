<?php

namespace Infrastructure\Service\Event;

use Domain\Core\Aggregate\AggregateRootAbstract;
use Domain\Core\Event\EventManagerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class EventPublisher
{
    public function __construct(
        private readonly EventManagerInterface $eventManager,
        private readonly MessageBusInterface $eventBus,
    ) { }

    public function publishEvents(): void
    {
        /** @var AggregateRootAbstract $aggregate */
        foreach ($this->eventManager->getAggregates() as $aggregate) {
            foreach ($aggregate->getRecordedEvents() as $event) {
                $this->eventBus->dispatch($event);
            }
        }

        $this->eventManager->clear();
    }
}
