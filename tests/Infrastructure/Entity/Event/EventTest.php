<?php

use App\Tests\Sample\Domain\User\User;
use App\Tests\Sample\Domain\User\UserWasCreatedEvent;
use Infrastructure\Entity\Event\Event;

beforeEach(function () {
    $this->event = new Event();
});

dataset('userWasCreated', fn() =>
   yield [
        'uuid' => '1afb3a17-f6cf-4a3c-8945-6f8e4f0ff91f',
        'aggregateClass' => User::class,
        'eventClass' => UserWasCreatedEvent::class,
        'eventName' => 'UserWasCreatedEvent',
        'aggregateId' => '6816480e-a3ca-4a17-bdd6-9255fd55d717',
        'payload' => '{"foo":"bar"}',
        'version' => '2.0'
   ]);

it('should be hydratable manually', function (
    string $uuid,
    string $aggregateClass,
    string $eventClass,
    string $eventName,
    string $aggregateId,
    string $payload,
    string $version
) {
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
})->with('userWasCreated');

it('should seed created at and updated at on first persistance', function () {
   $this->event->onPrePersist();
   $now = (new DateTime())->format('Y-m-d hh:mm:ss');
   expect($this->event->getCreatedAt()->format('Y-m-d hh:mm:ss'))->toBe($now)
       ->and($this->event->getUpdatedAt()->format('Y-m-d hh:mm:ss'))->toBe($now);
});

it('should seed updated at on update', function () {
    $this->event->onPreUpdate();
    $now = (new DateTime())->format('Y-m-d hh:mm:ss');
    expect($this->event->getUpdatedAt()->format('Y-m-d hh:mm:ss'))->toBe($now);
});
