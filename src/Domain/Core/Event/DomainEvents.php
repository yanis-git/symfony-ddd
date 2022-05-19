<?php

namespace Domain\Core\Event;

use ArrayAccess;
use ArrayIterator;

class DomainEvents extends ArrayIterator implements ArrayAccess
{
    public function __construct(array $events = [])
    {
        parent::__construct($events);
    }
}
