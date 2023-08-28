<?php

namespace App\Tests\Domain\Core\ValueObject;

use Domain\Core\ValueObject\EntityId;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Domain\Core\Contract\EntityIdInterface;

class EntityIdTest extends TestCase
{
    private string $uuid;
    private EntityId $elementId;

    protected function setUp(): void
    {
        parent::setUp();
        $this->uuid = '6eadc797-c7a8-4c8c-b20d-71c8017c9163';
        $this->elementId = ElementId::fromString($this->uuid);
    }

    #[Test]
    public function it_should_be_able_to_create_an_Entity_Id_from_string(): void
    {
        $this->assertEquals($this->uuid, (string) $this->elementId);
    }

    #[Test]
    public function it_should_be_serializable(): void
    {
        $this->assertEquals(json_encode($this->uuid), json_encode($this->elementId));
    }

    #[Test]
     public function it_should_throw_Exception_when_from_String_is_call_with_invalid_uuid(): void
     {
          $this->expectException(\InvalidArgumentException::class);
          $this->expectExceptionMessage('invalid-uuid is not valid UUID');
          ElementId::fromString('invalid-uuid');
     }

    #[Test]
    public function it_should_validate_the_uuid_format(): void
    {
        $invalidUuid = 'invalid-uuid';
        $this->assertFalse(ElementId::isValid($invalidUuid));
        $this->assertTrue(ElementId::isValid($this->uuid));
    }

    #[Test]
    public function it_should_be_able_to_compare_two_Entity_Ids(): void
    {
        $otherElementId = ElementId::fromString($this->uuid);
        $this->assertTrue($this->elementId->equals($otherElementId));
    }

    #[Test]
    public function it_should_be_able_to_generate_valid_UUID(): void
    {
        $uuid = ElementId::generate();
        $this->assertTrue(ElementId::isValid($uuid));
    }

    #[Test]
    public function it_should_implement_Entity_Id_Interface(): void
    {
        $this->assertInstanceOf(EntityIdInterface::class, $this->elementId);
    }
}

class ElementId extends EntityId {

}
