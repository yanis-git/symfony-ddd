<?php

use Domain\Core\Aggregate\AggregateRootAbstract;
use Domain\Core\Contract\DomainEventInterface;
use Domain\Core\Contract\EntityIdInterface;
use Domain\Core\Event\DomainEventAbstract;
use Domain\Core\ValueObject\EntityId;
use Symfony\Component\Uid\Uuid;

beforeEach(function () {
    $this->userId = UserId::fromString('6eadc797-c7a8-4c8c-b20d-71c8017c9163');
    $this->user = new User($this->userId);
    $this->userWasCreated = new UserWasCreatedEvent($this->userId);
});


it('Should have DomainEventInterface type', fn() => expect($this->userWasCreated)->toBeInstanceOf(DomainEventInterface::class));
it('Should have it own event UUID', fn() => expect(Uuid::isValid($this->userWasCreated->getEventId()))->toBe(true));
it('Should have Version 1 by default', fn() => expect($this->userWasCreated->getVersion())->toBe('1.0'));
it('Should have creation date', fn() =>
    expect($this->userWasCreated->getCreatedAt()->format('Y-m-d hh:mm:ss'))
        ->toBe((new DateTime())->format('Y-m-d hh:mm:ss'))
);
it('Should have it own Event class', fn() => expect($this->userWasCreated->getEventClass())->toBe(UserWasCreatedEvent::class));



class UserId extends EntityId { }

class User extends AggregateRootAbstract {
    public function __construct(EntityIdInterface $userId)
    {
        parent::__construct($userId);
    }
    public function jsonData(): array
    {
        return [];
    }
}

class UserWasCreatedEvent extends DomainEventAbstract {

    public function __construct(private readonly EntityIdInterface $userId) {
        parent::__construct('UserWasCreatedEvent');
    }

    public function getAggregateId(): EntityIdInterface
    {
        return $this->userId;
    }

    public function getAggregateClassName(): string
    {
        return User::class;
    }
}
