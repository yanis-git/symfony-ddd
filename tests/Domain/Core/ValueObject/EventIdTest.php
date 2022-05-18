<?php

use Domain\Core\Event\EventId;
use Domain\Core\ValueObject\EntityId;

beforeEach(function () {
    $this->eventId = EventId::generate();
});

it('Should be instance of Entity Id', function () {
    expect($this->eventId)->toBeInstanceOf(EntityId::class);
});
