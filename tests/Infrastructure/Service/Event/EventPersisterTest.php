<?php

namespace App\Tests\Infrastructure\Service\Event;

use App\Tests\Sample\Domain\User\User;
use Domain\Core\Event\EventManagerInterface;
use Domain\Core\Repository\EventRepositoryInterface;
use Infrastructure\Service\Event\EventPersister;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EventPersisterTest extends KernelTestCase
{
    private User $staticUser;
    protected function setUp(): void
    {
        parent::setUp();
        $this->staticUser = User::create();
    }

    #[Test]
    public function it_should_be_able_to_check_if_events_is_persisted_or_not(): void
    {
        $eventRepository = $this->createMock(EventRepositoryInterface::class);
        $eventRepository->expects($this->any())->method('persist');

        $eventManager = $this->createMock(EventManagerInterface::class);
        $emptyEventManager = $this->createMock(EventManagerInterface::class);

        $eventManager->expects($this->any())->method('getAggregates')->willReturn([User::create(), $this->staticUser]);
        $emptyEventManager->expects($this->any())->method('getAggregates')->willReturn([]);

        $eventPersister = new EventPersister($eventManager, $eventRepository);
        $eventPersisterEmpty = new EventPersister(
            $emptyEventManager,
            $eventRepository
        );

        $this->assertTrue($eventPersister->hasEvents());
        $this->assertFalse($eventPersisterEmpty->hasEvents());
    }
}