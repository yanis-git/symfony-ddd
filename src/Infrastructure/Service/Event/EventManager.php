<?php

namespace Infrastructure\Service\Event;

use Domain\Core\Aggregate\AggregateRootAbstract;
use Domain\Core\Contract\DomainEventInterface;
use Domain\Core\Event\EventManagerInterface;

class EventManager implements EventManagerInterface
{
    private array $aggregates = [];

    public function persist(AggregateRootAbstract $aggregateRoot): void
    {
        $this->aggregates[(string)$aggregateRoot->getUuid()] = $aggregateRoot;
    }

    public function clear(): void
    {
        $this->aggregates = [];
    }

    public function getAggregates(): array
    {
        return $this->aggregates;
    }

    public function detach(AggregateRootAbstract $aggregate): void
    {
        if (!empty($this->aggregates[(string)$aggregate->getUuid()])) {
            unset($this->aggregates[(string)$aggregate->getUuid()]);
        }
    }

    public function hasEvent(string $eventName): bool
    {
        /** @var AggregateRootAbstract $aggregate */
        foreach ($this->aggregates as $aggregate) {
            $events = $aggregate->getRecordedEvents()->getIterator();

            /** @var DomainEventInterface $event */
            foreach ($events as $event) {
                if ($event->getEventName() === $eventName) {
                    return true;
                }
            }
        }

        return false;
    }
}
