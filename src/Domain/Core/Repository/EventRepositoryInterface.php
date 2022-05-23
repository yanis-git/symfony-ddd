<?php

namespace Domain\Core\Repository;

use Domain\Core\Contract\DomainEntityInterface;
use Domain\Core\Event\DomainEvents;
use Domain\Core\Event\EventId;

interface EventRepositoryInterface
{
    public function persist(DomainEvents $domainEvents): void;

    public function fetch(int $page, int $countPerPage): array;

    public function fetchByAggregate(DomainEntityInterface $aggregateRoot): DomainEvents;

    public function fetchByAggregateAndId(DomainEntityInterface $aggregateRoot, EventId $eventId): DomainEvents;

    public function get(EventId $eventId);

    public function fetchByUuids(array $eventUuids): DomainEvents;
}
