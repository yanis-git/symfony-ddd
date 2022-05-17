<?php

use Domain\Core\Contract\EntityIdInterface;
use Domain\Core\ValueObject\EntityId;


beforeEach(function () {
    $this->uuid = '6eadc797-c7a8-4c8c-b20d-71c8017c9163';
    $this->elementId = ElementId::fromString($this->uuid);
});

it('Should be able to create an EntityId from a string', function () {
    expect((string) $this->elementId)->toBe($this->uuid);
});

it('Should be serializable', function () {
    expect(json_encode($this->elementId))->toBe(json_encode($this->uuid));
});

it('Should throw Exception when fromString is call with invalid uuid', function () {
    expect(fn() => ElementId::fromString('invalid-uuid'))
        ->toThrow(InvalidArgumentException::class, 'invalid-uuid is not valid UUID');
});

it('Should validate the uuid format', function () {
    $invalidUuid = 'invalid-uuid';
    expect(ElementId::isValid($invalidUuid))->toBe(false);
    expect(ElementId::isValid($this->uuid))->toBe(true);
});

it('Should be able to compare two EntityIds', function () {
    $otherElementId = ElementId::fromString($this->uuid);
    expect($this->elementId->equals($otherElementId))->toBe(true);
});

it('Should be able to generate valid UUID', function () {
    $uuid = ElementId::generate();
    expect(ElementId::isValid($uuid))->toBe(true);
});

it('Should implement EntityIdInterface', function () {
    expect($this->elementId)->toBeInstanceOf(EntityIdInterface::class);
});


class ElementId extends EntityId {

}
