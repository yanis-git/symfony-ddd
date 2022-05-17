<?php

namespace Domain\Core\ValueObject;

use Domain\Core\Contract\EntityIdInterface;
use InvalidArgumentException;
use JsonSerializable;
use Symfony\Component\Uid\Uuid;

abstract class EntityId implements EntityIdInterface, JsonSerializable
{
    protected function __construct(private readonly string $uuid)
    {
    }

    public function __toString(): string
    {
        return $this->uuid;
    }

    public static function fromString(string $uuid): static
    {
        if (!static::isValid($uuid)) {
            throw new InvalidArgumentException(sprintf('%s is not valid UUID', $uuid));
        }

        return new static($uuid);
    }

    public static function isValid(string $uuid): bool
    {
        return Uuid::isValid($uuid);
    }

    public function equals(EntityIdInterface $other): bool
    {
        return $other instanceof static && $other->uuid === $this->uuid;
    }

    public static function generate(): static
    {
        return new static(Uuid::v4()->toRfc4122());
    }

    public function jsonSerialize(): string
    {
        return $this->uuid;
    }
}
