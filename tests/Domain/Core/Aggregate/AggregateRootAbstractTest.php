<?php

namespace App\Tests\Domain\Core\Aggregate;

use App\Tests\Sample\Domain\User\User;
use App\Tests\Sample\Domain\User\UserId;
use Domain\Core\Contract\DomainEntityInterface;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class AggregateRootAbstractTest extends TestCase
{
    private UserId $userId;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userId = UserId::fromString('6eadc797-c7a8-4c8c-b20d-71c8017c9163');
        $this->user = new User($this->userId);
    }

    #[Test]
    public function it_should_implement_entity_interface(): void
    {
        $this->assertInstanceOf(DomainEntityInterface::class, $this->user);
    }

    #[Test]
    public function it_should_be_able_to_record_events(): void
    {
        $user = User::create();
        $this->assertCount(1, $user->getRecordedEvents());
        $this->assertTrue($user->hasEvents());
    }

    #[Test]
    public function it_should_be_able_to_clear_recorded_events(): void
    {
        $user = User::create();
        $user->clearRecordedEvents();

        $this->assertCount(0, $user->getRecordedEvents());
        $this->assertFalse($user->hasEvents());
    }

    #[Test]
    public function it_should_be_able_to_serialize(): void
    {
        $json = json_encode($this->user);
        $this->assertJson($json);
        $this->assertEquals([
            'uuid' => '6eadc797-c7a8-4c8c-b20d-71c8017c9163',
            'foo' => 'bar',
        ], json_decode($json, true));
    }

    #[Test]
    public function it_should_not_have_any_events_by_default(): void
    {
        $this->assertCount(0, $this->user->getRecordedEvents());
        $this->assertFalse($this->user->hasEvents());
    }

    #[Test]
    public function it_should_return_uuid_when_cast_to_string(): void
    {
        $this->assertEquals('6eadc797-c7a8-4c8c-b20d-71c8017c9163', (string) $this->user);
    }
}