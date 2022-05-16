<?php

namespace Domain\Core\Aggregate;

use Domain\Core\Contract\DomainEventInterface;
use Domain\Core\Entity\DomainEntityAbstract;
use Domain\Core\Event\DomainEvents;

abstract class AggregateRootAbstract extends DomainEntityAbstract
{
    private array $domainEvents = [];

    protected function recordEvent(DomainEventInterface $event): void
    {
        $this->domainEvents[] = $event;
    }

    public function clearRecordedEvents(): void
    {
        $this->domainEvents = [];
    }

    public function getRecordedEvents(): DomainEvents
    {
        return new DomainEvents($this->domainEvents);
    }

    public function hasEvents(): bool
    {
        return count($this->domainEvents) > 0;
    }
}
