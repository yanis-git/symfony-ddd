<?php

namespace App\Tests\Domain\Core\Entity;

use App\Tests\Sample\Domain\User\User;
use App\Tests\Sample\Domain\User\UserId;
use App\Tests\Sample\Domain\User\UserWasCreatedEvent;
use Domain\Core\Contract\DomainEventInterface;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;



class DomainEventAbstractTest extends TestCase
{
    private User $user;
    private UserId $userId;
    private UserWasCreatedEvent $userWasCreated;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userId = UserId::fromString('6eadc797-c7a8-4c8c-b20d-71c8017c9163');
        $this->user = new User($this->userId);
        $this->userWasCreated = new UserWasCreatedEvent($this->userId);
    }

    #[Test]
    public function it_should_have_domain_event_interface_type(): void
    {
        $this->assertInstanceOf(DomainEventInterface::class, $this->userWasCreated);
    }

    #[Test]
    public function it_should_have_it_own_event_uuid(): void
    {
        $this->assertTrue(Uuid::isValid($this->userWasCreated->getEventId()));
    }

    #[Test]
    public function it_should_have_version_1_by_default(): void
    {
        $this->assertEquals('1.0', (string) $this->userWasCreated->getVersion());
    }

    #[Test]
    public function it_should_have_creation_date(): void
    {
        $this->assertEquals(
            (new \DateTime())->format('Y-m-d hh:mm:ss'),
            $this->userWasCreated->getCreatedAt()->format('Y-m-d hh:mm:ss')
        );
    }

    #[Test]
     public function it_should_have_it_own_event_class(): void
     {
         $this->assertEquals(UserWasCreatedEvent::class, $this->userWasCreated->getEventClass());
     }

    #[Test]
    public function it_should_have_it_own_event_name(): void
    {
        $this->assertEquals('UserWasCreatedEvent', $this->userWasCreated->getEventName());
    }
}