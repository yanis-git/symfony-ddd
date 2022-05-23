<?php

namespace Domain\Core\Contract;

use Domain\Core\Event\EventId;
use Domain\Core\Event\Version;

interface DomainEventInterface
{
    public function getAggregateId(): EntityIdInterface;

    public function getEventId(): EventId;

    public function getEventName(): string;

    public function getVersion(): Version;

    public function getAggregateClassName(): string;

    public function getEventClass(): string;
}
