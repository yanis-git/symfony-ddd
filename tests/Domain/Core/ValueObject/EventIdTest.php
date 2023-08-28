<?php

namespace App\Tests\Domain\Core\ValueObject;

use Domain\Core\Event\EventId;
use Domain\Core\ValueObject\EntityId;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class EventIdTest extends TestCase
{
    #[Test]
    public function it_should_be_instance_of_entity_id(): void
    {
        expect(EventId::generate())->toBeInstanceOf(EntityId::class);
    }
}