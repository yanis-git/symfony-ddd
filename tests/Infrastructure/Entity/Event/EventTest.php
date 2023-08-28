<?php

namespace App\Tests\Infrastructure\Entity\Event;

use App\Tests\Sample\Domain\User\User;
use App\Tests\Sample\Domain\User\UserWasCreatedEvent;
use Infrastructure\Entity\Event\Event;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class EventTest extends TestCase
{
    private Event $event;

    protected function setUp(): void
    {
        parent::setUp();
        $this->event = new Event();
    }

    #[DataProvider('userWasCreatedProvider')]
    #[Test]
    public function it_should_be_hydratable_manually(
        string $uuid,
        string $aggregateClass,
        string $eventClass,
        string $eventName,
        string $aggregateId,
        string $payload,
        string $version
    ): void
    {
        $this->event
            ->setUuid($uuid)
            ->setAggregateClass($aggregateClass)
            ->setEventClass($eventClass)
            ->setEventName($eventName)
            ->setAggregateId($aggregateId)
            ->setPayload($payload)
            ->setVersion($version)
        ;
        expect($this->event->getUuid())->toBe($uuid)
            ->and($this->event->getAggregateClass())->toBe($aggregateClass)
            ->and($this->event->getEventClass())->toBe($eventClass)
            ->and($this->event->getEventName())->toBe($eventName)
            ->and($this->event->getAggregateId())->toBe($aggregateId)
            ->and($this->event->getPayload())->toBe($payload)
            ->and($this->event->getVersion())->toBe($version);
    }

    #[Test]
    public function it_should_seed_created_at_and_updated_at_on_first_persistance(): void
    {
        $this->event->onPrePersist();
        $now = (new \DateTime())->format('Y-m-d hh:mm:ss');
        expect($this->event->getCreatedAt()->format('Y-m-d hh:mm:ss'))->toBe($now)
            ->and($this->event->getUpdatedAt()->format('Y-m-d hh:mm:ss'))->toBe($now);
    }

    #[Test]
    public function it_should_seed_updated_at_on_update(): void
    {
        $this->event->onPreUpdate();
        $now = (new \DateTime())->format('Y-m-d hh:mm:ss');
        expect($this->event->getUpdatedAt()->format('Y-m-d hh:mm:ss'))->toBe($now);
    }

    public static function userWasCreatedProvider(): array
    {
        return [
            [
                'uuid' => '1afb3a17-f6cf-4a3c-8945-6f8e4f0ff91f',
                'aggregateClass' => User::class,
                'eventClass' => UserWasCreatedEvent::class,
                'eventName' => 'UserWasCreatedEvent',
                'aggregateId' => '6816480e-a3ca-4a17-bdd6-9255fd55d717',
                'payload' => '{"foo":"bar"}',
                'version' => '2.0'
            ]
        ];
    }
}