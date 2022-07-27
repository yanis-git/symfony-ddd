<?php

use App\Tests\Sample\Domain\User\User;
use Domain\Core\Event\EventManagerInterface;
use Domain\Core\Repository\EventRepositoryInterface;
use Infrastructure\Service\Event\EventPersister;

it('Should be able to check if events is persisted or not', function () {
    expect($this->eventPersister->hasEvents())->toBeTrue();
    expect($this->eventPersisterEmpty->hasEvents())->toBeFalse();
});

beforeEach(function () {
    $this->staticUser = User::create();
    $eventRepository = $this->createMock(EventRepositoryInterface::class);
    $eventRepository->expects($this->any())->method('persist');

    $eventManager = $this->createMock(EventManagerInterface::class);
    $emptyEventManager = $this->createMock(EventManagerInterface::class);

    $eventManager->expects($this->any())->method('getAggregates')->willReturn([User::create(), $this->staticUser]);
    $emptyEventManager->expects($this->any())->method('getAggregates')->willReturn([]);


    $this->eventPersister = new EventPersister($eventManager, $eventRepository);
    $this->eventPersisterEmpty = new EventPersister(
        $emptyEventManager,
        $eventRepository
    );
});