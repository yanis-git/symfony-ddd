<?php

namespace Domain\Core\Event;

use IteratorAggregate;
use Traversable;

class DomainEvents implements IteratorAggregate
{
    /**
     * DomainEvents constructor.
     */
    public function __construct(private readonly array $events)
    {
    }

    public function getIterator(): Traversable
    {
        foreach ($this->events as $device => $property) {
            yield $device => $property;
        }
    }
}
