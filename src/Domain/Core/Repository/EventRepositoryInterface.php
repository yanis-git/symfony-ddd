<?php

namespace Domain\Core\Repository;

use Domain\Core\Contract\DomainEntityInterface;
use Domain\Core\Event\DomainEvents;
use Domain\Core\Event\EventId;

/**
 * @template T
 */
interface EventRepositoryInterface
{
    public function persist(DomainEvents $domainEvents): void;

    /**
     * @return array<T>
     */
    public function fetch(int $page, int $countPerPage): array;

    public function fetchByAggregate(DomainEntityInterface $aggregateRoot): DomainEvents;

    public function fetchByAggregateAndId(DomainEntityInterface $aggregateRoot, EventId $eventId): DomainEvents;

    public function get(EventId $eventId): mixed;

    /**
     * @param array<string> $eventUuids
     */
    public function fetchByUuids(array $eventUuids): DomainEvents;
}
