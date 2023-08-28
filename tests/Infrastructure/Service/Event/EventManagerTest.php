<?php

namespace App\Tests\Infrastructure\Service\Event;

use Infrastructure\Service\Event\EventManager;
use App\Tests\Sample\Domain\User\User;
use App\Tests\Sample\Domain\User\UserId;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EventManagerTest extends KernelTestCase
{
    private EventManager $eventManager;

    protected function setUp(): void
    {
        parent::setUp();
        $this->eventManager = new EventManager();
    }

    #[Test]
    public function it_should_be_empty_by_default(): void
    {
        $this->assertCount(0, $this->eventManager->getAggregates());
    }

    #[Test]
    public function it_should_be_able_to_detach_specific_aggregate(): void
    {
        $aggregate1 = new User(UserId::fromString('3659abc9-ae96-4193-a217-8b6dfc361bae'));
        $aggregate2 = new User(UserId::fromString('3659abc9-ae96-4193-a217-e976ac503821'));
        $this->eventManager->persist($aggregate1);
        $this->eventManager->persist($aggregate2);
        $this->assertCount(2, $this->eventManager->getAggregates());
        $this->eventManager->detach($aggregate1);
        $this->assertCount(1, $this->eventManager->getAggregates());
    }

    #[Test]
    #[DataProvider('aggregateProvider')]
    public function it_should_be_able_to_persist_and_clear_aggregates(array $state): void
    {
        foreach ($state as $aggregate) {
            $this->eventManager->persist($aggregate);
        }
        $this->assertCount(3, $this->eventManager->getAggregates());
        $this->eventManager->clear();
        $this->assertCount(0, $this->eventManager->getAggregates());
    }

    public static function aggregateProvider(): array
    {
        return [
            [
                [
                    new User(UserId::fromString('3659abc9-ae96-4193-a217-8b6dfc361bae')),
                    new User(UserId::fromString('b3fe80c2-f339-4c3e-813e-e976ac503821')),
                    new User(UserId::fromString('2defa24a-0f86-4b97-b365-baaa14c212fa')),
                    new User(UserId::fromString('2defa24a-0f86-4b97-b365-baaa14c212fa')),
                ]
            ]
        ];
    }
}