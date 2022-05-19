<?php

use App\Tests\Sample\Domain\User\User;
use App\Tests\Sample\Domain\User\UserId;
use App\Tests\Sample\Domain\User\UserWasCreatedEvent;
use Domain\Core\Contract\DomainEventInterface;
use Symfony\Component\Uid\Uuid;

beforeEach(function () {
    $this->userId = UserId::fromString('6eadc797-c7a8-4c8c-b20d-71c8017c9163');
    $this->user = new User($this->userId);
    $this->userWasCreated = new UserWasCreatedEvent($this->userId);
});


it('Should have Domain Event Interface type', fn() => expect($this->userWasCreated)->toBeInstanceOf(DomainEventInterface::class));
it('Should have it own event UUID', fn() => expect(Uuid::isValid($this->userWasCreated->getEventId()))->toBe(true));
it('Should have Version 1 by default', fn() => expect($this->userWasCreated->getVersion())->toBe('1.0'));
it('Should have creation date', fn() =>
    expect($this->userWasCreated->getCreatedAt()->format('Y-m-d hh:mm:ss'))
        ->toBe((new DateTime())->format('Y-m-d hh:mm:ss'))
);
it('Should have it own Event class', fn() => expect($this->userWasCreated->getEventClass())->toBe(UserWasCreatedEvent::class));
it('Should have it own Event name', fn() => expect($this->userWasCreated->getEventName())->toBe('UserWasCreatedEvent'));
