<?php

namespace Domain\Core\Event;

use Domain\Core\Entity\EntityIdInterface;

interface DomainEvent
{
    public function getAggregateId(): EntityIdInterface;

    public function getEventId(): EventId;

    public function getEventName(): string;

    public function getVersion(): string;

    public function getAggregateClassName(): string;

    public function getEventClass(): string;

    public function getMeta(): array;
}
