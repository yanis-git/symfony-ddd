<?php

namespace Infrastructure\Service\Event;

use Domain\Core\Event\DomainEvents;
use Domain\Core\Event\EventManagerInterface;
use Domain\Core\Repository\EventRepositoryInterface;

class EventPersister
{
    public function __construct(
        private readonly EventManagerInterface $eventManager,
        private readonly EventRepositoryInterface $eventRepository,
    ) {
    }

    public function hasEvents(): bool
    {
        foreach ($this->eventManager->getAggregates() as $aggregate) {
            if ($aggregate->hasEvents()) {
                return true;
            }
        }

        return false;
    }

    public function store(): void
    {
        /*
        * Get all recorded aggregates
        */
        $aggregates = $this->eventManager->getAggregates();

        $events = [];

        /*
         * Save events to database.
         */
        foreach ($aggregates as $aggregate) {
            foreach ($aggregate->getRecordedEvents() as $event) {
                $eventId = (string) $event->getEventId();
                $events[$eventId] = $event;
            }
        }

        $this->eventRepository->persist(new DomainEvents($events));
    }
}
