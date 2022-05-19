<?php

namespace App\Tests\Sample\Domain\User;

use Domain\Core\Contract\EntityIdInterface;
use Domain\Core\Event\DomainEventAbstract;

class UserWasCreatedEvent extends DomainEventAbstract {

    public function __construct(private readonly EntityIdInterface $userId) {
        parent::__construct('UserWasCreated');
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
