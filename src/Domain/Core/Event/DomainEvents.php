<?php

namespace Domain\Core\Event;

use ArrayAccess;
use ArrayIterator;
use Domain\Core\Contract\DomainEventInterface;

/**
 * @implements ArrayAccess<int, DomainEventInterface>
 * @extends ArrayIterator<int, DomainEventInterface>
 */
class DomainEvents extends ArrayIterator implements ArrayAccess
{
    public function __construct(array $events = [])
    {
        parent::__construct($events);
    }
}
