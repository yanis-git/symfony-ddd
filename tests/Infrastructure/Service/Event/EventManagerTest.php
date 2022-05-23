<?php

use App\Tests\Sample\Domain\User\User;
use App\Tests\Sample\Domain\User\UserId;
use Domain\Core\Aggregate\AggregateRootAbstract;
use Infrastructure\Service\Event\EventManager;

beforeEach(function () {
    $this->eventManager = new EventManager();
});

dataset('aggregate', fn() => yield [[
    ['uuid' => '3659abc9-ae96-4193-a217-8b6dfc361bae', 'aggregate' => new User(UserId::fromString('3659abc9-ae96-4193-a217-8b6dfc361bae'))],
    ['uuid' => 'b3fe80c2-f339-4c3e-813e-e976ac503821', 'aggregate' => new User(UserId::fromString('b3fe80c2-f339-4c3e-813e-e976ac503821'))],
    ['uuid' => '2defa24a-0f86-4b97-b365-baaa14c212fa', 'aggregate' => new User(UserId::fromString('2defa24a-0f86-4b97-b365-baaa14c212fa'))],
    ['uuid' => '2defa24a-0f86-4b97-b365-baaa14c212fa', 'aggregate' => new User(UserId::fromString('2defa24a-0f86-4b97-b365-baaa14c212fa'))],
]]);

it('should be empty by default', fn() => expect(count($this->eventManager->getAggregates()))->toBe(0));

it('should be able to persist and clear aggregates', function (array $state) {
    foreach ($state as $item) {
        ['aggregate' => $aggregate] = $item;
        $this->eventManager->persist($aggregate);
    }
    expect(count($this->eventManager->getAggregates()))->toBe(3);
    $this->eventManager->clear();
    expect(count($this->eventManager->getAggregates()))->toBe(0);
})->with('aggregate');


it('should be able to detach specific aggregate', function () {
    $aggregate1 = new User(UserId::fromString('3659abc9-ae96-4193-a217-8b6dfc361bae'));
    $aggregate2 = new User(UserId::fromString('3659abc9-ae96-4193-a217-e976ac503821'));
    $this->eventManager->persist($aggregate1);
    $this->eventManager->persist($aggregate2);
    expect(count($this->eventManager->getAggregates()))->toBe(2);
    $this->eventManager->detach($aggregate1);
    expect(count($this->eventManager->getAggregates()))->toBe(1);
});
