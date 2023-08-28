<?php

namespace App\Tests\Domain\Core\Event;

use App\Tests\Sample\Domain\User\UserId;
use App\Tests\Sample\Domain\User\UserWasCreatedEvent;
use Domain\Core\Event\DomainEvents;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class DomainEventsTest extends TestCase
{
    #[Test]
    public function it_should_be_able_to_add_domain_event(): void
    {
        $domainEvents = new DomainEvents();
        $domainEvents->append(new UserWasCreatedEvent(UserId::generate()));
        expect(count($domainEvents))->toBe(1);
    }

    #[Test]
   public function it_should_be_traversable(): void
    {
        expect((new DomainEvents()))->toBeInstanceOf(\Traversable::class);
    }
}