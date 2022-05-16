<?php

namespace Domain\Core\Contract;

use Domain\Core\Event\EventId;

interface DomainEventInterface
{
    public function getAggregateId(): EntityIdInterface;

    public function getEventId(): EventId;

    public function getEventName(): string;

    public function getVersion(): string;

    public function getAggregateClassName(): string;

    public function getEventClass(): string;
}
