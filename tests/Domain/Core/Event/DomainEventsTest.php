<?php

use App\Tests\Sample\Domain\User\UserId;
use App\Tests\Sample\Domain\User\UserWasCreatedEvent;
use Domain\Core\Event\DomainEvents;

it('should be able to add domain event', function () {
    $domainEvents = new DomainEvents();
    $domainEvents->append(new UserWasCreatedEvent(UserId::generate()));
    expect(count($domainEvents))->toBe(1);
});

it('Should be traversable', fn() => expect((new DomainEvents()))->toBeInstanceOf(Traversable::class));
