<?php

namespace Infrastructure\Service\Event;

use Domain\Core\Aggregate\AggregateRootAbstract;
use Domain\Core\Contract\DomainEventInterface;
use Domain\Core\Event\EventManagerInterface;

class EventManager implements EventManagerInterface
{
    /** @var array<string, AggregateRootAbstract>  */
    private array $aggregates = [];

    public function persist(AggregateRootAbstract $aggregateRoot): void
    {
        $this->aggregates[(string)$aggregateRoot->getUuid()] = $aggregateRoot;
    }

    public function clear(): void
    {
        $this->aggregates = [];
    }

    /**
     * @return array<string, AggregateRootAbstract>
     */
    public function getAggregates(): array
    {
        return $this->aggregates;
    }

    public function detach(AggregateRootAbstract $aggregateRoot): void
    {
        $uuid = (string)$aggregateRoot->getUuid();
        if (!empty($this->aggregates[$uuid])) {
            unset($this->aggregates[$uuid]);
        }
    }
}
