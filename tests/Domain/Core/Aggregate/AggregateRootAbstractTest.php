<?php

use App\Tests\Sample\Domain\User\User;
use App\Tests\Sample\Domain\User\UserId;
use Domain\Core\Contract\DomainEntityInterface;

beforeEach(function () {
    $this->userId = UserId::fromString('6eadc797-c7a8-4c8c-b20d-71c8017c9163');
    $this->user = new User($this->userId);
});

it('should implement Domain Entity Interface', fn() => expect($this->user)->toBeInstanceOf(DomainEntityInterface::class));
it('should return not have any events by default', function() {
 expect(count($this->user->getRecordedEvents()))
     ->toBe(0)
     ->and($this->user->hasEvents())
     ->toBe(false)
 ;
});
it ('should be able to record events', function() {
    $user = User::create();
    expect(count($user->getRecordedEvents()))
        ->toBe(1)
        ->and($user->hasEvents())
        ->toBe(true)
    ;
});

it('should be able to serialize', function() {
    expect(json_encode($this->user))
        ->json()
        ->toHaveCount(2)
        ->uuid->toBe('6eadc797-c7a8-4c8c-b20d-71c8017c9163')
        ->foo->toBe('bar')
    ;
});

it('should be able to clear the recorded events', function() {
    $user = User::create();
    $user->clearRecordedEvents();
    expect(count($user->getRecordedEvents()))
        ->toBe(0)
        ->and($this->user->hasEvents())
        ->toBe(false)
    ;
});

it('should return uuid when we cast to string', function() {
    expect((string)$this->user)->toBe('6eadc797-c7a8-4c8c-b20d-71c8017c9163');
});
